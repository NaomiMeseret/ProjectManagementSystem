<div class="pm-panel p-4 md:p-6">
    <div class="flex items-start gap-6 max-md:flex-col">
        <div class="w-full md:w-[240px]">
            <flux:navlist aria-label="{{ __('Settings') }}" class="pm-panel-soft p-2">
            <flux:navlist.item :href="route('profile.edit')" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
            <flux:navlist.item :href="route('user-password.edit')" wire:navigate>{{ __('Password') }}</flux:navlist.item>
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <flux:navlist.item :href="route('two-factor.show')" wire:navigate>{{ __('Two-factor auth') }}</flux:navlist.item>
            @endif
            <flux:navlist.item :href="route('appearance.edit')" wire:navigate>{{ __('Appearance') }}</flux:navlist.item>
        </flux:navlist>
        </div>

        <flux:separator class="md:hidden" />

        <div class="flex-1 self-stretch max-md:pt-2">
            <h2 class="text-xl font-semibold text-amber-100">{{ $heading ?? '' }}</h2>
            <p class="mt-1 text-sm text-amber-100/70">{{ $subheading ?? '' }}</p>

            <div class="mt-6 w-full max-w-2xl">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
