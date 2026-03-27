<x-layouts::app :title="__('Create Project')">
    <section class="space-y-6">
        <div class="pm-panel p-6 md:p-8">
            <p class="pm-eyebrow">{{ __('Project Setup') }}</p>
            <h1 class="pm-title mt-3">{{ __('Create Project') }}</h1>
            <p class="pm-subtitle mt-3">{{ __('Define the project scope, timeline, and starting status before assigning tasks.') }}</p>
        </div>

        <div class="pm-panel p-6 md:p-8">
            <form method="POST" action="{{ route('projects.store') }}" class="space-y-6">
                @csrf

                @include('projects.partials.form')

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('projects.index') }}" class="inline-flex items-center justify-center rounded-xl border border-amber-500/30 px-5 py-3 text-sm font-semibold text-amber-100 transition hover:bg-amber-300/10">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-amber-300/70 bg-amber-300 px-5 py-3 text-sm font-semibold text-amber-950 transition hover:bg-amber-200">
                        {{ __('Create Project') }}
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-layouts::app>
