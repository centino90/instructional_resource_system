<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Saved resources</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Saved resources') }}
            </small>

            <div class="ms-auto">
                <a href="{{ route('resources.create') }}" class="btn btn-success">
                    {{ __('Create resource') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="my-4">
        @if (session()->get('status') == 'success')
            <x-alert-success class="mb-3">
                <strong>Success!</strong> {{ session()->get('message') }}
            </x-alert-success>

        @elseif(session()->get('status') == 'success-update-saved')
            <x-alert-success class="mb-3">
                <strong>Success!</strong> {{ session()->get('message') }}
            </x-alert-success>

        @elseif(session()->get('status') == 'success-destroy-saved')
            <x-alert-success class="mb-3">
                <strong>Success!</strong> {{ session()->get('message') }}

                <x-form-post action="{{ route('saved-resources.store') }}" class="px-3">
                    <input type="hidden" name="resource_id" value="{{ session()->get('resource_id') }}">

                    <small>You can still save back this resource</small>
                    <x-button type="submit" class="btn btn-link">
                        <strong>Save this resource?</strong>
                    </x-button>
                </x-form-post>
            </x-alert-success>

        @elseif(session()->get('status') == 'success-destroy-resource')
            <x-alert-success class="mb-3">
                <strong>Success!</strong> {{ session()->get('message') }}

                <x-form-post action="{{ route('deleted-resources.update', session()->get('resource_id')) }}"
                    class="px-3">
                    @csrf
                    @method('PUT')

                    <small>You can still restore back this deleted resource</small>
                    <x-button type="submit" class="btn btn-link">
                        <strong>Restore this resource?</strong>
                    </x-button>
                </x-form-post>
            </x-alert-success>
        @endif

        <x-alert-warning>
            You still have not created a single resource this semester!
            <a href="#"><strong class="px-2">Create now?</strong></a>
        </x-alert-warning>
    </div>

    <div class="row">
        <div class="col-12">
            <x-card-body>
                <x-table-resource id="resources-table">
                    @foreach ($resources as $resource)
                        <tr>
                            @include('layouts.includes.resource-table.td-checks')

                            @include('layouts.includes.resource-table.td-file')

                            @include('layouts.includes.resource-table.td-course')

                            @include('layouts.includes.resource-table.td-lastupdate')

                            @include('layouts.includes.resource-table.td-actions.saved-resource')
                        </tr>
                    @endforeach
                </x-table-resource>
            </x-card-body>
        </div>
    </div>

    {{-- HIDDEN FORMS --}}
    <x-form.update-importantresource-hidden></x-form.update-importantresource-hidden>
    <x-form.destroy-savedresource-hidden></x-form.destroy-savedresource-hidden>
    <x-form.destroy-resource-hidden></x-form.destroy-resource-hidden>

    @section('script')
        <script>
            $('.destroyResourceHiddenSubmit').click(function() {
                let form = $($(this).attr('data-form-target'))
                let formRoute = form.attr('action')
                let passoverData = $(this).attr('data-passover')
                let input = form.find('input[name="resource_id"]')

                input.val(passoverData)
                form.attr('action', `${formRoute}/${passoverData}`)

                form.submit()
            })

            $('.destroySavedresourceHiddenSubmit').click(function() {
                let form = $($(this).attr('data-form-target'))
                let formRoute = form.attr('action')
                let passoverData = $(this).attr('data-passover')
                let input = form.find('input[name="resource_id"]')

                input.val(passoverData)
                form.attr('action', `${formRoute}/${passoverData}`)

                form.submit()
            })

            $('.updateImportantresourceHiddenSubmit').click(function() {
                console.log('yes')
                let form = $($(this).attr('data-form-target'))
                let formRoute = form.attr('action')
                let passoverData = $(this).attr('data-passover')
                let input = form.find('input[name="resource_id"]')

                input.val(passoverData)
                form.attr('action', `${formRoute}/${passoverData}`)

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
