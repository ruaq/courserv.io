<div>

{{--    <div class="space-y-4 py-4">--}}
{{--        <div class="flex justify-between">--}}
{{--            <div class="flex w-2/4 space-x-4">--}}
{{--                <x-input.text wire:model="filters.search" placeholder="{{ _i('Search...') }}" />--}}

{{--                <x-button.link wire:click="toggleShowFilters">@if ($showFilters) Hide @endif Advanced Search...</x-button.link>--}}
{{--            </div>--}}

{{--            <div class="flex items-center space-x-2">--}}
{{--                <x-input.group borderless paddingless for="perPage" label="Per Page">--}}
{{--                    <x-input.select wire:model="perPage" id="perPage">--}}
{{--                        <option value="10">10</option>--}}
{{--                        <option value="25">25</option>--}}
{{--                        <option value="50">50</option>--}}
{{--                    </x-input.select>--}}
{{--                </x-input.group>--}}

{{--                @can('create', \App\Models\Course::class)--}}
{{--                    <x-button.primary wire:click="create"><x-icon.plus /> {{ _i('Add Course') }}</x-button.primary>--}}
{{--                @endcan--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- Advanced Search -->--}}
{{--        <div>--}}
{{--            @if ($showFilters)--}}
{{--                <div class="bg-cool-gray-200 relative flex rounded p-4 shadow-inner">--}}
{{--                    <div class="w-1/2 space-y-4 pr-2">--}}
{{--                        <x-input.group inline for="filter-courseType" label="{{ _i('course type') }}">--}}
{{--                            <x-input.select wire:model="filters.courseType" id="filter-courseType">--}}
{{--                                <option value="" disabled>{{ _i('select course type...') }}</option>--}}
{{--                                @foreach($courseTypes as $category => $courseType)--}}
{{--                                    <optgroup label="{{ $category }}">--}}
{{--                                        @foreach($courseType as $ct)--}}
{{--                                            <option value="{{ $ct['id'] }}">{{ $ct['name'] }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </optgroup>--}}
{{--                                @endforeach--}}
{{--                            </x-input.select>--}}
{{--                        </x-input.group>--}}

{{--                        <x-input.group inline for="filter-team" label="{{ _i('team') }}">--}}
{{--                            <x-input.select wire:model="filters.team" id="filter-team">--}}
{{--                                <option value="" disabled>{{ _i('select team...') }}</option>--}}
{{--                                    @foreach($ownTeams as $team)--}}
{{--                                        <option value="{{ $team['id'] }}">{{ $team['display_name'] }}</option>--}}
{{--                                    @endforeach--}}
{{--                            </x-input.select>--}}
{{--                        </x-input.group>--}}

{{--                        <x-input.group inline for="filter-showCancelled" label="{{ _i('cancelled courses') }}">--}}
{{--                            <x-input.select wire:model="filters.showCancelled" id="filter-showCancelled">--}}
{{--                                <option value="">{{ _i('don\'t show cancelled courses') }}</option>--}}
{{--                                <option value="true">{{ _i('show cancelled courses') }}</option>--}}
{{--                            </x-input.select>--}}
{{--                        </x-input.group>--}}
{{--                    </div>--}}

{{--                    <div class="w-1/2 space-y-4 pl-2">--}}
{{--                        <x-input.group inline for="filter-date-min" label="{{ _i('minimum date') }}">--}}
{{--                            <x-input.date wire:model="filters.date-min" id="filter-date-min" :options="$search_options"/>--}}
{{--                        </x-input.group>--}}

{{--                        <x-input.group inline for="filter-date-max" label="{{ _i('maximum date') }}">--}}
{{--                            <x-input.date wire:model="filters.date-max" id="filter-date-max" :options="$search_options"/>--}}
{{--                        </x-input.group>--}}

{{--                        <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">{{ _i('reset filters') }}</x-button.link>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}

{{--        <div class="flex-col space-y-4">--}}
{{--            <x-table>--}}
{{--                <x-slot name="head">--}}
{{--                    <x-table.heading sortable multi-column wire:click="sortBy('seminar_location')" :direction="$sorts['seminar_location'] ?? null">{{ _i('seminar location') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column wire:click="sortBy('street')" :direction="$sorts['street'] ?? null">{{ _i('street') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column wire:click="sortBy('location')" :direction="$sorts['location'] ?? null">{{ _i('location') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column wire:click="sortBy('start')" :direction="$sorts['start'] ?? null">{{ _i('start') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column wire:click="sortBy('course_type_id')" :direction="$sorts['course_type_id'] ?? null">{{ _i('course type') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column wire:click="sortBy('internal_number')" :direction="$sorts['internal_number'] ?? null">{{ _i('internal') }}</x-table.heading>--}}
{{--                    @if(config('qseh.codeNumber'))--}}
{{--                        <x-table.heading sortable multi-column wire:click="sortBy('registration_number')" :direction="$sorts['registration_number'] ?? null">{{ _i('qseh') }}</x-table.heading>--}}
{{--                    @endif--}}
{{--                    <x-table.heading sortable multi-column wire:click="sortBy('team_id')" :direction="$sorts['team_id'] ?? null">{{ _i('team') }}</x-table.heading>--}}
{{--                    <x-table.heading></x-table.heading>--}}
{{--                    <x-table.heading></x-table.heading>--}}
{{--                </x-slot>--}}

{{--                <x-slot name="body">--}}
{{--                    @foreach($courses as $course)--}}
{{--                        <x-table.row class="{{ $course->cancelled ? 'line-through' : '' }}">--}}
{{--                            <x-table.cell>{{ $course->seminar_location }}</x-table.cell>--}}
{{--                            <x-table.cell>{{ $course->street }}</x-table.cell>--}}
{{--                            <x-table.cell>{{ $course->zipcode }} {{ $course->location }}</x-table.cell>--}}
{{--                            <x-table.cell>{{ $course->start->format('d.m.Y H:i') }}</x-table.cell>--}}
{{--                            <x-table.cell>{{ $course->type->name }}</x-table.cell>--}}
{{--                            <div {{ ($course->internal_number == 'queued') ? "wire:poll.visible.5s" : '' }}>--}}
{{--                                <x-table.cell>{{ $course->internal_number }}</x-table.cell>--}}
{{--                            </div>--}}
{{--                            @if(config('qseh.codeNumber'))--}}
{{--                                <div {{ ($course->registration_number == 'queued') ? "wire:poll.visible.5s" : '' }}>--}}
{{--                                    <x-table.cell>{{ $course->registration_number }}</x-table.cell>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <x-table.cell>{{ $course->team->display_name }}</x-table.cell>--}}
{{--                            <x-table.cell>--}}
{{--                                @can('update', $course)--}}
{{--                                    <x-button.link wire:click="participant({{ $course->id }})">{{ _i('participants') }}</x-button.link>--}}
{{--                                @endcan--}}
{{--                            </x-table.cell>--}}
{{--                            <x-table.cell>--}}
{{--                                @can('update', $course)--}}
{{--                                    <x-button.link wire:click="edit({{ $course->id }})">{{ _i('edit') }}</x-button.link>--}}
{{--                                @endcan--}}
{{--                            </x-table.cell>--}}
{{--                        </x-table.row>--}}
{{--                    @endforeach--}}
{{--                </x-slot>--}}
{{--            </x-table>--}}
{{--            <div>--}}
{{--                {{ $courses->links() }}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between">
            <div class="flex w-2/4 space-x-4">
                <div>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <input type="text" wire:model="filters.search" placeholder="{{ _i('Search...') }}" class="block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <!-- Heroicon name: mini/magnifying-glass -->
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

{{--                <x-input.text wire:model="filters.search" placeholder="{{ _i('Search...') }}" />--}}

                <x-button.link wire:click="toggleShowFilters">@if ($showFilters) <i class="fa-solid fa-magnifying-glass-minus"></i> @else <i class="fa-solid fa-magnifying-glass-plus"></i> @endif</x-button.link>
            </div>

            <div class="flex items-center space-x-2">
                <div class="flex items-center" x-data="{ showOnlyOwnCourses: @entangle('showOnlyOwnCourses') }">
                    <span class="mr-3 hidden lg:block" id="public-bookable-label" @click="showOnlyOwnCourses = !showOnlyOwnCourses; $refs.switch.focus()">
                        <span class="text-sm font-medium text-gray-900">{{ _i('show only own courses') }}</span>
                    </span>
                    <button type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-gray-200" role="switch" aria-checked="false" x-ref="switch" :aria-checked="showOnlyOwnCourses" @click="showOnlyOwnCourses = !showOnlyOwnCourses" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-600': showOnlyOwnCourses, 'bg-gray-200': !(showOnlyOwnCourses) }">
                        <span class="sr-only">{{ _i('show only own courses') }}</span>
                        <span class="pointer-events-none relative inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': showOnlyOwnCourses, 'translate-x-0': !(showOnlyOwnCourses) }">
                            <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity opacity-100 ease-in duration-200" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'opacity-0 ease-out duration-100': showOnlyOwnCourses, 'opacity-100 ease-in duration-200': !(showOnlyOwnCourses) }">
                                <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                  <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                            <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity opacity-0 ease-out duration-100" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'opacity-100 ease-in duration-200': showOnlyOwnCourses, 'opacity-0 ease-out duration-100': !(showOnlyOwnCourses) }">
                                <svg class="h-3 w-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                                  <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"></path>
                                </svg>
                            </span>
                        </span>
                    </button>
                </div>

                <x-input.group borderless paddingless for="perPage" label="">
                    <x-input.select wire:model="perPage" id="perPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </x-input.select>
                </x-input.group>
            </div>
        </div>

        <!-- Advanced Search -->
        <div>
            @if ($showFilters)
                <div class="bg-cool-gray-200 relative flex rounded p-4 shadow-inner">
                    <div class="w-1/2 space-y-4 pr-2">
                        <x-input.group inline for="filter-courseType" label="{{ _i('course type') }}">
                            <x-input.select wire:model="filters.courseType" id="filter-courseType">
                                <option value="" disabled>{{ _i('select course type...') }}</option>
                                @foreach($courseTypes as $category => $courseType)
                                    <optgroup label="{{ $category }}">
                                        @foreach($courseType as $ct)
                                            <option value="{{ $ct['id'] }}">{{ $ct['name'] }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </x-input.select>
                        </x-input.group>

                        <x-input.group inline for="filter-team" label="{{ _i('team') }}">
                            <x-input.select wire:model="filters.team" id="filter-team">
                                <option value="" disabled>{{ _i('select team...') }}</option>
                                @foreach($ownTeams as $team)
                                    <option value="{{ $team['id'] }}">{{ $team['display_name'] }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>

                        <x-input.group inline for="filter-showCancelled" label="{{ _i('cancelled courses') }}">
                            <x-input.select wire:model="filters.showCancelled" id="filter-showCancelled">
                                <option value="">{{ _i('don\'t show cancelled courses') }}</option>
                                <option value="true">{{ _i('show cancelled courses') }}</option>
                            </x-input.select>
                        </x-input.group>
                    </div>

                    <div class="w-1/2 space-y-4 pl-2">
                        <x-input.group inline for="filter-date-min" label="{{ _i('minimum date') }}">
                            <x-input.date wire:model="filters.date-min" id="filter-date-min" :options="$search_options"/>
                        </x-input.group>

                        <x-input.group inline for="filter-date-max" label="{{ _i('maximum date') }}">
                            <x-input.date wire:model="filters.date-max" id="filter-date-max" :options="$search_options"/>
                        </x-input.group>

                        <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">{{ _i('reset filters') }}</x-button.link>
                    </div>
                </div>
            @endif
        </div>

        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">

            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                @can('create', \App\Models\Course::class)
                    <button wire:click="create" type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">{{ _i('Add Course') }}</button>
                @endcan
            </div>
        </div>
        <div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <x-table.heading sortable multi-column wire:click="sortBy('seminar_location')" :direction="$sorts['seminar_location'] ?? null" class="py-3.5 pl-4 pr-3 text-left text-xs lg:text-sm font-semibold text-gray-900 sm:pl-6">{{ _i('seminar location') }}</x-table.heading>
{{--                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ _i('seminar location') }}</th>--}}
                    <x-table.heading sortable multi-column wire:click="sortBy('street')" :direction="$sorts['street'] ?? null" class="hidden px-3 py-3.5 text-left text-xs lg:text-sm font-semibold text-gray-900 xl:table-cell">{{ _i('street') }}</x-table.heading>
{{--                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 xl:table-cell">{{ _i('street') }}</th>--}}
                    <x-table.heading sortable multi-column wire:click="sortBy('location')" :direction="$sorts['location'] ?? null" class="hidden px-3 py-3.5 text-left text-xs lg:text-sm font-semibold text-gray-900 sm:table-cell">{{ _i('location') }}</x-table.heading>
{{--                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">{{ _i('location') }}</th>--}}
                    <x-table.heading sortable multi-column wire:click="sortBy('start')" :direction="$sorts['start'] ?? null" class="px-3 py-3.5 text-left text-xs lg:text-sm font-semibold text-gray-900">{{ _i('start') }}</x-table.heading>
{{--                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ _i('start') }}</th>--}}
                    <x-table.heading sortable multi-column wire:click="sortBy('course_type_id')" :direction="$sorts['course_type_id'] ?? null" class="px-3 py-3.5 text-left text-xs lg:text-sm font-semibold text-gray-900">{{ _i('course type') }}</x-table.heading>
{{--                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ _i('course type') }}</th>--}}
                    <x-table.heading sortable multi-column wire:click="sortBy('internal_number')" :direction="$sorts['internal_number'] ?? null" class="hidden px-3 py-3.5 text-left text-xs lg:text-sm font-semibold text-gray-900 lg:table-cell">{{ _i('internal') }}</x-table.heading>
{{--                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">{{ _i('internal') }}</th>--}}
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-xs lg:text-sm font-semibold text-gray-900 lg:hidden md:table-cell sm:hidden">{{ _i('number') }}</th>
                    @if(config('qseh.codeNumber'))
                        <x-table.heading sortable multi-column wire:click="sortBy('registration_number')" :direction="$sorts['registration_number'] ?? null" class="hidden px-3 py-3.5 text-left text-xs lg:text-sm font-semibold text-gray-900 lg:table-cell">{{ _i('qseh') }}</x-table.heading>
{{--                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">{{ _i('qseh') }}</th>--}}
                    @endif
                    <x-table.heading sortable multi-column wire:click="sortBy('team_id')" :direction="$sorts['team_id'] ?? null" class="hidden px-3 py-3.5 text-left text-xs lg:text-sm font-semibold text-gray-900 lg:table-cell">{{ _i('team') }}</x-table.heading>
{{--                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">{{ _i('team') }}</th>--}}
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
{{--                        <span class="sr-only">Edit</span>--}}
                    </th>
                    <th scope="col" class="hidden relative py-3.5 pl-3 pr-4 sm:pr-6 sm:table-cell">
{{--                        <span class="sr-only">Edit</span>--}}
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($courses as $course)
                    <tr class="{{ $course->cancelled ? 'line-through' : '' }}">
                        <td class="w-full max-w-0 py-4 pl-4 pr-3 text-xs lg:text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                            {{ $course->seminar_location }}
                            <dl class="font-normal lg:hidden">
                                <dt class="sr-only">{{ _i('location') }}</dt>
    {{--                            <dd class="mt-1 truncate text-gray-700">XXX-end Developer</dd>--}}
{{--                                <dt class="sr-only sm:hidden">Email</dt>--}}
                                <dd class="mt-1 truncate text-gray-500 sm:hidden">{{ $course->location }}</dd>
                            </dl>
                        </td>
                        <td class="hidden px-3 py-4 text-xs lg:text-sm text-gray-500 xl:table-cell">{{ $course->street }}</td>
                        <td class="hidden px-3 py-4 text-xs lg:text-sm text-gray-500 sm:table-cell">
                            <dl class="xl:hidden">
                                <dt class="sr-only">{{ _i('street') }}</dt>
                                <dd class="mt-1 truncate text-gray-500">{{ $course->street }}</dd>
    {{--                            <dt class="sr-only sm:hidden">Email</dt>--}}
    {{--                            <dd class="mt-1 truncate text-gray-500 sm:hidden">lindsay.walton@example.com</dd>--}}
                            </dl>
                            {{ $course->zipcode }} {{ $course->location }}
                        </td>
                        <td class="px-3 py-4 text-xs lg:text-sm text-gray-500">{{ $course->start->format('d.m.Y H:i') }}</td>
                        <td class="px-3 py-4 text-xs lg:text-sm text-gray-500">{{ $course->type->name }}</td>
                        <div {{ ($course->internal_number == 'queued') ? "wire:poll.visible.5s" : '' }}>
                            <td class="hidden px-3 py-4 text-xs lg:text-sm text-gray-500 md:table-cell">
                                {{ $course->internal_number }}
                                <dl class="lg:hidden">
                                    <dt class="sr-only">{{ _i('qseh') }}</dt>
                                    <dd class="mt-1 truncate text-gray-500">{{ $course->registration_number }}</dd>
                                    {{--                            <dt class="sr-only sm:hidden">Email</dt>--}}
                                    {{--                            <dd class="mt-1 truncate text-gray-500 sm:hidden">lindsay.walton@example.com</dd>--}}
                                </dl>
                            </td>
                        </div>
                        @if(config('qseh.codeNumber'))
                            <div {{ ($course->registration_number == 'queued') ? "wire:poll.visible.5s" : '' }}>
                                <td class="hidden px-3 py-4 text-xs lg:text-sm text-gray-500 lg:table-cell">{{ $course->registration_number }}</td>
                            </div>
                        @endif
                        <td class="hidden px-3 py-4 text-xs lg:text-sm text-gray-500 lg:table-cell">{{ $course->team->display_name }}</td>
                        <td class="py-4 pl-3 pr-4 text-right text-xs lg:text-sm font-medium sm:pr-6">
                            @can('viewParticipants', $course)
                                <x-button.link wire:click="participant({{ $course->id }})"><i class="fa-solid fa-users-viewfinder"></i></x-button.link>
                            @else
                                <x-button.link disabled><i class="fa-solid fa-users-viewfinder"></i></x-button.link>
                            @endcan
    {{--                        <a href="#" class="text-indigo-600 hover:text-indigo-900"></a>--}}
                        </td>
                        <td class="hidden py-4 pl-3 pr-4 text-right text-xs lg:text-sm font-medium sm:pr-6 sm:table-cell">
                            @can('update', $course)
                                <x-button.link wire:click="edit({{ $course->id }})"><i class="fa-solid fa-pen-to-square"></i></x-button.link>
                            @else
                                <x-button.link disabled><i class="fa-solid fa-pen-to-square"></i></x-button.link>
                            @endcan
    {{--                        <a href="#" class="text-indigo-600 hover:text-indigo-900"><i class="fa-solid fa-pen-to-square"></i></a>--}}
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <div>
                {{ $courses->links() }}
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">{{ _i('edit course') }}</x-slot>
            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <label for="team" class="block text-sm font-medium text-gray-700">{{ _i('team') }}</label>
                        <select id="team" wire:model.lazy="editing.team_id" name="team" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            <option>{{ _i('select a team') }}</option>
                            @foreach($teams as $team)
                                <option value="{{ $team['id'] }}">{{ $team['display_name'] }}</option>
                            @endforeach
                        </select>
                        @error('editing.team_id')
                            <p class="mt-2 text-sm text-red-600" id="team-error">{{ $errors->first('editing.team_id') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="course_type" class="block text-sm font-medium text-gray-700">{{ _i('course type') }}</label>
                        <select id="course_type" wire:model.lazy="editing.course_type_id" name="course_type" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            <option value="">{{ _i('select a course type') }}</option>
                            @foreach($courseTypes as $category => $courseType)
                                <optgroup label="{{ $category }}">
                                    @foreach($courseType as $ct)
                                        <option value="{{ $ct['id'] }}">{{ $ct['name'] }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('editing.course_type')
                            <p class="mt-2 text-sm text-red-600" id="course_type-error">{{ $errors->first('editing.course_type_id') }}</p>
                        @enderror
                    </div>

                    <div>
                        @if($showRegisterCourse)
                            <div x-data="{ registerCourse: @entangle('registerCourse').defer }" class="space-y-3">
                                @if(!$courseRegistered && config('qseh.password'))
                                    <div class="flex items-center">
                                        <button type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-gray-200" role="switch" aria-checked="false" x-ref="switch" :aria-checked="registerCourse" @click="registerCourse = !registerCourse" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-600': registerCourse, 'bg-gray-200': !(registerCourse) }">
                                            <span class="sr-only">{{ _i('register automatically at QSEH') }}</span>
                                            <span class="pointer-events-none relative inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': registerCourse, 'translate-x-0': !(registerCourse) }">
                                            <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity opacity-100 ease-in duration-200" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'opacity-0 ease-out duration-100': registerCourse, 'opacity-100 ease-in duration-200': !(registerCourse) }">
                                                <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                                  <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>
                                            <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity opacity-0 ease-out duration-100" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'opacity-100 ease-in duration-200': registerCourse, 'opacity-0 ease-out duration-100': !(registerCourse) }">
                                                <svg class="h-3 w-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                                                  <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"></path>
                                                </svg>
                                            </span>
                                        </span>
                                        </button>
                                        <span class="ml-3" id="register-course-label" @click="registerCourse = !registerCourse; $refs.switch.focus()">
                                            <span class="text-sm font-medium text-gray-900">{{ _i('register automatically at QSEH') }}</span>
                                        </span>
                                    </div>
                                @endif

                                <div x-show="!registerCourse">
                                    <label for="registration_number" class="block text-sm font-medium text-gray-700">{{ _i('QSEH registration number') }}</label>
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <input {{ $courseRegistered ? 'disabled' : '' }} type="text" wire:model.lazy="editing.registration_number" name="{{ _i('QSEH registration number') }}" id="units" class="@error('editing.registration_number') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('QSEH registration number') }}" @error('editing.registration_number') aria-invalid="true" aria-describedby="registration_number-error" @enderror>
                                        @error('editing.registration_number')
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <!-- Heroicon name: solid/exclamation-circle -->
                                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('editing.registration_number')
                                        <p class="mt-2 text-sm text-red-600" id="registration_number-error">{{ $errors->first('editing.registration_number') }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>

                    <div x-data="{ publicBookable: @entangle('editing.public_bookable').defer }" class="space-y-3">
                        <div class="flex items-center">
                            <button type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-gray-200" role="switch" aria-checked="false" x-ref="switch" :aria-checked="publicBookable" @click="publicBookable = !publicBookable" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-600': publicBookable, 'bg-gray-200': !(publicBookable) }">
                                <span class="sr-only">{{ _i('public bookable') }}</span>
                                <span class="pointer-events-none relative inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': publicBookable, 'translate-x-0': !(publicBookable) }">
                                    <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity opacity-100 ease-in duration-200" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'opacity-0 ease-out duration-100': publicBookable, 'opacity-100 ease-in duration-200': !(publicBookable) }">
                                        <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                          <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                    <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity opacity-0 ease-out duration-100" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'opacity-100 ease-in duration-200': publicBookable, 'opacity-0 ease-out duration-100': !(publicBookable) }">
                                        <svg class="h-3 w-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                                          <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"></path>
                                        </svg>
                                    </span>
                                </span>
                            </button>
                            <span class="ml-3" id="public-bookable-label" @click="publicBookable = !publicBookable; $refs.switch.focus()">
                                <span class="text-sm font-medium text-gray-900">{{ _i('public bookable') }}</span>
                            </span>
                        </div>

                        <div x-show="publicBookable">
                            <fieldset class="space-y-5">
                                <legend class="sr-only">{{ _i('Prices') }}</legend>
                                @foreach($prices as $price)
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input wire:model="priceIds" value="{{ $price->id }}" id="{{ $price->title }}-{{ $price->id }}" aria-describedby="{{ $price->title }}-{{ $price->id }}-description" name="{{ $price->title }}-{{ $price->id }}" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="{{ $price->title }}-{{ $price->id }}" class="font-medium text-gray-700">{{ $price->title }}</label>
                                            <p id="{{ $price->title }}-{{ $price->id }}-description" class="text-gray-500">{{ formatCurrency($price->amount_gross, $price->currency) }} <-> @foreach(unserialize($price->payment) as $payment => $p){{ __('payments.' . $payment . '.title') }}{{ (! $loop->last) ? ', ' : '' }}@endforeach</p>
                                        </div>
                                    </div>
                                @endforeach
                            </fieldset>
                        </div>
                    </div>

                    <div>
                        <div class="flex flex-row">
                            <div class="col-span-3 sm:col-span-3">
                                <label for="start" class="block text-sm font-semibold text-gray-700">{{ _i('course date') }}</label>

                                <x-input.date id="start" wire:model="date_range" :options="$start_options"/>

                            </div>
                            <div>
                                <label for="start_time" class="block text-sm font-semibold text-gray-700">Start</label>

                                <x-input.date id="start_time" wire:model="time_start" :options="$start_time_options"/>
                            </div>
                            <div>
                                <label for="end_time" class="block text-sm font-semibold text-gray-700">Ende</label>
                                <x-input.date id="end_time" wire:model="time_end" :options="$end_time_options"/>
                            </div>

                        </div>
                    </div>

                    @if($editing->team)
                        <div>
                            @foreach($trainer['general'] as $train)
                                <div class="flex flex-row">
                                    <div>
                                        <label for="trainer-general-{{ $loop->index }}" class="block text-sm font-medium text-gray-700">{{ $loop->count > 1 ? $loop->iteration . '. ' : '' }}{{ _i('trainer') }}</label>
                                        <select id="trainer-general-{{ $loop->index }}" wire:model.lazy="trainer.general.{{ $loop->index }}.trainer" {{ !$loop->index ? 'required' : '' }} name="trainer-general-{{ $loop->index }}" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                            <option value="">{{ _i('select / remove a trainer') }}</option>
                                            <option value="later">{{ _i('select later') }}</option>
                                            <option value="choose">{{ _i('trainer can choose') }}</option>
                                            @foreach($editing->team->users as $user)
                                                @if($user->active)
                                                    <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="trainer-general-{{ $loop->index }}-position" class="block text-sm font-medium text-gray-700">{{ _i('position') }}</label>
                                        <select id="trainer-general-{{ $loop->index }}-position" wire:model.lazy="trainer.general.{{ $loop->index }}.position" required name="trainer-general-{{ $loop->index }}-position" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                            <option value="">{{ _i('select position') }}</option>
                                            @foreach($positions as $position)
                                                <option value="{{ $position['id'] }}">{{ $position['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                            <div>
                                <x-button.link wire:click="addTrainer('general')" class="mt-2 text-xs text-gray-500">{{ _i('add a new trainer') }}</x-button.link>
                            </div>
                        </div>
                    @endif

                    <div>
                        @if(count($courseDays) >= 2)
                            <hr>
                            @foreach($courseDays as $courseDay)
                                <div>
                                    <div class="flex flex-row">
                                        <div>
                                            <label for="{{ $loop->index }}" class="block text-sm font-semibold text-gray-700">{{ $loop->iteration }}. Tag</label>

                                            <x-input.date id="{{ $loop->index }}" wire:model="courseDays.{{ $loop->index }}.date" :options="$day_options"/>
                                        </div>
                                        <div>
                                            <label for="{{ $loop->index }}" class="block text-sm font-semibold text-gray-700">Start</label>

                                            <x-input.date id="{{ $loop->index }}" wire:model="courseDays.{{ $loop->index }}.startTime" :options="$start_time_options"/>
                                        </div>
                                        <div>
                                            <label for="{{ $loop->index }}" class="block text-sm font-semibold text-gray-700">Ende</label>
                                            <x-input.date id="{{ $loop->index }}" wire:model="courseDays.{{ $loop->index }}.endTime" :options="$end_time_options"/>
                                        </div>
                                    </div>
                                    @if($editing->team)
                                        <div>
                                            @foreach($trainer[$loop->index] as $t)
                                                <div class="flex flex-row">
                                                    <div>
                                                        <label for="day-{{ $loop->parent->index }}-trainer-{{ $loop->index }}" class="block text-sm font-medium text-gray-700">{{ $loop->count > 1 ? $loop->iteration . '. ' : '' }}{{ _i('trainer') }}</label>
                                                        <select id="day-{{ $loop->parent->index }}-trainer-{{ $loop->index }}" wire:model.lazy="trainer.{{ $loop->parent->index }}.{{ $loop->index }}.trainer" name="team" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                            <option value="">{{ _i('select / remove a trainer') }}</option>
                                                            <option value="later">{{ _i('select later') }}</option>
                                                            <option value="choose">{{ _i('trainer can choose') }}</option>
                                                            @foreach($editing->team->users as $user)
                                                                @if($user->active)
                                                                    <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="day-{{ $loop->parent->index }}-trainer-{{ $loop->index }}-position" class="block text-sm font-medium text-gray-700">{{ _i('position') }}</label>
                                                        <select id="day-{{ $loop->parent->index }}-trainer-{{ $loop->index }}-position" wire:model.lazy="trainer.{{ $loop->parent->index }}.{{ $loop->index }}.position" required name="team" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                            <option value="">{{ _i('select position') }}</option>
                                                            @foreach($positions as $position)
                                                                <option value="{{ $position['id'] }}">{{ $position['title'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div>
                                                <x-button.link wire:click="addTrainer({{ $loop->index }})" class="mt-2 text-xs text-gray-500">{{ _i('add a new trainer') }}</x-button.link>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <hr class="mt-2">
                            @endforeach
                        @endif
                    </div>

                    <div>
                        <label for="seminar_location" class="block text-sm font-medium text-gray-700">{{ _i('seminar location') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.seminar_location" name="{{ _i('seminar location') }}" id="units" class="@error('editing.seminar_location') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('seminar location') }}" @error('editing.seminar_location') aria-invalid="true" aria-describedby="seminar_location-error" @enderror>
                            @error('editing.seminar_location')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.seminar_location')
                            <p class="mt-2 text-sm text-red-600" id="seminar_location-error">{{ $errors->first('editing.seminar_location') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="seminar_location-description">{{ _i('the seminar location or company') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="street" class="block text-sm font-medium text-gray-700">{{ _i('street') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.street" name="{{ _i('street') }}" id="street" class="@error('editing.street') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('street') }}" @error('editing.street') aria-invalid="true" aria-describedby="street-error" @enderror>
                            @error('editing.street')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.street')
                            <p class="mt-2 text-sm text-red-600" id="street-error">{{ $errors->first('editing.street') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="zipcode" class="block text-sm font-medium text-gray-700">{{ _i('zipcode') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.zipcode" name="{{ _i('zipcode') }}" id="zipcode" class="@error('editing.zipcode') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('zipcode') }}" @error('editing.zipcode') aria-invalid="true" aria-describedby="zipcode-error" @enderror>
                            @error('editing.zipcode')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.zipcode')
                            <p class="mt-2 text-sm text-red-600" id="zipcode-error">{{ $errors->first('editing.zipcode') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">{{ _i('location') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.location" name="{{ _i('location') }}" id="location" class="@error('editing.location') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('location') }}" @error('editing.location') aria-invalid="true" aria-describedby="location-error" @enderror>
                            @error('editing.location')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.location')
                            <p class="mt-2 text-sm text-red-600" id="location-error">{{ $errors->first('editing.location') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="seats" class="block text-sm font-medium text-gray-700">{{ _i('seats') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.seats" name="{{ _i('seats') }}" id="seats" class="@error('editing.seats')border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300  pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('seats') }}" @error('editing.seats') aria-invalid="true" aria-describedby="seats-error" @enderror>
                            @error('editing.seats')
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('editing.seats')
                            <p class="mt-2 text-sm text-red-600" id="seats-error">{{ $errors->first('editing.seats') }}</p>
                        @enderror
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                @if($this->editing->id)
                    <x-button.danger wire:click="$set('showCancelModal', true)">{{ _i('Cancel course') }}</x-button.danger>
                @endif
                <x-button.secondary wire:click="$set('showEditModal', false)">{{ _i('Cancel') }}</x-button.secondary>
                <x-button.primary type="submit">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>

    <form wire:submit.prevent="cancel">
        <x-modal.confirmation wire:model.defer="showCancelModal">
            <x-slot name="title">{{ _i('Cancel course') }}</x-slot>
            <x-slot name="content">
                <p class="text-sm text-gray-500">
                    {{ _i('Are you sure you want to cancel this course? This action cannot be undone.') }}
                </p>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showCancelModal', false)">{{ _i('Cancel') }}</x-button.secondary>
                <x-button.danger type="submit">{{ _i('Cancel course') }}</x-button.danger>
            </x-slot>
        </x-modal.confirmation>
    </form>
</div>
