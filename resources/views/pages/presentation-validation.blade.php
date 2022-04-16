<x-app-layout>
    <x-slot name="header">
        Presentation Validation
    </x-slot>

    <x-slot name="headerTitle">

    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('resource.create', $lesson) }}">
                <- Go back</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('course.show', $lesson->course->id) }}">{{ $lesson->course->code }}</a>
        </li>

        <li class="breadcrumb-item">{{ $lesson->title }}</li>
        <li class="breadcrumb-item"><a href="{{ route('resource.create', $lesson) }}">New
                resource</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Presentation Validation</li>
    </x-slot>

    <div class="row">
        <div class="col-lg-3">
            <div class="row g-3">
                <div class="col-12">
                    <x-real.card :variant="'secondary'">
                        <x-slot name="header">
                            Some actions
                        </x-slot>
                        <x-slot name="body">
                            <div class="gap-3 d-lg-grid">
                                @if ($resources->where('hasReferenceWord', true)->count() > 0)
                                    <a id="createLessonsModalBtn" data-bs-toggle="modal"
                                        data-bs-target="#createLessonsModal" class="btn btn-primary">
                                        <span class="material-icons align-middle md-18">
                                            upload_file
                                        </span>
                                        Confirm Submission
                                    </a>
                                @endif
                                <a href="{{ route('resource.create', $lesson) }}" id="submitAgainBtn"
                                    class="btn btn-secondary">
                                    Submit Again
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
                                                        <h6 class="validationStatusSummary">
                                                            {{ $resources->where('hasReferenceWord', true)->count() }}
                                                            success,
                                                            {{ $resources->where('hasReferenceWord', false)->count() }}
                                                            failed</h6>
                                                        <small class="text-muted">Validation status</small>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body p-0">
                                                    <ul class="list-group nav nav-pills persist-default"
                                                        id="presentationValidationPillsTab">
                                                        @foreach ($resources as $resource)
                                                            <li class="nav-item list-group-item list-group-item-action p-0 border-0 border-bottom"
                                                                role="presentation">
                                                                <a href="#"
                                                                    class="overflow-hidden hstack gap-3 py-0 border-0 nav-link rounded-0 {{ $loop->first ? 'active' : '' }}"
                                                                    id="presentationValidationTab-{{ $resource->id }}"
                                                                    data-bs-toggle="pill"
                                                                    data-bs-target="#tabpanePresentationValidationCard{{ $resource->id }}"
                                                                    type="button" role="tab">
                                                                    <div class="py-2 col-8">
                                                                        <h6 class="my-0">
                                                                            {{ $resource->currentMediaVersion->file_name }}
                                                                        </h6>
                                                                    </div>
                                                                    <div class="vr"></div>
                                                                    <div class="validationStatusLabel col-4">
                                                                        @if ($resource->hasReferenceWord)
                                                                            <span
                                                                                class="badge text-white bg-success">Success</span>
                                                                        @else
                                                                            <span
                                                                                class="badge text-white bg-danger">Failed</span>
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

        <div class="col">
            <x-real.tabcontent id="PresentationValidationCard{{ $resource->id }}">
                @foreach ($resources as $resource)
                    <x-real.tabpane :id="'PresentationValidationCard' . $resource->id" :active="$loop->first">
                        <x-real.tablist :direction="'horizontal'" :id="'PresentationValidation' . $resource->id" class="persist-default mb-4">
                            <x-real.tab :active="true" :id="'Validation' . $resource->id" :targetId="'Validation' . $resource->id">
                                Validation
                            </x-real.tab>
                            <x-real.tab :id="'FileContent' . $resource->id" :targetId="'FileContent' . $resource->id">
                                File content
                            </x-real.tab>
                        </x-real.tablist>

                        <x-real.tabcontent id="PresentationValidation{{ $resource->id }}">
                            <x-real.tabpane :id="'Validation' . $resource->id" :active="true">
                                <div class="parentTabpane tab-pane fade show active"
                                    id="presentationValidationTabpane{{ $resource->id }}" role="tabpanel">
                                    <x-real.card class="overflow-auto">
                                        <x-slot name="header">Presentation Checking Result</x-slot>

                                        <x-slot name="body">
                                            <header class="pb-2 overflow-hidden mt-4 mb-3">
                                                <h4 class="text-truncate d-block my-0">Reference Label Checking
                                                </h4>
                                            </header>

                                            <p class="col-lg-7">The following result is validated by matching the
                                                scanned
                                                texts from your
                                                presentation to any of these parameters (reference, references, list of
                                                reference, list of
                                                references, bibliography)</p>

                                            @if ($resource->hasReferenceWord === false)
                                                <div class="alert alert-danger mb-0">
                                                    <b>Failed!</b> No word or label was detected that indicates
                                                    reference.
                                                </div>
                                            @else
                                                <div class="alert alert-primary mb-0">
                                                    <b>Successful!</b> We detected a word or label that indicates
                                                    reference.
                                                </div>
                                            @endif

                                            <header class="pb-2 overflow-hidden mt-5 mb-3">
                                                <h4 class="text-truncate d-block my-0">Citation or URL Checking
                                                </h4>
                                            </header>

                                            <p class="col-lg-7">The following are the paragraphs/texts that we
                                                detected in
                                                the last slide
                                                of your presentation:</p>

                                            <ul class="list-group">
                                                @foreach ($resource->texts as $text)
                                                    @if ($loop->index < 10)
                                                        <li class="list-group-item py-0">
                                                            <div class="hstack gap-3">
                                                                @foreach ($resource->urls as $url)
                                                                    @if ($text == $url)
                                                                        <b class="text-success">
                                                                            <span class="material-icons align-middle">
                                                                                task_alt
                                                                            </span>
                                                                        </b>
                                                                        <div class="vr"></div>
                                                                        <span
                                                                            class="text-success py-2">{{ $text }}</span>
                                                                    @else
                                                                        <b class="text-muted">
                                                                            <span class="material-icons align-middle">
                                                                                error
                                                                            </span>
                                                                        </b>
                                                                        <div class="vr"></div>
                                                                        <span
                                                                            class="text-muted py-2">{{ $text }}</span>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </li>
                                                    @endif

                                                    @if ($loop->index == 10)
                                                        <small class="d-block text-end mt-3">
                                                            <a href="#">Show more >></a>
                                                        </small>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </x-slot>
                                    </x-real.card>
                                </div>
                            </x-real.tabpane>
                            <x-real.tabpane :id="'FileContent' . $resource->id">
                                <x-real.card>
                                    <x-slot name="header">File Content: <b
                                            class="text-muted">{{ $resource->currentMediaVersion->file_name }}</b>
                                    </x-slot>
                                    <x-slot name="body">
                                        <div class="reference">
                                            <div class="row">
                                                <div class="references col-12"
                                                    id="presentationPDF{{ $resource->id }}">
                                                    <iframe src="{!! $resource->pdf !!}" class="w-100"
                                                        height="600"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </x-slot>
                                </x-real.card>
                            </x-real.tabpane>
                        </x-real.tabcontent>
                    </x-real.tabpane>
                @endforeach
            </x-real.tabcontent>
        </div>
    </div>

    <div class="modal modal-sheet bg-secondary py-5" tabindex="-1" role="dialog" id="createLessonsModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-6 shadow py-5 px-5">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Confirm Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <form action="{{ route('presentations.confirmValidation') }}" method="POST"
                        class="row g-3">
                        @method('POST')
                        @csrf

                        <input type="hidden" name="lesson" value="{{ $lesson->id }}">
                        @foreach ($resources->where('hasReferenceWord', true) as $resource)
                            <input type="hidden" name="resources[]" value="{{ $resource->id }}">
                        @endforeach

                        @foreach ($resources->where('hasReferenceWord', false) as $resource)
                            <input type="hidden" name="failed_resources[]" value="{{ $resource->id }}">
                        @endforeach

                        <div class="alert alert-primary mb-0">
                            <b>Do you want to continue submitting these presentation?</b>
                        </div>

                        <div class="col-12">
                            <div class="d-grid gap-2 w-100">
                                <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                                </button>
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

            })
        </script>
    @endsection
</x-app-layout>
