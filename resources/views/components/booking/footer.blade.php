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
