@props(['passover' => ''])

<form id="destroyProgramHiddenForm" action="{{ route('programs.destroy', $passover) }}" method="POST"
    hidden>
    @csrf
    @method('DELETE')

    <x-input name="program_id" hidden>
    </x-input>

    <x-button class="btn-secondary form-control" type="submit">
        Delete
    </x-button>
</form>
