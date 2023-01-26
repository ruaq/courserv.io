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
