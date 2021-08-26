@props(['type' => 'button', 'class' => ''])

<button {{ $attributes->merge(['type' => $type, 'class' => 'btn ' . $class]) }}>
    {{ $slot }}
</button>
