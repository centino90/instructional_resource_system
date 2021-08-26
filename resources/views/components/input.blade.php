@props(['name' => '', 'label' => '', 'type' => 'text'])

@if ($label)
    <label for="{!! $name !!}" class="form-label">{!! ucfirst($label) !!}</label>
@endif

@error($name)
    <input {!! $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-control is-invalid', 'value' => old($name), 'type' => $type]) !!}>


@else
    <input {!! $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-control', 'value' => old($name), 'type' => $type]) !!}>
@enderror
