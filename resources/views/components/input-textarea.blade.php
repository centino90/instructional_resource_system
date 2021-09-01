@props(['name' => '', 'error' => '', 'value' => ''])

@error($error ? $error : $name)
    <textarea autocomplete="off" rows="4"
        {{ $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-control is-invalid']) }}>{{ old($name) ?? (old($error) ?? $value) }}</textarea>

@else
    <textarea autocomplete="off" rows="4"
        {{ $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-control']) }}>{{ old($name) ?? (old($error) ?? $value) }}</textarea>
@enderror
