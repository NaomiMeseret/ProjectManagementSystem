<x-layouts::app :title="__('Edit Project')">
    <section class="space-y-6">
        <div class="pm-panel p-6 md:p-8">
            <p class="pm-eyebrow">{{ __('Project Update') }}</p>
            <h1 class="pm-title mt-3">{{ __('Edit Project') }}</h1>
            <p class="pm-subtitle mt-3">{{ __('Adjust timeline, project details, or completion status without changing business rules.') }}</p>
        </div>

        <div class="pm-panel p-6 md:p-8">
            <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-6">
                @csrf
                @method('PUT')

                @include('projects.partials.form', ['project' => $project])

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center justify-center rounded-xl border border-amber-500/30 px-5 py-3 text-sm font-semibold text-amber-100 transition hover:bg-amber-300/10">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-amber-300/70 bg-amber-300 px-5 py-3 text-sm font-semibold text-amber-950 transition hover:bg-amber-200">
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-layouts::app>
