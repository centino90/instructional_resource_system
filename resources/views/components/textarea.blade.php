@props(['name' => '', 'label' => ''])

@if ($label)
    <label for="{!! $name !!}" class="form-label">{!! ucfirst($label) !!}</label>
@endif

@error($name)
    <textarea rows="4"
        $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-control is-invalid']) !!}>{{ old($name) }}</textarea>

@else
    <textarea rows="4" {!! $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-control']) !!}>{{ old($name) }}</textarea>
@enderror
