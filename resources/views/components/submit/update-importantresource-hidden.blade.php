@props(['passover' => ''])

<x-button {{ $attributes }} class="btn-secondary form-control updateImportantresourceHiddenSubmit submit"
    data-form-target="#updateImportantresourceHiddenForm" data-passover="{{ $passover }}">
    <x-icon.star></x-icon.star>

    Important
</x-button>
