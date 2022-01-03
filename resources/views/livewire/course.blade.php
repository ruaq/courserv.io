<div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ _i('seminar location') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ _i('street') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ _i('location') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ _i('start') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ _i('course type') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ _i('course number') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ _i('team') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 tracking-wider">
                                @can('create', \App\Models\Course::class)<x-button.link wire:click="create">{{ _i('Add Course') }}</x-button.link>@endcan
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($courses as $course)
                            <tr class="{{ $course->cancelled ? 'line-through' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $course->seminar_location }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $course->street }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $course->zipcode }} {{ $course->location }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $course->start->format('d.m.Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $course->type->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $course->registration_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $course->team->display_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @can('update', $course)
                                        <x-button.link wire:click="edit({{ $course->id }})">{{ _i('edit') }}</x-button.link>
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
            <x-slot name="title">{{ _i('edit course') }}</x-slot>
            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <label for="team" class="block text-sm font-medium text-gray-700">{{ _i('team') }}</label>
                        <select id="team" wire:model.lazy="editing.team_id" name="team" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option>{{ _i('select a team') }}</option>
                            @foreach($teams as $team)
                                <option value="{{ $team['id'] }}">{{ $team['display_name'] }}</option>
                            @endforeach
                        </select>
                        @error('editing.team_id')
                            <p class="mt-2 text-sm text-red-600" id="team-error">{{ $errors->first('editing.team_id') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="course_type" class="block text-sm font-medium text-gray-700">{{ _i('course type') }}</label>
                        <select id="course_type" wire:model.lazy="editing.course_type_id" name="course_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">{{ _i('select a course type') }}</option>
                            @foreach($courseTypes as $category => $courseType)
                                <optgroup label="{{ $category }}">
                                    @foreach($courseType as $ct)
                                        <option value="{{ $ct['id'] }}">{{ $ct['name'] }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('editing.course_type')
                            <p class="mt-2 text-sm text-red-600" id="course_type-error">{{ $errors->first('editing.course_type_id') }}</p>
                        @enderror
                    </div>

                    <div>
                        @if($showRegisterCourse)
                            <div x-data="{ registerCourse: @entangle('registerCourse').defer }" class="space-y-3">
                                @if(!$courseRegistered)
                                    <div class="flex items-center">
                                        <button {{ !config('app.qsehPassword') ? 'disabled' : '' }} type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-gray-200" role="switch" aria-checked="false" x-ref="switch" :aria-checked="registerCourse.toString()" @click="registerCourse = !registerCourse" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-600': registerCourse, 'bg-gray-200': !(registerCourse) }">
                                            <span class="sr-only">{{ _i('register automatically at QSEH') }}</span>
                                            <span class="pointer-events-none relative inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': registerCourse, 'translate-x-0': !(registerCourse) }">
                                                <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity opacity-100 ease-in duration-200" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'opacity-0 ease-out duration-100': registerCourse, 'opacity-100 ease-in duration-200': !(registerCourse) }">
                                                    <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                                      <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                                <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity opacity-0 ease-out duration-100" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'opacity-100 ease-in duration-200': registerCourse, 'opacity-0 ease-out duration-100': !(registerCourse) }">
                                                    <svg class="h-3 w-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                                                      <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                        </button>
                                        <span class="ml-3" id="annual-billing-label" @if(config('app.qsehPassword')) @click="registerCourse = !registerCourse; $refs.switch.focus()" @endif>
                                            <span class="text-sm font-medium text-gray-900">{{ _i('register automatically at QSEH') }}</span>
                                        </span>
                                    </div>
                                @endif

                                <div x-show="!registerCourse">
                                    <label for="registration_number" class="block text-sm font-medium text-gray-700">{{ _i('QSEH registration number') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input {{ $courseRegistered ? 'disabled' : '' }} type="text" wire:model.lazy="editing.registration_number" name="{{ _i('QSEH registration number') }}" id="units" class="block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300 @error('editing.registration_number') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror " placeholder="{{ _i('QSEH registration number') }}" @error('editing.registration_number') aria-invalid="true" aria-describedby="registration_number-error" @enderror>
                                        @error('editing.registration_number')
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <!-- Heroicon name: solid/exclamation-circle -->
                                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('editing.registration_number')
                                        <p class="mt-2 text-sm text-red-600" id="registration_number-error">{{ $errors->first('editing.registration_number') }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="start" class="block text-sm text-gray-700 font-semibold">start</label>

                            <x-input.date id="start" wire:model="editing.start" :options="$options"/>

                        </div>
                    </div>

                    <div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="end" class="block text-sm text-gray-700 font-semibold">end</label>

                            <x-input.date id="end" wire:model="editing.end" :options="$options"/>

                        </div>
                    </div>

                    <div>
                        <label for="seminar_location" class="block text-sm font-medium text-gray-700">{{ _i('seminar location') }}</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.seminar_location" name="{{ _i('seminar location') }}" id="units" class="block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300 @error('editing.seminar_location') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror " placeholder="{{ _i('seminar location') }}" @error('editing.seminar_location') aria-invalid="true" aria-describedby="seminar_location-error" @enderror>
                            @error('editing.seminar_location')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.seminar_location')
                            <p class="mt-2 text-sm text-red-600" id="seminar_location-error">{{ $errors->first('editing.seminar_location') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="seminar_location-description">{{ _i('the seminar location or company') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="street" class="block text-sm font-medium text-gray-700">{{ _i('street') }}</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.street" name="{{ _i('street') }}" id="street" class="block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300 @error('editing.street') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror " placeholder="{{ _i('street') }}" @error('editing.street') aria-invalid="true" aria-describedby="street-error" @enderror>
                            @error('editing.street')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.street')
                            <p class="mt-2 text-sm text-red-600" id="street-error">{{ $errors->first('editing.street') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="zipcode" class="block text-sm font-medium text-gray-700">{{ _i('zipcode') }}</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.zipcode" name="{{ _i('zipcode') }}" id="zipcode" class="block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300 @error('editing.zipcode') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror " placeholder="{{ _i('zipcode') }}" @error('editing.zipcode') aria-invalid="true" aria-describedby="zipcode-error" @enderror>
                            @error('editing.zipcode')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.zipcode')
                            <p class="mt-2 text-sm text-red-600" id="zipcode-error">{{ $errors->first('editing.zipcode') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">{{ _i('location') }}</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.location" name="{{ _i('location') }}" id="location" class="block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300 @error('editing.location') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror " placeholder="{{ _i('location') }}" @error('editing.location') aria-invalid="true" aria-describedby="location-error" @enderror>
                            @error('editing.location')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.location')
                            <p class="mt-2 text-sm text-red-600" id="location-error">{{ $errors->first('editing.location') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="seats" class="block text-sm font-medium text-gray-700">{{ _i('seats') }}</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.seats" name="{{ _i('seats') }}" id="seats" class="block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300 @error('editing.seats') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror " placeholder="{{ _i('seats') }}" @error('editing.seats') aria-invalid="true" aria-describedby="seats-error" @enderror>
                            @error('editing.seats')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('editing.seats')
                        <p class="mt-2 text-sm text-red-600" id="seats-error">{{ $errors->first('editing.seats') }}</p>
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
