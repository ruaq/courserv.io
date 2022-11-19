<div>

    <div class="space-y-4 py-4">
        <div class="flex justify-between">
            <div class="flex w-2/4 space-x-4">
                <x-input.text wire:model="filters.search" placeholder="{{ _i('Search...') }}" />

{{--                <x-button.link wire:click="toggleShowFilters">@if ($showFilters) Hide @endif Advanced Search...</x-button.link>--}}
            </div>

            <div class="flex items-center space-x-2">
                <x-input.group borderless paddingless for="perPage" label="Per Page">
                    <x-input.select wire:model="perPage" id="perPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </x-input.select>
                </x-input.group>

                @can('create', \App\Models\Price::class)
                    <x-button.primary wire:click="create"><x-icon.plus /> {{ _i('Add Price') }}</x-button.primary>
                @endcan
            </div>
        </div>

        <!-- Advanced Search -->
{{--        <div>--}}
{{--            @if ($showFilters)--}}
{{--                <div class="bg-cool-gray-200 relative flex rounded p-4 shadow-inner">--}}
{{--                    <div class="w-1/2 space-y-4 pr-2">--}}
{{--                        <x-input.group inline for="filter-courseType" label="{{ _i('course type') }}">--}}
{{--                            <x-input.select wire:model="filters.courseType" id="filter-courseType">--}}
{{--                                <option value="" disabled>{{ _i('select course type...') }}</option>--}}
{{--                                @foreach($courseTypes as $category => $courseType)--}}
{{--                                    <optgroup label="{{ $category }}">--}}
{{--                                        @foreach($courseType as $ct)--}}
{{--                                            <option value="{{ $ct['id'] }}">{{ $ct['name'] }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </optgroup>--}}
{{--                                @endforeach--}}
{{--                            </x-input.select>--}}
{{--                        </x-input.group>--}}

{{--                        <x-input.group inline for="filter-team" label="{{ _i('team') }}">--}}
{{--                            <x-input.select wire:model="filters.team" id="filter-team">--}}
{{--                                <option value="" disabled>{{ _i('select team...') }}</option>--}}
{{--                                @foreach($teams as $team)--}}
{{--                                    <option value="{{ $team['id'] }}">{{ $team['display_name'] }}</option>--}}
{{--                                @endforeach--}}
{{--                            </x-input.select>--}}
{{--                        </x-input.group>--}}

{{--                        <x-input.group inline for="filter-showCancelled" label="{{ _i('cancelled courses') }}">--}}
{{--                            <x-input.select wire:model="filters.showCancelled" id="filter-showCancelled">--}}
{{--                                <option value="">{{ _i('don\'t show cancelled courses') }}</option>--}}
{{--                                <option value="true">{{ _i('show cancelled courses') }}</option>--}}
{{--                            </x-input.select>--}}
{{--                        </x-input.group>--}}
{{--                    </div>--}}

{{--                    <div class="w-1/2 space-y-4 pl-2">--}}
{{--                        <x-input.group inline for="filter-date-min" label="{{ _i('minimum date') }}">--}}
{{--                            <x-input.date wire:model="filters.date-min" id="filter-date-min" :options="$search_options"/>--}}
{{--                        </x-input.group>--}}

{{--                        <x-input.group inline for="filter-date-max" label="{{ _i('maximum date') }}">--}}
{{--                            <x-input.date wire:model="filters.date-max" id="filter-date-max" :options="$search_options"/>--}}
{{--                        </x-input.group>--}}

{{--                        <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">{{ _i('reset filters') }}</x-button.link>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}

        <div class="flex-col space-y-4">
            <x-table>
                <x-slot name="head">
                    <x-table.heading sortable multi-column wire:click="sortBy('title')" :direction="$sorts['title'] ?? null">{{ _i('title') }}</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('description')" :direction="$sorts['description'] ?? null">{{ _i('description') }}</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('price')" :direction="$sorts['price'] ?? null">{{ _i('price') }}</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-slot>

                <x-slot name="body">
                    @foreach($prices as $price)
                        <x-table.row class="{{ !$price->active ? 'line-through' : '' }}">
                            <x-table.cell>{{ $price->title }}</x-table.cell>
                            <x-table.cell>{{ $price->description }}</x-table.cell>
                            <x-table.cell>{{ $price->amount_net }} {{ $price->amount_net != $price->amount_gross ? '/ ' . $price->amount_gross : '' }} {{ $price->currency }}</x-table.cell>
                            <x-table.cell>
                                @can('update', $price)
                                    <x-button.link wire:click="edit({{ $price->id }})">{{ _i('edit') }}</x-button.link>
                                @endcan
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-slot>
            </x-table>
            <div>
                {{ $prices->links() }}
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">{{ _i('edit price') }}</x-slot>
            <x-slot name="content">
                <div class="space-y-3">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">{{ _i('title') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" wire:model.lazy="editing.title" name="{{ _i('title') }}" id="units" class="@error('editing.title') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('title') }}" @error('editing.title') aria-invalid="true" aria-describedby="title-error" @enderror>
                            @error('editing.title')
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('editing.title')
                            <p class="mt-2 text-sm text-red-600" id="title-error">{{ $errors->first('editing.title') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="title-description">{{ _i('the price title') }}</p>
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
                            <p class="mt-2 text-xs text-gray-500" id="description-description">{{ _i('A description for price option.') }}</p>
                        @enderror
                    </div>

                   <div>
                        <div class="flex flex-row">
                            <div>
                                <label for="tax_rate" class="block text-sm font-medium text-gray-700">{{ _i('tax') }}</label>
                                <select wire:model.lazy="editing.tax_rate" id="tax_rate" name="tax_rate" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                    @foreach(\App\Models\Price::TAX as $tax_id => $tax_rate)
                                        <option value="{{ $tax_id }}">{{ $tax_rate }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <label for="amount_net" class="block text-sm font-medium text-gray-700">{{ _i('price (net)') }}</label>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm"> {{ $sign }} </span>
                                </div>
                                <input type="text" wire:model.lazy="editing.amount_net" name="price" id="price" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 flex items-center">
                                    <label for="currency" class="sr-only">Currency</label>
                                    <select wire:model.lazy="editing.currency" id="currency" name="currency" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md">
                                        @foreach(\App\Models\Price::CURRENCY as $currency)
                                            <option value="{{ $currency }}">{{ $currency }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="amount_net" class="block text-sm font-medium text-gray-700">{{ _i('net / gross is calculated automatically') }}</label>
                            </div>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <label for="amount_gross" class="block text-sm font-medium text-gray-700">{{ _i('price (gross)') }}</label>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm"> {{ $sign }} </span>
                                </div>
                                <input type="text" wire:model.lazy="editing.amount_gross" name="amount_gross" id="amount_gross" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 flex items-center">
                                    <label for="currency" class="sr-only">Currency</label>
                                    <select wire:model.lazy="editing.currency" id="currency" name="currency" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md">
                                        @foreach(\App\Models\Price::CURRENCY as $currency)
                                            <option value="{{ $currency }}">{{ $currency }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="certTemplate" class="block text-sm font-medium text-gray-700">{{ _i('Certification Template') }}</label>
                        <select id="certTemplate" wire:model.lazy="editing.cert_template_id" name="certTemplate" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            <option value="0">{{ _i('No Certification Template') }}</option>
                            @foreach($certTemplates as $certTemplate)
                                <option value="{{ $certTemplate->id }}">{{ $certTemplate->title }}</option>
                            @endforeach
                        </select>
                        @error('editing.cert_template_id')
                        <p class="mt-2 text-sm text-red-600" id="certTemplate-error">{{ $errors->first('editing.cert_template_id') }}</p>
                        @enderror
                    </div>

                    <fieldset class="space-y-5">
                        <legend class="sr-only">Notifications</legend>
                        @foreach(config('payment.methods') as $method)
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input wire:model.lazy="payment.{{ $method }}" id="{{ $method }}" aria-describedby="{{ $method }}-description" name="{{ $method }}" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="{{ $method }}" class="font-medium text-gray-700">{{ __('payments.' . $method . '.title')  }}</label>
                                    <p id="{{ $method }}-description" class="text-gray-500">{!! __('payments.' . $method . '.description') !!}</p>
                                </div>
                            </div>
                        @endforeach
                    </fieldset>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showEditModal', false)">{{ _i('Cancel') }}</x-button.secondary>
                <x-button.primary type="submit">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
