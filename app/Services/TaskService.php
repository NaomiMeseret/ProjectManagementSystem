<?php

namespace App\Services;

use App\DTOS\TaskDTO;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;

class TaskService
{
    public function createTask(TaskDTO $dto): Task
    {
        $task = Task::create([
            'title' => $dto->title,
            'description' => $dto->description,
            'project_id' => $dto->project_id,
            'assigned_to' => $dto->assigned_to,
            'status' => $dto->status->value,
            'priority' => $dto->priority->value,
        ]);

        $this->notifyAssignee($task);

        return $task;
    }

    public function updateTask(Task $task, TaskDTO $dto): Task
    {
        $assigneeChanged = (int) $task->assigned_to !== $dto->assigned_to;

        $task->update([
            'title' => $dto->title,
            'description' => $dto->description,
            'project_id' => $dto->project_id,
            'assigned_to' => $dto->assigned_to,
            'status' => $dto->status->value,
            'priority' => $dto->priority->value,
        ]);

        if ($assigneeChanged) {
            $this->notifyAssignee($task);
        }

        activity()
            ->performedOn($task)
            ->causedBy(auth()->user())
            ->log('Task updated');

        return $task;
    }

    public function changeTaskStatus(Task $task, TaskStatus $status): Task
    {
        $task->update([
            'status' => $status->value,
        ]);

        activity()
            ->performedOn($task)
            ->causedBy(auth()->user())
            ->log('Task status updated');

        return $task;
    }

    public function listTasksForUser(User $user)
    {
        if ($user->role === UserRole::ADMIN) {
            return Task::with(['project', 'assignee'])
                ->latest()
                ->paginate(15);
        }

        if ($user->role === UserRole::MANAGER) {
            return Task::with(['project', 'assignee'])
                ->whereHas('project', function ($projectQuery) use ($user) {
                    $projectQuery->where('created_by', $user->id);
                })
                ->latest()
                ->paginate(15);
        }

        if ($user->role === UserRole::DEVELOPER) {
            return Task::with(['project', 'assignee'])
                ->where('assigned_to', $user->id)
                ->latest()
                ->paginate(15);
        }

        return Task::whereKey([])
            ->paginate(15);
    }

    public function deleteTask(Task $task): void
    {
        $task->load('comments');

        foreach ($task->comments as $comment) {
            $comment->delete();
        }

        $task->delete();
    }

    private function notifyAssignee(Task $task): void
    {
        $assignee = User::find($task->assigned_to);

        if ($assignee === null || $assignee->role !== UserRole::DEVELOPER) {
            return;
        }

        $assignee->notify(new TaskAssignedNotification($task));
    }
}
