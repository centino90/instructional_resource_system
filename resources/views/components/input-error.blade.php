@props(['for'])

@error($for)
    <span {{ $attributes->merge(['class' => 'invalid-feedback fw-bold']) }} role="alert">
        {{ $message }}
    </span>
@enderror
