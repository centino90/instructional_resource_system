@props(['name' => '', 'type' => 'button'])

<input {{ $attributes->merge(['name' => $name, 'id' => $name, 'type' => $type, 'class' => 'btn form-control']) }}>
