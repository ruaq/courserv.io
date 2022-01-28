@props(['options'])

<div data-options="{{ json_encode($options) }}"
    x-data
    x-init="flatpickr($refs.input, {{ json_encode((object)$options) }});"
>
    <input
        x-ref="input"
        type="text"
        {{ $attributes->merge(['class' => '"block w-full pr-10 sm:text-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 block border-gray-300']) }}
    >
</div>
