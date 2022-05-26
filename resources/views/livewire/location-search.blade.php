<div>
    <div class="pt-24 sm:pt-12 px-4 space-y-4 mt-8 text-center">
        <div class="lg:text-center">
            <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">{{ $courseType }}</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{ _i('our course dates at a glance') }}</p>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">{{ _i('Find your course near you here') }}</p>
        </div>
        <form onsubmit="return false;">
            <input class="border-solid border border-gray-300 p-2 w-full rounded md:w-2/3 lg:w-1/3"
                   type="text" placeholder="{{ _i('Search for your desired course location ...') }}" wire:model.debounce.500ms="term"/>
        </form>
        <div wire:loading class="text-gray-500">{{ _i('Searching for location ... Please wait ...') }}</div>
        <div wire:loading.remove>
            {{--
                notice that $term is available as a public
                variable, even though it's not part of the
                data array
            --}}
            @if ($term == "")
                <div class="text-gray-500 text-sm">
                    {{ _i('Enter a zipcode or a location to search for courses.') }}
                </div>
            @else
                @if($locations->isEmpty())
                    <div class="text-gray-500 text-sm">
                        {{ _i('No suitable location was found.') }}
                    </div>
                @else
                    <p class="font-bold text-gray-600 text-lg pb-2">{{ _i('Select your desired location') }}</p>
                    @foreach($locations as $location)
                        <div class="text-gray-500">
                            <a href="{{ route('booking.overview', ['slug' => $slug, 'location' => $location->location]) }}">{{$location->location}} <span class="text-xs">{{$location->state}}</span></a>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
        <hr>
        <p><button onclick="getLocation()">{{ _i('Click here to find a course near your current location.') }}<br /><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg></button></p>
        <p id="locationResponse" wire:ignore class="mt-8 text-center text-base text-red-600"></p>
    </div>

    <x-booking.footer />

    @if($redirectUrl)
        <script>
            if(window.self !== window.top); //inside an iframe
            else window.location = "{{ $redirectUrl }}"; // Outside
        </script>
    @endif

    <script>
        var x = document.getElementById("locationResponse");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                x.innerHTML = "{{ _i('Geolocation is not supported by this browser.') }}";
            }
        }

        function showPosition(position) {
            Livewire.emit('located', position.coords.latitude, position.coords.longitude);
            // x.innerHTML = "Latitude: " + position.coords.latitude +
            //     "<br>Longitude: " + position.coords.longitude;
        }

        function showError(error) {
            // Livewire.emit('error', error.code);
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    x.innerHTML = "{{ _i('User denied the request for Geolocation.') }}"
                    break;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML = "{{ _i('Location information is unavailable.') }}"
                    break;
                case error.TIMEOUT:
                    x.innerHTML = "{{ _i('The request to get user location timed out.') }}"
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML = "{{ _i('An unknown error occurred.') }}"
                    break;
            }
        }
    </script>
</div>
