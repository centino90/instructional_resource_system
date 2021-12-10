@props(['passover' => ''])

<x-button {{ $attributes }} class="btn-danger destroyProgramHiddenSubmit submit"
    data-form-target="#destroyProgramHiddenForm" data-passover="{{ $passover }}" data-bs-toggle="modal"
    data-bs-target="#deleteProgramModal">
    Delete
</x-button>
