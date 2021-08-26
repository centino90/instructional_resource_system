@props(['name' => '', 'label' => '', 'type' => 'checkbox'])

<div class="form-check">
    @if ($label)
        <label for="{!! $name !!}" class="form-check-label">{!! ucfirst($label) !!}</label>
    @endif

    @error($name)
        <input {!! $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-check-input is-invalid', 'value' => old($name), 'type' => $type]) !!}>

    @else
        <input {!! $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-check-input', 'value' => old($name), 'type' => $type]) !!}>
    @enderror
</div>
