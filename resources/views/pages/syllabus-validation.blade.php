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
                                            @if ($resource->activityLogs()->whereIn('log_name', ['resource-attempt-versioned', 'resource-versioned', 'resource-created'])->exists())
                                                {{ $resource->activityLogs()->whereIn('log_name', ['resource-attempt-versioned', 'resource-versioned', 'resource-created'])->latest()->first()->causer->nameTag }}
                                            @endif
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
                                            role="tab" aria-selected="false">Lesson
                                            Creation</a>
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
                                                            with red) or undetected verb (colored with yellow) in the course outcomes and student
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

                            <div class="col-12 d-none">
                                <ul class="" id="course_outcomes_f">
                                </ul>
                            </div>

                            <div class="col-12 d-none">
                                <ul class="" id="learning_outcomes_f">
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

        <div class="modal modal-sheet py-5" tabindex="-1" role="dialog" id="verbSuggestionModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content rounded-6 shadow py-5 px-5">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title">Suggested Verbs</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        <x-real.alert :variant="'info'"></x-real.alert>

                        <div id="verbSuggestionContent" class="mt-4 d-flex flex-wrap gap-2"></div>
                    </div>
                </div>
            </div>
        </div>

        @section('script')
            <script>
                $(document).ready(function() {
                    let verbs2 = $.parseJSON(`{!! json_encode($verbs) !!}`)
                    let faultyVerbs = $.parseJSON(`{!! json_encode(collect($verbs)->keys()) !!}`)
                    let suggestedVerbs = $.parseJSON(`{!! json_encode(
    collect(
        collect($verbs)->values()->unique()->flatten(),
    ),
) !!}`)

                    console.log(suggestedVerbs)
                    const courseId = '{{ $course->id }}'
                    const syllabusSettings = $.parseJSON(`{!! json_encode($syllabusSettings) !!}`)

                    let validationSuccessCount = 0
                    let validationFailedCount = 0

                    let courseOutcomesTableNo = syllabusSettings ? syllabusSettings.course_outcomes_table_no : 0
                    let courseOutcomesRowNo = syllabusSettings ? syllabusSettings.course_outcomes_row_no : 0
                    let courseOutcomesColNo = syllabusSettings ? syllabusSettings.course_outcomes_col_no : 0

                    let studLearningOutcomesTableNo = syllabusSettings ? syllabusSettings.student_outcomes_table_no : 0
                    let studLearningOutcomesRowNo = syllabusSettings ? syllabusSettings.student_outcomes_row_no : 0
                    let studLearningOutcomesColNo = syllabusSettings ? syllabusSettings.student_outcomes_col_no : 0

                    let lessonTableNo = syllabusSettings ? syllabusSettings.lesson_table_no : 0
                    let lessonRowNo = syllabusSettings ? syllabusSettings.lesson_row_no : 0
                    let lessonColNo = syllabusSettings ? syllabusSettings.lesson_col_no : 0

                    $(`#tabcontentSyllabusValidation`).find('.references').each(function(index,
                        reference) {
                        const $reference = $(reference)
                        const $refTabcontent = $($(`#tabcontentSyllabusValidation`).find(
                            '.parentTabpane'))

                        // course outcomes
                        let searchedCourseSentences = searchTable($reference, courseOutcomesTableNo,
                            courseOutcomesRowNo, courseOutcomesColNo)
                        let [
                            courseResultString,
                            successCourseCounter,
                            failedCourseCounter,
                            undetectedCourseCounter
                        ] = checkVerbAppropriateness(searchedCourseSentences, verbs2)
                        if (searchedCourseSentences.length > 0) {
                            $refTabcontent.find('.courseOutcomes').html(courseResultString);
                        }

                        // student learning outcomes
                        let searchedStudentSentences = searchTable($reference, studLearningOutcomesTableNo,
                            studLearningOutcomesRowNo,
                            studLearningOutcomesColNo)
                        let [
                            studentResultString,
                            successStudentCounter,
                            failedStudentCounter,
                            undetectedStudentCounter
                        ] = checkVerbAppropriateness(searchedStudentSentences, verbs2)
                        if (searchedStudentSentences.length > 0) {
                            $refTabcontent.find('.studentOutcomes').html(studentResultString);
                        }

                        let totalFailedCounter = failedCourseCounter + failedStudentCounter;
                        let totalSuccessCounter = successCourseCounter + successStudentCounter;
                        let totalUndetectedCounter = undetectedCourseCounter + undetectedStudentCounter

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
                                            <td class="text-center"><b>Undetected</b></td>
                                            <td class="text-center"><b>Not appropriate</b></td>
                                            <td class="text-center"><b>Appropriate</b></td>
                                        </tr>

                                        <tr>
                                            <td>Course outcomes</td>
                                            <td class="text-center">${undetectedCourseCounter}</td>
                                            <td class="text-center">${failedCourseCounter}</td>
                                            <td class="text-center">${successCourseCounter}</td>
                                        </tr>

                                        <tr>
                                            <td>Student learning outcomes</td>
                                            <td class="text-center">${undetectedStudentCounter}</td>
                                            <td class="text-center">${failedStudentCounter}</td>
                                            <td class="text-center">${successStudentCounter}</td>
                                        </tr>


                                        <tr>
                                            <td></td>
                                            <td class="text-center"><b>Total: ${totalUndetectedCounter}</b></td>
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

                        // lessons
                        let searchedLessonSentences = searchTable($reference, lessonTableNo,
                            lessonRowNo,
                            lessonColNo,
                            true)

                        let lessonItems = ''
                        $(searchedLessonSentences).each(function(index, sentence) {
                            lessonItems += generateLessonListItem(index, sentence)
                        })
                        if (searchedLessonSentences.length > 0) {
                            $refTabcontent.find('.lessons').html(lessonItems);
                        }
                        $('[name=lessons]').val(searchedLessonSentences)

                        $("#createLessonsModal").on("shown.bs.modal", function() {
                            $('#lessonConfirmList').html('')
                            $('#course_outcomes_f').html('')
                            $('#learning_outcomes_f').html('')

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

                            $refTabcontent.find(".courseOutcomes li").each(function(index,
                                item) {
                                let text = $(item).text()
                                $('#course_outcomes_f').append(
                                    `<li class="nav-item">
                                <input readonly class="form-control-plaintext" type="text" name="course_outcomes[]" value="${text}">
                            </li>`
                                )
                            })

                            $refTabcontent.find(".studentOutcomes li").each(function(index,
                                item) {
                                let text = $(item).text()
                                $('#learning_outcomes_f').append(
                                    `<li class="nav-item">
                                <input readonly class="form-control-plaintext" type="text" name="learning_outcomes[]" value="${text}">
                            </li>`
                                )
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

                    function getAllBeforeNumber(number) {
                        return $(Array.from(Array(number).keys()))
                    }

                    function concatAllSelectedEq(startIndex) {
                        let eqs = []
                        getAllBeforeNumber(startIndex).each(function(index, item) {
                            eqs.push(`:eq(${item})`)
                        })

                        return eqs.join(",")
                    }

                    function searchTable($referenceContainer, tableNo, rowNo, colNo, searchEntireField = false) {
                        // minus each params by 1 to offset admin input
                        tableNo--
                        rowNo--
                        colNo--

                        const $table = $referenceContainer.find(`table:eq(${tableNo})`)
                        const $rows = $table.find(`tr:not(${concatAllSelectedEq(rowNo)})`)
                        let $fields
                        if (searchEntireField) {
                            $fields = $rows.find(`td:eq(${colNo})`)
                        } else {
                            $fields = $rows.find(`td:eq(${colNo}) p`)
                        }

                        let searchedSentences = []
                        $fields.each(function(index, paragraph) {
                            let $sentence = $(paragraph).text().trim()
                            if ($sentence.length !== 0) {
                                searchedSentences.push($sentence)
                            }
                        })

                        return searchedSentences
                    }

                    function checkVerbAppropriateness(searchedSentences, verbStandards) {
                        let successCounter = 0
                        let failedCounter = 0
                        let undetectedCounter = 0
                        let d = "";

                        $(searchedSentences).each(function(index, sentence) {
                            let firstWord = sentence.split(" ")[0].trim();
                            let withoutFirstWord = sentence.replace(firstWord, "").trim();
                            let uppercasedFirstWord = firstWord.toUpperCase()

                            $(verbStandards).each(function(index, verb) {
                                // check for appropriate verbs
                                if (!faultyVerbs.includes(uppercasedFirstWord) && suggestedVerbs.includes(
                                        uppercasedFirstWord)) {
                                    d += generateSuccessVerbListItem(sentence)

                                    successCounter++;
                                    return;
                                }

                                // check for undetected verbs
                                if (!faultyVerbs.includes(uppercasedFirstWord) && !suggestedVerbs.includes(
                                        uppercasedFirstWord)) {
                                    d += generateUndetectedVerbListItem(suggestedVerbs, firstWord,
                                        withoutFirstWord)

                                    undetectedCounter++;
                                    return;
                                }

                                let suggestions = verb[firstWord.toUpperCase()].join(", ");

                                d += generateFailedVerbListItem(suggestions, firstWord,
                                    withoutFirstWord)

                                failedCounter++;
                            });
                        })

                        return [
                            d,
                            successCounter,
                            failedCounter,
                            undetectedCounter
                        ]
                    }

                    function generateSuccessVerbListItem(sentence) {
                        return `<li class="list-group-item">
                                <b class="badge bg-success rounded-pill align-middle me-2">???</b>
                                ${sentence}
                            </li>`
                    }

                    function generateFailedVerbListItem(suggestions, firstWord, withoutFirstWord) {
                        return `<li class="list-group-item bg-danger text-white">
                                <span data-bs-toggle="modal" data-bs-target="#verbSuggestionModal" data-bs-content="${suggestions}">
                                <a class="fw-bold text-white" tabindex="0" type="button"  data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view suggestions">
                                    <u>${firstWord}</u>
                                </a>
                            </span>
                                    ${withoutFirstWord}
                            </li>`
                    }

                    function generateUndetectedVerbListItem(suggestions, firstWord, withoutFirstWord) {
                        return `<li class="list-group-item bg-warning text-white">
                                <span data-bs-toggle="modal" data-bs-target="#verbSuggestionModal" data-bs-content="${suggestions}" data-bs-description="Reminder! The first word of your sentence should be a verb and it should be based on the following list">
                                <a class="fw-bold text-white" tabindex="0" type="button"  data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view suggestions">
                                    <u>${firstWord}</u>
                                </a>
                            </span>
                                    ${withoutFirstWord}
                            </li>`
                    }


                    let verbSuggestionModalEl = document.querySelector('#verbSuggestionModal')
                    let verbSuggestionModal = bootstrap.Modal.getOrCreateInstance(verbSuggestionModalEl)

                    verbSuggestionModalEl.addEventListener('shown.bs.modal', function(event) {
                        const $modal = $(event.target)
                        const $modalTrigger = $(event.relatedTarget)
                        const suggestionsList = $modalTrigger.data("bs-content").split(',')
                        const modalDescription = $modalTrigger.data("bs-description")
                        const $modalInfoAlert = $modal.find('.alert')

                            !modalDescription ? $modalInfoAlert.addClass('d-none') : $modalInfoAlert.removeClass(
                                'd-none')
                        $modalInfoAlert.text(modalDescription)
                        $modal.find('#verbSuggestionContent').html('')

                        $(suggestionsList).each(function(index, item) {
                            $modal.find('#verbSuggestionContent').append(
                                `<div class="card p-2 text-capitalize">${item.toLowerCase()}</div>`)
                        })
                    })

                    function generateLessonListItem(index, sentence) {
                        return `
                            <li class="list-group-item hstack gap-3">
                                <input id="lessonCheck${index}" type="checkbox" class="form-check-input p-2" checked/>
                                <div class="vr"></div>
                                <span class="lessonContent">${sentence}</span>
                            </li>
                        `
                    }
                })
            </script>
        @endsection
</x-app-layout>
