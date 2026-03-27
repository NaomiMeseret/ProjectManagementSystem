@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Project Management System" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-lg border border-amber-300/70 bg-amber-300/15 text-accent-foreground">
            <x-app-logo-icon class="size-5 fill-current text-amber-300" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Project Management System" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-lg border border-amber-300/70 bg-amber-300/15 text-accent-foreground">
            <x-app-logo-icon class="size-5 fill-current text-amber-300" />
        </x-slot>
    </flux:brand>
@endif
