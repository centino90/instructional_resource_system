@props(['passover' => ''])

<form id="updateImportantresourceHiddenForm" action="{{ route('important-resources.update', $passover) }}" hidden
    method="POST">
    @csrf
    @method('PUT')

    <x-input name="resource_id" hidden>
    </x-input>

    <x-button class="btn-secondary form-control" type="submit">
        <x-icon.star></x-icon.star>

        Important
    </x-button>
</form>
