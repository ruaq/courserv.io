<div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ _i('role name') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ _i('Display Name') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ _i('Description') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium tracking-wider text-gray-500">
                                @can('create', \App\Models\Role::class)<x-button.link wire:click="create">{{ _i('Add Role') }}</x-button.link>@endcan
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($roles as $role)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $role->name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $role->display_name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $role->description ?? 'none' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                    @can('update', $role)
                                        <x-button.link wire:click="edit({{ $role->id }})">Edit</x-button.link>
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
            <x-slot name="title">{{ _i('edit role') }}</x-slot>
            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ _i('role name') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.name" name="{{ _i('role name') }}" id="name" class="@error('editing.name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 lowercase focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('role name') }}" @error('editing.name') aria-invalid="true" aria-describedby="name-error" @enderror>
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
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="email-description">{{ _i('The internal used role name.') }}</p>
                            @enderror
                    </div>

                    <div>
                        <label for="display_name" class="block text-sm font-medium text-gray-700">{{ _i('Display role Name') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.display_name" name="display_name" id="display_name" class="@error('editing.display_name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('Display role Name') }}" @error('editing.display_name') aria-invalid="true" aria-describedby="display_name-error" @enderror>
                            @error('editing.display_name')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.display_name')
                            <p class="mt-2 text-sm text-red-600" id="name-error">{{ $errors->first('editing.display_name') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="name-description">{{ _i('The displayed role name') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">{{ _i('Description') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <textarea wire:model.lazy="editing.description" name="description" id="description" class="@error('editing.description') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('Description') }}" @error('editing.description') aria-invalid="true" aria-describedby="description-error" @enderror></textarea>
                            @error('editing.description')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.description')
                            <p class="mt-2 text-sm text-red-600" id="description-error">{{ $errors->first('editing.description') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="description-description">{{ _i('A description for this role (optional)') }}</p>
                        @enderror
                    </div>

                    <div>
                        <fieldset class="border-t border-b border-gray-200">
                            <legend class="sr-only">{{ _i('Permissions') }}</legend>
                            <div class="divide-y divide-gray-200">
                                @foreach($permissions->groupBy('group') as $groups)
                                    <div class="font-bold">{{ _i($groups[0]['group']) }}</div>
                                    @foreach($groups as $group)
                                        <div class="relative flex items-start py-4">
                                            <div class="min-w-0 flex-1 text-sm">
                                                <label for="{{ $group->id }}" class="font-medium text-gray-700">{{ $group->display_name }}</label>
                                                <p id="{{ $group->id }}-description" class="text-gray-500">{{ $group->description }}</p>
                                            </div>
                                            <div class="ml-3 flex h-5 items-center">
{{--                                                <x-input.checkbox wire:model="permIds" value="{{ $group->id }}" />--}}
                                                <input wire:model="permIds" value="{{ $group->id }}" id="{{ $group->id }}" aria-describedby="{{ $group->id }}-description" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </fieldset>
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
