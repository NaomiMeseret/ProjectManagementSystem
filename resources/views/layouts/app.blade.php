<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        <div class="pm-page-wrap">
            {{ $slot }}
        </div>
    </flux:main>
</x-layouts::app.sidebar>
