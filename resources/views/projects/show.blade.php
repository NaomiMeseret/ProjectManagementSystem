<x-layouts::app :title="$project->name">
    <section class="space-y-8">
        <div class="pm-panel p-7 md:p-9">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div class="space-y-3">
                    <p class="pm-eyebrow">{{ __('Project Detail') }}</p>
                    <h1 class="pm-title">{{ $project->name }}</h1>
                    <p class="pm-subtitle">{{ $project->description ?: __('No description added yet.') }}</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    @can('create', [\App\Models\Task::class, $project])
                        <a href="{{ route('projects.tasks.create', $project) }}" class="inline-flex items-center justify-center rounded-xl border border-amber-300/70 bg-amber-300 px-4 py-2.5 text-sm font-semibold text-amber-950 transition hover:bg-amber-200">
                            {{ __('Add Task') }}
                        </a>
                    @endcan

                    @can('update', $project)
                        <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center justify-center rounded-xl border border-amber-500/30 px-4 py-2.5 text-sm font-semibold text-amber-100 transition hover:bg-amber-300/10">
                            {{ __('Edit') }}
                        </a>
                    @endcan

                    @can('delete', $project)
                        <form method="POST" action="{{ route('projects.destroy', $project) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-rose-400/30 px-4 py-2.5 text-sm font-semibold text-rose-200 transition hover:bg-rose-500/10">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

        <x-auth-session-status :status="session('status')" />

        <div class="grid gap-4 lg:grid-cols-4">
            <div class="pm-panel-soft p-5 md:p-6">
                <p class="pm-eyebrow">{{ __('Status') }}</p>
                <p class="mt-3 text-lg font-semibold text-amber-100">{{ str($project->status->value)->replace('_', ' ')->title() }}</p>
            </div>
            <div class="pm-panel-soft p-5 md:p-6">
                <p class="pm-eyebrow">{{ __('Deadline') }}</p>
                <p class="mt-3 text-lg font-semibold text-amber-100">{{ $project->deadline?->format('M d, Y') ?? __('Not set') }}</p>
            </div>
            <div class="pm-panel-soft p-5 md:p-6">
                <p class="pm-eyebrow">{{ __('Manager') }}</p>
                <p class="mt-3 text-lg font-semibold text-amber-100">{{ $project->creator?->name ?? __('Unknown') }}</p>
            </div>
            <div class="pm-panel-soft p-5 md:p-6">
                <p class="pm-eyebrow">{{ __('Total Tasks') }}</p>
                <p class="mt-3 text-lg font-semibold text-amber-100">{{ $project->tasks->count() }}</p>
            </div>
        </div>

        <div class="pm-panel p-7">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-amber-100">{{ __('Project Tasks') }}</h2>
                <span class="text-sm text-amber-100/60">{{ trans_choice(':count task|:count tasks', $project->tasks->count(), ['count' => $project->tasks->count()]) }}</span>
            </div>

            <div class="mt-6 space-y-4">
                @forelse ($project->tasks as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="block rounded-xl border border-amber-500/20 bg-black/25 p-5 transition hover:border-amber-300/40 hover:bg-amber-300/5">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="font-semibold text-amber-50">{{ $task->title }}</p>
                                <p class="mt-1 text-sm text-amber-100/60">{{ $task->assignee?->name ?? __('Unassigned') }}</p>
                                <p class="mt-2 text-xs text-amber-100/55">
                                    {{ trans_choice(':count comment|:count comments', $task->comments_count, ['count' => $task->comments_count]) }}
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-3 text-sm text-amber-200">
                                <span>{{ str($task->priority->value)->title() }}</span>
                                <span>{{ str($task->status->value)->replace('_', ' ')->title() }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="rounded-xl border border-amber-500/20 bg-black/25 p-5 text-amber-100/60">
                        {{ __('No tasks have been added to this project yet.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts::app>
