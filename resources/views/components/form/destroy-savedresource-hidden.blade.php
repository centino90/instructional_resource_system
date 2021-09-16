@props(['passover' => ''])

<form id="destroySavedresourceHiddenForm" action="{{ route('saved-resources.destroy', $passover) }}" method="POST"
    hidden>
    @csrf
    @method('DELETE')

    <x-input name="resource_id" hidden>
    </x-input>

    <x-button class="btn-secondary form-control" type="submit">
        Unsave
    </x-button>
</form>
