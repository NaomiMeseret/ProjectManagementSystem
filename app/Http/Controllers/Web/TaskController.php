<?php

namespace App\Http\Controllers\Web;

use App\DTOS\TaskDTO;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeTaskStatusRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Task::class);

        $user = $request->user();

        abort_unless($user !== null, 401);

        return view('tasks.index', [
            'tasks' => $this->taskService->listTasksForUser($user),
        ]);
    }

    public function create(Project $project): View
    {
        $this->authorize('create', [Task::class, $project]);

        return view('tasks.create', [
            'project' => $project,
            'developers' => $this->developers(),
            'priorities' => TaskPriority::cases(),
            'statuses' => TaskStatus::cases(),
        ]);
    }

    public function store(StoreTaskRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('create', [Task::class, $project]);

        $dto = new TaskDTO(
            id: null,
            title: $request->title,
            description: $request->description,
            project_id: (int) $project->id,
            assigned_to: (int) $request->assigned_to,
            status: TaskStatus::from($request->status),
            priority: TaskPriority::from($request->priority),
        );

        $task = $this->taskService->createTask($dto);

        return redirect()
            ->route('tasks.show', $task)
            ->with('status', 'Task created successfully.');
    }

    public function show(Task $task): View
    {
        $this->authorize('view', $task);

        $task->load([
            'project.creator',
            'assignee',
            'comments' => function ($commentQuery): void {
                $commentQuery->with('user')->latest();
            },
        ]);

        return view('tasks.show', [
            'task' => $task,
            'statusOptions' => TaskStatus::cases(),
        ]);
    }

    public function edit(Project $project, Task $task): View
    {
        abort_unless($task->project_id === $project->id, 404);

        $this->authorize('update', $task);

        $task->load(['project', 'assignee']);

        return view('tasks.edit', [
            'project' => $project,
            'task' => $task,
            'developers' => $this->developers(),
            'priorities' => TaskPriority::cases(),
            'statuses' => TaskStatus::cases(),
        ]);
    }

    public function update(UpdateTaskRequest $request, Project $project, Task $task): RedirectResponse
    {
        abort_unless($task->project_id === $project->id, 404);

        $this->authorize('update', $task);

        $dto = new TaskDTO(
            id: $task->id,
            title: $request->title ?? $task->title,
            description: $request->description ?? $task->description,
            project_id: (int) $project->id,
            assigned_to: (int) ($request->assigned_to ?? $task->assigned_to),
            status: $request->filled('status') ? TaskStatus::from($request->status) : $task->status,
            priority: $request->filled('priority') ? TaskPriority::from($request->priority) : $task->priority,
        );

        $updatedTask = $this->taskService->updateTask($task, $dto);

        return redirect()
            ->route('tasks.show', $updatedTask)
            ->with('status', 'Task updated successfully.');
    }

    public function changeStatus(ChangeTaskStatusRequest $request, Task $task): RedirectResponse
    {
        $this->authorize('changeStatus', $task);

        $updatedTask = $this->taskService->changeTaskStatus(
            $task,
            TaskStatus::from($request->status),
        );

        return redirect()
            ->route('tasks.show', $updatedTask)
            ->with('status', 'Task status updated successfully.');
    }

    public function destroy(Project $project, Task $task): RedirectResponse
    {
        abort_unless($task->project_id === $project->id, 404);

        $this->authorize('delete', $task);

        $this->taskService->deleteTask($task);

        return redirect()
            ->route('projects.show', $project)
            ->with('status', 'Task deleted successfully.');
    }

    private function developers(): Collection
    {
        return User::where('role', UserRole::DEVELOPER->value)
            ->orderBy('name')
            ->get();
    }
}
