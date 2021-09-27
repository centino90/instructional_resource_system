@props(['passover' => ''])

<form id="rejectPendingresourceHiddenForm" action="{{ route('pending-resources.reject', $passover) }}"
    method="POST">
    @csrf
    @method('PUT')

    <x-input type="hidden" name="resource_id">
    </x-input>
    <x-label>Your comment *</x-label>
    <x-input type="hidden" name="comment_type" value="rejected">
    </x-input>
    <x-input-textarea name="comment">
    </x-input-textarea>

    {{-- {{$slot}} --}}
</form>
