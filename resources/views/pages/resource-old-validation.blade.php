<x-app-layout>
    <x-slot name="header">
        Import Validation
    </x-slot>

    <x-slot name="headerTitle">

    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a class="fw-bold"
                href="{{ route('resource.create', $lesson->course->id) }}">
                <- Go back</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('course.show', $lesson->course->id) }}">{{ $lesson->course->code }}</a>
        </li>

        <li class="breadcrumb-item">{{ $lesson->title }}</li>
        <li class="breadcrumb-item"><a href="{{ route('resource.createOld', $lesson->course->id) }}">Import Old
                Resource</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Import Validation</li>
    </x-slot>

    <div class="row">
        <div class="col-lg-3">
            <div class="row g-3">
                <div class="col-12">
                    <x-real.card>
                        <x-slot name="header">
                            Some actions
                        </x-slot>
                        <x-slot name="body">
                            <div class="gap-2 d-lg-grid">
                                <a id="confirmOldPdfModalBtn" data-bs-toggle="modal"
                                    data-bs-target="#confirmOldPdfModal" class="btn btn-primary">
                                    <span class="material-icons align-middle md-18">
                                        upload_file
                                    </span>
                                    Confirm Submission
                                </a>
                            </div>
                        </x-slot>
                    </x-real.card>
                </div>

                <div class="col-12">
                    <x-real.card :variant="'secondary'">
                        <x-slot name="header">
                            Summary
                        </x-slot>
                        <x-slot name="body">
                            <ul class="list-group">
                                <li class="list-group-item p-0">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item px-0 border-0">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                    aria-controls="collapseOne">

                                                    <div class="vstack">
                                                        <h6 class="validationStatusSummary">{{ $resources->count() }}
                                                            success, 0 failed</h6>
                                                        <small class="text-muted">Validation status</small>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body p-0">
                                                    <ul class="list-group nav nav-pills persist-default"
                                                        id="oldPdfValidationPillsTab">
                                                        @foreach ($resources as $resource)
                                                            <li class="nav-item list-group-item list-group-item-action p-0 border-0 {{ $loop->last ? '' : 'border-bottom' }}"
                                                                role="presentation">
                                                                <a href="#"
                                                                    class="hstack gap-3 py-0 border-0 nav-link rounded-0 {{ $loop->first ? 'active' : '' }}"
                                                                    id="oldPdfValidationTab-{{ $resource->id }}"
                                                                    data-bs-toggle="pill"
                                                                    data-bs-target="#oldPdfValidationTabpane-{{ $resource->id }}"
                                                                    type="button" role="tab">
                                                                    <div class="py-2">
                                                                        <h6 class="my-0">
                                                                            {{ $resource->currentMediaVersion->file_name }}
                                                                        </h6>
                                                                    </div>
                                                                    <div class="vr"></div>
                                                                    <div class="validationStatusLabel">
                                                                        @if ($resource->html)
                                                                            <span
                                                                                class="badge bg-success text-white">Success</span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-danger text-white">Failed</span>
                                                                        @endif
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <h6 class="my-0">Pending</h6>
                                    <small class="text-muted">Submission status</small>
                                </li>
                            </ul>
                        </x-slot>
                    </x-real.card>
                </div>
            </div>
        </div>

        <div class="oldPdfValidationTabContent tab-content col-lg-9">
            @foreach ($resources as $resource)
                <div class="parentTabpane tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                    id="oldPdfValidationTabpane-{{ $resource->id }}" role="tabpanel">
                    <x-real.card class="overflow-auto">
                        <x-slot name="header">{{ $resource->currentMediaVersion->file_name }}</x-slot>

                        <x-slot name="body">
                            <div class="previewContainer mt-4">
                                {!! $resource->html !!}
                            </div>
                        </x-slot>
                    </x-real.card>
                </div>
            @endforeach
        </div>

        <div class="modal modal-sheet bg-secondary py-5" tabindex="-1" role="dialog" id="confirmOldPdfModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-6 shadow py-5 px-5">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title">Confirm Old Resource Import</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        <form id="confirmOldPdfForm" method="POST" action="{{route('resource.confirm')}}" class="row g-3">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $lesson->course->id }}">
                            <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

                            @foreach ($resources as $resource)
                                <input type="hidden" name="resources[]" value="{{ $resource->id }}" />
                            @endforeach

                            <div class="col-12">
                                <div class="alert alert-primary mb-0">
                                    <b>Do you want to continue importing these resource(s)?</b>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid gap-2 w-100">
                                    <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                                        submission</button>
                                    <button type="button" class="btn btn-lg btn-light mx-0 rounded-4"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @section('script')
            <script>
                $(document).ready(function() {
                    const courseId = '{{ $lesson->course->id }}'
                    const lessonId = '{{ $lesson->id }}'
                    const relayedFormData = $.parseJSON(`{!! json_encode($formData) !!}`);
                    const submitType = relayedFormData.type;
                })
            </script>
        @endsection
</x-app-layout>
