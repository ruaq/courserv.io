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
    <div class="flex min-h-screen items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                     alt="Workflow">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    {{ _i('Log in to your account') }}
                </h2>
                {{-- <p class="mt-2 text-center text-sm text-gray-600">
                    Or
                    <a href="/" class="font-medium text-indigo-600 hover:text-indigo-500">
                        start your 14-day free trial
                    </a>
                </p> --}}
            </div>
            <form wire:submit.prevent="login" class="mt-8 space-y-6">
                <input type="hidden" name="remember" value="true">
                <div class="-space-y-px rounded-md shadow-sm">
                    <div>
                        <label for="email-address" class="sr-only">{{ _i('Email address') }}</label>
                        <input wire:model.lazy="email" id="email-address" type="email" autocomplete="email" required
                               class="@error('email') border-red-500 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red @enderror relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                               placeholder="{{ _i('Email address') }}">
                    </div>

                    <div>
                        <label for="password" class="sr-only">{{ _i('Password') }}</label>
                        <input wire:model.lazy="password" id="password" type="password" autocomplete="current-password"
                               required
                               class="@error('email') border-red-500 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red @enderror relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                               placeholder="{{ _i('Password') }}">
                    </div>

                    @error('email')
                        <div class="mt-1 flex justify-center text-center text-sm text-red-500">{{ $message }}</div>
                    @enderror

                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input wire:model="remember" id="remember-me" type="checkbox"
                               class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            {{ _i('Remember me') }}
                        </label>
                    </div>

                    <div class="text-sm">
                        <x-button.link
                            class="font-medium text-indigo-600 hover:text-indigo-500"
                            wire:click="$set('showForgotModal', true)"
                        >
                            {{ _i('Forgot your password?') }}
                        </x-button.link>
                    </div>
                </div>

                @error('captcha')
                <div class="mt-1 flex justify-center text-sm text-red-500">{{ $message }}</div> @enderror

                <livewire:fcaptcha/>

                <div>
                    <button type="submit" wire:loading.attr="disabled"
                            class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <!-- Heroicon name: solid/lock-closed -->
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd"/>
                            </svg>
                        </span>
                        {{ _i('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <form wire:submit.prevent="forgot">
        <x-modal.dialog wire:model.defer="showForgotModal">
            <x-slot name="title">{{ _i('Forgot your password?') }}</x-slot>
            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ _i('e-mail address') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="email" name="email" id="email" class="@error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('e-mail address') }}" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                            @error('email')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600" id="name-error">{{ $errors->first('email') }}</p>
                        @enderror
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showForgotModal', false)">Cancel</x-button.secondary>
                <x-button.primary type="submit">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
