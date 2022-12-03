<div>

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">

            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                @can('create', \App\Models\Price::class)
                    <button type="button" wire:click="create" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                        {{ _i('Add Certification Template') }}
                    </button>
                @endcan
            </div>
        </div>
        <div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ _i('title') }}</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">{{ _i('description') }}</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($templates as $template)
                <tr>
                    <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                        {{ $template->title }}
                    </td>
                    <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">{{ $template->description }}</td>
                    <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                        @can('update', $template)
                            <x-button.link wire:click="edit({{ $template->id }})"><i class="fa-solid fa-pen-to-square"></i></x-button.link>
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
            <x-slot name="title">{{ _i('edit certification template') }}</x-slot>
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
                            <p class="mt-2 text-xs text-gray-500" id="title-description">{{ _i('the template title') }}</p>
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
                            <p class="mt-2 text-xs text-gray-500" id="description-description">{{ _i('A description for this template.') }}</p>
                            @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">{{ _i('Template File') }}</label>
                        <div class="relative mt-1 rounded-md shadow-sm text-center">
                            <input type="file" wire:model="newTemplate" id="{{ $uploadId }}">
{{--                            <textarea wire:model.lazy="editing.description" name="description" id="description" class="@error('editing.description') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500 @enderror block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="{{ _i('Description') }}" @error('editing.description') aria-invalid="true" aria-describedby="description-error" @enderror></textarea>--}}
                            @error('newTemplate')
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <!-- Heroicon name: solid/exclamation-circle -->
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('newTemplate')
                            <p class="mt-2 text-sm text-red-600" id="name-error">{{ $errors->first('newTemplate') }}</p>
                        @else
                            <p class="mt-2 text-xs text-gray-500" id="description-description">{{ _i('The Template File') }}</p>
                        @enderror
                    </div>

{{--                    <div>--}}
{{--                        <div class="flex flex-row">--}}
{{--                            <div>--}}
{{--                                <label for="tax_rate" class="block text-sm font-medium text-gray-700">{{ _i('tax') }}</label>--}}
{{--                                <select wire:model.lazy="editing.tax_rate" id="tax_rate" name="tax_rate" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">--}}
{{--                                    @foreach(\App\Models\Price::TAX as $tax_id => $tax_rate)--}}
{{--                                        <option value="{{ $tax_id }}">{{ $tax_rate }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}

{{--                            </div>--}}
{{--                            <div class="mt-1 relative rounded-md shadow-sm">--}}
{{--                                <label for="amount_net" class="block text-sm font-medium text-gray-700">{{ _i('price (net)') }}</label>--}}
{{--                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">--}}
{{--                                    <span class="text-gray-500 sm:text-sm"> --}}{{-- $sign --}}{{-- </span>--}}
{{--                                </div>--}}
{{--                                <input type="text" wire:model.lazy="editing.amount_net" name="price" id="price" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00">--}}
{{--                                <div class="absolute inset-y-0 right-0 flex items-center">--}}
{{--                                    <label for="currency" class="sr-only">Currency</label>--}}
{{--                                    <select wire:model.lazy="editing.currency" id="currency" name="currency" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md">--}}
{{--                                        @foreach(\App\Models\Price::CURRENCY as $currency)--}}
{{--                                            <option value="{{ $currency }}">{{ $currency }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <label for="amount_net" class="block text-sm font-medium text-gray-700">{{ _i('net / gross is calculated automatically') }}</label>--}}
{{--                            </div>--}}
{{--                            <div class="mt-1 relative rounded-md shadow-sm">--}}
{{--                                <label for="amount_gross" class="block text-sm font-medium text-gray-700">{{ _i('price (gross)') }}</label>--}}
{{--                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">--}}
{{--                                    <span class="text-gray-500 sm:text-sm"><input type="file" wire:model="newAvatar"></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <fieldset class="space-y-5">
                        <legend class="sr-only">Notifications</legend>
{{--                        @foreach(config('payment.methods') as $method)--}}
{{--                            <div class="relative flex items-start">--}}
{{--                                <div class="flex items-center h-5">--}}
{{--                                    <input wire:model.lazy="payment.{{ $method }}" id="{{ $method }}" aria-describedby="{{ $method }}-description" name="{{ $method }}" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">--}}
{{--                                </div>--}}
{{--                                <div class="ml-3 text-sm">--}}
{{--                                    <label for="{{ $method }}" class="font-medium text-gray-700">{{ __('payments.' . $method . '.title')  }}</label>--}}
{{--                                    <p id="{{ $method }}-description" class="text-gray-500">{!! __('payments.' . $method . '.description') !!}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
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
