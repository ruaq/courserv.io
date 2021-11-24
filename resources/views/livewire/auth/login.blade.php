<div>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
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
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email-address" class="sr-only">{{ _i('Email address') }}</label>
                        <input wire:model.lazy="email" id="email-address" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('email') border-red-500 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red @enderror" placeholder="{{ _i('Email address') }}">
                    </div>

                    @error('email') <div class="flex justify-center mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror

                    <div>
                        <label for="password" class="sr-only">{{ _i('Password') }}</label>
                        <input wire:model.lazy="password" id="password" type="password" autocomplete="current-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('password') border-red-500 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red @enderror" placeholder="{{ _i('Password') }}">
                    </div>

                    @error('password') <div class="flex justify-center mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror

                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input wire:model="remember" id="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            {{ _i('Remember me') }}
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                            {{ _i('Forgot your password?') }}
                        </a>
                    </div>
                </div>

                @error('captcha') <div class="flex justify-center mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror

                <livewire:fcaptcha />

                <div>
                    <button type="submit" wire:loading.attr="disabled" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <!-- Heroicon name: solid/lock-closed -->
            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </span>
                        {{ _i('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>