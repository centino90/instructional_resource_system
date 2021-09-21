<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Syllabus Courses</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}"></a>create-syllabus</li>
            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}"></a>edit-syllabus</li>
            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}"></a>show-syllabus</li>
            <li class="breadcrumb-item active" aria-current="page">Show course</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex my-4">
            <small class="h4 font-weight-bold">
                {{ __('Show course') }}
            </small>

            {{-- HEADER ACTIONS SECTION --}}
            <div class="ms-auto"></div>
        </div>
    </x-slot>

    @if (session()->exists('success'))
    <div class="my-4">
        <x-alert-success>
            {{ session()->get('success') }}
        </x-alert-success>
    </div>
    @endif

    {{-- CONTENT SECTION --}}
    <div class="row">
        <div class="col-12 mb-3">
            <h5>Course information</h5>

            <x-card-body>
                <h4>{{ $course->title }} ({{ $course->code }})</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">Program: {{ $course->program->title }}</li>
                    <li class="nav-item">Year level: {{ $course->year_level }}</li>
                    <li class="nav-item">semester: {{ $course->semester }}</li>
                    <li class="nav-item">term: {{ $course->term }}</li>
                </ul>
            </x-card-body>
        </div>

        <div class="col-12 mb-3">
            <div class="d-flex align-items-center">
                <h5>Resources submitted in this course</h5>
            </div>

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

        <div class="col-12 mb-3">
            <h5>History log</h5>
            @foreach ($activities as $activity)
            <span>
                <b>{{ $activity->causer->name ?? 'unknown user' }}</b>
                {{ $activity->description }}
                {{ $activity->subject->getMedia()[0]->file_name ?? 'unknown file' }}
                <small class="badge rounded-pill bg-success mx-1">{{ $loop->index == 0 ? 'latest' : '' }}</small>
            </span>

            <div class="lh-1 mb-1">
                <small class="text-muted">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->created_at)->diffForHumans() }}</small>
            </div>
            @endforeach
        </div>

        {{-- HIDDEN FORMS --}}
        <x-form.store-savedresource-hidden></x-form.store-savedresource-hidden>
    </div>

    @section('script')
    <script>
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
            console.log(checkboxes)
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
            } else {
                downloadBtn.addClass('disabled')
            }
        })
    </script>
    @endsection
</x-app-layout>