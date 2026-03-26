<?php

namespace App\Services;

use App\DTOS\ProjectDTO;
use App\Enums\UserRole;
use App\Models\Project;
use App\Models\User;

class ProjectService
{
    public function createProject(ProjectDTO $dto, int $creatorId): Project
    {
        $project = Project::create([
            'name' => $dto->name,
            'description' => $dto->description,
            'deadline' => $dto->deadline,
            'status' => $dto->status->value,
            'created_by' => $creatorId,
        ]);

        activity()
            ->performedOn($project)
            ->causedBy(auth()->user())
            ->log('Project created');

        return $project;
    }

    public function listProjectsForUser(User $user)
    {
        if ($user->role === UserRole::ADMIN) {
            return Project::with('creator')
                ->latest()
                ->paginate(15);
        }

        if ($user->role === UserRole::MANAGER) {
            return Project::with('creator')
                ->where('created_by', $user->id)
                ->latest()
                ->paginate(15);
        }

        if ($user->role === UserRole::DEVELOPER) {
            return Project::with('creator')
                ->whereHas('tasks', function ($taskQuery) use ($user) {
                    $taskQuery->where('assigned_to', $user->id);
                })
                ->latest()
                ->paginate(15);
        }

        return Project::whereKey([])
            ->paginate(15);
    }

    public function updateProject(Project $project, ProjectDTO $dto): Project
    {
        $project->update([
            'name' => $dto->name,
            'description' => $dto->description,
            'deadline' => $dto->deadline,
            'status' => $dto->status->value,
        ]);

        return $project;
    }

    public function deleteProject(Project $project): void
    {
        $project->load('tasks.comments');

        foreach ($project->tasks as $task) {
            foreach ($task->comments as $comment) {
                $comment->delete();
            }

            $task->delete();
        }

        $project->delete();
    }
}
