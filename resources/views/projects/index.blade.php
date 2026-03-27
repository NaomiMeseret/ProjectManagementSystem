<x-layouts::app :title="__('Projects')">
    <section class="space-y-10">
        <div class="pm-panel p-8 md:p-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div class="space-y-4">
                    <p class="pm-eyebrow">{{ __('Project Workspace') }}</p>
                    <h1 class="pm-title pt-1">{{ __('Projects') }}</h1>
                    <p class="pm-subtitle max-w-3xl pt-1">{{ __('Review current delivery timelines, ownership, and status across your portfolio.') }}</p>
                </div>

                @can('create', \App\Models\Project::class)
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center rounded-xl border border-amber-300/70 bg-amber-300 px-5 py-3 text-sm font-semibold text-amber-950 transition hover:bg-amber-200">
                        {{ __('New Project') }}
                    </a>
                @endcan
            </div>
        </div>

        <x-auth-session-status :status="session('status')" />

        <div class="pm-panel p-4 sm:p-6 lg:p-7">
            <div class="hidden xl:block">
                <div class="overflow-hidden rounded-2xl border border-amber-500/20 bg-black/20">
                    <div class="grid grid-cols-[minmax(0,2.8fr)_minmax(0,1fr)_minmax(0,1.2fr)_minmax(0,1.4fr)_auto] gap-x-6 bg-amber-400/10 px-7 py-4 text-xs uppercase tracking-[0.1em] text-amber-300/80">
                        <p class="whitespace-nowrap">{{ __('Project') }}</p>
                        <p class="whitespace-nowrap">{{ __('Status') }}</p>
                        <p class="whitespace-nowrap">{{ __('Deadline') }}</p>
                        <p class="whitespace-nowrap">{{ __('Owner') }}</p>
                        <p class="whitespace-nowrap text-right">{{ __('Open') }}</p>
                    </div>

                    @forelse ($projects as $project)
                        <div class="grid grid-cols-[minmax(0,2.8fr)_minmax(0,1fr)_minmax(0,1.2fr)_minmax(0,1.4fr)_auto] gap-x-6 border-t border-amber-500/15 px-7 py-6 text-[0.98rem] text-amber-100/85 hover:bg-amber-300/5">
                            <div class="min-w-0 space-y-2 pr-2">
                                <p class="break-words text-[1.15rem] font-semibold leading-8 text-amber-50">{{ $project->name }}</p>
                                <p class="break-words text-[0.95rem] leading-7 text-amber-100/65">{{ str($project->description)->limit(110) }}</p>
                            </div>
                            <div class="pt-1">
                                <span class="inline-flex whitespace-nowrap rounded-full border border-amber-400/30 bg-amber-300/10 px-3.5 py-1.5 text-sm font-semibold text-amber-200">
                                    {{ str($project->status->value)->replace('_', ' ')->title() }}
                                </span>
                            </div>
                            <p class="whitespace-nowrap pt-2 text-amber-100/90">{{ $project->deadline?->format('M d, Y') ?? __('No deadline') }}</p>
                            <p class="min-w-0 truncate pt-2 text-amber-100/90">{{ $project->creator?->name ?? __('Unknown') }}</p>
                            <div class="pt-2 text-right">
                                <a href="{{ route('projects.show', $project) }}" class="text-base font-semibold whitespace-nowrap text-amber-300 transition hover:text-amber-100">
                                    {{ __('View') }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="border-t border-amber-500/15 px-7 py-16 text-center text-amber-100/60">
                            {{ __('No projects available.') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="grid gap-4 xl:hidden">
                @forelse ($projects as $project)
                    <div class="rounded-xl border border-amber-500/20 bg-black/25 p-5 sm:p-6">
                        <p class="text-xl font-semibold leading-8 text-amber-50">{{ $project->name }}</p>
                        <p class="mt-3 text-sm leading-7 text-amber-100/65">{{ str($project->description)->limit(120) }}</p>
                        <div class="mt-5 grid gap-2.5 text-sm text-amber-100/85">
                            <p><span class="text-amber-300/85">{{ __('Status') }}:</span> {{ str($project->status->value)->replace('_', ' ')->title() }}</p>
                            <p><span class="text-amber-300/85">{{ __('Deadline') }}:</span> {{ $project->deadline?->format('M d, Y') ?? __('No deadline') }}</p>
                            <p><span class="text-amber-300/85">{{ __('Owner') }}:</span> {{ $project->creator?->name ?? __('Unknown') }}</p>
                        </div>
                        <div class="mt-5">
                            <a href="{{ route('projects.show', $project) }}" class="text-base font-semibold text-amber-300 transition hover:text-amber-100">
                                {{ __('View') }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-amber-500/20 bg-black/25 p-6 text-center text-amber-100/60">
                        {{ __('No projects available.') }}
                    </div>
                @endforelse
            </div>
        </div>

        <div>
            {{ $projects->links() }}
        </div>
    </section>
</x-layouts::app>
