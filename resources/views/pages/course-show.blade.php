<x-app-layout>
    <x-slot name="header">
        ({{ $course->code }}) {{ $course->title }}
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">
            <a class="fw-bold" href="{{ route('dashboard') }}">
                <- Go back </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">
            {{ $course->code }}
        </li>
    </x-slot>

    <div class="modal modal-sheet bg-secondary py-5" tabindex="-1" role="dialog" id="createResourceModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-6 shadow py-5 px-5">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Choose or create a lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <form action="{{ route('lesson.store') }}" method="POST" class="row g-3">
                        @method('POST')
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="mode">

                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input list="lessons" type="text" name="title" class="form-control rounded-4"
                                    id="floatingInput" placeholder="_">
                                <label for="floatingInput">Lesson</label>

                                @if ($course->lessons->isEmpty())
                                    <small class="form-text">There are no lessons yet. Create one.</small>
                                @else
                                    <small class="form-text">Search all items in the datalist by typing their
                                        values.</small>

                                    <datalist id="lessons">
                                        @foreach ($course->lessons as $lesson)
                                            <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                                        @endforeach
                                    </datalist>
                                @endif
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

    <div class="row g-3">
        <div class="col-md-8">
            <div class="row g-3">
                <div class="col-12">
                    <div class="hstack justify-content-end gap-2">
                        <x-real.btn :tag="'a'" :btype="'solid'" :icon="'post_add'" class="ms-auto"
                            data-mode="new" data-bs-toggle="modal" data-bs-target="#createResourceModal">
                            New resource
                        </x-real.btn>
                    </div>
                </div>
                <div class="col-12">

                    <x-real.card :vertical="'center'">
                        <x-slot name="header">Syllabus</x-slot>
                        <x-slot name="action">
                            @empty($course->latestSyllabus)
                                <x-real.btn :size="'sm'" :tag="'a'"
                                    href="{{ route('syllabi.create', $course) }}">
                                    Submit Syllabus
                                </x-real.btn>
                            @else
                                @if ($course->latestSyllabus->verificationStatus == 'Pending')
                                    <x-real.form
                                        action="{{ route('syllabi.storeNewVersion', $course->latestSyllabus) }}">
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                                        <x-slot name="submit">
                                            <x-real.btn :size="'sm'" type="submit">
                                                Continue
                                                Validation
                                            </x-real.btn>
                                        </x-slot>
                                    </x-real.form>
                                @else
                                    <x-real.btn :size="'sm'" :tag="'a'"
                                        href="{{ route('resource.createNewVersion', $course->latestSyllabus) }}">Submit
                                        New
                                        Version
                                    </x-real.btn>

                                    <x-real.btn :size="'sm'" :tag="'a'"
                                        href="{{ route('resource.addViewCountThenRedirectToPreview', $course->latestSyllabus) }}">
                                        Preview
                                    </x-real.btn>
                                    <x-real.btn :size="'sm'" :tag="'a'"
                                        href="{{ route('resources.download', $course->latestSyllabus) }}">Download
                                    </x-real.btn>
                                @endif

                                <x-real.btn :size="'sm'" :tag="'a'"
                                    href="{{ route('resource.addViewCountThenRedirectToShow', $course->latestSyllabus) }}">
                                    View more
                                </x-real.btn>
                            @endempty
                        </x-slot>
                        <x-slot name="body">
                            <div class="row">
                                <div class="col-12 hstack justify-content-center text-muted">
                                    @empty($course->latestSyllabus)
                                        <x-real.no-rows>
                                            <x-slot name="label">There is no syllabus in this course yet</x-slot>
                                        </x-real.no-rows>
                                    @else
                                        <div class="w-100 hstack gap-3 ">
                                            @if ($course->latestSyllabus->archiveStatus == 'Archived')
                                                <x-real.alert :variant="'warning'" :dismiss="false"
                                                    class="w-100 justify-content-center">
                                                    <div>
                                                        The current Syllabus is archived

                                                        <div class="hstack gap-3 mt-3">
                                                            <x-real.form
                                                                action="{{ route('resource.toggleArchiveState', $course->latestSyllabus) }}"
                                                                method="PUT">
                                                                <input type="hidden" name="course_id"
                                                                    value="{{ $course->id }}">
                                                                <x-slot name="submit">
                                                                    <x-real.btn :size="'sm'" type="submit"
                                                                        class="w-100">
                                                                        Restore
                                                                    </x-real.btn>
                                                                </x-slot>
                                                            </x-real.form>
                                                            <x-real.btn :size="'sm'" :tag="'a'"
                                                                href="{{ route('resource.createNewVersion', $course->latestSyllabus) }}">
                                                                Submit
                                                                New
                                                            </x-real.btn>
                                                        </div>
                                                    </div>
                                                </x-real.alert>
                                            @else
                                                @if ($course->latestSyllabus->verificationStatus == 'Approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($course->latestSyllabus->verificationStatus == 'Rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @elseif($course->latestSyllabus->verificationStatus == 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif

                                                <p class="mb-0 small lh-sm">
                                                    <strong
                                                        class="d-block text-gray-dark">{{ $course->latestSyllabus->title }}</strong>
                                                    <small class="d-block mt-1">
                                                        Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                                        Voluptatem,
                                                        explicabo!
                                                    </small>
                                                </p>
                                            @endif
                                        </div>
                                    @endempty
                                </div>
                            </div>
                        </x-slot>
                    </x-real.card>
                </div>

                <div class="col-12">
                    <x-real.card id="lessonSection" :vertical="'center'">
                        <x-slot name="header">Lessons</x-slot>
                        <x-slot name="action">
                            <a href="{{ route('course.showUserLessons', [$course, auth()->id()]) }}"
                                class="btn btn-light btn-sm text-primary border fw-bold">Manage Your Lessons</a>

                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('course.showLessons', [$course]) }}"
                                    class="btn btn-light btn-sm text-primary border fw-bold">Manage Lessons</a>
                            @endif
                        </x-slot>
                        <x-slot name="body">
                            <div class="row mt-4">
                                <div class="accordion accordion-flush" id="accordionLessons">
                                    <table class="w-100 tableAccordion py-3">
                                        <thead class="d-none">
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($course->lessons as $lesson)
                                                <tr>
                                                    <td>
                                                        <div class="accordion-item bg-transparent">
                                                            <h2 class="accordion-header"
                                                                id="flushHeading{{ $loop->index }}">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#flushCollapse{{ $loop->index }}"
                                                                    aria-expanded="false">
                                                                    <div
                                                                        class="hstack align-items-center gap-3 text-muted">
                                                                        <p class="mb-0 small lh-sm">
                                                                            <strong
                                                                                class="d-block text-gray-dark">{{ $lesson->title }}</strong>
                                                                            <small
                                                                                class="pt-2">{{ $lesson->description }}</small>
                                                                        </p>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="flushCollapse{{ $loop->index }}"
                                                                class="border-start ms-3 my-3 accordion-collapse collapse"
                                                                aria-labelledby="flushHeading{{ $loop->index }}"
                                                                data-bs-parent="#accordionLessons">
                                                                <div class="accordion-body">
                                                                    <table
                                                                        class="table table-sm table-hover tableInsideAccordion">
                                                                        <caption class="caption-top">Resources
                                                                        </caption>
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Resource name</th>
                                                                                <th>Type</th>
                                                                                <th>Submitter</th>
                                                                                <th>Submitted at</th>
                                                                                <th>Verification</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                            @foreach ($lesson->resources as $resource)
                                                                                <tr>
                                                                                    <td>{{ $resource->title }}
                                                                                    </td>
                                                                                    <td>{{ $resource->resourceType }}
                                                                                    </td>
                                                                                    <td>{{ $resource->user->nameTag }}
                                                                                    </td>
                                                                                    <td>{{ $resource->submitDate }}
                                                                                    </td>
                                                                                    <td>{{ $resource->verificationStatus }}
                                                                                    </td>
                                                                                    <td><a
                                                                                            href="{{ route('resource.addViewCountThenRedirectToShow', $resource->id) }}">View</a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </x-slot>
                    </x-real.card>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row g-3">
                <div class="col-12">
                    <x-real.card :variant="'secondary'" :vertical="'center'">
                        <x-slot name="header">Recent submissions</x-slot>
                        <x-slot name="action">
                            <a href="{{ route('course.showResources', $course) }}"
                            class="btn btn-light btn-sm text-primary border fw-bold">View More</a>
                        </x-slot>
                        <x-slot name="body">
                            @forelse ($course->resources()->latest()->limit(4)->get() as $submission)
                                <div class="py-2 border-bottom">
                                    <small
                                        class="text-muted">{{ $submission->created_at->diffForHumans() }}</small>
                                    -
                                    {{ $submission->title }} ({{ $submission->currentMediaVersion->file_name }})
                                    <div>
                                        <small>Submitted by <b>{{ $submission->user->name }}</b></small>
                                    </div>
                                    <a href="{{route('resource.addViewCountThenRedirectToShow', $submission)}}"><small>View resource >></small></a>
                                </div>
                            @empty
                                <x-real.no-rows>
                                    <x-slot name="label">
                                        There are no recent submissions
                                    </x-slot>
                                </x-real.no-rows>
                            @endforelse
                        </x-slot>
                    </x-real.card>
                </div>
                <div class="col-12">
                    <x-real.card :variant="'secondary'" :vertical="'center'">
                        <x-slot name="header">Most active instructors</x-slot>
                        <x-slot name="action">
                            @if ($course->resources()->count() >= 3)
                                <x-real.btn :tag="'a'" :size="'sm'" :icon="'read_more'"
                                    href="{{ route('course.showMostActiveInstructors', $course) }}">View More
                                </x-real.btn>
                            @endif
                        </x-slot>
                        <x-slot name="body">
                            @forelse ($course->program->users()->withCount('activityLogs')->orderByDesc("activity_logs_count")->where('role_id', App\Models\Role::INSTRUCTOR)->limit(4)->get() as $instructor)
                                <div
                                    class="d-flex align-items-center gap-3 text-muted overflow-hidden py-0  border-bottom">
                                    <div
                                        class="{{ $loop->iteration > 1 ? 'bg-secondary' : 'bg-primary' }} bg-gradient text-white rounded px-3 py-2">
                                        <b>{{ $loop->iteration }}</b>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="hstack gap-3 align-items-center">
                                                <strong
                                                    class="d-block text-gray-dark">{{ $instructor->username }}</strong>
                                            </div>
                                        </div>

                                        <div class="hstack gap-3">
                                            <small>Total activities:
                                                <b> {{ $instructor->activityLogs->count() }}</b>
                                            </small>
                                        </div>

                                        <a href="{{route('user.show', $instructor)}}"><small>View profile >></small></a>
                                    </div>
                                </div>
                            @empty
                                <x-real.no-rows>
                                    <x-slot name="label">
                                        There are no activities coming from instructors
                                    </x-slot>
                                </x-real.no-rows>
                            @endforelse
                        </x-slot>
                    </x-real.card>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            $(document).ready(function() {
                $('#lessonSection .tableInsideAccordion').DataTable({
                    sDom: 'frtip',
                    language: {
                        emptyTable: 'No resources available in this table'
                    }
                })
                $('#lessonSection .tableAccordion').DataTable({
                    language: {
                        emptyTable: 'No lessons available in this table'
                    }
                })

                var exampleModal = document.getElementById('createResourceModal')
                exampleModal.addEventListener('show.bs.modal', function(event) {
                    let button = event.relatedTarget

                    let mode = button.getAttribute('data-mode')

                    let modalTitle = exampleModal.querySelector('.modal-title')
                    let modalBodyInput = exampleModal.querySelector('[name="mode"]')

                    modalBodyInput.value = mode
                })
            })
        </script>
    @endsection
</x-app-layout>
