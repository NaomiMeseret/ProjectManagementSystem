<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy
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
    public function view(User $user, Project $project): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        if ($user->role === UserRole::MANAGER) {
            return (int) $user->id === (int) $project->created_by;
        }

        if ($user->role !== UserRole::DEVELOPER) {
            return false;
        }

        return $this->developerAssignedToProject($user, $project);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::MANAGER;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        return $user->role === UserRole::MANAGER
            && (int) $user->id === (int) $project->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        return $user->role === UserRole::MANAGER
            && (int) $user->id === (int) $project->created_by;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return $this->delete($user, $project);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return $this->delete($user, $project);
    }

    private function developerAssignedToProject(User $user, Project $project): bool
    {
        if (! $project->relationLoaded('tasks')) {
            if (! $project->exists) {
                return false;
            }

            $project->load('tasks');
        }

        return $project->tasks->contains(fn ($task) => (int) $task->assigned_to === (int) $user->id);
    }
}
