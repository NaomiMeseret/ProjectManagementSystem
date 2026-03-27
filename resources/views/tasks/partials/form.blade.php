@php
    $task ??= null;
@endphp

<div class="grid gap-5">
    <div>
        <label for="title" class="mb-2 block text-sm font-semibold text-amber-100">{{ __('Task Title') }}</label>
        <input
            id="title"
            name="title"
            type="text"
            value="{{ old('title', $task?->title) }}"
            class="w-full rounded-xl border border-amber-500/30 bg-black/40 px-4 py-3 text-amber-50 outline-none transition focus:border-amber-300"
            required
        >
        @error('title')
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
        >{{ old('description', $task?->description) }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        <div>
            <label for="assigned_to" class="mb-2 block text-sm font-semibold text-amber-100">{{ __('Assigned Developer') }}</label>
            <select
                id="assigned_to"
                name="assigned_to"
                class="w-full rounded-xl border border-amber-500/30 bg-black/40 px-4 py-3 text-amber-50 outline-none transition focus:border-amber-300"
                required
            >
                @foreach ($developers as $developer)
                    <option value="{{ $developer->id }}" @selected((int) old('assigned_to', $task?->assigned_to) === (int) $developer->id)>
                        {{ $developer->name }}
                    </option>
                @endforeach
            </select>
            @error('assigned_to')
                <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="priority" class="mb-2 block text-sm font-semibold text-amber-100">{{ __('Priority') }}</label>
            <select
                id="priority"
                name="priority"
                class="w-full rounded-xl border border-amber-500/30 bg-black/40 px-4 py-3 text-amber-50 outline-none transition focus:border-amber-300"
                required
            >
                @foreach ($priorities as $priority)
                    <option value="{{ $priority->value }}" @selected(old('priority', $task?->priority?->value ?? $task?->priority) === $priority->value)>
                        {{ str($priority->value)->title() }}
                    </option>
                @endforeach
            </select>
            @error('priority')
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
                    <option value="{{ $status->value }}" @selected(old('status', $task?->status?->value ?? $task?->status) === $status->value)>
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
