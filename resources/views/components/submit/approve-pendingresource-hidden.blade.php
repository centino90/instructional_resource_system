@props(['passover' => '', 'isApproved' => false])

<x-button {{ $attributes }} class="btn-success form-control approvePendingresourceHiddenSubmit submit {{ $isApproved ? 'disabled' : '' }}"
    data-form-target="#approvePendingresourceHiddenForm" data-passover="{{ $passover }}" data-bs-toggle="modal"
    data-bs-target="#approvePendingresourceModal">

    Approve
</x-button>
