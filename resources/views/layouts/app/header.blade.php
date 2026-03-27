<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="pm-theme min-h-screen">
        <flux:header container class="border-b border-amber-500/30 bg-black/70 backdrop-blur-md">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navbar.item>
                @can('viewAny', \App\Models\Project::class)
                    <flux:navbar.item icon="folder" :href="route('projects.index')" :current="request()->routeIs('projects.*')" wire:navigate>
                        {{ __('Projects') }}
                    </flux:navbar.item>
                @endcan
                @can('viewAny', \App\Models\Task::class)
                    <flux:navbar.item icon="clipboard-document-list" :href="route('tasks.index')" :current="request()->routeIs('tasks.*', 'projects.tasks.*')" wire:navigate>
                        {{ __('Tasks') }}
                    </flux:navbar.item>
                @endcan
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                <flux:tooltip :content="__('Settings')" position="bottom">
                    <flux:navbar.item
                        class="h-10 [&>div>svg]:size-5"
                        icon="cog-8-tooth"
                        :href="route('profile.edit')"
                        :label="__('Settings')"
                        wire:navigate
                    />
                </flux:tooltip>
            </flux:navbar>

            <x-desktop-user-menu />
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-amber-500/30 bg-black/75 backdrop-blur-md">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')">
                    <flux:sidebar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard')  }}
                    </flux:sidebar.item>
                    @can('viewAny', \App\Models\Project::class)
                        <flux:sidebar.item icon="folder" :href="route('projects.index')" :current="request()->routeIs('projects.*')" wire:navigate>
                            {{ __('Projects') }}
                        </flux:sidebar.item>
                    @endcan
                    @can('viewAny', \App\Models\Task::class)
                        <flux:sidebar.item icon="clipboard-document-list" :href="route('tasks.index')" :current="request()->routeIs('tasks.*', 'projects.tasks.*')" wire:navigate>
                            {{ __('Tasks') }}
                        </flux:sidebar.item>
                    @endcan
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="cog-8-tooth" :href="route('profile.edit')" :current="request()->routeIs('profile.edit', 'user-password.edit', 'two-factor.show', 'appearance.edit')" wire:navigate>
                    {{ __('Settings') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
