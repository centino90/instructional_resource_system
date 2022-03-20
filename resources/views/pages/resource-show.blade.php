<x-app-layout>
    <x-slot name="header">
        {{$resource->title}}
    </x-slot>

    <x-slot name="headerTitle">
        Resource title
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('course.show', $resource->course->id) }}"><- Go back</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('course.index') }}">Courses</a></li>
        <li class="breadcrumb-item"><a href="{{ route('course.show', $resource->course->id) }}">{{$resource->course->code}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$resource->title}}</li>
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

    <div>
        <ul class="d-none nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    type="button" role="tab" aria-controls="pills-home" aria-selected="true">Home</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                    aria-selected="false">Profile</button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row">
                    <div class="col-12 col-md-7">
                        <ul class="list-group shadow-sm">
                            <li class="list-group-item hstack gap-3">
                                <div class="flex-1 hstack gap-3">
                                    <div class="overflow-hidden">
                                        <h5 class="text-truncate d-block my-0">
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
                                        </h5>
                                        <small class="text-muted">Status</small>
                                    </div>

                                    <div class="overflow-hidden">
                                        <h5 class="text-truncate d-block my-0">
                                            @if ($resource->is_syllabus)
                                                <span class="badge rounded-pill bg-primary">Syllabus</span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary">Regular</span>
                                            @endif
                                        </h5>

                                        <small class="text-muted">Resource type</small>
                                    </div>
                                </div>

                                <span class="vr"></span>

                                <div>
                                    <div class="btn-group dropend">
                                        <button class="btn btn-light rounded" data-bs-toggle="dropdown"
                                            data-bs-auto-close="outside" aria-expanded="false">
                                            <img src="{{ asset('images/icons/image-search.svg') }}" title="view more"
                                                alt="view more">
                                        </button>
                                        <ul class="dropdown-menu shadow border-0 p-0">
                                            <li class="dropdown-item p-0">
                                                <ul class="list-group" style="min-width: 300px">
                                                    <li class="list-group-item">
                                                        {{-- onclick="bootstrap.Tab.getOrCreateInstance($('#pills-profile-tab')[0]).show()" --}}
                                                        <a href="{{route('resource.preview', $resource->id)}}"
                                                            class="w-100 btn btn-light border text-primary fw-bold">
                                                            Preview
                                                        </a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <a href="{{ route('resources.downloadOriginal', $resource->id) }}"
                                                            class="w-100 btn btn-light border text-primary fw-bold">Download</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            {{-- resource title --}}
                            <li class="list-group-item hstack gap-3">
                                <div class="flex-1 overflow-hidden">
                                    <h5 class="text-truncate d-block my-0 fw-bold">
                                        {{$resource->user ? $resource->user->fname . ' ' . $resource->user->lname : ''}}
                                    </h5>
                                    <small class="text-muted">Submitted by</small>
                                </div>

                                <span class="vr"></span>

                                <div class="flex-1 overflow-hidden">
                                    <h5 class="text-truncate d-block my-0 fw-bold">
                                        {{ $resource->getFirstMedia()->file_name }}
                                    </h5>
                                    <small class="text-muted">Media file</small>
                                </div>

                                <span class="vr"></span>

                                <div>
                                    <div class="btn-group dropend">
                                        <button class="btn btn-light rounded" data-bs-toggle="dropdown"
                                            data-bs-auto-close="outside" aria-expanded="false">
                                            <img src="{{ asset('images/icons/publish-changes.svg') }}"
                                                title="publish changes" alt="publish changes"">
                                        </button>
                                        <ul class=" dropdown-menu shadow border-0 p-0">
                            <li class="dropdown-item p-0">
                                <ul class="list-group" style="min-width: 300px">
                                    <li class="list-group-item">
                                        <button class="w-100 btn btn-light border text-primary fw-bold">
                                            Save to Draft
                                        </button>
                                    </li>
                                    <li class="list-group-item">
                                        <button class="w-100 btn btn-light border text-primary fw-bold">
                                            Cancel Submission
                                        </button>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                </li>

                {{-- submitted by --}}
                <li class="list-group-item hstack gap-3">
                    <div class="flex-1 overflow-hidden">
                        <h6 class="text-truncate d-block my-0 ">
                            {{ $resource->lesson ? $resource->title : '' }}
                        </h6>
                        <small class="text-muted">Lesson</small>
                    </div>
                    <span class="vr"></span>
                    <div class="flex-1 overflow-hidden">
                        <h6 class="text-truncate d-block my-0 ">
                            {{ $resource->course->code }} - {{ $resource->course->title }}
                        </h6>
                        <small class="text-muted">Submitted on</small>
                    </div>
                    <span class="vr"></span>
                    <div class="flex-1 overflow-hidden">
                        <h6 class="text-truncate d-block my-0 ">
                            {{ $resource->getMedia()->first()->created_at }}
                        </h6>
                        <small class="text-muted">Submitted at</small>
                    </div>
                    <span class="vr"></span>
                    <div>
                        <div class="btn-group dropend">
                            <button class="btn btn-light rounded" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                aria-expanded="false">
                                <img src="{{ asset('images/icons/archive.svg') }}" title="all versions"
                                    alt="all versions">
                            </button>
                            <ul class="dropdown-menu shadow border-0 p-0">
                                <li class="dropdown-item p-0">
                                    <ul class="list-group" style="min-width: 300px">
                                        <li class="list-group-item">
                                            <a href="{{route('resource.createNewVersion', $resource->id)}}" class="w-100 btn btn-light border text-primary fw-bold">
                                                Submit new version
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{route('resource.viewVersions', $resource->id)}}" class="w-100 btn btn-light border text-primary fw-bold">
                                                View all versions
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                {{-- Last updated at --}}
                <li class="list-group-item hstack gap-3">
                    <div class="flex-2 overflow-hidden">
                        <h6 class="text-truncate d-block my-0 ">
                            {{ $resource->updated_at }}
                        </h6>
                        <small class="text-muted">Last updated at</small>
                    </div>
                    @if (auth()->user()->isProgramDean())
                        <span class="vr"></span>
                        <div class="flex-1 overflow-hidden">
                            <small class="d-block pb-1 fw-bold">Confirm Admission</small>
                            <div class="d-flex gap-2">
                                <x-submit.approve-pendingresource-hidden :passover="$resource->id"
                                    :isApproved="$resource->approved_at ? true : false">
                                </x-submit.approve-pendingresource-hidden>

                                <x-submit.reject-pendingresource-hidden :passover="$resource->id"
                                    :isRejected="$resource->rejected_at ? true : false">
                                </x-submit.reject-pendingresource-hidden>
                            </div>
                        </div>
                    @endif
                </li>
                </ul>
            </div>

            <div class="col-12 col-md-5">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                More resource information
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul class="list-group">
                                    <li class="list-group-item hstack gap-3">
                                        <div class="overflow-hidden">
                                            <p class="m-0">
                                                {{ $resource->description ?? 'This resource has no description' }}</p>
                                            <small class="text-muted">Resource description</small>
                                        </div>
                                    </li>
                                    <li class="list-group-item hstack gap-3">
                                        <div class="overflow-hidden">
                                            <h6 class="text-truncate d-block my-0 ">
                                                {{ $resource->updated_at }}
                                            </h6>
                                            <small class="text-muted">Downloads</small>
                                        </div>
                                        <span class="vr"></span>
                                        <div class="overflow-hidden">
                                            <h6 class="text-truncate d-block my-0 ">
                                                {{ $resource->updated_at }}
                                            </h6>
                                            <small class="text-muted">Views</small>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                More media information
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul class="list-group">
                                    <li class="list-group-item hstack gap-3">
                                        <div class="overflow-hidden">
                                            <h6 class="text-truncate d-block my-0 ">
                                                {{ $resource->updated_at }}
                                            </h6>
                                            <small class="text-muted">File size</small>
                                        </div>
                                        <span class="vr"></span>
                                        <div class="overflow-hidden">
                                            <h6 class="text-truncate d-block my-0 ">
                                                {{ $resource->updated_at }}
                                            </h6>
                                            <small class="text-muted">File type</small>
                                        </div>
                                    </li>
                                    <li class="list-group-item hstack gap-3">
                                        <div class="overflow-hidden">
                                            <h6 class="text-truncate d-block my-0 ">
                                                {{ $resource->updated_at }}
                                            </h6>
                                            <small class="text-muted">File path</small>
                                        </div>
                                        <span class="vr"></span>
                                        <div class="overflow-hidden">
                                            <h6 class="text-truncate d-block my-0 ">
                                                {{ $resource->updated_at }}
                                            </h6>
                                            <small class="text-muted">File URL</small>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="mb-3">
            <div class="row">
                <div class="col-12">
                    <a href="#" onclick="bootstrap.Tab.getOrCreateInstance($('#pills-home-tab')[0]).show()"
                        class="btn fw-bold text-black">
                        <img src="{{ asset('images/icons/keyboard-return.svg') }}" alt="return tab">
                        Return
                    </a>

                    <ul class="list-group shadow-sm overflow-auto mt-3">
                        <li class="list-group-item hstack gap-3">
                            <div class="flex-1 hstack gap-3">
                                <div>
                                    <a href="{{ route('resources.downloadOriginal', $resource->id) }}"
                                        class="btn btn-primary">Download</a>
                                </div>
                            </div>

                            <span class="vr"></span>

                            <div>
                                <button class="btn btn-secondary">Fullscreen</button>
                            </div>
                        </li>

                        <li class="list-group-item hstack gap-3 justify-content-center" style="height: 500px">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <div class="mt-5">
        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                    role="tab" aria-controls="home" aria-selected="true">Comments</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                    type="button" role="tab" aria-controls="profile" aria-selected="false">History Logs</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row g-3">
                    @comments([
                    'model' => $resource,
                    'maxIndentationLevel' => 1,
                    'perPage' => 5
                    ])
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row g-3">
                    <div class="col-12">
                        @forelse ($resource->activities->sortByDesc('created_at') as $activity)
                            <div class="vstack pb-2">
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->created_at)->diffForHumans() }}</small>

                                <span><b>
                                    @empty($activity->causer)
                                        Unknown User
                                    @else
                                        {{ $activity->causer->fname . ' ' . $activity->causer->lname }}
                                        <small class="text-lowercase">({{ $activity->causer->role->name }})</small>
                                    @endempty
                                </b></span>
                            <p class="my-0">{{ $activity->description }}</p>
                            <ul class="my-0">
                                @foreach ($activity->subject->getMedia() as $media)
                                    <li>
                                        {{ $media->file_name ?? 'unknown file' }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="approvePendingresourceModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to approve this
                    resource?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

<div class="modal" id="rejectPendingresourceModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to reject this
                    resource?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        $(document).ready(function() {
            $('.comment-textarea').summernote({
                height: 200,
                width: '100%'
            })


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
                    spinnerGenerator(triggerButton, null, true)

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
        })
    </script>
@endsection
</x-app-layout>
