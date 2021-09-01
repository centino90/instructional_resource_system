@props(['name' => '', 'type' => 'text', 'error' => ''])


@error($error ? $error : $name)
    <input autocomplete="off"
        {{ $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-control is-invalid', 'value' => old($name) ? old($name) : old($error), 'type' => $type]) }}>

@else
    <input autocomplete="off"
        {{ $attributes->merge(['name' => $name, 'id' => $name, 'class' => 'form-control', 'value' => old($name) ? old($name) : old($error), 'type' => $type]) }}>
@enderror

{{-- <td class="col-10">
    <input class="form-control @error('types.lists.${tabLength}') is-invalid @enderror" name="types[lists][${tablength}]" id="types[lists][${tablength}]" value="{{ old('types[lists][${tabLength}]') }}">

    @error('types.lists.${tabLength}')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</td> --}}
