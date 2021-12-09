<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'px-2 inline-flex text-xs leading-5 font-semibold' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
    ]) }}
>
    {{ $slot }}
</button>
