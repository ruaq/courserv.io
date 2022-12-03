<div x-data="{ settings: false }" @keydown.escape="settings = false" class="relative">
    <x-button.link @click="settings = !settings" class="px-3 py-2 text-sm font-medium text-gray-900">{{ _i('Settings') }}</x-button.link>

    <x-nav.settings-flyout />
</div>
