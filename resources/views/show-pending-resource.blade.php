<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Pending Resources</a></li>
            <li class="breadcrumb-item active" aria-current="page">Show Pending Resource</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Show Pending Resource') }}
            </small>

            <div class="ms-auto">
            </div>
        </div>
    </x-slot>

    <div class="my-4">
        @if (session()->exists('success'))
            <x-alert-success class="mb-3">
                {{ session()->get('success') }}

                <a href="{{ route('resources.create') }}"><strong class="px-2">Go back to creating
                        resource?</strong></a>
            </x-alert-success>

        @elseif(session()->get('status') == 'success')
            <x-alert-success class="mb-3">
                <strong>Success!</strong> {{ session()->get('message') }}
            </x-alert-success>
        @endif
    </div>

    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title my-0">
                                @if ($resource->rejected_at)
                                    <span class="badge bg-danger">
                                        Rejected
                                    </span>
                                @elseif($resource->approved_at)
                                    <span class="badge bg-success">
                                        Approved
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>
                                @endif
                                {{ $resource->user->fname . ' ' . $resource->user->lname ?? 'unknown user' }}
                            </h5>
                            <small class="text-muted me-3">
                                Submitted on {{ $resource->course->code }} - {{ $resource->course->title }}
                            </small>

                            <p class="card-text mt-3">
                                <span class="d-block">
                                    {{ $resource->getMedia()->first()->file_name ?? 'unknown file' }}

                                    <small class="badge bg-success">
                                        {{ $resource->getMedia()->first() ? 'latest' : '' }}
                                    </small>

                                    <a href="{{ route('resources.download', $resource->id) }}"
                                        class="ms-3">Download</a>
                                    <a href="#" class="ms-3">View all version</a>
                                </span>

                                <span class="me-3">
                                    @if ($resource->is_syllabus)
                                        <span class="badge rounded-pill bg-primary">Syllabus</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">Regular</span>
                                    @endif
                                </span>

                                <small class="text-muted">Submitted at:
                                    {{ $resource->getMedia()->first()->created_at }}</small>
                            </p>

                            <div class="d-flex gap-2 border-top pt-3">
                                @if (auth()->user()->isProgramDean())
                                    <x-submit.approve-pendingresource-hidden :passover="$resource->id"
                                        :isApproved="$resource->approved_at ? true : false">
                                    </x-submit.approve-pendingresource-hidden>

                                    <x-submit.reject-pendingresource-hidden :passover="$resource->id"
                                        :isRejected="$resource->rejected_at ? true : false">
                                    </x-submit.reject-pendingresource-hidden>
                                @elseif(auth()->user()->isInstructor())
                                    <a href="btn btn-secondary">Add another file</a>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <b>
                                Last updated at: {{ $resource->updated_at }}
                            </b>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <div class="card ">
                        <div class="card-header">
                            Resource Information
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <h5 class="card-title">{{ $resource->title }}</h5>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <p class="card-text">{{ $resource->description }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            Lorem ipsum dolor sit amet.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">

                <div class="page-header">
                    <h1 id="">Timeline</h1>
                </div>

                <div id="timeline" class="row">
                    <div class="col-6">
                        <div class="row g-3">
                            <div>
                                <div class="rounded-circle d-flex justify-content-center align-items-center bg-warning text-danger"
                                    style="width:50px;height:50px">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-message-circle">
                                        <path
                                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                                    </svg>
                                </div>
                                <h5>History Log</h5>

                                {{-- <span class="text-muted">{{ $resource->comments->first()->created_at }}</span> --}}
                            </div>

                            <div class="col-12">
                                @foreach ($resource->activities as $activity)
                                    <span>
                                        <b>{{ $activity->causer->fname . ' ' . $activity->causer->lname ?? 'unknown user' }}</b>
                                        {{ $activity->description }}
                                        <ul>
                                            @foreach ($activity->subject->getMedia() as $media)
                                                <li>
                                                    {{ $media->file_name ?? 'unknown file' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </span>

                                    <div class="lh-1 mb-1">
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->created_at)->diffForHumans() }}</small>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="row g-3">
                            <div>
                                <div class="rounded-circle d-flex justify-content-center align-items-center bg-warning text-danger"
                                    style="width:50px;height:50px">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-message-circle">
                                        <path
                                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                                    </svg>
                                </div>
                                <h5>Comments</h5>

                                {{-- <span class="text-muted">{{ $resource->comments->first()->created_at }}</span> --}}
                            </div>

                            @forelse ($resource->comments as $comment)
                                <div class="col-12">
                                    <div
                                        class="card {{ $comment->comment_type == 'approved' ? 'bg-success' : ($comment->comment_type == 'rejected' ? 'bg-danger' : 'bg-secondary') }} text-white">
                                        <div class="card-body">
                                            @if (auth()->id() === $comment->user_id)
                                                <span class="badge bg-primary fs-6">You</span>
                                            @else
                                                <span>{{ $comment->user_id }}</span>
                                            @endif
                                            <p class="card-text">
                                                {{ $comment->comment }}
                                            </p>
                                        </div>
                                        <div class="card-footer d-flex align-items-center">
                                            <small class="text-muted">Last updated:
                                                {{ $comment->updated_at }}</small>

                                            <div class="d-flex ms-3">
                                                <x-button :class="'btn-secondary'">Edit</x-button>

                                                <x-button :class="'btn-danger ms-2'">Delete</x-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    There are no comments in this resource.
                                </div>
                            @endforelse
                            <div class="col-12">
                                <x-form-post action="{{ route('comments.store') }}">
                                    <x-input type="hidden" :name="'resource_id'" value="{{ $resource->id }}">
                                    </x-input>
                                    <x-input type="hidden" :name="'comment_type'" value="regular"></x-input>

                                    <x-label>Your comment</x-label>
                                    <x-input-textarea :name="'comment'"></x-input-textarea>

                                    <x-button type="submit" :class="'btn-primary mt-3'">Submit</x-button>
                                </x-form-post>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="approvePendingresourceModal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to approve this
                                resource?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <x-form.approve-pendingresource-hidden></x-form.approve-pendingresource-hidden>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                            <button type="button" class="btn btn-success submit">Yes. Approve this resource</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="rejectPendingresourceModal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to reject this
                                resource?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <x-form.reject-pendingresource-hidden></x-form.reject-pendingresource-hidden>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                            <button type="button" class="btn btn-danger submit">Yes. Reject this resource</button>
                        </div>
                    </div>
                </div>
            </div>

            @section('script')
                <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.4/jquery.simplePagination.min.js"
                                integrity="sha512-J4OD+6Nca5l8HwpKlxiZZ5iF79e9sgRGSf0GxLsL1W55HHdg48AEiKCXqvQCNtA1NOMOVrw15DXnVuPpBm2mPg=="
                                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script>
                    $(function() {
                        $(selector).pagination({
                            items: 100,
                            itemsOnPage: 10,
                            cssStyle: 'light-theme'
                        });
                    });

                    $('#rejectPendingresourceModal').on('shown.bs.modal', function(event) {
                        let triggerButton = $(event.relatedTarget)
                        let form = $(triggerButton.attr('data-form-target'))
                        let formRoute = form.attr('action')
                        let passoverData = $(triggerButton).attr('data-passover')
                        let input = form.find('input[name="resource_id"]')
                        input.val(passoverData)
                        form.attr('action', `${formRoute}/${passoverData}`)

                        $(this).find('button.submit').click(function() {
                            form.submit()
                        })

                        $('#rejectPendingresourceModal').on('hidden.bs.modal', function() {
                            triggerButton.removeClass(['loading', 'disabled'])

                            resetFormAction()
                        })

                        let resetFormAction = () => form.attr('action', `${formRoute}`)
                    })

                    $('#approvePendingresourceModal').on('shown.bs.modal', function(event) {
                        let triggerButton = $(event.relatedTarget)
                        let form = $(triggerButton.attr('data-form-target'))
                        let formRoute = form.attr('action')
                        let passoverData = $(triggerButton).attr('data-passover')
                        let input = form.find('input[name="resource_id"]')
                        input.val(passoverData)
                        form.attr('action', `${formRoute}/${passoverData}`)

                        $(this).find('button.submit').click(function() {
                            form.submit()
                        })

                        $('#approvePendingresourceModal').on('hidden.bs.modal', function() {
                            triggerButton.removeClass(['loading', 'disabled'])

                            resetFormAction()
                        })

                        let resetFormAction = () => form.attr('action', `${formRoute}`)
                    })

                    $('.storeSavedresourceHiddenSubmit').click(function() {
                        let form = $($(this).attr('data-form-target'))
                        let passoverData = $(this).attr('data-passover')
                        let input = form.find('input[name="resource_id"]')
                        input.val(passoverData)

                        form.submit()
                    })

                    $('#download-bulk').click(function(e) {
                        e.preventDefault()
                        let downloadBtn = $(this)
                        let table = $(this.closest('table'))
                        let checkboxes = table.find('th:first-child .check, td:first-child .check')
                        $(checkboxes).each(function() {
                            if ($(this).is(":checked")) {
                                $(this).closest('th, td').find(':hidden').removeAttr('disabled')
                            } else {
                                $(this).closest('th, td').find(':hidden').attr('disabled', 'disabled')
                            }
                        })

                        table.closest('form').submit();
                        checkboxes.prop('checked', false);
                        downloadBtn.removeClass('loading')
                    })

                    $('#check-all').change(function(e) {
                        let table = $(this.closest('table'))
                        let checkboxes = table.find('td:first-child .check')

                        if ($(this).is(':checked')) {
                            checkboxes.prop('checked', true)
                        } else {
                            checkboxes.prop('checked', false)
                        }
                    })

                    $('.check').change(function(e) {
                        let table = $(this.closest('table'))
                        let downloadBtn = table.find('#download-bulk')
                        let checkboxes = table.find('td:first-child .check')
                        let currentCheckbox = $(this)

                        if (checkboxes.filter(':checked').length > 0) {
                            downloadBtn.removeClass('disabled')
                            console.log('yes')
                        } else {
                            downloadBtn.addClass('disabled')
                        }
                    })
                </script>
            @endsection
</x-app-layout>
