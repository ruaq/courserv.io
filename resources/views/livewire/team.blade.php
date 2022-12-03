<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">

            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                @can('create', \App\Models\Team::class)
                    <button type="button" wire:click="create" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                        {{ _i('Add Team') }}
                    </button>
                @endcan
            </div>
        </div>
        <div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ _i('team name') }}</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ _i('Display Name') }}</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">{{ _i('Description') }}</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($teams as $team)
                <tr>
                    <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                        {{ $team->name }}
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{ $team->display_name }}</td>
                    <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">{{ $team->description ?? 'none' }}</td>
                    <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                        @can('update', $team)
                            <x-button.link wire:click="edit({{ $team->id }})"><i class="fa-solid fa-pen-to-square"></i></x-button.link>
                        @else
                            <x-button.link disabled><i class="fa-solid fa-pen-to-square"></i></x-button.link>
                        @endcan
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">{{ _i('edit team') }}</x-slot>
            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ _i('team name') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.name" name="{{ _i('team name') }}" id="name" class="@error('editing.name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 lowercase focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('team name') }}" @error('editing.name') aria-invalid="true" aria-describedby="name-error" @enderror>
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
                            <p class="mt-2 text-xs text-gray-500" id="email-description">{{ _i('The internal used team name.') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="display_name" class="block text-sm font-medium text-gray-700">{{ _i('Display Team Name') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.display_name" name="display_name" id="display_name" class="@error('editing.display_name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('Display Team Name') }}" @error('editing.display_name') aria-invalid="true" aria-describedby="display_name-error" @enderror>
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
                            <p class="mt-2 text-xs text-gray-500" id="name-description">{{ _i('The displayed team name.') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">{{ _i('Description') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <textarea wire:model.lazy="editing.description" name="description" id="description" class="@error('editing.description') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('Description') }}" @error('editing.description') aria-invalid="true" aria-describedby="description-error" @enderror></textarea>
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
                            <p class="mt-2 text-sm text-red-600" id="name-error">{{ $errors->first('editing.description') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="description-description">{{ _i('A description for this team. (optional)') }}</p>
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
