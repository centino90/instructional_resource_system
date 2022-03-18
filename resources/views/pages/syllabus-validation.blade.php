<x-app-layout>
    <x-slot name="header">
        Syllabus Validation
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
        <li class="breadcrumb-item active" aria-current="page">Syllabus Validation</li>
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

        <ul class="nav nav-pills mb-3 d-none" id="pills-tab" role="tablist">
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

        <div class="tab-content col-lg-9" id="pills-tabContent">
            {{-- verb checking --}}
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="bg-white shadow-sm overflow-auto p-3" style="min-height: 500px">
                    <header class="pb-2 overflow-hidden border-bottom">
                        <h6 class="text-truncate d-block my-0">Syllabus Verb Checking Result</h6>
                    </header>

                    <div id="previewContainer" class="mt-4">
                        <div id="validation" class="w-100 h-100 bg-white">
                            <div id="report">
                                <header class="pb-2 overflow-hidden mb-3">
                                    <h4 class="text-truncate d-block my-0">Course outcomes verb checking</h4>
                                </header>

                                <ul class="list-group" id="courseOutcomes">
                                    <li class="list-group-item">We did not detected any course learning outcomes.
                                    </li>
                                </ul>

                                <header class="pb-2 overflow-hidden mt-5 mb-3">
                                    <h4 class="text-truncate d-block my-0">Student learning outcomes verb checking
                                    </h4>
                                </header>

                                <ul class="list-group" id="studentOutcomes">
                                    <li class="list-group-item">We did not detected any student learning outcomes.
                                    </li>
                                </ul>

                                <div class="mt-5" id="result_msg">
                                    <h5>% Result summary</h5>
                                </div>

                                <div class="mt-5" id="confirm_submission">
                                    <div class="hstack gap-3">
                                        <a href="javascript:void(0)" id="syllabus-cancel-submission"
                                            class="btn btn-secondary mb-3">Submit Again</a>

                                        <a id="syllabus-submit-submission" disabled class="btn btn-success mb-3">
                                            Lesson Creation
                                            <span class="material-icons align-middle">
                                                east
                                            </span>
                                        </a>
                                    </div>

                                    <div class="alert alert-info mt-3">
                                        <p class="m-0">Note: You cannot submit to proceed if the system
                                            finds
                                            inapproriate verb (colored
                                            with red) in the course outcomes and student learning outcomes.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- lessons checking --}}
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="bg-white shadow-sm overflow-auto p-3" style="min-height: 500px">
                    <header class="pb-2 overflow-hidden border-bottom">
                        <h6 class="text-truncate d-block my-0">Syllabus Lessons Confirmation</h6>
                    </header>

                    <div id="lessonsContainer" class="mt-4">
                        <div class="w-100 h-100 bg-white">
                            <div id="report">
                                <header class="pb-2 overflow-hidden border-bottom mt-5 mb-3">
                                    <h4 class="text-truncate d-block my-0">List of detected lessons</h4>
                                </header>

                                <ul class="list-group" id="lessons">
                                    <li class="list-group-item">We did not detected any lessons.</li>
                                </ul>

                                <div class="hstack gap-3 mt-5">
                                    <a id="showVerbCheckingTabBtn" disabled class="btn btn-success">
                                        <span class="material-icons align-middle">
                                            west
                                        </span>

                                        Verb Checking
                                    </a>

                                    <a data-bs-toggle="modal" data-bs-target="#createLessonsModal"
                                        class="btn btn-primary">
                                        <span class="material-icons align-middle md-18">
                                            upload_file
                                        </span>
                                        Confirm Lessons
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div id="reference" class="d-none">
                    {!! $syllabusHtml !!}
                </div>
            </div>
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
                let verbs2 = $.parseJSON(`{!! json_encode($verbs) !!}`)
                const courseId = '{{$lesson->course->id}}'

                var failedCourseOutcomesCounter = 0;
                var successCourseOutcomesCounter = 0;
                $("#reference table").find("td p").each(function(index, element) {
                    if ($(element).text().toUpperCase().trim() == "COURSE OUTCOMES") {
                        let excludedRow = element.closest("td");
                        $("#courseOutcomes").html('');

                        $(element).closest("table").find("td:nth-child(2) p").each(function(index, element) {
                            let txtContent = element.textContent.trim();
                            let firstWord = txtContent.split(" ")[0].trim();
                            let withoutFirstWord = txtContent.replace(firstWord, "").trim();

                            if (!txtContent || excludedRow == $(element).closest("td")[0]) {
                                return;
                            }

                            let d = "";
                            $(verbs2).each(function(index, item) {
                                if (!item.hasOwnProperty(firstWord.toUpperCase())) {
                                    d +=
                                        `<li class="list-group-item"> <b class="badge bg-success rounded-pill align-middle me-2">✓</b> ${txtContent}</li>`;
                                    successCourseOutcomesCounter++;
                                } else {
                                    let suggestions = item[firstWord.toUpperCase()].join(", ");
                                    d +=
                                        `<li class="list-group-item bg-danger text-white"> <a class="fw-bold text-white" tabindex="0" type="button" data-bs-trigger="focus" data-bs-toggle="popover" title="Suggested words" data-bs-content="${suggestions}"><u>${firstWord}</u></a> ${withoutFirstWord} </li>`;
                                    failedCourseOutcomesCounter++;
                                }

                            });

                            $("#courseOutcomes").append(d);
                        })
                    }
                })


                var failedStudentOutcomesCounter = 0;
                var successStudentOutcomesCounter = 0;
                $("#reference table").find("td p").each(function(index, element) {
                    if ($(element).text().toUpperCase().trim() == "STUDENT LEARNING OUTCOMES") {
                        let excludedRow = element.closest("td");
                        $("#studentOutcomes").html('');

                        $(element).closest("table").find("td:nth-child(1) p").each(function(index, element) {
                            let txtContent = element.textContent.trim();
                            let firstWord = txtContent.split(" ")[0].trim();
                            let withoutFirstWord = txtContent.replace(firstWord, "").trim();

                            if (!txtContent || excludedRow == $(element).closest("td")[0]) {
                                return;
                            }

                            let d = "";
                            $(verbs2).each(function(index, item) {
                                if (!item.hasOwnProperty(firstWord.toUpperCase())) {
                                    d +=
                                        `<li class="list-group-item"> <b class="badge bg-success rounded-pill align-middle me-2">✓</b> ${txtContent}</li>`;
                                    successStudentOutcomesCounter++;
                                } else {
                                    let suggestions = item[firstWord.toUpperCase()].join(", ");
                                    d +=
                                        `<li class="list-group-item bg-danger text-white"> <a class="fw-bold text-white" tabindex="0" type="button" data-bs-trigger="focus" data-bs-toggle="popover" title="Suggested words" data-bs-content="${suggestions}"><u>${firstWord}</u></a> ${withoutFirstWord} </li>`;
                                    failedStudentOutcomesCounter++;
                                }
                            });

                            $("#studentOutcomes").append(d);
                        })
                    }
                })

                var totalFailedCounter = failedCourseOutcomesCounter + failedStudentOutcomesCounter;
                var totalSuccessCounter = successCourseOutcomesCounter + successStudentOutcomesCounter;

                if (totalFailedCounter == 0 && totalSuccessCounter == 0) {
                    $("#validation").html("");
                    $("#validation").append(`
                    <div class="alert alert-danger" role="alert">
                        <h5 class="fw-bold">The submitted file is not a valid syllabus!</h5>
                        <p>Use this <a href="#">syllabus</a> template so that we can appropriately validate your submission.</p>
                    </div>
                `)
                } else {
                    $("#result_msg").append(`
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
                        $("#syllabus-submit-submission").attr("disabled", false);
                    } else {
                        $("#syllabus-submit-submission").attr("hidden", true);
                    }
                }

                $("#syllabus-submit-submission").click(function(event) {
                    bootstrap.Tab.getOrCreateInstance($('#pills-profile-tab')[0]).show()
                });
                $("#showVerbCheckingTabBtn").click(function(event) {
                    bootstrap.Tab.getOrCreateInstance($('#pills-home-tab')[0]).show()
                });

                $("#syllabus-cancel-submission").click(function() {
                    $("#syllabus-iframe-container").html("");
                });

                [].slice.call(document.querySelectorAll(`[data-bs-toggle="popover"]`)).forEach(el => new bootstrap
                    .Popover(el))

                $("#reference table").find("td p").each(function(index, element) {
                    if ($(element).text().toUpperCase().trim() == "WEEK") {

                        let excludedRow = element.closest("td");
                        $("#lessons").html('');
                        let lessonsArr = []
                        $(element).closest("table").find("td:nth-child(2)").each(function(index, element) {
                            let txtContent = element.textContent.trim();

                            if (!txtContent || excludedRow == $(element).prev()[0]) {
                                return;
                            }

                            $("#lessons").append(`
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
                    let $modal = $(this)
                    let formData = new FormData()
                    $('#lessonConfirmList').html('')

                    formData.append("course_id", courseId)
                    $("#lessons").find("input").each(function(index, item) {
                        if ($(item).prop("checked")) {
                            let lesson = $(item).siblings(".lessonContent")
                            formData.append("lesson[]", removeBreaklinesAndSpaces(lesson.text()))
                            $('#lessonConfirmList').append(
                                `<li class="nav-item">${lesson.text()}</li>`
                            )
                        }
                    })

                    function removeBreaklinesAndSpaces(text) {
                        return $.trim(text.replace(/(\r\n|\n|\r)/gm,""))
                    }

                    $modal.find("form").submit(function(event) {
                        event.preventDefault()

                        $.ajax({
                            url: "{{ route('syllabi.lessonCreation') }}",
                            method: "POST",
                            processData: false,
                            contentType: false,
                            cache: false,
                            data: formData
                        }).done(function(data) {
                            if(data.statusCode == 200) {
                                window.location.href = "{{ route('resource.create', $lesson->course->id) }}"
                            }
                        })
                    })
                })
            })
        </script>
    @endsection
</x-app-layout>
