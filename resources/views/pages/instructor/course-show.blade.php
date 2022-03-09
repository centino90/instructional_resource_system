<x-app-layout>
    <x-slot name="header">
        ({{ $course->code }}) {{ $course->title }}
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
        <li class="breadcrumb-item active">
            {{ $course->code }}
        </li>
    </x-slot>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="row g-3">
                <div class="col-12">
                    <div class="hstack justify-content-end">
                        <a href="" class="btn btn-primary ms-auto">
                            <span class="material-icons align-middle md-18">
                                upload_file
                            </span>
                            Submit new resource
                        </a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 bg-white rounded shadow-sm">
                        <header class="hstack align-items-center gap-3 pb-2 border-bottom">
                            <h6 class="mb-0">Syllabus</h6>

                            <span class="badge bg-success">Complied</span>
                        </header>

                        <div class="row">
                            <div class="d-flex text-muted pt-3">
                                <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
                                    xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
                                    preserveAspectRatio="xMidYMid slice" focusable="false">
                                    <title>Placeholder</title>
                                    <rect width="100%" height="100%" fill="#007bff"></rect><text x="50%" y="50%"
                                        fill="#007bff" dy=".3em">32x32</text>
                                </svg>

                                <p class="pb-3 mb-0 small lh-sm border-bottom">
                                    <strong class="d-block text-gray-dark">qweqweqwe</strong>
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatem, explicabo!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 bg-white rounded shadow-sm" id="lessonSection">
                        <h6 class="border-bottom pb-2 mb-0">Lessons</h6>

                        <div class="row">
                            <div class="accordion accordion-flush" id="accordionLessons">
                                @foreach ($course->lessons as $lesson)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flushHeading{{ $loop->index }}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#flushCollapse{{ $loop->index }}"
                                                aria-expanded="false">
                                                <div class="d-flex text-muted pt-3">
                                                    <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded"
                                                        width="32" height="32" xmlns="http://www.w3.org/2000/svg"
                                                        role="img" aria-label="Placeholder: 32x32"
                                                        preserveAspectRatio="xMidYMid slice" focusable="false">
                                                        <title>Placeholder</title>
                                                        <rect width="100%" height="100%" fill="#007bff"></rect><text
                                                            x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
                                                    </svg>

                                                    <p class="pb-3 mb-0 small lh-sm border-bottom">
                                                        <strong
                                                            class="d-block text-gray-dark">{{ $lesson->title }}</strong>
                                                        {{ $lesson->description }}
                                                    </p>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="flushCollapse{{ $loop->index }}" class="accordion-collapse collapse"
                                            aria-labelledby="flushHeading{{ $loop->index }}"
                                            data-bs-parent="#accordionLessons">
                                            <div class="accordion-body">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Resource title</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($lesson->resources as $resource)
                                                            <tr>
                                                                <td>{{ $resource->title }}</td>
                                                                <td><a
                                                                        href="{{ route('instructor.resource.show', $resource->id) }}">View</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row g-3">
                <div class="col-12">
                    <div class="p-3 bg-white rounded shadow-sm">
                        <h6 class="border-bottom pb-2 mb-0">Recent submissions</h6>

                        <div class="d-flex text-muted pt-3">
                            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
                                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
                                preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title>Placeholder</title>
                                <rect width="100%" height="100%" fill="#007bff"></rect><text x="50%" y="50%"
                                    fill="#007bff" dy=".3em">32x32</text>
                            </svg>

                            <p class="pb-3 mb-0 small lh-sm border-bottom">
                                <strong class="d-block text-gray-dark">@username</strong>
                                Some representative placeholder content, with some information about this user. Imagine
                                this
                                being
                                some sort of status update, perhaps?
                            </p>
                        </div>
                        <div class="d-flex text-muted pt-3">
                            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
                                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
                                preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title>Placeholder</title>
                                <rect width="100%" height="100%" fill="#e83e8c"></rect><text x="50%" y="50%"
                                    fill="#e83e8c" dy=".3em">32x32</text>
                            </svg>

                            <p class="pb-3 mb-0 small lh-sm border-bottom">
                                <strong class="d-block text-gray-dark">@username</strong>
                                Some more representative placeholder content, related to this other user. Another status
                                update,
                                perhaps.
                            </p>
                        </div>
                        <div class="d-flex text-muted pt-3">
                            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
                                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
                                preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title>Placeholder</title>
                                <rect width="100%" height="100%" fill="#6f42c1"></rect><text x="50%" y="50%"
                                    fill="#6f42c1" dy=".3em">32x32</text>
                            </svg>

                            <p class="pb-3 mb-0 small lh-sm border-bottom">
                                <strong class="d-block text-gray-dark">@username</strong>
                                This user also gets some representative placeholder content. Maybe they did something
                                interesting,
                                and you really want to highlight this in the recent updates.
                            </p>
                        </div>

                        <small class="d-block text-end mt-3">
                            <a href="#">Show more >></a>
                        </small>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 bg-white rounded shadow-sm">
                        <h6 class="border-bottom pb-2 mb-0">Most active instructors</h6>

                        <div class="d-flex text-muted pt-3">
                            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
                                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
                                preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title>Placeholder</title>
                                <rect width="100%" height="100%" fill="#007bff"></rect><text x="50%" y="50%"
                                    fill="#007bff" dy=".3em">32x32</text>
                            </svg>

                            <p class="pb-3 mb-0 small lh-sm border-bottom">
                                <strong class="d-block text-gray-dark">@username</strong>
                                Some representative placeholder content, with some information about this user. Imagine
                                this
                                being
                                some sort of status update, perhaps?
                            </p>
                        </div>
                        <div class="d-flex text-muted pt-3">
                            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
                                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
                                preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title>Placeholder</title>
                                <rect width="100%" height="100%" fill="#e83e8c"></rect><text x="50%" y="50%"
                                    fill="#e83e8c" dy=".3em">32x32</text>
                            </svg>

                            <p class="pb-3 mb-0 small lh-sm border-bottom">
                                <strong class="d-block text-gray-dark">@username</strong>
                                Some more representative placeholder content, related to this other user. Another status
                                update,
                                perhaps.
                            </p>
                        </div>
                        <div class="d-flex text-muted pt-3">
                            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"
                                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32"
                                preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title>Placeholder</title>
                                <rect width="100%" height="100%" fill="#6f42c1"></rect><text x="50%" y="50%"
                                    fill="#6f42c1" dy=".3em">32x32</text>
                            </svg>

                            <p class="pb-3 mb-0 small lh-sm border-bottom">
                                <strong class="d-block text-gray-dark">@username</strong>
                                This user also gets some representative placeholder content. Maybe they did something
                                interesting,
                                and you really want to highlight this in the recent updates.
                            </p>
                        </div>

                        <small class="d-block text-end mt-3">
                            <a href="#">Show more >></a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            $(document).ready(function() {
                $('#lessonSection table').DataTable()
            })
        </script>
    @endsection
</x-app-layout>
