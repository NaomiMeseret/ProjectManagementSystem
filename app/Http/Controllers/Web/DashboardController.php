<?php

namespace App\Http\Controllers\Web;

use App\Enums\ProjectStatus;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        abort_unless($user instanceof User, 401);

        $projectScope = $this->projectsFor($user);
        $taskScope = $this->tasksFor($user);

        $activeProjectsCount = (clone $projectScope)
            ->where('status', ProjectStatus::ACTIVE->value)
            ->count();

        $pendingTasksCount = (clone $taskScope)
            ->whereIn('status', [TaskStatus::TODO->value, TaskStatus::IN_PROGRESS->value])
            ->count();

        $completedThisWeekCount = (clone $taskScope)
            ->where('status', TaskStatus::DONE->value)
            ->where('updated_at', '>=', now()->startOfWeek())
            ->count();

        $todayPriorities = (clone $taskScope)
            ->whereIn('status', [TaskStatus::TODO->value, TaskStatus::IN_PROGRESS->value])
            ->latest('updated_at')
            ->limit(5)
            ->get();

        $upcomingDeadlines = (clone $projectScope)
            ->whereNotNull('deadline')
            ->whereDate('deadline', '>=', today())
            ->orderBy('deadline')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'activeProjectsCount' => $activeProjectsCount,
            'pendingTasksCount' => $pendingTasksCount,
            'completedThisWeekCount' => $completedThisWeekCount,
            'todayPriorities' => $todayPriorities,
            'upcomingDeadlines' => $upcomingDeadlines,
        ]);
    }

    private function projectsFor(User $user): Builder
    {
        if ($user->role === UserRole::ADMIN) {
            return Project::query()->with('creator');
        }

        if ($user->role === UserRole::MANAGER) {
            return Project::query()
                ->with('creator')
                ->where('created_by', $user->id);
        }

        return Project::query()
            ->with('creator')
            ->whereHas('tasks', function (Builder $taskFilter) use ($user): void {
                $taskFilter->where('assigned_to', $user->id);
            });
    }

    private function tasksFor(User $user): Builder
    {
        if ($user->role === UserRole::ADMIN) {
            return Task::query()->with(['project', 'assignee']);
        }

        if ($user->role === UserRole::MANAGER) {
            return Task::query()
                ->with(['project', 'assignee'])
                ->whereHas('project', function (Builder $projectFilter) use ($user): void {
                    $projectFilter->where('created_by', $user->id);
                });
        }

        return Task::query()
            ->with(['project', 'assignee'])
            ->where('assigned_to', $user->id);
    }
}
