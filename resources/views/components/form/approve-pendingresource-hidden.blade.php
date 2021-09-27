@props(['passover' => ''])

<form id="approvePendingresourceHiddenForm" action="{{ route('pending-resources.approve', $passover) }}"
    method="POST">
    @csrf
    @method('PUT')

    <x-input type="hidden" name="resource_id">
    </x-input>
    <x-label>Your comment</x-label>
    <x-input type="hidden" name="comment_type" value="approved">
    </x-input>
    <x-input-textarea name="comment">
    </x-input-textarea>

    {{-- {{ $slot }} --}}
</form>
