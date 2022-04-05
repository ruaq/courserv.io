<div>
    <div>
        @unless($solved)
            <div>
                @error('validation') <div class="mt-1 flex justify-center text-sm text-red-500">{{ $message }}</div> @enderror
            </div>

            <div class="flex justify-center">
                <div class="frc-captcha flex justify-center" data-sitekey="{{ config('fcaptcha.sitekey') }}" data-callback="captchaSolved" data-lang="{{ app()->getLocale() }}"></div>
            </div>
        @endunless
    </div>

    <script>
        function captchaSolved(solution) {
            Livewire.emitTo('fcaptcha', 'captchaSolved', solution);
        }
    </script>

    {{-- remove captcha, if no friendly captcha key is present--}}
    @if(!config('fcaptcha.sitekey') || !config('fcaptcha.secret'))
        <div x-init="$wire.emit('removeCaptcha')"></div>
    @endif
</div>
