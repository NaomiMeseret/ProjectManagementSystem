<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="pm-theme min-h-screen antialiased">
        <div class="grid min-h-svh items-center px-6 py-8 lg:grid-cols-2 lg:px-10">
            <div class="pm-panel relative hidden h-full min-h-[30rem] overflow-hidden p-10 lg:flex lg:flex-col">
                <div class="absolute -top-16 left-10 h-52 w-52 rounded-full bg-amber-400/15 blur-3xl"></div>
                <div class="absolute -bottom-20 right-0 h-60 w-60 rounded-full bg-amber-700/10 blur-3xl"></div>

                <a href="{{ route('home') }}" class="relative z-10 flex items-center gap-3 text-lg font-semibold text-amber-100" wire:navigate>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl border border-amber-400/55 bg-amber-300/15">
                        <x-app-logo-icon class="h-6 fill-current text-amber-300" />
                    </span>
                    {{ config('app.name', 'Project Management System') }}
                </a>

                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp

                <div class="relative z-10 mt-auto">
                    <blockquote class="space-y-2">
                        <p class="text-2xl leading-relaxed font-medium text-amber-100/90">&ldquo;{{ trim($message) }}&rdquo;</p>
                        <footer class="pm-eyebrow !tracking-[0.12em]">{{ trim($author) }}</footer>
                    </blockquote>
                </div>
            </div>

            <div class="w-full lg:px-10">
                <div class="mx-auto flex w-full max-w-md flex-col justify-center">
                    <a href="{{ route('home') }}" class="mb-6 flex flex-col items-center gap-3 text-center lg:hidden" wire:navigate>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl border border-amber-400/55 bg-amber-300/15">
                            <x-app-logo-icon class="size-7 fill-current text-amber-300" />
                        </span>
                        <span class="pm-eyebrow">{{ config('app.name', 'Project Management System') }}</span>
                    </a>

                    <div class="pm-auth-card">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
