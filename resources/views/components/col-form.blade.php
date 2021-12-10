@props(['name' => '', 'type' => 'text', 'error' => '', 'label' => ''])

<div class="row mb-3">
    <label for="{{ $name }}" class="col-sm-2 col-form-label text-secondary fw-bold">{{ $label }}</label>
    <div class="col-sm-10">
        @error($error ? $error : $name)
            <input
                {{ $attributes->merge(['type' => $type, 'name' => $name, 'id' => $name, 'value' => old($name) ? old($name) : old($error), 'class' => 'form-control is-invalid']) }}>
            <x-input-error :for="$name"></x-input-error>
        @else
            <input
                {{ $attributes->merge(['type' => $type, 'name' => $name, 'id' => $name, 'value' => old($name) ? old($name) : old($error), 'class' => 'form-control']) }}>
        @enderror
    </div>
</div>
