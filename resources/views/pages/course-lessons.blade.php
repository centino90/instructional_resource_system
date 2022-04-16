<x-app-layout>
    <x-slot name="header">
        Course Lessons
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">
            <a class="fw-bold" href="{{ route('course.show', $course) }}">
                <- Go back </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('course.show', $course) }}">{{ $course->code }}</a></li>
        <li class="breadcrumb-item active">
            Course Lessons
        </li>
    </x-slot>

    <div class="modal modal-sheet bg-secondary py-5" tabindex="-1" role="dialog" id="courseLessonModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-6 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5 py-5">
                    <div class="editLesson collapse">
                        <div class="row">
                            <x-real.form action="{{ route('lesson.index') }}" :method="'PUT'">
                                <div class="col-12">
                                    <x-real.input name="title">
                                        <x-slot name="label">Name</x-slot>
                                    </x-real.input>

                                    <x-real.input :type="'textarea'" name="description">
                                        <x-slot name="label">Description</x-slot>
                                    </x-real.input>
                                </div>

                                <x-slot name="submit">
                                    <div class="col-12 mt-4">
                                        <div class="d-grid gap-2 w-100">
                                            <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                                                update</button>
                                            <button type="button" class="btn btn-lg btn-light mx-0 rounded-4"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </x-slot>
                            </x-real.form>
                        </div>
                    </div>

                    <div class="archiveLesson collapse">
                        <div class="row">
                            <x-real.form action="{{ route('lesson.index') }}" :method="'PUT'">
                                <div class="col-12">
                                    <div class="confirmAlert alert alert-primary">Do you want to move this lesson to
                                        archive?</div>
                                </div>
                                <x-slot name="submit">
                                    <div class="col-12 mt-4">
                                        <div class="d-grid gap-2 w-100">
                                            <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                                            </button>
                                            <button type="button" class="btn btn-lg btn-light mx-0 rounded-4"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </x-slot>
                            </x-real.form>
                        </div>
                    </div>

                    <div class="trashLesson collapse">
                        <div class="row">
                            <x-real.form action="{{ route('lesson.index') }}" :method="'DELETE'">
                                <div class="col-12">
                                    <div class="confirmAlert alert alert-primary">Do you want to move this lesson to
                                        trash?
                                    </div>
                                </div>
                                <x-slot name="submit">
                                    <div class="col-12 mt-4">
                                        <div class="d-grid gap-2 w-100">
                                            <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                                            </button>
                                            <button type="button" class="btn btn-lg btn-light mx-0 rounded-4"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </x-slot>
                            </x-real.form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <div class="row g-3">
                <div class="col-12">
                    <x-real.card>
                        <x-slot name="header">Lessons</x-slot>
                        <x-slot name="action">
                            <ul class="nav nav-pills justify-content-end gap-3" id="courseLessonsTab"
                                role="tablist">
                                <li class="nav-item p-0" role="presentation">
                                    <button class="nav-link py-0 text-dark rounded-0 active"
                                        id="allCourseLessonsTab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#allCourseLessonsTabPane"
                                        type="button" role="tab">
                                        All</button>
                                </li>
                                <li class="nav-item p-0" role="presentation">
                                    <button class="nav-link py-0 text-dark rounded-0"
                                        id="archivedCourseLessonsTab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#archivedCourseLessonsTabpane"
                                        type="button" role="tab">
                                        Archived
                                    </button>
                                </li>
                                <li class="nav-item p-0" role="presentation">
                                    <button class="nav-link py-0 text-dark rounded-0"
                                        id="trashedCourseLessonsTab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#trashedCourseLessonsTabpane"
                                        type="button" role="tab">
                                        Trashed
                                    </button>
                                </li>
                            </ul>
                        </x-slot>
                        <x-slot name="body">
                            <div class="tab-content"
                                id="courseLessonsTabcontent">
                                <div class="tab-pane fade show active"
                                    id="allCourseLessonsTabPane" role="tabpanel">
                                    <x-real.table class="allCourseLessonsTable">
                                        <x-slot name="headers">
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Created at</th>
                                            <th>Is Syllabus Generated</th>
                                            <th>Actions</th>
                                        </x-slot>
                                        <x-slot name="rows">
                                            @foreach ($course->lessons()->withoutArchived()->get() as $lesson)
                                                <tr id="tableRow{{ $lesson->id }}">
                                                    <td class="lessonTitle">
                                                        {{ $lesson->title }}
                                                    </td>
                                                    <td class="lessonDescription">
                                                        <div class="line-clamp">
                                                            {{ $lesson->description }}</div>
                                                    </td>
                                                    <td>{{ $lesson->created_at }}</td>
                                                    <td>{{ !empty($lesson->resource_id) ? '<span class="badge bg-success text-white">✓</span>' : '' }}
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-3">
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#courseLessonModal"
                                                                data-bs-title="Update ({{ $lesson->title }})"
                                                                data-bs-mode="edit"
                                                                data-bs-lesson-id="{{ $lesson->id }}">Edit</a>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#courseLessonModal"
                                                                data-bs-title="Archive ({{ $lesson->title }})"
                                                                data-bs-mode="archive"
                                                                data-bs-lesson-id="{{ $lesson->id }}">Archive</a>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#courseLessonModal"
                                                                data-bs-title="Trash ({{ $lesson->title }})"
                                                                data-bs-mode="trash"
                                                                data-bs-lesson-id="{{ $lesson->id }}">Trash</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </x-slot>
                                    </x-real.table>
                                </div>
                                <div class="tab-pane fade"
                                    id="archivedCourseLessonsTabpane"
                                    role="tabpanel">
                                    <x-real.table class="archivedCourseLessonsTable">
                                        <x-slot name="headers">
                                            <td>Name</td>
                                            <td>Description</td>
                                            <td>Archived at</td>
                                            <td>Is Syllabus Generated</td>
                                            <td>Actions</td>
                                        </x-slot>
                                        <x-slot name="rows">
                                            @foreach ($course->lessons()->onlyArchived()->get() as $lesson)
                                                <tr id="tableRow{{ $lesson->id }}">
                                                    <td>{{ $lesson->title }}</td>
                                                    <td>
                                                        <div class="line-clamp">
                                                            {{ $lesson->description }}</div>
                                                    </td>
                                                    <td>{{ $lesson->archived_at }}</td>
                                                    <td>{{ !empty($lesson->resource_id) ? '<span class="badge bg-success text-white">✓</span>' : '' }}
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-3">
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#courseLessonModal"
                                                                data-bs-title="Archive ({{ $lesson->title }})"
                                                                data-bs-mode="archive"
                                                                data-bs-toggle-type="remove"
                                                                data-bs-lesson-id="{{ $lesson->id }}">Remove</a>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#courseLessonModal"
                                                                data-bs-title="Trash ({{ $lesson->title }})"
                                                                data-bs-mode="trash"
                                                                data-bs-lesson-id="{{ $lesson->id }}">Move
                                                                to
                                                                Trash</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </x-slot>
                                    </x-real.table>
                                </div>
                                <div class="tab-pane fade"
                                    id="trashedCourseLessonsTabpane"
                                    role="tabpanel">
                                    <x-real.table class="trashedCourseLessonsTable">
                                        <x-slot name="headers">
                                            <td>Name</td>
                                            <td>Description</td>
                                            <td>Trashed at</td>
                                            <td>Is Syllabus Generated</td>
                                            <td>Actions</td>
                                        </x-slot>
                                        <x-slot name="rows">
                                            @foreach ($course->lessons()->onlyTrashed()->get() as $lesson)
                                                <tr id="tableRow{{ $lesson->id }}">
                                                    <td>{{ $lesson->title }}</td>
                                                    <td>
                                                        <div class="line-clamp">
                                                            {{ $lesson->description }}</div>
                                                    </td>
                                                    <td>{{ $lesson->deleted_at }}</td>
                                                    <td>{{ !empty($lesson->resource_id) ? '<span class="badge bg-success text-white">✓</span>' : '' }}
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-3">
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#courseLessonModal"
                                                                data-bs-title="Trash ({{ $lesson->title }})"
                                                                data-bs-mode="trash"
                                                                data-bs-toggle-type="remove"
                                                                data-bs-lesson-id="{{ $lesson->id }}">Remove</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </x-slot>
                                    </x-real.table>
                                </div>
                            </div>
                        </x-slot>
                    </x-real.card>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            $(document).ready(function() {
                const exampleModal = document.getElementById('courseLessonModal')
                exampleModal.addEventListener('show.bs.modal', function(event) {
                    const $button = $(event.relatedTarget)

                    const $recipient = $button.attr('data-bs-title')
                    const $mode = $button.attr('data-bs-mode')
                    const $lessonId = $button.attr('data-bs-lesson-id')
                    const $toggleType = $button.attr('data-bs-toggle-type')

                    const $lessonTitle = $button.closest('tr').find('.lessonTitle')
                    const $lessonDescription = $button.closest('tr').find('.lessonDescription')

                    // Update the modal's content.
                    const $lessonCollapsedDiv = $(this).find(`.${$mode}Lesson`)
                    const $modalTitle = $(this).find('.modal-title')
                    const $collapsedForm = $lessonCollapsedDiv.find('form')

                    $collapsedForm.find('[name="title"]').val($lessonTitle.text().trim())
                    $collapsedForm.find('[name="description"]').val($lessonDescription.text().trim())
                    $collapsedForm.attr('action',
                        `{{ route('lesson.index') }}/${$lessonId}${$.inArray($mode, ['archive', 'archive-remove']) != -1 ? '/archive' : ''}`
                    )
                    if ($toggleType == 'remove') {
                        $lessonCollapsedDiv.find('.confirmAlert').text(
                            `Do you want to remove this lesson from ${$mode}?`)
                        let regex = new RegExp(`${$mode}`, 'gi');
                        $modalTitle.text($recipient.replace(regex, `Remove from ${$mode}`))
                    } else {
                        $lessonCollapsedDiv.find('.confirmAlert').text(
                            `Do you want to move this lesson to ${$mode}?`)
                        $modalTitle.text($recipient)
                    }
                    $lessonCollapsedDiv.show()

                })

                exampleModal.addEventListener('hidden.bs.modal', function(event) {
                    $(this).find('.collapse').hide()
                })
            })
        </script>
    @endsection
</x-app-layout>
