<x-layouts::app :title="__('Dashboard')">
    <section class="space-y-8">
        <div class="pm-panel pm-fade-up overflow-hidden p-6 md:p-8">
            <p class="pm-eyebrow">{{ __('Project Operations') }}</p>
            <div class="mt-3 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div class="max-w-2xl space-y-3">
                    <h1 class="pm-title">{{ __('Command Center') }}</h1>
                    <p class="pm-subtitle">
                        {{ __('Live delivery metrics, active priorities, and upcoming deadlines from your workspace.') }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('projects.index') }}" class="inline-flex items-center justify-center rounded-xl border border-amber-300/70 bg-amber-300 px-4 py-2.5 text-sm font-semibold text-amber-950 transition hover:bg-amber-200">
                        {{ __('View Projects') }}
                    </a>
                    <a href="{{ route('tasks.index') }}" class="inline-flex items-center justify-center rounded-xl border border-amber-500/30 px-4 py-2.5 text-sm font-semibold text-amber-100 transition hover:bg-amber-300/10">
                        {{ __('View Tasks') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="pm-panel p-5 pm-fade-up">
                <p class="pm-eyebrow">{{ __('Active Projects') }}</p>
                <p class="mt-3 text-3xl font-semibold text-amber-100">{{ $activeProjectsCount }}</p>
                <p class="mt-2 text-sm text-amber-100/65">{{ __('Projects currently marked active in your workspace.') }}</p>
            </div>

            <div class="pm-panel p-5 pm-fade-up" style="animation-delay: 80ms;">
                <p class="pm-eyebrow">{{ __('Pending Tasks') }}</p>
                <p class="mt-3 text-3xl font-semibold text-amber-100">{{ $pendingTasksCount }}</p>
                <p class="mt-2 text-sm text-amber-100/65">{{ __('Tasks still in todo or in-progress stages.') }}</p>
            </div>

            <div class="pm-panel p-5 pm-fade-up" style="animation-delay: 160ms;">
                <p class="pm-eyebrow">{{ __('Completed This Week') }}</p>
                <p class="mt-3 text-3xl font-semibold text-amber-100">{{ $completedThisWeekCount }}</p>
                <p class="mt-2 text-sm text-amber-100/65">{{ __('Tasks moved to done during the current week.') }}</p>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <div class="pm-panel p-6 pm-fade-up">
                <h2 class="text-lg font-semibold text-amber-100">{{ __('Today\'s Priorities') }}</h2>
                <ul class="mt-4 space-y-3 text-sm text-amber-100/80">
                    @forelse ($todayPriorities as $task)
                        <li class="pm-panel-soft p-3.5">
                            <p class="font-medium text-amber-100">{{ $task->title }}</p>
                            <p class="mt-1 text-xs text-amber-100/65">
                                {{ $task->project?->name ?? __('Unknown Project') }}
                                ·
                                {{ str($task->status->value)->replace('_', ' ')->title() }}
                            </p>
                        </li>
                    @empty
                        <li class="pm-panel-soft p-3 text-amber-100/70">{{ __('No pending priorities for today.') }}</li>
                    @endforelse
                </ul>
            </div>

            <div class="pm-panel p-6 pm-fade-up" style="animation-delay: 120ms;">
                <h2 class="text-lg font-semibold text-amber-100">{{ __('Upcoming Deadlines') }}</h2>
                <ul class="mt-4 space-y-3 text-sm text-amber-100/80">
                    @forelse ($upcomingDeadlines as $project)
                        <li class="pm-panel-soft flex items-center justify-between gap-4 p-3.5">
                            <span>{{ $project->name }}</span>
                            <span class="text-amber-300">{{ $project->deadline?->format('M d, Y') }}</span>
                        </li>
                    @empty
                        <li class="pm-panel-soft p-3 text-amber-100/70">{{ __('No upcoming project deadlines.') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </section>
</x-layouts::app>
