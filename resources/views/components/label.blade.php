@props(['value'])

<label {{ $attributes->merge(['class' => 'form-label']) }}>
    {{ ucfirst($value ?? $slot) }}
</label>
