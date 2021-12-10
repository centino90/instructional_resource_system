@props(['action' => '', 'submitClass' => 'btn-danger'])

<form method="POST" {{ $attributes->merge(['action' => $action]) }}>
    @csrf
    @method('DELETE')

    <div>
        <x-button :class="'no-loading ' . $submitClass" type="submit"
            onclick="return confirm('Are you sure you want to delete this resource?')">
            Delete
        </x-button>
    </div>
</form>
