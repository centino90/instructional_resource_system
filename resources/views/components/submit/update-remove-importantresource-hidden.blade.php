@props(['passover' => ''])

<x-button {{ $attributes }} class="btn-secondary form-control updateImportantresourceHiddenSubmit submit"
    data-form-target="#updateImportantresourceHiddenForm" data-passover="{{ $passover }}">
    <x-icon.star :width="'18'" :height="'18'" :viewBox="'0 0 30 30'"></x-icon.star>

    Unimportant
</x-button>
