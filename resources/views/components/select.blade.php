@props(['name' => '', 'label' => ''])

@if ($label)
    <label for="{!! $name !!}" class="form-label">{!! ucfirst($label) !!}</label>
@endif

@error($name)
    <select {!! $attributes->merge(['class' => 'form-select is-invalid', 'name' => $name, 'id' => $name]) !!}>

        {!! $slot !!}
    </select>

@else
    <select {!! $attributes->merge(['class' => 'form-select ', 'name' => $name, 'id' => $name]) !!}>

        {!! $slot !!}
    </select>
@enderror


{{-- @error($name)
    <div class="invalid-feedback">
        {!! $message !!}
    </div>
@enderror --}}
