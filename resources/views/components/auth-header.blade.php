@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <span class="pm-eyebrow mb-2">{{ __('Secure Access') }}</span>
    <h1 class="pm-title text-2xl md:text-3xl">{{ $title }}</h1>
    <p class="pm-subtitle mt-2">{{ $description }}</p>
</div>
