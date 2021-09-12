@props(['passover' => ''])

<form id="destroyResourceHiddenForm" action="{{ route('resources.destroy', $passover) }}" method="POST" hidden>
    @csrf
    @method('DELETE')

    <x-input name="resource_id" hidden>
    </x-input>

    <x-button class="btn-secondary form-control" type="submit">Delete
    </x-button>
</form>
