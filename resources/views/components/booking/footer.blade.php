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

<div wire:ignore>
    <footer id="footer" style="display: none;">
        <div class="mx-auto max-w-7xl overflow-hidden py-12 px-4 sm:px-6 lg:px-8">
            <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">

                @if(config('booking.gtc'))
                    <div class="px-5 py-2">
                        <a href="{{ config('booking.gtc') }}" target="_blank" class="text-base text-gray-500 hover:text-gray-900">
                            {{ _i('gtc') }}
                        </a>
                    </div>
                @endif

                @if(config('booking.imprint'))
                    <div class="px-5 py-2">
                        <a href="{{ config('booking.imprint') }}" target="_blank" class="text-base text-gray-500 hover:text-gray-900">
                            {{ _i('imprint') }}
                        </a>
                    </div>
                @endif

                @if(config('booking.privacy'))
                    <div class="px-5 py-2">
                        <a href="{{ config('booking.privacy') }}" target="_blank" class="text-base text-gray-500 hover:text-gray-900">
                            {{ _i('privacy') }}
                        </a>
                    </div>
                @endif

            </nav>
            @if(config('booking.copyright'))
                <p class="mt-8 text-center text-base text-gray-400">{{ config('booking.copyright') }}</p>
            @endif
        </div>
    </footer>

    {{-- only show the footer, it not shown in a iframe --}}
    <script>
        if(window.self !== window.top); //inside an iframe
        else document.getElementById("footer").style.display = "block";
    </script>
</div>
