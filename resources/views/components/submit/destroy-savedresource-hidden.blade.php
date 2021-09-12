@props(['passover' => ''])

<x-button {{ $attributes }} class="btn-secondary form-control destroySavedresourceHiddenSubmit submit"
    data-form-target="#destroySavedresourceHiddenForm" data-passover="{{ $passover }}">
    Unsave
</x-button>
