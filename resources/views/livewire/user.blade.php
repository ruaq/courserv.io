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

@php use App\Models\User; @endphp
<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">

            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                @can('create', User::class)
                    <button type="button" wire:click="create"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                        {{ _i('Add User') }}
                    </button>
                @endcan
            </div>
        </div>
        <div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                        Name
                    </th>
                    <th scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">{{ _i('Teams') }}</th>
                    <th scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">{{ _i('Roles') }}</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($users as $user)
                    <tr>
                        <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full"
                                         src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                         alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="hidden text-gray-500 sm:table-cell">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                            @foreach($user->teams as $team)
                                {{ $team->display_name }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </td>
                        <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">
                            @foreach($user->roles as $role)
                                @if(!$role->pivot->team_id)
                                    {{ $role->display_name }}{{ !$loop->last ? ', ' : '' }}
                                @endif
                            @endforeach
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-500">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            @can('update', $user)
                                <x-button.badge
                                    wire:click="active({{ $user->id }})">{{ $user->active ? _i('active') : _i('inactive') }}</x-button.badge>
                            @else
                                <x-button.badge wire:click="active({{ $user->id }})"
                                                disabled>{{ $user->active ? _i('active') : _i('inactive') }}</x-button.badge>
                            @endcan
                        </span>
                        </td>
                        <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            @can('update', $user)
                                <x-button.link wire:click="edit({{ $user->id }})"><i
                                        class="fa-solid fa-pen-to-square"></i></x-button.link>
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
            <x-slot name="title">{{ _i('edit user') }}</x-slot>
            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ _i('name') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.name" name="{{ _i('name') }}" id="name"
                                   class="@error('editing.name') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="{{ _i('name') }}" @error('editing.name') aria-invalid="true"
                                   aria-describedby="name-error" @enderror>
                            @error('editing.name')
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('editing.name')
                        <p class="mt-2 text-sm text-red-600" id="name-error">{{ $errors->first('editing.name') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email"
                               class="block text-sm font-medium text-gray-700">{{ _i('e-mail address') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.email" name="email" id="email"
                                   class="@error('editing.email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500  focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="{{ _i('e-mail address') }}" @error('editing.email') aria-invalid="true"
                                   aria-describedby="email-error" @enderror>
                            @error('editing.email')
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                          clip-rule="evenodd"/>
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
                                        <div class="py-2">
                                            <div class="relative flex items-start py-2">
                                                <div class="min-w-0 flex-1 text-sm">
                                                    <label for="{{ $team->id }}"
                                                           class="font-medium text-gray-700">{{ $team->display_name }}</label>
                                                    <p id="{{ $team->id }}-description"
                                                       class="text-gray-500">{{ $team->description }}</p>
                                                </div>
                                                <div class="ml-3 flex h-5 items-center">
                                                    <input wire:model="teamIds" value="{{ $team->id }}"
                                                           id="{{ $team->id }}"
                                                           aria-describedby="{{ $team->id }}-description"
                                                           type="checkbox"
                                                           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="category"
                                                       class="block text-sm font-medium text-gray-700">{{ _i('role for this team') }}</label>
                                                <select id="category" wire:model.lazy="teamRoleIds.{{ $team->id }}"
                                                        name="category"
                                                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                    <option value="">{{ _i('no role') }}</option>
                                                    @foreach($roles as $role)
                                                        <option
                                                            value="{{ $role->id }}">{{ $role->display_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('editing.category')
                                                <p class="mt-2 text-sm text-red-600"
                                                   id="category-error">{{ $errors->first('editing.category') }}</p>
                                                @enderror
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
                                                <label for="{{ $role->id }}"
                                                       class="font-medium text-gray-700">{{ $role->display_name }}</label>
                                                <p id="{{ $role->id }}-description"
                                                   class="text-gray-500">{{ $role->description }}</p>
                                            </div>
                                            <div class="ml-3 flex h-5 items-center">
                                                <input wire:model="roleIds" value="{{ $role->id }}" id="{{ $role->id }}"
                                                       aria-describedby="{{ $role->id }}-description" type="checkbox"
                                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
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
