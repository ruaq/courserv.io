@props([
    'metaTitle' => '',
    'siteTitle',
    'active' => '',
    'breadcrumb_back' => ['link' => route('home'), 'text' => 'Home'],
    'breadcrumbs' => [['link' => route('home'), 'text' => 'Home']],
])

<x-layouts.base :metaTitle="$metaTitle">

    <div class="min-h-full">
        <header x-data="{ open: false }" @keydown.escape="open = false" class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex px-2 lg:px-0">
                        <div class="flex flex-shrink-0 items-center">
                            <a href="#">
                                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=blue&shade=600" alt="Your Company">
                            </a>
                        </div>
                        <nav aria-label="Global" class="hidden lg:ml-6 lg:flex lg:items-center lg:space-x-4">
                            <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium text-gray-900">Dashboard</a>

                            @can('viewAny', \App\Models\Course::class)
                                <a href="{{ route('course') }}" class="px-3 py-2 text-sm font-medium text-gray-900">{{ _i('Courses') }}</a>
                            @endcan

                            @can('viewAny', \App\Models\Participant::class)
                                <a href="#" class="px-3 py-2 text-sm font-medium text-gray-900">{{ _i('participants') }}</a>
                            @endcan

                            <x-nav.settings />

{{--                            <a href="#" class="px-3 py-2 text-sm font-medium text-gray-900">Company</a>--}}
                        </nav>
                    </div>
                    <div class="flex flex-1 items-center justify-center px-2 lg:ml-6 lg:justify-end">
                        <div class="w-full max-w-lg lg:max-w-xs">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <!-- Heroicon name: mini/magnifying-glass -->
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="search" name="search" class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-3 leading-5 placeholder-gray-500 shadow-sm focus:border-blue-600 focus:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-600 sm:text-sm" placeholder="Search" type="search">
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center lg:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" @click="open = true" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                            <span class="sr-only">Open main menu</span>
                            <!-- Heroicon name: outline/bars-3 -->
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile menu, show/hide based on mobile menu state. -->
                    <div class="lg:hidden">
                        <!--
                          Mobile menu overlay, show/hide based on mobile menu state.

                          Entering: "duration-150 ease-out"
                            From: "opacity-0"
                            To: "opacity-100"
                          Leaving: "duration-150 ease-in"
                            From: "opacity-100"
                            To: "opacity-0"
                        -->
                        <div x-show="open"
                             x-transition:enter="duration-150 ease-out"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="duration-150 ease-in"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 z-20 bg-black bg-opacity-25" aria-hidden="true" style="display: none;"></div>

                        <!--
                          Mobile menu, show/hide based on mobile menu state.

                          Entering: "duration-150 ease-out"
                            From: "opacity-0 scale-95"
                            To: "opacity-100 scale-100"
                          Leaving: "duration-150 ease-in"
                            From: "opacity-100 scale-100"
                            To: "opacity-0 scale-95"
                        -->
                        <div x-show="open"
                             x-transition:enter="duration-150 ease-out"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="duration-150 ease-in"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute top-0 right-0 z-30 w-full max-w-none origin-top transform p-2 transition"
                             @click.outside="open = false"
                             style="display: none;">
                            <div class="divide-y divide-gray-200 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                                <div class="pt-3 pb-2">
                                    <div class="flex items-center justify-between px-4">
                                        <div>
                                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=blue&shade=600" alt="Your Company">
                                        </div>
                                        <div class="-mr-2">
                                            <button type="button" class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" @click="open = false" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                                                <span class="sr-only">Close menu</span>
                                                <!-- Heroicon name: outline/x-mark -->
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-3 space-y-1 px-2">
                                        <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Dashboard</a>

                                        @can('viewAny', \App\Models\Course::class)
                                            <a href="{{ route('course') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">{{ _i('Courses') }}</a>
                                        @endcan

                                        @can('viewAny', \App\Models\Participant::class)
                                            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">{{ _i('participants') }}</a>
                                        @endcan

                                        <x-nav.settings-mobile />

{{--                                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Company</a>--}}
                                    </div>
                                </div>
                                <div class="pt-4 pb-2">
                                    <div class="flex items-center px-5">
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80" alt="">
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-base font-medium text-gray-800">Whitney Francis</div>
                                            <div class="text-sm font-medium text-gray-500">whitney@example.com</div>
                                        </div>
                                        <button type="button" class="ml-auto flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            <span class="sr-only">View notifications</span>
                                            <!-- Heroicon name: outline/bell -->
                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mt-3 space-y-1 px-2">
                                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Your Profile</a>

                                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Settings</a>

                                        <a href="#" @click.prevent="window.livewire.emit('logout')" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">{{ _i('Logout') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:ml-4 lg:flex lg:items-center">
                        <button type="button" class="flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <span class="sr-only">View notifications</span>
                            <!-- Heroicon name: outline/bell -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>

                        <!-- Profile dropdown -->
                        <div x-data="{ profileDropdown: false }" @click.outside="profileDropdown = false" class="relative ml-4 flex-shrink-0">
                            <div>
                                <button type="button" @click="profileDropdown = !profileDropdown" class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80" alt="">
                                </button>
                            </div>

                            <!--
                              Dropdown menu, show/hide based on menu state.

                              Entering: "transition ease-out duration-100"
                                From: "transform opacity-0 scale-95"
                                To: "transform opacity-100 scale-100"
                              Leaving: "transition ease-in duration-75"
                                From: "transform opacity-100 scale-100"
                                To: "transform opacity-0 scale-95"
                            -->

                            <div x-show="profileDropdown"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 style="display: none;"
                                 class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <!-- Active: "bg-gray-100", Not Active: "" -->
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>

                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>

                                <a href="#" @click.prevent="window.livewire.emit('logout')" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">{{ _i('Logout') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="border-t border-gray-200 py-3">
                    <nav class="flex" aria-label="Breadcrumb">
                        <div class="flex sm:hidden">
                            <a href="{{ url($breadcrumb_back['link']) }}" class="group inline-flex space-x-3 text-sm font-medium text-gray-500 hover:text-gray-700">
                                @if(count($breadcrumbs) === 1 && $breadcrumb_back['text'] != 'Home')
                                    <!-- Heroicon name: mini/folder -->
                                    <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M4.75 3A1.75 1.75 0 003 4.75v2.752l.104-.002h13.792c.035 0 .07 0 .104.002V6.75A1.75 1.75 0 0015.25 5h-3.836a.25.25 0 01-.177-.073L9.823 3.513A1.75 1.75 0 008.586 3H4.75zM3.104 9a1.75 1.75 0 00-1.673 2.265l1.385 4.5A1.75 1.75 0 004.488 17h11.023a1.75 1.75 0 001.673-1.235l1.384-4.5A1.75 1.75 0 0016.896 9H3.104z" />
                                    </svg>
                                @elseif(count($breadcrumbs) === 1 && $breadcrumb_back['text'] == 'Home')
                                    <!-- Heroicon name: mini/home -->
                                    <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <!-- Heroicon name: mini/arrow-long-left -->
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                                <span>{{ _i($breadcrumb_back['text']) }}</span>
                            </a>
                        </div>
                        <div class="hidden sm:block">
                            <ol role="list" class="flex items-center space-x-4">
                                <li>
                                    <div>
                                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                            <!-- Heroicon name: mini/home -->
                                            <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="sr-only">Home</span>
                                        </a>
                                    </div>
                                </li>

                                @foreach($breadcrumbs as $breadcrumb)
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                            </svg>
                                            <a href="{{ url($breadcrumb['link']) }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ _i($breadcrumb['text']) }}</a>
                                        </div>
                                    </li>
                                @endforeach

{{--                                <li>--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">--}}
{{--                                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />--}}
{{--                                        </svg>--}}
{{--                                        <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Front End Developer</a>--}}
{{--                                    </div>--}}
{{--                                </li>--}}

{{--                                <li>--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">--}}
{{--                                            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />--}}
{{--                                        </svg>--}}
{{--                                        <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Applicants</a>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
                            </ol>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <div class="py-10">
{{--            <header>--}}
{{--                <div class="mx-auto px-4 sm:px-6 lg:px-8">--}}
{{--                    <h1 class="text-3xl font-bold leading-tight text-gray-900">--}}
{{--                        {{ $siteTitle ?? $metaTitle }}--}}
{{--                    </h1>--}}
{{--                </div>--}}
{{--            </header>--}}
            <main>
                <div class="mx-auto sm:px-6 lg:px-8">
                    <!-- Replace with your content -->
{{--                    <div class="px-4 py-8 sm:px-0">--}}
                        {{ $slot }}
{{--                    </div>--}}
                    <!-- /End replace -->
                </div>
            </main>
        </div>
    </div>

</x-layouts.base>
