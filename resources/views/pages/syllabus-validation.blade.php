<x-app-layout>
    <x-slot name="header">
        Syllabus Validation
    </x-slot>

    <x-slot name="headerTitle">

    </x-slot>

    <x-slot name="breadcrumb">
        @if ($resource->hasMultipleMedia)
            <li class="breadcrumb-item"><a class="fw-bold"
                    href="{{ route('resource.createNewVersion', $resource) }}">
                    <- Go back</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('course.show', $course) }}">{{ $course->code }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('resource.createNewVersion', $resource) }}">New version</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Syllabus Validation</li>
        @else
            <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('syllabi.create', $course) }}">
                    <- Go back</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('course.show', $course) }}">{{ $course->code }}</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('syllabi.create', $course) }}">Submit syllabus</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Syllabus Validation</li>
        @endif
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
                            <div class="gap-3 d-lg-grid">
                                @if ($resource->verificationStatus == 'Approved')
                                    <a class="btn btn-primary" href="{{ route('resource.show', $resource) }}">
                                        Go back to resource
                                    </a>
                                @else
                                    <a id="createLessonsModalBtn" data-bs-toggle="modal"
                                        data-bs-target="#createLessonsModal" class="disabled btn btn-primary">
                                        <span class="material-icons align-middle md-18">
                                            upload_file
                                        </span>
                                        Confirm Lessons
                                    </a>
                                    @if ($resource->hasMultipleMedia && $resource->verificationStatus == 'Pending')
                                        <a href="{{ route('resource.createNewVersion', $resource) }}"
                                            id="submitAgainBtn" class="btn btn-secondary">
                                            Submit Again
                                        </a>

                                        <x-real.form method="PUT"
                                            action="{{ route('resource.cancelSubmission', $resource) }}">
                                            <x-slot name="submit">
                                                <x-real.btn type="submit" :variant="'warning-dark'" :btype="'solid'"
                                                    class="w-100">
                                                    Cancel Current Submission
                                                </x-real.btn>
                                            </x-slot>
                                        </x-real.form>
                                    @else
                                        <a href="{{ route('syllabi.create', $course) }}" id="submitAgainBtn"
                                            class="btn btn-secondary">
                                            Submit Again
                                        </a>
                                    @endif
                                @endif
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
                                                        <h6 class="validationStatusSummary"></h6>
                                                        <small class="text-muted">Validation status</small>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body p-0">
                                                    <ul class="list-group nav nav-pills persist-default"
                                                        id="syllabusValidationPillsTab">
                                                        <li class="nav-item list-group-item list-group-item-action p-0 border-0 border-bottom"
                                                            role="presentation">
                                                            <a href="#"
                                                                class="hstack gap-3 py-0 border-0 nav-link rounded-0 active"
                                                                id="syllabusValidationTab-{{ $resource->id }}"
                                                                data-bs-toggle="pill"
                                                                data-bs-target="#syllabusValidationTabpane-{{ $resource->id }}"
                                                                type="button" role="tab">
                                                                <div class="py-2">
                                                                    <h6 class="my-0">
                                                                        {{ $resource->currentMediaVersion->file_name }}
                                                                    </h6>
                                                                </div>
                                                                <div class="vr"></div>
                                                                <div class="validationStatusLabel"></div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <h6 class="my-0">{{ $resource->verificationStatus }}</h6>
                                    <small class="text-muted">Submission status</small>
                                </li>
                                <li class="list-group-item">
                                    <h6 class="my-0">
                                        {{ $resource->title }}
                                    </h6>
                                    <small class="text-muted">Resource title</small>
                                </li>
                                @if ($resource->hasMultipleMedia)
                                    <li class="list-group-item">
                                        <h6 class="my-0">
                                            {{ $resource->activityLogs()->whereIn('log_name', ['resource-attempt-versioned', 'resource-versioned'])->latest()->first()->causer->nameTag }}
                                        </h6>
                                        @if ($resource->verification_status == 'Pending')
                                            <small class="text-muted">Submitted by</small>
                                        @else
                                            <small class="text-muted">Reassigned by</small>
                                        @endif
                                    </li>
                                @else
                                    <li class="list-group-item">
                                        <h6 class="my-0">
                                            {{ $resource->user->nameTag }}
                                        </h6>
                                        <small class="text-muted">Submitted by</small>
                                    </li>
                                @endif
                                <li class="list-group-item">
                                    <h6 class="my-0">{{ $resource->course->code }}</h6>
                                    <small class="text-muted">Course</small>
                                </li>
                                @isset($resource->lesson)
                                    <li class="list-group-item">
                                        <h6 class="my-0">{{ $resource->lesson->title }}</h6>
                                        <small class="text-muted">Lesson</small>
                                    </li>
                                @endisset
                            </ul>
                        </x-slot>
                    </x-real.card>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <x-real.tablist :direction="'horizontal'" :id="'SyllabusValidation'" class="persist-default mb-4">
                <x-real.tab :active="true" :id="'Validation'" :targetId="'Validation'">
                    Validation
                </x-real.tab>
                <x-real.tab :id="'FileContent'" :targetId="'FileContent'">
                    File content
                </x-real.tab>
            </x-real.tablist>


            <x-real.tabcontent id="SyllabusValidation">
                <x-real.tabpane :id="'Validation'" :active="true">
                    <div class="parentTabpane tab-pane fade show active" id="syllabusValidationTabpane-"
                        role="tabpanel">
                        <x-real.card class="overflow-auto">
                            <x-slot name="header">Syllabus Checking & Lesson Scanning Result</x-slot>
                            <x-slot name="action">
                                <ul class="nav nav-pills gap-3" id="pills-tab-" role="tablist">
                                    <li class="nav-item p-0" role="presentation">
                                        <a class="nav-link active text-dark rounded-0 py-0" id="pills-home-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-home-" type="button" role="tab"
                                            aria-selected="true">Verb Checking</a>
                                    </li>
                                    <li class="nav-item p-0" role="presentation">
                                        <a class="nav-link text-dark rounded-0 py-0" id="pills-profile-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-profile-" type="button"
                                            role="tab" aria-selected="false">Lesson Creation</a>
                                    </li>
                                </ul>
                            </x-slot>
                            <x-slot name="body">
                                <div class="validation parentTabContent tab-content" id="pills-tabContent-">
                                    <div class="tab-pane fade show active" id="pills-home-" role="tabpanel">
                                        <div class="previewContaine">
                                            <div class="confirm_submission">
                                                @if ($resource->verificationStatus != 'Approved')
                                                    <div class="alert alert-info">
                                                        <p class="m-0">Note: You cannot submit to
                                                            proceed
                                                            if the
                                                            system
                                                            finds
                                                            inapproriate verb (colored
                                                            with red) in the course outcomes and student
                                                            learning
                                                            outcomes.
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="report mt-5">
                                                <header class="pb-2 overflow-hidden mb-3">
                                                    <h4 class="text-truncate d-block my-0">Course outcomes
                                                        verb
                                                        checking
                                                    </h4>
                                                </header>

                                                <ul class="courseOutcomes list-group">
                                                    <li class="list-group-item">We did not detected any
                                                        course
                                                        learning
                                                        outcomes.
                                                    </li>
                                                </ul>

                                                <header class="pb-2 overflow-hidden mt-5 mb-3">
                                                    <h4 class="text-truncate d-block my-0">Student learning
                                                        outcomes
                                                        verb
                                                        checking
                                                    </h4>
                                                </header>

                                                <ul class="studentOutcomes list-group">
                                                    <li class="list-group-item">We did not detected any
                                                        student
                                                        learning
                                                        outcomes.
                                                    </li>
                                                </ul>

                                                <div class="result_msg mt-5">
                                                    <h5>% Result summary</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-profile-" role="tabpanel">
                                        <div class="lessonsContainer" class="mt-4">
                                            <div class="w-100 h-100 bg-white">
                                                <div class="report">
                                                    <header class="pb-2 overflow-hidden border-bottom mt-5 mb-3">
                                                        <h4 class="text-truncate d-block my-0">List of
                                                            detected
                                                            lessons
                                                        </h4>
                                                    </header>

                                                    <ul class="lessons list-group">
                                                        <li class="list-group-item">We did not detected any
                                                            lessons.
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-slot>
                        </x-real.card>
                    </div>
                </x-real.tabpane>
                <x-real.tabpane :id="'FileContent'">
                    <x-real.card>
                        <x-slot name="header">File Content: <b
                                class="text-muted">{{ $resource->currentMediaVersion->file_name }}</b>
                        </x-slot>
                        <x-slot name="body">
                            <div class="reference">
                                <div class="row">
                                    <div class="references col-12" id="syllabusHTML">
                                        {!! $resource->html !!}
                                    </div>
                                </div>
                            </div>
                        </x-slot>
                    </x-real.card>
                </x-real.tabpane>
            </x-real.tabcontent>
        </div>

        <div class="modal modal-sheet bg-secondary py-5" tabindex="-1" role="dialog" id="createLessonsModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-6 shadow py-5 px-5">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title">Confirm Lesson Creation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        <form id="lessonForm" action="{{ route('syllabi.confirmValidation', $resource) }}"
                            method="POST" class="row g-3">
                            @method('POST')
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">

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
                    let verbs2 = $.parseJSON(`{!! json_encode($verbs) !!}`)
                    const courseId = '{{ $course->id }}'

                    let validationSuccessCount = 0
                    let validationFailedCount = 0


                    let failedCourseOutcomesCounter = 0;
                    let successCourseOutcomesCounter = 0;
                    $(`#tabcontentSyllabusValidation`).find('.references').each(function(index,
                        reference) {
                        const $reference = $(reference)
                        const $refTabcontent = $($(`#tabcontentSyllabusValidation`).find(
                            '.parentTabpane'))
                        $reference.find("table td p").each(function(index, element) {
                            if ($(element).text().toUpperCase().trim() == "COURSE OUTCOMES") {
                                let excludedRow = element.closest("td");
                                $refTabcontent.find(".courseOutcomes").html('');

                                $(element).closest("table").find("td:nth-child(2) p").each(
                                    function(index,
                                        element) {
                                        let txtContent = element.textContent.trim();
                                        let firstWord = txtContent.split(" ")[0].trim();
                                        let withoutFirstWord = txtContent.replace(firstWord,
                                            "").trim();

                                        if (!txtContent || excludedRow == $(element)
                                            .closest("td")[0]) {
                                            return;
                                        }

                                        let d = "";
                                        $(verbs2).each(function(index, item) {
                                            if (!item.hasOwnProperty(firstWord
                                                    .toUpperCase())) {
                                                d +=
                                                    `<li class="list-group-item"> <b class="badge bg-success rounded-pill align-middle me-2">✓</b> ${txtContent}</li>`;
                                                successCourseOutcomesCounter++;
                                            } else {
                                                let suggestions = item[firstWord
                                                        .toUpperCase()]
                                                    .join(", ");
                                                d +=
                                                    `<li class="list-group-item bg-danger text-white"> <a class="fw-bold text-white" tabindex="0" type="button" data-bs-trigger="focus" data-bs-toggle="popover" title="Suggested words" data-bs-content="${suggestions}"><u>${firstWord}</u></a> ${withoutFirstWord} </li>`;
                                                failedCourseOutcomesCounter++;
                                            }

                                        });

                                        $refTabcontent.find(".courseOutcomes").append(d);
                                    })
                            }
                        })


                        let failedStudentOutcomesCounter = 0;
                        let successStudentOutcomesCounter = 0;
                        $reference.find("table td p").each(function(index, element) {
                            if ($(element).text().toUpperCase().trim() ==
                                "STUDENT LEARNING OUTCOMES") {
                                let excludedRow = element.closest("td");
                                $refTabcontent.find(".studentOutcomes").html('');

                                $(element).closest("table").find("td:nth-child(1) p").each(
                                    function(index,
                                        element) {
                                        let txtContent = element.textContent.trim();
                                        let firstWord = txtContent.split(" ")[0].trim();
                                        let withoutFirstWord = txtContent.replace(firstWord,
                                            "").trim();

                                        if (!txtContent || excludedRow == $(element)
                                            .closest("td")[0]) {
                                            return;
                                        }

                                        let d = "";
                                        $(verbs2).each(function(index, item) {
                                            if (!item.hasOwnProperty(firstWord
                                                    .toUpperCase())) {
                                                d +=
                                                    `<li class="list-group-item"> <b class="badge bg-success rounded-pill align-middle me-2">✓</b> ${txtContent}</li>`;
                                                successStudentOutcomesCounter++;
                                            } else {
                                                let suggestions = item[firstWord
                                                        .toUpperCase()]
                                                    .join(", ");
                                                d +=
                                                    `<li class="list-group-item bg-danger text-white"> <a class="fw-bold text-white" tabindex="0" type="button" data-bs-trigger="focus" data-bs-toggle="popover" title="Suggested words" data-bs-content="${suggestions}"><u>${firstWord}</u></a> ${withoutFirstWord} </li>`;
                                                failedStudentOutcomesCounter++;
                                            }
                                        });

                                        $refTabcontent.find(".studentOutcomes").append(d);
                                    })
                            }
                        })

                        let totalFailedCounter = failedCourseOutcomesCounter +
                            failedStudentOutcomesCounter;
                        let totalSuccessCounter = successCourseOutcomesCounter +
                            successStudentOutcomesCounter;

                        if (totalFailedCounter == 0 && totalSuccessCounter == 0) {
                            $refTabcontent.find(".validation").html("");
                            $refTabcontent.find(".validation").append(`
                                <div class="alert alert-danger" role="alert">
                                    <h5 class="fw-bold">The submitted file is not a valid syllabus!</h5>
                                    <p>Use this <a href="#">syllabus</a> template so that we can appropriately validate your submission.</p>
                                </div>
                            `)
                        } else {
                            $refTabcontent.find(".result_msg").append(`
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td class="text-center"><b>Not appropriate</b></td>
                                            <td class="text-center"><b>Appropriate</b></td>
                                        </tr>

                                        <tr>
                                            <td>Course outcomes</td>
                                            <td class="text-center">${failedCourseOutcomesCounter}</td>
                                            <td class="text-center">${successCourseOutcomesCounter}</td>
                                        </tr>

                                        <tr>
                                            <td>Student learning outcomes</td>
                                            <td class="text-center">${failedStudentOutcomesCounter}</td>
                                            <td class="text-center">${successStudentOutcomesCounter}</td>
                                        </tr>


                                        <tr>
                                            <td></td>
                                            <td class="text-center"><b>Total: ${totalFailedCounter}</b></td>
                                            <td class="text-center"><b>Total: ${totalSuccessCounter}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            `);

                            if (totalFailedCounter <= 0) {
                                validationSuccessCount++
                                $refTabcontent.find(".syllabus-submit-submission").attr("disabled",
                                    false);
                                $(`#syllabusValidationTab`).find('.validationStatusLabel')
                                    .append(
                                        '<div class="badge bg-success text-white">Success</div>')
                                $('#createLessonsModalBtn').removeClass('disabled')
                            } else {
                                validationFailedCount++
                                $('#createLessonsModalBtn').remove()
                                $refTabcontent.find(".syllabus-submit-submission").attr("hidden", true);
                                $(`#syllabusValidationTab`).find('.validationStatusLabel')
                                    .append(
                                        '<div class="badge bg-danger text-white">Failed</div>')
                            }
                        }

                        $reference.find("table td p").each(function(index, element) {
                            if ($(element).text().toUpperCase().trim() == "WEEK") {
                                let excludedRow = element.closest("td");
                                $refTabcontent.find(".lessons").html('');
                                let lessonsArr = []
                                $(element).closest("table").find("td:nth-child(2)").each(
                                    function(index, element) {
                                        let txtContent = element.textContent.trim();

                                        if (!txtContent || excludedRow == $(element).prev()[
                                                0]) {
                                            return;
                                        }

                                        $refTabcontent.find(".lessons").append(`
                                            <li class="list-group-item hstack gap-3">
                                                <input id="lessonCheck${index}" type="checkbox" class="form-check-input p-2" checked/>
                                                <div class="vr"></div>
                                                <span class="lessonContent">${txtContent}</span>
                                            </li>
                                        `);

                                        lessonsArr.push(txtContent)
                                    })
                                $('[name=lessons]').val(lessonsArr)
                            }
                        })

                        $("#createLessonsModal").on("shown.bs.modal", function() {
                            $('#lessonConfirmList').html('')

                            $refTabcontent.find(".lessons").find("input").each(function(index,
                                item) {
                                if ($(item).prop("checked")) {
                                    let lesson = $(item).siblings(".lessonContent")
                                    $('#lessonConfirmList').append(
                                        `<li class="nav-item">
                                            <input readonly class="form-control-plaintext" type="text" name="lesson[]" value="${lesson.text()}">
                                        </li>`
                                    )
                                }
                            })

                            function removeBreaklinesAndSpaces(text) {
                                return $.trim(text.replace(/(\r\n|\n|\r)/gm, ""))
                            }
                        })
                    })

                    $('.validationStatusSummary').text(`${validationSuccessCount} success, ${validationFailedCount} failed`)

                    if (document.querySelectorAll('[data-bs-toggle="popover"]').length > 0) {
                        [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).forEach(el => new bootstrap
                            .Popover(el))
                    }
                })
            </script>
        @endsection
</x-app-layout>
