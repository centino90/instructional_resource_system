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
                            <h5 class="card-title">{{ $resource->users->first()->name }}</h5>
                            <p class="card-text">
                                <span class="d-block">{{ $resource->getMedia()->first()->file_name }}</span>

                                <span class="me-3">
                                    @if ($resource->is_syllabus)
                                        <span class="badge rounded-pill bg-primary">Syllabus</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">Regular</span>
                                    @endif
                                </span>

                                <small class="text-muted me-3">
                                    {{ $resource->course->code }} - {{ $resource->course->title }}
                                </small>

                                <small class="text-muted">Submitted at: {{ $resource->created_at }}</small>
                            </p>

                            <div class="border-top pt-3">
                                <a href="#" class="btn btn-primary">Download</a>
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
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional
                                content.
                            </p>
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
                <div id="timeline">
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

                            <span class="text-muted">2021/2/25</span>
                        </div>

                        <div class="col-12">
                            <div class="card bg-primary text-white">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a
                                        natural lead-in to additional content. This content is a little bit longer.</p>
                                </div>
                                <div class="card-footer d-flex align-items-center">
                                    <small class="text-muted">Last updated 3 mins ago</small>

                                    <div class="d-flex ms-3">
                                        <x-button :class="'btn-secondary'">Edit</x-button>

                                        <x-button :class="'btn-danger ms-2'">Delete</x-button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card bg-secondary text-white">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a
                                        natural lead-in to additional content. This content is a little bit longer.</p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Last updated 3 mins ago</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card bg-secondary text-white">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a
                                        natural lead-in to additional content. This content is a little bit longer.</p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Last updated 3 mins ago</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card bg-secondary text-white">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a
                                        natural lead-in to additional content. This content is a little bit longer.</p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Last updated 3 mins ago</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div>
                            <div class="rounded-circle d-flex justify-content-center align-items-center bg-secondary text-white"
                                style="width:50px;height:50px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-message-circle">
                                    <path
                                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                                </svg>
                            </div>
                            <span class="text-muted">2021/2/26</span>
                        </div>

                        <div class="col-12">
                            <div class="card bg-primary text-white">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a
                                        natural lead-in to additional content. This content is a little bit longer.</p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Last updated 3 mins ago</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card bg-secondary text-white">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a
                                        natural lead-in to additional content. This content is a little bit longer.</p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Last updated 3 mins ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- HIDDEN FORMS --}}
                <x-form.store-savedresource-hidden></x-form.store-savedresource-hidden>

                {{-- MODAL FORMS --}}
                <div class="modal fade" id="saveResourceModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <x-form-post action="{{ route('saved-resources.store') }}" class="px-0 col">
                                    <x-input name="resource_id" hidden>
                                    </x-input>

                                    <x-button class="btn-secondary form-control" type="submit">Save
                                    </x-button>
                                </x-form-post>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                <button type="button" class="btn btn-primary">Proceed</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-12 mb-3">
            <h5>History log</h5>

            @foreach ($activities as $activity)
                <span>
                    @if ($resource->user_id != auth()->id())
                        <strong>
                            {{ isset($activity->causer->name) ? ucwords($activity->causer->name) : 'Unknown user' }}
                        </strong>
                    @else
                        <strong>
                            You
                        </strong>
                    @endif

                    {{ $activity->description }}
                    {{ $activity->subject->getMedia()[0]->file_name ?? 'not available' }}
                    <small
                        class="badge rounded-pill bg-success mx-1">{{ $activity->changes['attributes']['batch_id'] == $activities[0]->changes['attributes']['batch_id'] ? 'latest' : '' }}</small>

                </span>

                <div class="lh-1 mb-1">
                    <small
                        class="text-muted">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->created_at)->diffForHumans() }}</small>
                </div>
            @endforeach
            <div class="my-2">
                <small class="text-muted">
                    <a href="#">Click to view more</a>
                </small>
            </div>
        </div> --}}
            </div>

            @section('script')
                <script>
                    // var saveResourceModal = document.getElementById('saveResourceModal')
                    // saveResourceModal.addEventListener('show.bs.modal', function(event) {
                    //     // Button that triggered the modal
                    //     var button = event.relatedTarget
                    //     // Extract info from data-bs-* attributes
                    //     var recipient = button.getAttribute('data-bs-resource')
                    //     // If necessary, you could initiate an AJAX request here
                    //     // and then do the updating in a callback.
                    //     //
                    //     // Update the modal's content.
                    //     // var modalTitle = saveResourceModal.querySelector('.modal-title')
                    //     // var modalBodyInput = saveResourceModal.querySelector('.modal-bod input')
                    //     let input = $(saveResourceModal).find('input[name="resource_id"]');
                    //     input.val(recipient)

                    //     // modalTitle.textContent = 'New message to ' + recipient
                    //     // modalBodyInput.value = recipient
                    // })

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
