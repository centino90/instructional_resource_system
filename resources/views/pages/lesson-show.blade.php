<x-app-layout>
    <x-slot name="header">
        {{ $lesson->title }}
    </x-slot>

    <x-slot name="headerTitle">
        Lesson
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('course.showLessons', $lesson->course) }}">
                <- Go back</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('course.show', $lesson->course) }}">{{$lesson->course->code}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('course.showLessons', $lesson->course) }}">Course lessons</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $lesson->title }}</li>
    </x-slot>

    <div class="row g-3">
        <div class="col-3">
            <x-real.card>
                <x-slot name="header">Some actions</x-slot>
                <x-slot name="body">
                    <div class="d-grid gap-2">
                        <a href="{{route('resource.create', $lesson)}}" class="btn btn-secondary">Submit resource</a>
                    </div>
                </x-slot>
            </x-real.card>
        </div>
        <div class="col-9">
            <x-real.card>
                <x-slot name="header">Resources</x-slot>
                <x-slot name="body">
                    <x-real.table id="myLessonTable">
                        <x-slot name="headers">
                            <th>Name</th>
                            <th>Type</th>
                            <th>Submitted at</th>
                            <th>Versions</th>
                            <th></th>
                        </x-slot>
                        <x-slot name="rows">
                            @foreach ($lesson->resources()->latest()->get()
    as $resource)
                                <tr>
                                    <td>{{ $resource->title }}</td>
                                    <td>{{ $resource->resourceType }}</td>
                                    <td>{{ $resource->created_at }}</td>
                                    <td>
                                        {{ $resource->getMedia()->count() }}
                                    </td>
                                    <td>
                                        <x-real.btn :size="'sm'" :tag="'a'"
                                            href="{{ route('resource.addViewCountThenRedirectToShow', $resource) }}">
                                            View more
                                        </x-real.btn>
                                    </td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-real.table>
                </x-slot>
            </x-real.card>
        </div>
    </div>
    </div>

    @section('script')
        <script>
            $(document).ready(function() {
                $('#myLessonTable').DataTable({
                    "order": false,
                    "bsort": false,
                    "bStateSave": true,
                    "stateSaveParams": function(settings, data) {
                        data.search.search = ""
                        data.order = false
                    },
                    language: {
                        emptyTable: 'No lessons available in this table'
                    }
                })
            })
        </script>
    @endsection
</x-app-layout>
