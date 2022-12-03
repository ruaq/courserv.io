<div x-data="{ settings: false }" @keydown.escape="settings = false" class="relative">
    <a href="#" @click="settings = !settings" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">{{ _i('Settings') }}</a>

    <x-nav.settings-flyout />
</div>
