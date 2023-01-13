<div>
    <div>
        <div class="mx-auto max-w-7xl py-4 px-4 sm:py-6 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-base font-semibold uppercase tracking-wide text-indigo-600">{{ _i('Course overview') }}</h1>
                <p class="mx-auto mt-5 max-w-xl text-xl text-gray-500">{{ $courseType }} {{ (is_numeric($location) ? _i('near you') : _i('in %s and surroundings', $location)) }}</p>
            </div>
        </div>
    </div>

    <fieldset class="space-x-5">
        <legend class="sr-only">Locations</legend>
        <div class="relative flex items-start justify-center space-x-2">
            @foreach($perimeter_locations as $location)
                <div class="flex h-5 items-center">
                    <input id="{{ $location->location }}" wire:model="searchLocations.{{ $location->location }}" value="{{ $location->location }}" aria-describedby="{{ $location->location }}-description" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                </div>
                <div class="ml-3 text-sm">
                    <label for="{{ $location->location }}" class="font-medium text-gray-700">{{ $location->location }}</label>
                    <span id="{{ $location->location }}-description" class="text-gray-500"><span class="sr-only">{{ $location->location }} </span><svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg> {{ round($location->distance) }} km</span>
                </div>
            @endforeach
        </div>
    </fieldset>

    @if(count($courses))
        <div class="mt-3 overflow-hidden bg-white shadow sm:rounded-md">
            <ul role="list" class="divide-y divide-gray-200">
                @foreach($courses as $course)
                    <li>
                        <a @if(($course->seats - $course->participants_count) > 0)wire:click="showPrice({{ $course->id }})"@endif class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <p class="truncate text-sm font-medium text-indigo-600">{{ $courses[0]->type->name }}</p>
                                    <div class="ml-2 flex flex-shrink-0">
                                        @if(percentage($course->seats, $course->participants_count) > config('booking.few_seats'))
                                            <p class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">{{ _i('free seats') }}</p>
                                        @elseif(percentage($course->seats, $course->participants_count) <= config('booking.few_seats') && ($course->seats - $course->participants_count) > 0)
                                            <p class="inline-flex rounded-full bg-yellow-300 px-2 text-xs font-semibold leading-5 text-yellow-800">{{ _i('few seats') }}</p>
                                        @else
                                            <p class="inline-flex rounded-full bg-red-300 px-2 text-xs font-semibold leading-5 text-red-800">{{ _i('booked out') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500">
                                            <!-- Heroicon name: solid/location-marker -->
                                            <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $course->street }}, {{ $course->zipcode }} {{ $course->location }}
                                        </p>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                        <!-- Heroicon name: solid/calendar -->
                                        <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        <p>
                                            <time datetime="{{ \Carbon\Carbon::parse($course->start)->isoFormat('YYYY-MM-DD') }}">{{ \Carbon\Carbon::parse($course->start)->isoFormat('DD.MM.YYYY, dd.') }} {{ \Carbon\Carbon::parse($course->start)->isoFormat('HH:mm') }} - {{ \Carbon\Carbon::parse($course->end)->isoFormat('HH:mm') }}</time>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <p class="text-center text-gray-500">{{ _i('aren\'t offered at the moment... Please try again with another location!') }}</p>
    @endif

    <x-booking.footer />

    <x-modal.dialog wire:model.defer="showPriceModal">
        <x-slot name="title"></x-slot>
        <x-slot name="content">
            <div class="mx-auto max-w-7xl bg-white py-12 px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-extrabold text-gray-900 sm:text-5xl sm:leading-none sm:tracking-tight lg:text-6xl">{{ _i('Our offers') }}</h2>
                <p class="mt-6 max-w-2xl text-xl text-gray-500">{{ _i('Choose the right offer for your course here.') }}</p>

                <div class="mt-12 space-y-0 lg:grid lg:grid-cols-2 lg:gap-x-8">
                    @foreach($actual->prices as $price)
                        <div class="relative flex flex-col rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-900">{{ $price->title }}</h3>
                                <p class="mt-4 flex items-baseline text-gray-900">
                                    <span class="text-3xl font-extrabold tracking-tight">{{ \App\Models\Price::SIGN[$price->currency] }} {{ $price->amount_gross }}</span>
                                    <span class="ml-1 text-xl font-semibold">/ {{ _i('Person') }}</span>
                                </p>
                                <p class="mt-6 text-gray-500">{{ $price->description }}</p>
                            </div>

                            <button wire:click="selectCourse({{ $actual->id }}, {{ $price->id }})" class="mt-8 block w-full rounded-md border border-transparent bg-indigo-500 py-3 px-6 text-center font-medium text-white hover:bg-indigo-600">{{ _i('select') }}</button>
                        </div>

                    @endforeach
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="text-xs">Preise inkl. MwSt</div>
        </x-slot>
    </x-modal.dialog>

</div>
