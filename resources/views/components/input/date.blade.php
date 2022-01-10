{{--@props([--}}
{{--'error' => null--}}
{{--])--}}

{{--<div--}}
{{--    x-data="{ value: @entangle($attributes->wire('model')) }"--}}
{{--    x-on:change="value = $event.target.value"--}}
{{--    x-init="flatpickr($refs.input, {enableTime: true, dateFormat: 'd.m.Y H:i', defaultHour: 10, time_24hr: true })"--}}
{{-->--}}
{{--    <input--}}
{{--        {{ $attributes->whereDoesntStartWith('wire:model') }}--}}
{{--        x-ref="input"--}}
{{--        x-bind:value="value"--}}
{{--        type="text"--}}
{{--        class="pl-10 block w-full shadow-sm sm:text-lg bg-gray-50 border-gray-300 @if($error) focus:ring-danger-500 focus:border-danger-500 border-danger-500 text-danger-500 pr-10 @else focus:ring-primary-500 focus:border-primary-500 @endif rounded-md"--}}
{{--    />--}}
{{--</div>--}}



{{--<div wire:ignore>--}}
{{--    <div--}}
{{--        x-data="{value: @entangle($attributes->wire('model'))}"--}}
{{--        x-on:change="value = $event.target.value"--}}
{{--        x-init="flatpickr($refs.input, {{ json_encode((object)$options) }})"--}}
{{--        x-init="() => {--}}
{{--            $watch('value', value => instance.setDate(value, true));--}}
{{--            instance = flatpickr($refs.input, {{ json_encode((object)$options) }});--}}
{{--        }"--}}
{{--    >--}}
{{--        <input--}}
{{--            {{ $attributes->whereDoesntStartWith('wire:model') }}--}}
{{--            x-ref="input"--}}
{{--            x-bind:value="value"--}}
{{--            type="text"--}}
{{--            {{ $attributes->merge(['class' => 'form-input w-full rounded-md shadow-sm']) }}--}}
{{--        />--}}
{{--    </div>--}}
{{--</div>--}}

@props(['options'])

<div>
    <div wire:ignore>
        <input
            x-data="{
                 value: @entangle($attributes->wire('model')),
                 instance: undefined,
                 init() {
                     $watch('value', value => this.instance.setDate(value, false));
                     this.instance = flatpickr(this.$refs.input, {{ json_encode((object)$options) }});
                 }
            }"
            x-ref="input"
            x-bind:value="value"
            type="text"
            {{ $attributes->merge(['class' => '"block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300']) }}
        />
    </div>
</div>
