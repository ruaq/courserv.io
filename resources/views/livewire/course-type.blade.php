<div>
{{--    <div class="flex flex-col">--}}
{{--        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">--}}
{{--            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">--}}
{{--                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">--}}
{{--                    <table class="min-w-full divide-y divide-gray-200">--}}
{{--                        <thead class="bg-gray-50">--}}
{{--                        <tr>--}}
{{--                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">--}}
{{--                                {{ _i('course type name') }}--}}
{{--                            </th>--}}
{{--                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">--}}
{{--                                {{ _i('category') }}--}}
{{--                            </th>--}}
{{--                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">--}}
{{--                                {{ _i('units') }}--}}
{{--                            </th>--}}
{{--                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">--}}
{{--                                {{ _i('units per day') }}--}}
{{--                            </th>--}}
{{--                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">--}}
{{--                                {{ _i('breaks') }}--}}
{{--                            </th>--}}
{{--                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">--}}
{{--                                {{ _i('seats') }}--}}
{{--                            </th>--}}
{{--                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium tracking-wider text-gray-500">--}}
{{--                                @can('create', \App\Models\CourseType::class)<x-button.link wire:click="create">{{ _i('Add Course type') }}</x-button.link>@endcan--}}
{{--                            </th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody class="divide-y divide-gray-200 bg-white">--}}
{{--                        @foreach($courseTypes as $courseType)--}}
{{--                            <tr>--}}
{{--                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">--}}
{{--                                    {{ $courseType->name }}--}}
{{--                                </td>--}}
{{--                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">--}}
{{--                                    {{ $courseType->category }}--}}
{{--                                </td>--}}
{{--                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">--}}
{{--                                    {{ $courseType->units }} {{ _i('LU') }}--}}
{{--                                </td>--}}
{{--                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">--}}
{{--                                    {{ $courseType->units_per_day }} {{ _i('LU / day') }}--}}
{{--                                </td>--}}
{{--                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">--}}
{{--                                    {{ $courseType->breaks }} {{ _i('minutes') }}--}}
{{--                                </td>--}}
{{--                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">--}}
{{--                                    {{ $courseType->seats }} {{ _i('seats') }}--}}
{{--                                </td>--}}
{{--                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">--}}
{{--                                    @can('update', $courseType)--}}
{{--                                        <x-button.link wire:click="edit({{ $courseType->id }})">{{ _i('edit') }}</x-button.link>--}}
{{--                                    @endcan--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
{{--                <h1 class="text-xl font-semibold text-gray-900">Users</h1>--}}
{{--                <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name, title, email and role.</p>--}}
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                @can('create', \App\Models\CourseType::class)
                    <button type="button" wire:click="create" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                        {{ _i('Add Course type') }}
                    </button>
                @endcan
            </div>
        </div>
        <div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ _i('course type name') }}</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">{{ _i('category') }}</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ _i('units') }}</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">{{ _i('units per day') }}</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">{{ _i('breaks') }}</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ _i('seats') }}</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($courseTypes as $courseType)
                <tr>
                    <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                        {{ $courseType->name }}
                        <dl class="font-normal md:hidden">
                            <dt class="sr-only">Title</dt>
                            <dd class="mt-1 truncate text-gray-500">{{ $courseType->category }}</dd>
{{--                            <dt class="sr-only sm:hidden">Email</dt>--}}
{{--                            <dd class="mt-1 truncate text-gray-500 sm:hidden">lindsay.walton@example.com</dd>--}}
                        </dl>
                    </td>
                    <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">{{ $courseType->category }}</td>
                    <td class="px-3 py-4 text-sm text-gray-500">
                        {{ $courseType->units }} {{ _i('LU') }}
                        <dl class="font-normal md:hidden">
                            <dt class="sr-only">Title</dt>
                            <dd class="mt-1 truncate text-gray-500">{{ $courseType->units_per_day }} {{ _i('LU / day') }}</dd>
{{--                            <dt class="sr-only sm:hidden">Email</dt>--}}
{{--                            <dd class="mt-1 truncate text-gray-500 sm:hidden">lindsay.walton@example.com</dd>--}}
                        </dl>
                    </td>
                    <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">{{ $courseType->units_per_day }} {{ _i('LU / day') }}</td>
                    <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">{{ $courseType->breaks }} {{ _i('minutes') }}</td>
                    <td class="px-3 py-4 text-sm text-gray-500">{{ $courseType->seats }} {{ _i('seats') }}</td>
                    <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                        @can('update', $courseType)
{{--                            <x-button.link wire:click="edit({{ $courseType->id }})">{{ _i('edit') }}</x-button.link>--}}
                            <x-button.link wire:click="edit({{ $courseType->id }})"><i class="fa-solid fa-pen-to-square"></i></x-button.link>
                        @else
                            <x-button.link disabled><i class="fa-solid fa-pen-to-square"></i></x-button.link>
                        @endcan

{{--                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, Lindsay Walton</span></a>--}}
                    </td>
                </tr>
                @endforeach

                <!-- More people... -->
                </tbody>
            </table>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">{{ _i('edit course type') }}</x-slot>
            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ _i('Course type name') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.name" name="{{ _i('Course type name') }}" id="name" class="@error('editing.name') border-red-300 placeholder-red-300 text-red-900 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('Course type name') }}" @error('editing.name') aria-invalid="true" aria-describedby="name-error" @enderror>
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
                            <p class="mt-2 text-xs text-gray-500" id="name-description">{{ _i('The internal used team name.') }}</p>
                        @enderror
                    </div>

                    @if(config('qseh.codeNumber'))
                        <div>
                            <label for="qseh_course" class="block text-sm font-medium text-gray-700">{{ _i('QSEH Course') }}</label>
                            <select id="qseh_course" wire:model.lazy="editing.wsdl_id" name="category" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                <option>{{ _i('no') }}</option>
                                @foreach(\App\Models\CourseType::WSDL as $wsdl_id => $wsdl_label)
                                    <option value="{{ $wsdl_id }}">{{ $wsdl_label }}</option>
                                @endforeach
                            </select>
                            @error('editing.category')
                                <p class="mt-2 text-sm text-red-600" id="qseh_course-error">{{ $errors->first('editing.wsdl_id') }}</p>
                            @enderror
                        </div>
                    @endif

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">{{ _i('category') }}</label>
                        <select id="category" wire:model.lazy="editing.category" name="category" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            <option>{{ _i('please select a category') }}</option>
                            @foreach($courseTypeCategories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                            <option value="new_category">{{ _i('new category') }}</option>
                        </select>
                        @error('editing.category')
                            <p class="mt-2 text-sm text-red-600" id="category-error">{{ $errors->first('editing.category') }}</p>
                        @enderror
                    </div>

                    @if($showCategoryInput)
                        <div>
                            <label for="new_category" class="block text-sm font-medium text-gray-700">{{ _i('new category') }}</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <input type="text" wire:model.lazy="new_category" name="new_category" id="new_category" class="@error('new_category') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500  focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('new category') }}" @error('new_category') aria-invalid="true" aria-describedby="new_category-error" @enderror>
                                @error('new_category')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                @enderror
                            </div>
                            @error('new_category')
                                <p class="mt-2 text-sm text-red-600" id="new_category-error">{{ $errors->first('new_category') }}</p>
                            @else
                                <p class="mt-2 text-xs text-gray-500" id="new_category-description">{{ _i('The new category name.') }}</p>
                                @enderror
                        </div>
                    @endif

                    <div>
                        <label for="certTemplate" class="block text-sm font-medium text-gray-700">{{ _i('Certification Template') }}</label>
                        <select id="certTemplate" wire:model.lazy="editing.cert_template_id" name="certTemplate" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            <option value="">{{ _i('No Certification Template') }}</option>
                            @foreach($certTemplates as $certTemplate)
                                <option value="{{ $certTemplate->id }}">{{ $certTemplate->title }}</option>
                            @endforeach
                        </select>
                        @error('editing.cert_template_id')
                            <p class="mt-2 text-sm text-red-600" id="certTemplate-error">{{ $errors->first('editing.cert_template_id') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700">{{ _i('slug') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.slug" name="slug" id="slug" class="block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300 @error('editing.slug') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror " placeholder="{{ _i('slug') }}" @error('editing.slug') aria-invalid="true" aria-describedby="slug-error" @enderror>
                            @error('editing.slug')
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('editing.slug')
                            <p class="mt-2 text-sm text-red-600" id="slug-error">{{ $errors->first('editing.slug') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="slug-description">{{ _i('the course slug') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="iframe_url" class="block text-sm font-medium text-gray-700">{{ _i('iframe redirect url') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.iframe_url" name="iframe_url" id="iframe_url" class="block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300 @error('editing.iframe_url') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror " placeholder="{{ _i('http://your-site.com/slug/dates') }}" @error('editing.iframe_url') aria-invalid="true" aria-describedby="iframe_url-error" @enderror>
                            @error('editing.iframe_url')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.iframe_url')
                            <p class="mt-2 text-sm text-red-600" id="iframe_url-error">{{ $errors->first('editing.iframe_url') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="iframe_url-description">{{ _i('the url to which it\'s redirect, if the location search for this slug isn\'t loaded in a iframe (optional)') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="units" class="block text-sm font-medium text-gray-700">{{ _i('units') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.units" name="{{ _i('units') }}" id="units" class="@error('editing.units') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('units') }}" @error('editing.units') aria-invalid="true" aria-describedby="units-error" @enderror>
                            @error('editing.units')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.units')
                        <p class="mt-2 text-sm text-red-600" id="units-error">{{ $errors->first('editing.units') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="name-description">{{ _i('the complete lesson units') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="units_per_day" class="block text-sm font-medium text-gray-700">{{ _i('units per day') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.units_per_day" name="{{ _i('units per day') }}" id="units_per_day" class="@error('editing.units_per_day') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('units per day') }}" @error('editing.units_per_day') aria-invalid="true" aria-describedby="units_per_day-error" @enderror>
                            @error('editing.units_per_day')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.units_per_day')
                            <p class="mt-2 text-sm text-red-600" id="units_per_day-error">{{ $errors->first('editing.units_per_day') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="units_per_day-description">{{ _i('maximum units per day') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="breaks" class="block text-sm font-medium text-gray-700">{{ _i('breaks') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.breaks" name="{{ _i('breaks') }}" id="breaks" class="@error('breaks') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:border-red-500 focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('breaks') }}" @error('breaks') aria-invalid="true" aria-describedby="breaks-error" @enderror>
                            @error('editing.breaks')
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Heroicon name: solid/exclamation-circle -->
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('editing.breaks')
                            <p class="mt-2 text-sm text-red-600" id="breaks-error">{{ $errors->first('editing.breaks') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="breaks-description">{{ _i('The breaks in minutes') }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="seats" class="block text-sm font-medium text-gray-700">{{ _i('seats') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.seats" name="{{ _i('seats') }}" id="seats" class="@error('seats') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300  pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('seats') }}" @error('seats') aria-invalid="true" aria-describedby="seats-error" @enderror>
                            @error('editing.seats')
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('editing.seats')
                            <p class="mt-2 text-sm text-red-600" id="seats-error">{{ $errors->first('editing.seats') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="seats-description">{{ _i('maximum seats') }}</p>
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
