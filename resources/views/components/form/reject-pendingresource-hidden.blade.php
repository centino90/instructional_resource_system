@props(['passover' => ''])

<form id="rejectPendingresourceHiddenForm" action="{{ route('pending-resources.reject', $passover) }}" hidden
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
