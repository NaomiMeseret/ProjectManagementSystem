<x-layouts::app :title="$task->title">
    <section class="space-y-8">
        <div class="pm-panel p-7 md:p-9">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div class="space-y-3">
                    <p class="pm-eyebrow">{{ __('Task Detail') }}</p>
                    <h1 class="pm-title">{{ $task->title }}</h1>
                    <p class="pm-subtitle">{{ $task->description ?: __('No description added yet.') }}</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    @can('update', $task)
                        <a href="{{ route('projects.tasks.edit', [$task->project, $task]) }}" class="inline-flex items-center justify-center rounded-xl border border-amber-500/30 px-4 py-2.5 text-sm font-semibold text-amber-100 transition hover:bg-amber-300/10">
                            {{ __('Edit Task') }}
                        </a>
                    @endcan

                    @can('delete', $task)
                        <form method="POST" action="{{ route('projects.tasks.destroy', [$task->project, $task]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-rose-400/30 px-4 py-2.5 text-sm font-semibold text-rose-200 transition hover:bg-rose-500/10">
                                {{ __('Delete Task') }}
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

        <x-auth-session-status :status="session('status')" />

        <div class="grid gap-4 lg:grid-cols-4">
            <div class="pm-panel-soft p-5 md:p-6">
                <p class="pm-eyebrow">{{ __('Project') }}</p>
                <p class="mt-3 text-lg font-semibold text-amber-100">{{ $task->project?->name ?? __('Unknown') }}</p>
            </div>
            <div class="pm-panel-soft p-5 md:p-6">
                <p class="pm-eyebrow">{{ __('Assigned To') }}</p>
                <p class="mt-3 text-lg font-semibold text-amber-100">{{ $task->assignee?->name ?? __('Unassigned') }}</p>
            </div>
            <div class="pm-panel-soft p-5 md:p-6">
                <p class="pm-eyebrow">{{ __('Priority / Status') }}</p>
                <p class="mt-3 text-lg font-semibold text-amber-100">{{ str($task->priority->value)->title() }} · {{ str($task->status->value)->replace('_', ' ')->title() }}</p>
            </div>
            <div class="pm-panel-soft p-5 md:p-6">
                <p class="pm-eyebrow">{{ __('Comments') }}</p>
                <p class="mt-3 text-lg font-semibold text-amber-100">{{ $task->comments->count() }}</p>
            </div>
        </div>

        @can('changeStatus', $task)
            <div class="rounded-3xl border border-amber-300/35 bg-gradient-to-br from-amber-300/16 via-black/55 to-black/80 p-6 shadow-xl shadow-amber-950/30 md:p-7">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div class="space-y-3">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-300/90">{{ __('Developer Action') }}</p>
                        <div>
                            <h2 class="text-2xl font-semibold text-amber-50">{{ __('Update Task Status') }}</h2>
                            <p class="mt-2 max-w-2xl text-sm leading-7 text-amber-100/75">
                                {{ __('You are the assigned developer for this task, so you can move it between todo, in progress, and done from here.') }}
                            </p>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-amber-400/25 bg-black/35 px-4 py-3 text-sm text-amber-100/75">
                        <p class="text-[0.7rem] uppercase tracking-[0.18em] text-amber-300/75">{{ __('Current Status') }}</p>
                        <p class="mt-2 text-lg font-semibold text-amber-50">{{ str($task->status->value)->replace('_', ' ')->title() }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('tasks.change-status', $task) }}" class="mt-6 flex flex-col gap-4 md:flex-row md:items-end">
                    @csrf
                    @method('PATCH')
                    <div class="flex-1">
                        <label for="status" class="mb-2 block text-sm font-semibold text-amber-100">{{ __('New Status') }}</label>
                        <select
                            id="status"
                            name="status"
                            class="w-full rounded-xl border border-amber-500/30 bg-black/40 px-4 py-3 text-amber-50 outline-none transition focus:border-amber-300"
                            required
                        >
                            @foreach ($statusOptions as $status)
                                <option value="{{ $status->value }}" @selected(old('status', $task->status->value) === $status->value)>
                                    {{ str($status->value)->replace('_', ' ')->title() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-amber-300/70 bg-amber-300 px-6 py-3 text-sm font-semibold text-amber-950 transition hover:bg-amber-200">
                        {{ __('Update Status') }}
                    </button>
                </form>
            </div>
        @endcan

        <div class="grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">
            <div class="pm-panel p-7">
                <h2 class="text-lg font-semibold text-amber-100">
                    {{ __('Comments') }}
                    <span class="ml-2 text-sm font-normal text-amber-100/60">({{ $task->comments->count() }})</span>
                </h2>

                <div class="mt-5 space-y-4">
                    @forelse ($task->comments as $comment)
                        <div class="rounded-xl border border-amber-500/20 bg-black/25 p-4 md:p-5">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-semibold text-amber-50">{{ $comment->user?->name ?? __('Unknown') }}</p>
                                <p class="text-xs text-amber-100/50">{{ $comment->created_at?->diffForHumans() }}</p>
                            </div>
                            <p class="mt-3 text-sm leading-7 text-amber-100/78">{{ $comment->comment }}</p>
                        </div>
                    @empty
                        <div class="rounded-xl border border-amber-500/20 bg-black/25 p-5 text-amber-100/60">
                            {{ __('No comments yet.') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="pm-panel p-7">
                <h2 class="text-lg font-semibold text-amber-100">{{ __('Add Comment') }}</h2>

                <form method="POST" action="{{ route('tasks.comments.store', $task) }}" class="mt-5 space-y-4">
                    @csrf
                    <div>
                        <textarea
                            name="comment"
                            rows="8"
                            class="w-full rounded-xl border border-amber-500/30 bg-black/40 px-4 py-3 text-amber-50 outline-none transition focus:border-amber-300"
                            placeholder="{{ __('Share progress, blockers, or clarification.') }}"
                            required
                        >{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-amber-300/70 bg-amber-300 px-5 py-3 text-sm font-semibold text-amber-950 transition hover:bg-amber-200">
                        {{ __('Post Comment') }}
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layouts::app>
