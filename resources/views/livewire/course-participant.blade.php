{{--
| Copyright 2023 courservio.de
|
| Licensed under the EUPL, Version 1.2 or – as soon they
| will be approved by the European Commission - subsequent
| versions of the EUPL (the "Licence");
| You may not use this work except in compliance with the
| Licence.
| You may obtain a copy of the Licence at:
|
| https://joinup.ec.europa.eu/software/page/eupl
|
| Unless required by applicable law or agreed to in
| writing, software distributed under the Licence is
| distributed on an "AS IS" basis,
| WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
| express or implied.
| See the Licence for the specific language governing
| permissions and limitations under the Licence.
--}}

@php use App\Models\Participant; @endphp
@php use Carbon\Carbon; @endphp
<div>
{{--    <div class="space-y-4 py-4">--}}
{{--        <div class="flex justify-between">--}}
{{--            <div class="flex w-2/4 space-x-4">--}}
{{--                <x-input.text wire:model="filters.search" placeholder="{{ _i('Search...') }}" />--}}

{{--                <x-button.link wire:click="$set('showCertModal', true)">{{ _i('Create certificates') }}</x-button.link>--}}
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
{{--                                @foreach($teams as $team)--}}
{{--                                    <option value="{{ $team['id'] }}">{{ $team['display_name'] }}</option>--}}
{{--                                @endforeach--}}
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
{{--                    <x-table.heading></x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column>{{ _i('lastname') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column>{{ _i('firstname') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column>{{ _i('date of birth') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column>{{ _i('street') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column>{{ _i('location') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column>{{ _i('phone') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column>{{ _i('email') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column>{{ _i('booked on') }}</x-table.heading>--}}
{{--                    <x-table.heading sortable multi-column>{{ _i('price') }}</x-table.heading>--}}
{{--                    <x-table.heading></x-table.heading>--}}
{{--                    <x-table.heading></x-table.heading>--}}
{{--                    <x-table.heading></x-table.heading>--}}
{{--                    <x-table.heading></x-table.heading>--}}
{{--                </x-slot>--}}

{{--                <x-slot name="body">--}}
{{--                    @foreach($companies as $company)--}}
{{--                        <tr class="border-t border-gray-200">--}}
{{--                            <th colspan="5" scope="colgroup" class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">{{ $company[0]['company'] ? $company[0]['company'] : _i('no company') }}</th>--}}
{{--                        </tr>--}}
{{--                        @foreach($company as $participant)--}}
{{--                            <x-table.row class="{{ $participant->cancelled ? 'line-through' : '' }}">--}}
{{--                                <x-table.cell><x-input.checkbox wire:model="select" value="{{ $participant->id }}" /></x-table.cell>--}}
{{--                                <x-table.cell>{{ $participant->lastname }}</x-table.cell>--}}
{{--                                <x-table.cell>{{ $participant->firstname }}</x-table.cell>--}}
{{--                                <x-table.cell>--}}
{{--                                    @can('viewAny', $participant)--}}
{{--                                        {{ \Carbon\Carbon::parse($participant->date_of_birth)->isoFormat('DD.MM.YYYY') }}--}}
{{--                                    @else--}}
{{--                                        <span class="blur-sm">XX.XX.XXXX</span>--}}
{{--                                    @endcan--}}
{{--                                </x-table.cell>--}}
{{--                                <x-table.cell>--}}
{{--                                    @can('viewAny', $participant)--}}
{{--                                        {{ $participant->street }}--}}
{{--                                    @else--}}
{{--                                        <span class="blur">{{ substr(sha1(time()), 0, strlen($participant->street)) }}</span>--}}
{{--                                    @endcan--}}
{{--                                </x-table.cell>--}}
{{--                                <x-table.cell>--}}
{{--                                    @can('viewAny', $participant)--}}
{{--                                        {{ $participant->zipcode }} {{ $participant->location }}--}}
{{--                                    @else--}}
{{--                                        <span class="blur">12345 {{ substr(sha1(time()), 0, strlen($participant->location)) }}</span>--}}
{{--                                    @endcan--}}
{{--                                </x-table.cell>--}}
{{--                                <x-table.cell>--}}
{{--                                    @can('viewAny', $participant)--}}
{{--                                        {{ $participant->phone }}--}}
{{--                                    @else--}}
{{--                                        <span class="blur">{{ substr(sha1(time()), 0, strlen($participant->phone)) }}</span>--}}
{{--                                    @endcan--}}
{{--                                </x-table.cell>--}}
{{--                                <x-table.cell>--}}
{{--                                    @can('viewAny', $participant)--}}
{{--                                        {{ $participant->email }}--}}
{{--                                    @else--}}
{{--                                        <span class="blur">{{ substr(sha1(time()), 0, strlen($participant->email)) }}</span>--}}
{{--                                    @endcan--}}
{{--                                </x-table.cell>--}}
{{--                                <x-table.cell>{{ \Carbon\Carbon::parse($participant->created_at)->isoFormat('DD.MM.YYYY') }}</x-table.cell>--}}
{{--                                <x-table.cell>{{ $participant->currency }} {{ $participant->price_gross }}</x-table.cell>--}}
{{--                                <x-table.cell>--}}
{{--                                    <span class="inline-flex {{ $participant->participated ? 'text-green-800' : 'text-red-800' }}">--}}
{{--                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $participant->participated ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">--}}
{{--                                        @if($can_update && !$participant->cancelled)--}}
{{--                                            <x-button.link wire:click="participate({{ $participant->id }})">{!! $participant->participated ? '<i class="fa-solid fa-user-plus"></i>' : '<i class="fa-solid fa-user-xmark"></i>' !!}</x-button.link>--}}
{{--                                            <x-button.badge wire:click="participate({{ $participant->id }})">{{ $participant->participated ? _i('participated') : _i('not participated') }}</x-button.badge>--}}
{{--                                        @else--}}
{{--                                            <x-button.link disabled>{!! $participant->participated ? '<i class="fa-solid fa-user-plus"></i>' : '<i class="fa-solid fa-user-xmark"></i>' !!}</x-button.link>--}}
{{--                                            <x-button.badge wire:click="participate({{ $participant->id }})" disabled>{{ $participant->participated ? _i('participated') : _i('not participated') }}</x-button.badge>--}}
{{--                                        @endif--}}
{{--                                    </span>--}}
{{--                                </x-table.cell>--}}
{{--                                <x-table.cell>--}}
{{--                                    <span class="inline-flex {{ $participant->payed ? 'text-green-800' : 'text-red-800' }}">--}}
{{--                                        @if($can_update)--}}
{{--                                            <x-button.link wire:click="pay({{ $participant->id }})"><i class="{{ \App\Models\Participant::PAYMENTMETHOD[$participant->payment] }}"></i></x-button.link>--}}
{{--                                            <x-button.badge wire:click="pay({{ $participant->id }})">{{ __('payments.' . $participant->payment . '.title') }}</x-button.badge>--}}
{{--                                        @else--}}
{{--                                            <x-button.link disabled><i class="{{ \App\Models\Participant::PAYMENTMETHOD[$participant->payment] }}"></i></x-button.link>--}}
{{--                                            <x-button.badge disabled>{{ __('payments.' . $participant->payment . '.title') }}</x-button.badge>--}}
{{--                                        @endif--}}
{{--                                    </span>--}}
{{--                                </x-table.cell>--}}
{{--                                <x-table.cell>--}}
{{--                                    @can('viewAny', $participant)--}}
{{--                                        <x-button.link wire:click="showDetails({{ $participant->id }})"><i class="fa-solid fa-address-card"></i></x-button.link>--}}
{{--                                    @else--}}
{{--                                        <x-button.link disabled><i class="fa-solid fa-address-card"></i></x-button.link>--}}
{{--                                    @endif--}}
{{--                                </x-table.cell>--}}
{{--                                <x-table.cell>--}}
{{--                                    @if($can_update && !$participant->cancelled && (\Carbon\Carbon::parse($course_data->start)->format('Y-m-d H:i') > \Carbon\Carbon::parse(now())->format('Y-m-d H:i')) )--}}
{{--                                        <x-button.link wire:click="showCancelModal({{ $participant->id }})"><i class="fa-solid fa-user-slash"></i></x-button.link>--}}
{{--                                    @else--}}
{{--                                        <x-button.link disabled><i class="fa-solid fa-user-slash"></i></x-button.link>--}}
{{--                                    @endif--}}
{{--                                </x-table.cell>--}}
{{--    --}}{{--                            <x-table.cell>--}}
{{--    --}}{{--                                @can('update', $course)--}}
{{--    --}}{{--                                    <x-button.link wire:click="participant({{ $course->id }})">{{ _i('participants') }}</x-button.link>--}}
{{--    --}}{{--                                @endcan--}}
{{--    --}}{{--                            </x-table.cell>--}}
{{--    --}}{{--                            <x-table.cell>--}}
{{--    --}}{{--                                @can('update', $course)--}}
{{--    --}}{{--                                    <x-button.link wire:click="edit({{ $course->id }})">{{ _i('edit') }}</x-button.link>--}}
{{--    --}}{{--                                @endcan--}}
{{--    --}}{{--                            </x-table.cell>--}}
{{--                            </x-table.row>--}}
{{--                        @endforeach--}}
{{--                    @endforeach--}}
{{--                </x-slot>--}}
{{--            </x-table>--}}

{{--            <div wire:poll>--}}

{{--                Current time: {{ now() }}--}}

{{--            </div>--}}
{{--            <div>--}}
{{--                {{ $courses->links() }}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <x-button.link wire:click="showCertModal"
                               class="mt-2 hidden text-sm text-gray-700 sm:inline">{{ _i('Create certificates') }}</x-button.link>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    Add user
                </button>
            </div>
        </div>
        <div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="hidden sm:table-cell"></th>
                    <th scope="col"
                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:hidden">{{ _i('name') }}</th>
                    <th scope="col"
                        class="hidden py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:table-cell sm:pl-6">{{ _i('lastname') }}</th>
                    <th scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">{{ _i('firstname') }}</th>
                    <th scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">{{ _i('date of birth') }}</th>
                    <th scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 xl:table-cell">{{ _i('phone') }}</th>
                    <th scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 xl:table-cell">{{ _i('email') }}</th>
                    <th scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:hidden lg:table-cell xl:hidden">{{ _i('contact') }}</th>
                    <th scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">{{ _i('booked on') }}</th>
                    <th scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ _i('price') }}</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        {{--                        <span class="sr-only">Edit</span>--}}
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        {{--                        <span class="sr-only">Edit</span>--}}
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        {{--                        <span class="sr-only">Edit</span>--}}
                    </th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        {{--                        <span class="sr-only">Edit</span>--}}
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($companies as $company)
                    <tr class="border-t border-gray-200">
                        <th colspan="12" scope="colgroup"
                            class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">{{ $company[0]['company'] ? $company[0]['company'] : _i('no company') }}</th>
                    </tr>
                    @foreach($company as $participant)
                        <tr class="{{ $participant->cancelled ? 'line-through' : '' }}">
                            <td class="hidden px-4 py-4 leading-5 sm:table-cell">
                                <x-input.checkbox wire:model="select" value="{{ $participant->id }}"/>
                            </td>
                            <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                                {{ $participant->lastname }}
                                <dl class="sm:hidden">
                                    <dd class="mt-1 truncate text-gray-500">{{ $participant->firstname }}</dd>
                                </dl>
                            </td>
                            <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">{{ $participant->firstname }}</td>
                            <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">{{ Carbon::parse($participant->date_of_birth)->isoFormat('DD.MM.YYYY') }}</td>
                            <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                                @can('view', $participant)
                                    {{ $participant->phone }}
                                @else
                                    <span class="blur">{{ substr(sha1(time()), 0, strlen($participant->phone)) }}</span>
                                @endcan
                                <dl class="xl:hidden">
                                    <dt class="sr-only">{{ _i('email') }}</dt>
                                    <dd class="mt-1 truncate text-gray-500">
                                        @can('view', $participant)
                                            {{ $participant->email }}
                                        @else
                                            <span
                                                class="blur">{{ substr(sha1(time()), 0, strlen($participant->email)) }}</span>
                                        @endcan
                                    </dd>
                                </dl>
                            </td>
                            <td class="hidden px-3 py-4 text-sm text-gray-500 xl:table-cell">
                                @can('view', $participant)
                                    {{ $participant->email }}
                                @else
                                    <span class="blur">{{ substr(sha1(time()), 0, strlen($participant->email)) }}</span>
                                @endcan
                            </td>
                            <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">{{ Carbon::parse($participant->created_at)->isoFormat('DD.MM.YYYY') }}</td>
                            <td class="px-3 py-4 text-sm text-gray-500">{{ $participant->currency }} {{ $participant->price_gross }}</td>
                            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <span
                                    class="inline-flex {{ $participant->participated ? 'text-green-800' : 'text-red-800' }}">
                                    @if(auth()->user()->can('update', $participant) && !$participant->cancelled)
                                        <x-button.link
                                            wire:click="participate({{ $participant->id }})">{!! $participant->participated ? '<i class="fa-solid fa-user-plus"></i>' : '<i class="fa-solid fa-user-xmark"></i>' !!}</x-button.link>
                                    @else
                                        <x-button.link
                                            disabled>{!! $participant->participated ? '<i class="fa-solid fa-user-plus"></i>' : '<i class="fa-solid fa-user-xmark"></i>' !!}</x-button.link>
                                    @endif
                                </span>
                            </td>
                            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <span class="inline-flex {{ $participant->payed ? 'text-green-800' : 'text-red-800' }}">
                                    @can('update', $participant)
                                        <x-button.link wire:click="pay({{ $participant->id }})"><i
                                                class="{{ Participant::PAYMENTMETHOD[$participant->payment] }}"></i></x-button.link>
                                    @else
                                        <x-button.link disabled><i
                                                class="{{ Participant::PAYMENTMETHOD[$participant->payment] }}"></i></x-button.link>
                                    @endcan
                                </span>
                            </td>
                            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                @can('view', $participant)
                                    <x-button.link wire:click="showDetails({{ $participant->id }})"><i
                                            class="fa-solid fa-address-card"></i></x-button.link>
                                @else
                                    <x-button.link disabled><i class="fa-solid fa-address-card"></i></x-button.link>
                                @endif
                            </td>
                            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                @if(auth()->user()->can('update', $participant) && !$participant->cancelled && (Carbon::parse($course_data->start)->format('Y-m-d H:i') > Carbon::parse(now())->format('Y-m-d H:i')) )
                                    <x-button.link wire:click="showCancelModal({{ $participant->id }})"><i
                                            class="fa-solid fa-user-slash"></i></x-button.link>
                                @else
                                    <x-button.link disabled><i class="fa-solid fa-user-slash"></i></x-button.link>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach

                </tbody>
            </table>
            <div>
                {{ $paginate->links() }}
            </div>
        </div>
    </div>


    <form wire:submit.prevent="getCert">
        <x-modal.confirmation wire:model.defer="showCertModal">
            <x-slot name="title">{{ _i('Create certificates') }}</x-slot>
            <x-slot name="content">
                <div wire:loading.remove>
                    <p class="mt-5 text-sm text-gray-500">
                        {{ _i('Are you sure you want to create the certificates?') }}
                    </p>
                </div>

                <div wire:loading wire:target="getCert">
                    {{ _i('Is being prepared ... Please wait ...') }}
                </div>
            </x-slot>

            <x-slot name="footer">
                <div wire:loading.remove>
                    <x-button.secondary
                        wire:click="$set('showCertModal', false)">{{ _i('Cancel') }}</x-button.secondary>
                    <x-button.danger type="submit">{{ _i('Create certificates') }}</x-button.danger>
                </div>
            </x-slot>
        </x-modal.confirmation>
    </form>

    <form wire:submit.prevent="cancel">
        <x-modal.confirmation wire:model.defer="showCancelModal">
            <x-slot name="title">{{ _i('Cancel booking') }}</x-slot>
            <x-slot name="content">
                <p class="text-sm text-gray-500">
                    {{ _i('Are you sure you want to cancel this booking? This action cannot be undone.') }}
                </p>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showCancelModal', false)">{{ _i('Cancel') }}</x-button.secondary>
                <x-button.danger type="submit">{{ _i('Cancel booking') }}</x-button.danger>
            </x-slot>
        </x-modal.confirmation>
    </form>

    <x-modal.confirmation wire:model.defer="showWaitModal">
        <x-slot name="title">{{ _i('Create certificates') }}</x-slot>
        <x-slot name="content">
            @if($batchId && !$creationFinished)
                <div wire:poll.1s="updateCreationProgress">
                    <ul class="max-w-md space-y-2 text-gray-500 list-inside dark:text-gray-400">
                        <li class="flex items-center">
                            <svg aria-hidden="true"
                                 class="w-5 h-5 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                                 fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            {{ _i('Select participants') }}
                        </li>
                        <li class="flex items-center">
                            <div role="status">
                                @if(!$concat)
                                    <svg aria-hidden="true"
                                         class="w-5 h-5 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                         viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor"/>
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                @else
                                    <svg aria-hidden="true"
                                         class="w-5 h-5 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>
                            {{ _i('Generate Certificate') }} - {{ $actCert }} / {{ $totalCert }}
                        </li>
                        @if($concat)
                            <li class="flex items-center">
                                <div role="status">
                                    <svg aria-hidden="true"
                                         class="w-5 h-5 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                         viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor"/>
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                                {{ _i('Generate .pdf File') }}
                            </li>
                        @endif
                    </ul>
                </div>
            @elseif($creationFinished && !$creationFailed)
                <ul class="max-w-md space-y-2 text-gray-500 list-inside dark:text-gray-400">
                    <li class="flex items-center">
                        <svg aria-hidden="true"
                             class="w-5 h-5 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        {{ _i('Select participants') }}
                    </li>
                    <li class="flex items-center">
                        <div role="status">
                            <svg aria-hidden="true"
                                 class="w-5 h-5 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                                 fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        {{ _i('Generate Certificate') }} - {{ $actCert }} / {{ $totalCert }}
                    </li>
                    <li class="flex items-center">
                        <svg aria-hidden="true"
                             class="w-5 h-5 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        {{ _i('Generate .pdf File') }}
                    </li>
                    <li class="flex items-center">
                        <div role="status">
                            <svg aria-hidden="true"
                                 class="w-5 h-5 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                 viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor"/>
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill"/>
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                        {{ _i('Preparing Download') }}
                    </li>
                </ul>
            @endif
        </x-slot>

        <x-slot name="footer">
        </x-slot>
    </x-modal.confirmation>

    <x-modal.confirmation wire:model.defer="showCreationFailedModal">
        <x-slot name="title">{{ _i('Creation failed') }}</x-slot>
        <x-slot name="content">
            <div>
                <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Converting your image:</h2>
                <ul class="max-w-md space-y-2 text-gray-500 list-inside dark:text-gray-400">
                    <li class="flex items-center">
                        <svg aria-hidden="true" class="w-5 h-5 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0"
                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        {{ _i('Select participants') }}
                    </li>
                    <li class="flex items-center">
                        <div role="status">
                            <svg aria-hidden="true" class="w-5 h-5 mr-1.5 text-red-500 dark:text-red-400 flex-shrink-0"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/>
                            </svg>
                        </div>
                        {{ _i('.pdf creating failed. Please try again.') }}
                    </li>
                </ul>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button.secondary
                wire:click="$set('showCreationFailedModal', false)">{{ _i('Cancel') }}</x-button.secondary>
        </x-slot>
    </x-modal.confirmation>

    <form wire:submit.prevent="downloadFile">
        <x-modal.confirmation wire:model.defer="showDownloadModal">
            <x-slot name="title">{{ _i('Creation successful') }}</x-slot>
            <x-slot name="content">
                <div wire:loading.remove>
                    <p class="mt-5 text-sm text-gray-500">
                        {{ _i('.pdf File was successfully created.') }}
                    </p>
                </div>

                <div wire:loading wire:target="downloadFile">
                    {{ _i('Is being prepared ... Please wait ...') }}
                </div>
            </x-slot>

            <x-slot name="footer">
                <div wire:loading.remove>
                    <x-button.secondary
                        wire:click="$set('showDownloadModal', false)">{{ _i('Cancel') }}</x-button.secondary>
                    <x-button.danger type="submit">{{ _i('Download') }}</x-button.danger>
                </div>
            </x-slot>
        </x-modal.confirmation>
    </form>
</div>
