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

@php use App\Models\Position; @endphp
<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">

            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                @can('create', Position::class)
                    <button type="button" wire:click="create"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                        {{ _i('Add Position') }}
                    </button>
                @endcan
            </div>
        </div>
        <div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ _i('title') }}</th>
                    <th scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ _i('team') }}</th>
                    <th scope="col"
                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">{{ _i('Description') }}</th>
                    <th scope="col"
                        class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">{{ _i('leading') }}</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($positions as $position)
                    <tr>
                        <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                            {{ $position->title }}
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-500">{{ $position->team->display_name ?? '' }}</td>
                        <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">{{ $position->description ?? 'none' }}</td>
                        <td class="px-3 py-4 text-right text-sm text-gray-500">{!! $position->leading ? '<i class="fa-solid fa-circle-check"></i>' : '<i class="fa-regular fa-circle-xmark"></i>' !!}</td>
                        <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            @can('update', $position)
                                <x-button.link wire:click="edit({{ $position->id }})"><i
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
            <x-slot name="title">{{ _i('edit position') }}</x-slot>
            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <label for="name"
                               class="block text-sm font-medium text-gray-700">{{ _i('position title') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.title" name="{{ _i('team name') }}" id="name"
                                   class="@error('editing.title') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="{{ _i('team name') }}" @error('editing.title') aria-invalid="true"
                                   aria-describedby="title-error" @enderror>
                            @error('editing.title')
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
                        @error('editing.title')
                        <p class="mt-2 text-sm text-red-600" id="title-error">{{ $errors->first('editing.title') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500"
                               id="email-description">{{ _i('The internal used team name.') }}</p>
                            @enderror
                    </div>

                    <div x-data="{ leadingPosition: @entangle('editing.leading').defer }" class="space-y-3">
                        <div class="flex items-center">
                            <button type="button"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-gray-200 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    role="switch" aria-checked="false" x-ref="switch" :aria-checked="leadingPosition"
                                    @click="leadingPosition = !leadingPosition" x-state:on="Enabled"
                                    x-state:off="Not Enabled"
                                    :class="{ 'bg-indigo-600': leadingPosition, 'bg-gray-200': !(leadingPosition) }">
                                <span class="sr-only">{{ _i('leading position') }}</span>
                                <span
                                    class="pointer-events-none relative inline-block h-5 w-5 translate-x-0 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                    x-state:on="Enabled" x-state:off="Not Enabled"
                                    :class="{ 'translate-x-5': leadingPosition, 'translate-x-0': !(leadingPosition) }">
                                        <span
                                            class="absolute inset-0 flex h-full w-full items-center justify-center opacity-100 transition-opacity duration-200 ease-in"
                                            aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled"
                                            :class="{ 'opacity-0 ease-out duration-100': leadingPosition, 'opacity-100 ease-in duration-200': !(leadingPosition) }">
                                            <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                              <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                        <span
                                            class="absolute inset-0 flex h-full w-full items-center justify-center opacity-0 transition-opacity duration-100 ease-out"
                                            aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled"
                                            :class="{ 'opacity-100 ease-in duration-200': leadingPosition, 'opacity-0 ease-out duration-100': !(leadingPosition) }">
                                            <svg class="h-3 w-3 text-indigo-600" fill="currentColor"
                                                 viewBox="0 0 12 12">
                                              <path
                                                  d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"></path>
                                            </svg>
                                        </span>
                                    </span>
                            </button>
                            <span class="ml-3" id="public-bookable-label"
                                  @click="leadingPosition = !leadingPosition; $refs.switch.focus()">
                                    <span class="text-sm font-medium text-gray-900">{{ _i('leading position') }}</span>
                                </span>
                        </div>
                    </div>

                    <div>
                        <label for="team" class="block text-sm font-medium text-gray-700">{{ _i('team') }}</label>
                        <select id="team" wire:model.lazy="editing.team_id" name="team" required
                                class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            @permission('position.update')
                            <option value="0">{{ _i('every team') }}</option>
                            @else
                                <option value="">{{ _i('select a team') }}</option>
                                @endpermission

                                @foreach($teams as $team)
                                    <option value="{{ $team['id'] }}">{{ $team['display_name'] }}</option>
                                @endforeach
                        </select>
                        @error('editing.team_id')
                        <p class="mt-2 text-sm text-red-600" id="team-error">{{ $errors->first('editing.team_id') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description"
                               class="block text-sm font-medium text-gray-700">{{ _i('Description') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <textarea wire:model.lazy="editing.description" name="description" id="description"
                                      class="@error('editing.description') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                      placeholder="{{ _i('Description') }}"
                                      @error('editing.description') aria-invalid="true"
                                      aria-describedby="description-error" @enderror></textarea>
                            @error('editing.description')
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
                        @error('editing.description')
                        <p class="mt-2 text-sm text-red-600"
                           id="name-error">{{ $errors->first('editing.description') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500"
                               id="description-description">{{ _i('A description for this team. (optional)') }}</p>
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
