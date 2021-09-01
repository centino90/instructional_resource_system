@props(['name' => '', 'label' => '', 'type' => 'checkbox', 'error' => ''])

<div class="form-check">
    @if ($label)
        <label for="{{ $name }}" class="form-check-label">{{ ucfirst($label) }}</label>
    @endif

    @error($error ? $error : $name)
        <input autocomplete="off"
            {{ $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-check-input is-invalid', 'value' => old($name) ? old($name) : old($error), 'type' => $type]) }}>

    @else
        <input autocomplete="off"
            {{ $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-check-input', 'value' => old($name) ? old($name) : old($error), 'type' => $type]) }}>
    @enderror
</div>
