<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
            <li class="breadcrumb-item active" aria-current="page">Show course</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex my-4">
            <small class="h4 font-weight-bold">
                {{ __('Show course') }}
            </small>

            {{-- HEADER ACTIONS SECTION --}}
            <div class="ms-auto"></div>
        </div>
    </x-slot>

    @if (session()->exists('success'))
        <div class="my-4">
            <x-alert-success>
                {{ session()->get('success') }}
            </x-alert-success>
        </div>
    @endif

    {{-- CONTENT SECTION --}}
    <div class="row">
        <div class="col-12 mb-3">
            <h5>Course information</h5>

            <x-card-body>
                <h4>{{ $course->title }} ({{ $course->code }})</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">Program: {{ $course->program->title }}</li>
                    <li class="nav-item">Year level: {{ $course->year_level }}</li>
                    <li class="nav-item">semester: {{ $course->semester }}</li>
                    <li class="nav-item">term: {{ $course->term }}</li>
                </ul>
            </x-card-body>
        </div>

        <div class="col-12 mb-3">
            <div class="d-flex align-items-center">
                <h5>Resources submitted in this course</h5>
                <a href="{{ route('resources.download', ['all', 'course_id' => $course->id]) }}"
                    class="btn btn-primary ms-auto">Download all</a>
            </div>

            <x-table>
                <x-slot name="thead">
                    <th>#</th>
                    <th>File</th>
                    <th>Description</th>
                    <th>Last update</th>
                    <th></th>
                </x-slot>

                @foreach ($resourcesWithinCourse as $resource)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="text-muted">
                                <span class="text-muted">
                                    Submitted by
                                    @if ($resource->user_id != auth()->id())
                                        <strong>
                                            {{ ucwords($resource->users[0]->name) }}
                                        </strong>
                                    @else
                                        <strong>
                                            me
                                        </strong>
                                    @endif
                                </span>

                                @if ($resource->is_syllabus)
                                    | <strong class="text-primary">
                                        Syllabus
                                    </strong>
                                @endif

                                @isset($resource->getMedia()[0])
                                    | <a href="{{ route('resources.download', $resource->id) }}">
                                        <small>Download</small>
                                    </a>
                                @endisset

                                @if (!$resource->approved_at)
                                    | <span class="badge rounded-pill bg-warning text-dark">
                                        for approval
                                    </span>
                                @endif
                            </div>
                            {{ $resource->getMedia()[0]->file_name ?? 'not available' }}
                        </td>
                        <td>{{ $resource->description }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($resource->updated_at)->format('M d Y') }}
                        </td>
                        <td>action</td>
                    </tr>
                @endforeach
            </x-table>
        </div>

        <div class="col-12 mb-3">
            <h5>History log</h5>
            @foreach ($activities as $activity)
                <span>
                    <b>{{ $activity->causer->name ?? 'unknown user' }}</b>
                    {{ $activity->description }}
                    {{ $activity->subject->getMedia()[0]->file_name }}
                    <small class="badge rounded-pill bg-success mx-1">{{ $loop->index == 0 ? 'latest' : '' }}</small>
                </span>

                <div class="lh-1 mb-1">
                    <small
                        class="text-muted">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->created_at)->diffForHumans() }}</small>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
