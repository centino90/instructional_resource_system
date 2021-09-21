@props(['passover' => '', 'isRejected' => false])

<x-button {{ $attributes }}
    class="btn-danger form-control rejectPendingresourceHiddenSubmit submit {{ $isRejected ? 'disabled' : '' }}"
    data-form-target="#rejectPendingresourceHiddenForm" data-passover="{{ $passover }}" data-bs-toggle="modal"
    data-bs-target="#rejectPendingresourceModal">

    Reject
</x-button>
