<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::MANAGER, UserRole::DEVELOPER], true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        if ($user->role === UserRole::MANAGER) {
            return $this->managerOwnsTaskProject($user, $task);
        }

        return $user->id === $task->assigned_to;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, ?Project $project = null): bool
    {
        if ($user->role !== UserRole::MANAGER) {
            return false;
        }

        if ($project === null) {
            return true;
        }

        return (int) $project->created_by === (int) $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        if ($user->role !== UserRole::MANAGER) {
            return false;
        }

        return $this->managerOwnsTaskProject($user, $task);
    }

    /**
     * Determine whether the user can update the task status.
     */
    public function changeStatus(User $user, Task $task): bool
    {
        return $user->role === UserRole::DEVELOPER && $user->id === $task->assigned_to;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        if ($user->role !== UserRole::MANAGER) {
            return false;
        }

        return $this->managerOwnsTaskProject($user, $task);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return $this->delete($user, $task);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $this->delete($user, $task);
    }

    private function managerOwnsTaskProject(User $user, Task $task): bool
    {
        if ($task->relationLoaded('project')) {
            return $task->project !== null
                && (int) $task->project->created_by === (int) $user->id;
        }

        return $task->project()
            ->where('created_by', $user->id)
            ->exists();
    }
}
