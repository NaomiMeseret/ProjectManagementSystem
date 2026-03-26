@php
    $project ??= null;
@endphp

<div class="grid gap-5">
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-amber-100">{{ __('Project Name') }}</label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $project?->name) }}"
            class="w-full rounded-xl border border-amber-500/30 bg-black/40 px-4 py-3 text-amber-50 outline-none transition focus:border-amber-300"
            required
        >
        @error('name')
            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-semibold text-amber-100">{{ __('Description') }}</label>
        <textarea
            id="description"
            name="description"
            rows="5"
            class="w-full rounded-xl border border-amber-500/30 bg-black/40 px-4 py-3 text-amber-50 outline-none transition focus:border-amber-300"
        >{{ old('description', $project?->description) }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="deadline" class="mb-2 block text-sm font-semibold text-amber-100">{{ __('Deadline') }}</label>
            <input
                id="deadline"
                name="deadline"
                type="date"
                value="{{ old('deadline', optional($project?->deadline)->format('Y-m-d') ?? $project?->deadline) }}"
                class="w-full rounded-xl border border-amber-500/30 bg-black/40 px-4 py-3 text-amber-50 outline-none transition focus:border-amber-300"
            >
            @error('deadline')
                <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="mb-2 block text-sm font-semibold text-amber-100">{{ __('Status') }}</label>
            <select
                id="status"
                name="status"
                class="w-full rounded-xl border border-amber-500/30 bg-black/40 px-4 py-3 text-amber-50 outline-none transition focus:border-amber-300"
                required
            >
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(old('status', $project?->status?->value ?? $project?->status) === $status->value)>
                        {{ str($status->value)->replace('_', ' ')->title() }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
