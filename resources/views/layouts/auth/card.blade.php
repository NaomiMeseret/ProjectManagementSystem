<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="pm-theme min-h-screen antialiased">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="pm-auth-shell">
                <a href="{{ route('home') }}" class="mb-6 flex flex-col items-center gap-3 text-center" wire:navigate>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl border border-amber-400/55 bg-amber-300/15 shadow-lg shadow-amber-900/30">
                        <x-app-logo-icon class="size-7 fill-current text-amber-300" />
                    </span>
                    <span class="pm-eyebrow">{{ config('app.name', 'Project Management System') }}</span>
                </a>

                <div class="pm-auth-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
