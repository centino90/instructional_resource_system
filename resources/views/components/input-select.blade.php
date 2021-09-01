@props(['name' => '', 'error' => ''])

@error($error ? $error : $name)
    <select autocomplete="off"
        {{ $attributes->merge(['class' => 'form-select is-invalid', 'name' => $name, 'id' => $name]) }}>

        {{ $slot }}
    </select>

@else
    <select autocomplete="off" {{ $attributes->merge(['class' => 'form-select ', 'name' => $name, 'id' => $name]) }}>

        {{ $slot }}
    </select>
@enderror
