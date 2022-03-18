<x-app-layout>
    <x-slot name="header">
        Presentation Validation
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
        <li class="breadcrumb-item"><a href="{{ route('resource.create', $lesson->course->id) }}">New
                resource</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Presentation Validation</li>
    </x-slot>

    <div class="row">
        <div class="col-lg-3">
            <div class="p-3 bg-white rounded shadow-sm">
                <h6 class="pb-2 border-bottom">Some actions</h6>

                <div class="gap-2 d-lg-grid">
                    {{-- <button class="btn btn-secondary">Fullscreen</button>
                    <button class="btn btn-primary">Download Original</button>
                    <button class="btn btn-danger">Download as PDF</button> --}}
                </div>
            </div>
        </div>

        <div class="col">
            <x-real.card>
                <x-slot name="header">Presentation Checking Result</x-slot>

                <x-slot name="body">
                    <header class="pb-2 overflow-hidden mt-4 mb-3">
                        <h4 class="text-truncate d-block my-0">Reference Label Checking
                        </h4>
                    </header>

                    <p class="col-lg-7">The following result is validated by matching the scanned texts from your
                        presentation to any of these parameters (reference, references, list of reference, list of
                        references, bibliography)</p>

                    @if ($result['hasReferenceWord'] === false)
                        <div class="alert alert-danger mb-0">
                            <b>Failed!</b> No word or label was detected that indicates reference.
                        </div>
                    @else
                        <div class="alert alert-primary mb-0">
                            <b>Successful!</b> We detected a word or label that indicates reference.
                        </div>
                    @endif

                    <header class="pb-2 overflow-hidden mt-5 mb-3">
                        <h4 class="text-truncate d-block my-0">Citation or URL Checking
                        </h4>
                    </header>

                    <p class="col-lg-7">The following are the paragraphs/texts that we detected in the last slide
                        of your presentation:</p>

                    <ul class="list-group">
                        @foreach ($result['all'] as $text)
                            @if ($loop->index < 10)
                                <li class="list-group-item py-0">
                                    <div class="hstack gap-3">
                                        @foreach ($result['urls'] as $url)
                                            @if ($text == $url)
                                                <b class="text-success">
                                                    <span class="material-icons align-middle">
                                                        task_alt
                                                    </span>
                                                </b>
                                                <div class="vr"></div>
                                                <span class="text-success py-2">{{ $text }}</span>
                                            @else
                                                <b class="text-muted">
                                                    <span class="material-icons align-middle">
                                                        error
                                                    </span>
                                                </b>
                                                <div class="vr"></div>
                                                <span class="text-muted py-2">{{ $text }}</span>
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

                    <div class="mt-5">
                        <div class="hstack gap-3">
                            <a href="javascript:void(0)" id="syllabus-cancel-submission"
                                class="btn btn-secondary mb-3">Submit Again</a>

                            <a id="syllabus-submit-submission" disabled class="btn btn-primary mb-3">
                                <span class="material-icons align-middle md-18">
                                    upload_file
                                </span>
                                Confirm Submission
                            </a>
                        </div>
                    </div>
                </x-slot>
            </x-real.card>
        </div>
    </div>

    <div class="modal modal-sheet bg-secondary py-5" tabindex="-1" role="dialog" id="createLessonsModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-6 shadow py-5 px-5">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Confirm Lesson Creation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <form action="{{ route('lesson.store') }}" method="POST" class="row g-3">
                        @method('POST')
                        @csrf
                        {{-- <input type="hidden" name="course_id" value="{{ $course->id }}"> --}}


                        <div class="alert alert-primary mb-0">
                            <b>Do you want to include all of these lessons?</b>
                        </div>

                        <div class="col-12">
                            <ul class="" id="lessonConfirmList">
                            </ul>
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

            })
        </script>
    @endsection
</x-app-layout>
