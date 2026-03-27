<?php

namespace App\Filament\Widgets;

use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class ProjectStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        [$projectCount, $taskCount, $completedTaskCount] = $this->resolveCounts();

        return [
            Stat::make('Total Projects', (string) $projectCount)
                ->color('warning'),
            Stat::make('Total Tasks', (string) $taskCount)
                ->color('primary'),
            Stat::make('Completed Tasks', (string) $completedTaskCount)
                ->color('success'),
        ];
    }

    private function resolveCounts(): array
    {
        $user = auth()->user();

        if (! $user instanceof User) {
            return [0, 0, 0];
        }

        if ($user->role === UserRole::ADMIN) {
            return [
                Project::count(),
                Task::count(),
                Task::where('status', TaskStatus::DONE->value)->count(),
            ];
        }

        if ($user->role === UserRole::MANAGER) {
            return [
                Project::where('created_by', $user->id)->count(),
                Task::whereHas('project', function (Builder $projectQuery) use ($user): void {
                    $projectQuery->where('created_by', $user->id);
                })->count(),
                Task::whereHas('project', function (Builder $projectQuery) use ($user): void {
                    $projectQuery->where('created_by', $user->id);
                })->where('status', TaskStatus::DONE->value)->count(),
            ];
        }

        return [
            Task::where('assigned_to', $user->id)->distinct('project_id')->count('project_id'),
            Task::where('assigned_to', $user->id)->count(),
            Task::where('assigned_to', $user->id)->where('status', TaskStatus::DONE->value)->count(),
        ];
    }
}
