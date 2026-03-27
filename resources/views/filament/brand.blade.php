@php
    $brandName = filament()->getBrandName();
@endphp

<div class="fi-logo flex items-center gap-5">
    <img src="{{ asset('images/logo.png') }}" alt="{{ $brandName }}" class="h-6 w-6" />
    <span class="text-xl font-bold tracking-wide">{{ $brandName }}</span>
</div>
