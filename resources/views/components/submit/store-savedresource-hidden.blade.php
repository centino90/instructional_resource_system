@props(['passover' => ''])

<x-button {{ $attributes }} class="btn-secondary form-control storeSavedresourceHiddenSubmit submit"
    data-form-target="#storeSavedresourceHiddenForm" data-passover="{{ $passover }}">
    Save
</x-button>
