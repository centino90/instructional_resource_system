@props(['type' => 'button', 'class' => ''])

<button {{ $attributes->merge(['type' => $type, 'class' => 'btn bg-gradient ' . $class]) }}>
    {{ $slot }}
</button>
