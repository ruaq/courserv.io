<div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ _i('Teams') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 tracking-wider">
                                @can('create', \App\Models\User::class)<x-button.link wire:click="create">{{ _i('Add User') }}</x-button.link>@endcan
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @foreach($user->teams as $team){{ $team->email }}{{ !$loop->last ? ', ' : '' }}@endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @foreach($user->roles as $role){{ $role->email }}{{ !$loop->last ? ', ' : '' }}@endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $user->status_color }}-100 text-{{ $user->status_color }}-800">
                                            @can('update', $user)
                                                <x-button.badge wire:click="active({{ $user->id }})">{{ $user->active ? _i('active') : _i('inactive') }}</x-button.badge>
                                            @else
                                                <x-button.badge wire:click="active({{ $user->id }})" disabled>{{ $user->active ? _i('active') : _i('inactive') }}</x-button.badge>
                                            @endcan
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @can('update', $user)
                                            <x-button.link wire:click="edit({{ $user->id }})">{{ _i('edit') }}</x-button.link>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        <!-- More people... -->
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
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.name" name="{{ _i('name') }}" id="name" class="block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300 @error('editing.name') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror " placeholder="{{ _i('name') }}" @error('editing.name') aria-invalid="true" aria-describedby="name-error" @enderror>
                            @error('editing.name')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
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
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.email" name="email" id="email" class="block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300 @error('editing.email') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror " placeholder="{{ _i('e-mail address') }}" @error('editing.email') aria-invalid="true" aria-describedby="email-error" @enderror>
                            @error('editing.email')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
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
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showEditModal', false)">Cancel</x-button.secondary>
                <x-button.primary type="submit">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
