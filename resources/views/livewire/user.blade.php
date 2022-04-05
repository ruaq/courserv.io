<div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ _i('Teams') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium tracking-wider text-gray-500">
                                @can('create', \App\Models\User::class)<x-button.link wire:click="create">{{ _i('Add User') }}</x-button.link>@endcan
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 shrink-0">
                                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        @foreach($user->teams as $team){{ $team->display_name }}{{ !$loop->last ? ', ' : '' }}@endforeach
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        @foreach($user->roles as $role){{ $role->display_name }}{{ !$loop->last ? ', ' : '' }}@endforeach
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            @can('update', $user)
                                                <x-button.badge wire:click="active({{ $user->id }})">{{ $user->active ? _i('active') : _i('inactive') }}</x-button.badge>
                                            @else
                                                <x-button.badge wire:click="active({{ $user->id }})" disabled>{{ $user->active ? _i('active') : _i('inactive') }}</x-button.badge>
                                            @endcan
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        @can('update', $user)
                                            <x-button.link wire:click="edit({{ $user->id }})">{{ _i('edit') }}</x-button.link>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">{{ _i('edit user') }}</x-slot>
            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ _i('name') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.name" name="{{ _i('name') }}" id="name" class="@error('editing.name') @enderror block w-full rounded-md border-gray-300 border-red-300 pr-10 text-red-900 placeholder-red-300 focus:border-indigo-500 focus:border-red-500 focus:outline-none focus:ring-indigo-500 focus:ring-red-500 sm:text-sm" placeholder="{{ _i('name') }}" @error('editing.name') aria-invalid="true" aria-describedby="name-error" @enderror>
                            @error('editing.name')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.name')
                            <p class="mt-2 text-sm text-red-600" id="name-error">{{ $errors->first('editing.name') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ _i('e-mail address') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.email" name="email" id="email" class="@error('editing.email') @enderror block w-full rounded-md border-gray-300 border-red-300 pr-10 text-red-900 placeholder-red-300 focus:border-indigo-500 focus:border-red-500 focus:outline-none focus:ring-indigo-500 focus:ring-red-500 sm:text-sm" placeholder="{{ _i('e-mail address') }}" @error('editing.email') aria-invalid="true" aria-describedby="email-error" @enderror>
                            @error('editing.email')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.email')
                            <p class="mt-2 text-sm text-red-600" id="name-error">{{ $errors->first('editing.email') }}</p>
                        @enderror
                    </div>
                    <div>
                        <div class="mt-4 font-bold">{{ _i('Teams') }}</div>
                        <div>
                            <fieldset class="border-t border-b border-gray-200">
                                <legend class="sr-only">{{ _i('Teams') }}</legend>
                                <div class="divide-y divide-gray-200">
                                    @foreach($teams as $team)
                                        <div class="relative flex items-start py-4">
                                            <div class="min-w-0 flex-1 text-sm">
                                                <label for="{{ $team->id }}" class="font-medium text-gray-700">{{ $team->display_name }}</label>
                                                <p id="{{ $team->id }}-description" class="text-gray-500">{{ $team->description }}</p>
                                            </div>
                                            <div class="ml-3 flex h-5 items-center">
                                                <input wire:model="teamIds" value="{{ $team->id }}" id="{{ $team->id }}" aria-describedby="{{ $team->id }}-description" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                        <div class="mt-4 font-bold">{{ _i('Roles') }}</div>
                        <div>
                            <fieldset class="border-t border-b border-gray-200">
                                <legend class="sr-only">{{ _i('Roles') }}</legend>
                                <div class="divide-y divide-gray-200">
                                    @foreach($roles as $role)
                                        <div class="relative flex items-start py-4">
                                            <div class="min-w-0 flex-1 text-sm">
                                                <label for="{{ $role->id }}" class="font-medium text-gray-700">{{ $role->display_name }}</label>
                                                <p id="{{ $role->id }}-description" class="text-gray-500">{{ $role->description }}</p>
                                            </div>
                                            <div class="ml-3 flex h-5 items-center">
                                                <input wire:model="roleIds" value="{{ $role->id }}" id="{{ $role->id }}" aria-describedby="{{ $role->id }}-description" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showEditModal', false)">Cancel</x-button.secondary>
                <x-button.primary type="submit">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
