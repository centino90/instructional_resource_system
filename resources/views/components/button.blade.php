@props(['type' => 'button', 'class' => ''])

<button {{ $attributes->merge(['type' => $type, 'class' => 'btn text-nowrap border fw-bold ' . $class]) }}>
    {{ $slot }}
</button>
