<x-app-layout>
    <x-slot name="header">
        ({{ $course->code }}) {{ $course->title }}
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('dashboard') }}">
                <- Go back</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">
            {{ $course->code }}
        </li>
    </x-slot>

    <div class="modal modal-sheet bg-secondary py-5" tabindex="-1" role="dialog" id="newResourceModal">
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
                                @endunless
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
    @if ($errors->any())
        <div class="col-12">
            <div class="alert alert-danger my-0">
                <ul class="nav flex-column">
                    @foreach ($errors->all() as $error)
                        <li class="nav-item">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="col-md-6">
        <div class="row g-3">
            <div class="col-12">
                <div class="hstack justify-content-end">
                    {{-- href="{{route('resource.create', $course->id)}}" --}}
                    <a data-bs-toggle="modal" data-bs-target="#newResourceModal" class="btn btn-primary ms-auto">
                        <span class="material-icons align-middle md-18">
                            upload_file
                        </span>
                        New resource
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
                            @foreach ($course->with('resources')->first()->lessons as $lesson)
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
                                                                    href="{{ route('resource.show', $resource->id) }}">View</a>
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

                    <small class="d-block text-end mt-3">
                        <a href="#">Show more >></a>
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row g-3">
            <div class="col-12">
                <div class="p-3 bg-white rounded shadow-sm">
                    <h6 class="border-bottom pb-2 mb-0">Recent submissions</h6>

                    @forelse ($course->resources()->latest()->take(4) as $submission)
                        <div class="d-flex text-muted pt-3">
                            <div class="pb-3 mb-0 small lh-sm border-bottom">
                                <div class="hstack gap-3 align-items-center mb-2">
                                    <strong
                                        class="d-block text-gray-dark">{{ $submission->user->username }}</strong>

                                    <a href="#"><small>View more >></small></a>
                                </div>

                                <div class="hstack gap-3">
                                    <div class="">resource type</div>
                                    <div class="vr"></div>
                                    <div class="ms-auto">lesson</div>
                                    <div class="vr"></div>
                                    <div class="">datetime</div>
                                </div>
                            </div>
                        </div>

                        @if ($loop->index >= 3)
                            <small class="d-block text-end mt-3">
                                <a href="#">Show more >></a>
                            </small>
                        @endif
                    @empty
                        <x-real.no-rows>
                            <x-slot name="label">
                                There are no recent submissions
                            </x-slot>
                        </x-real.no-rows>
                    @endforelse
                </div>
            </div>

            <div class="col-12">
                <div class="p-3 bg-white rounded shadow-sm">
                    <h6 class="border-bottom pb-2 mb-0">Most active instructors</h6>

                    @php
                        $instructorBySubmissions = $course
                            ->resources()
                            ->with('user')
                            ->get()
                            ->groupBy('user_id');

                        $instructorByComments = collect();
                        foreach (
                            $course->program
                                ->users()
                                ->with('comments')
                                ->get()
                            as $user
                        ) {
                            if (sizeof($user->comments) >= 1) {
                                $instructorByComments->put($user->id, $user->comments);
                            }
                        }

                        $merged = $instructorBySubmissions->zip($instructorByComments);
                        $grouped = $merged->mapWithKeys(function ($item, $key) {
                            return [$item->flatten(1)->first()->user_id => sizeof($item->flatten(1))];
                        });

                        $mostActiveInstructors = $grouped->sortDesc();
                    @endphp

                    @forelse ($mostActiveInstructors->take(4) as $instructorId)
                        <div class="d-flex text-muted pt-3">
                            <div class="pb-3 mb-0 small lh-sm border-bottom">
                                <div class="hstack gap-3 align-items-center mb-2">
                                    <div
                                        class="{{ $loop->count > 1 ? 'bg-secondary' : 'bg-primary' }} bg-gradient text-white rounded px-3 py-2">
                                        <b>{{ $loop->count }}</b>
                                    </div>
                                    <strong
                                        class="d-block text-gray-dark">{{ App\Models\User::find($instructorId)->username }}</strong>

                                    <a href="#"><small>View more >></small></a>
                                </div>

                                <div class="hstack gap-3">
                                    <div class="">resource type</div>
                                    <div class="vr"></div>
                                    <div class="ms-auto">lesson</div>
                                    <div class="vr"></div>
                                    <div class="">datetime</div>
                                </div>
                            </div>
                        </div>

                        @if ($loop->index >= 3)
                            <small class="d-block text-end mt-3">
                                <a href="#">Show more >></a>
                            </small>
                        @endif
                    @empty
                        <x-real.no-rows>
                            <x-slot name="label">
                                There are no activities coming from instructors
                            </x-slot>
                        </x-real.no-rows>
                    @endforelse
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
