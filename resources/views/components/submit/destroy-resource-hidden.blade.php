@props(['passover' => ''])

<x-button {{ $attributes }} class="btn-danger form-control destroyResourceHiddenSubmit submit"
    data-form-target="#destroyResourceHiddenForm" data-passover="{{ $passover }}">
    Delete
</x-button>
