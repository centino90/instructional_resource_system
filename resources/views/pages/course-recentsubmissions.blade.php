<x-app-layout>
    <x-slot name="header">
        Recent Submissions
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">
            <a class="fw-bold" href="{{ route('course.show', $course) }}">
                <- Go back </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('course.show', $course) }}">{{ $course->code }}</a></li>
        <li class="breadcrumb-item active">
            Recent Submissions by course
        </li>
    </x-slot>

    <div class="row g-3">
        <div class="col-12">
            <div class="row g-3">
                <div class="col-12">
                    <x-real.card>
                        <x-slot name="header">Submissions</x-slot>
                        <x-slot name="action">

                        </x-slot>
                        <x-slot name="body">
                            <x-real.table id="recentSubmissionsTable">
                                <x-slot name="headers">
                                    <th>Resource title</th>
                                    <th>Media</th>
                                    <th>Description</th>
                                    <th>Submitted at</th>
                                    <th>Submitted by</th>
                                    <th>Actions</th>
                                </x-slot>
                                <x-slot name="rows">
                                    @foreach ($activities as $activity)
                                        <tr>
                                            <td>{{ $activity->subject ? $activity->subject->title : '' }}</td>
                                            <td>{{ $activity->subject ? $activity->subject->currentMediaVersion->file_name : '' }}
                                            </td>
                                            <td>{{ $activity->subject ? $activity->subject->description : '' }}</td>
                                            <td>{{ $activity->created_at }}</td>
                                            <td>{{ $activity->causer->nameTag }}</td>
                                            <td>
                                                @isset($activity->subject)
                                                    <x-real.btn :size="'sm'" :tag="'a'"
                                                        href="{{ route('resource.show', $activity->subject) }}">
                                                        Show more
                                                    </x-real.btn>
                                                @endisset
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
    </div>

    @section('script')
        <script>
            $(document).ready(function() {
                $('#recentSubmissionsTable').DataTable();
            })
        </script>
    @endsection
</x-app-layout>
