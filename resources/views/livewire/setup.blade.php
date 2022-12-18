<div>
    <div class="flex min-h-screen items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div wire:loading.remove wire:target="register">
                <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                     alt="Workflow">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    {{ _i('add admin account') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    {{ _i('Whole database will be reset!') }}
                </p>
            </div>
            <form wire:submit.prevent="register" wire:loading.remove wire:target="register" class="mt-8 space-y-6">
                <input type="hidden" name="remember" value="true">
                <div class="-space-y-px rounded-md shadow-sm">
                    <div>
                        <label for="name" class="sr-only">{{ _i('name') }}</label>
                        <input wire:model.lazy="name" id="name" type="text" autocomplete="name" required
                               class="@error('name') border-red-500 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red @enderror relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                               placeholder="{{ _i('name') }}">
                    </div>
                    @error('name')
                        <div class="mt-1 flex justify-center text-center text-sm text-red-500">{{ $message }}</div>
                    @enderror

                    <div>
                        <label for="email-address" class="sr-only">{{ _i('Email address') }}</label>
                        <input wire:model.lazy="email" id="email-address" type="email" autocomplete="email" required
                               class="@error('email') border-red-500 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red @enderror relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                               placeholder="{{ _i('Email address') }}">
                    </div>
                    @error('email')
                        <div class="mt-1 flex justify-center text-center text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <button type="submit"
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
                        {{ _i('add account') }}
                    </button>
                </div>
            </form>

            <div class="flex w-full justify-center text-center">
                <div wire:loading wire:target="register">
                    {{ _i('Processing ... Please wait ...') }}
                </div>
            </div>
        </div>
    </div>
</div>
