@props(['passover' => ''])

<form id="storeSavedresourceHiddenForm" action="{{ route('saved-resources.store') }}" method="POST" hidden>
    @csrf
    @method('POST')

    <x-input name="resource_id" hidden>
    </x-input>

    <x-button class="btn-secondary form-control" type="submit">Save
    </x-button>
</form>
