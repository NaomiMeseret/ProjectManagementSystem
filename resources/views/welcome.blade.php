<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <title>{{ config('app.name', 'Project Management System') }}</title>
    </head>
    <body class="pm-theme min-h-screen antialiased">
        <main class="mx-auto flex min-h-svh w-full max-w-7xl flex-col justify-center px-6 py-10 md:px-10">
            <section class="pm-panel pm-fade-up overflow-hidden p-6 md:p-10">
                <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl space-y-4">
                        <p class="pm-eyebrow">{{ __('Mini Project Management System') }}</p>
                        <h1 class="pm-title text-4xl md:text-5xl">
                            {{ __('Plan work, ship faster, and stay accountable.') }}
                        </h1>
                        <p class="pm-subtitle max-w-2xl">
                            {{ __('Organize projects, assign tasks, and keep teams moving with clear priorities, due dates, and progress tracking.') }}
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-amber-300/70 bg-amber-300 px-5 py-3 text-sm font-semibold text-amber-950 transition hover:bg-amber-200"
                            >
                                {{ __('Open Dashboard') }}
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-amber-300/70 bg-amber-300 px-5 py-3 text-sm font-semibold text-amber-950 transition hover:bg-amber-200"
                            >
                                {{ __('Log In') }}
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-flex items-center justify-center rounded-xl border border-amber-300/45 bg-transparent px-5 py-3 text-sm font-semibold text-amber-100 transition hover:bg-amber-300/10"
                                >
                                    {{ __('Create Account') }}
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </section>

            <section class="mt-6 grid gap-4 md:grid-cols-3">
                <article class="pm-panel-soft p-5">
                    <p class="pm-eyebrow">{{ __('Project Planning') }}</p>
                    <p class="mt-3 text-sm text-amber-100/75">
                        {{ __('Define project goals, set deadlines, and maintain a structured roadmap from kickoff to delivery.') }}
                    </p>
                </article>

                <article class="pm-panel-soft p-5">
                    <p class="pm-eyebrow">{{ __('Team Execution') }}</p>
                    <p class="mt-3 text-sm text-amber-100/75">
                        {{ __('Assign work by priority, monitor progress in real time, and keep everyone focused on the next action.') }}
                    </p>
                </article>

                <article class="pm-panel-soft p-5">
                    <p class="pm-eyebrow">{{ __('Delivery Insights') }}</p>
                    <p class="mt-3 text-sm text-amber-100/75">
                        {{ __('Review completion trends, upcoming deadlines, and workload balance to make better planning decisions.') }}
                    </p>
                </article>
            </section>
        </main>
    </body>
</html>
