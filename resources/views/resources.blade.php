<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Resources</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Resources') }}
            </small>

            <div class="ms-auto">
                <a href="{{ route('resources.create') }}" class="btn btn-success">
                    {{ __('Create resource') }}
                </a>
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

        <x-alert-warning>
            You still have not created a single resource this semester!
            <a href="#"><strong class="px-2">Create now?</strong></a>
        </x-alert-warning>
    </div>

    <div class="row">
        <div class="col-12 mb-3">
            <x-table-resource id="resources-table">
                @foreach ($resources as $resource)
                    <tr>
                        @include('layouts.includes.resource-table.td-checks')

                        @include('layouts.includes.resource-table.td-file')

                        @include('layouts.includes.resource-table.td-course')

                        @include('layouts.includes.resource-table.td-lastupdate')

                        @include('layouts.includes.resource-table.td-actions.resource')
                    </tr>
                @endforeach
            </x-table-resource>
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
