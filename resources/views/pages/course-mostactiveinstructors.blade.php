<x-app-layout>
    <x-slot name="header">
        Most Active Instructors
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">
            <a class="fw-bold" href="{{ route('course.show', $course) }}">
                <- Go back </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('course.show', $course) }}">{{ $course->code }}</a></li>
        <li class="breadcrumb-item active">
            Most Active Instructors
        </li>
    </x-slot>

    <div class="row g-3">
        <div class="col-12">
            <div class="row g-3">
                <div class="col-12">
                    <x-real.card>
                        <x-slot name="header">Active Instructors</x-slot>
                        <x-slot name="body">
                            <x-real.table id="mostActiveInstructorsTable">
                                <x-slot name="headers">
                                    <th>Name</th>
                                    <th>Resource Submissions</th>
                                    <th>Lesson Creations</th>
                                    <th>Resource Management</th>
                                    <th>Lesson Management</th>
                                    <th>Comments</th>
                                    <th>Daily Signins</th>
                                    <th>Actions</th>
                                    <th class="d-none"></th>
                                </x-slot>
                                <x-slot name="rows">
                                    @forelse ($activeInstructors as $instructor)
                                        <tr>
                                            <td>{{ $instructor->name }}</td>

                                            @php
                                                $created = isset($instructor->activitiesByLogName['resource-created']) ? $instructor->activitiesByLogName['resource-created'] : [];
                                                $resourceSubmission = count($created);
                                            @endphp
                                            <td>
                                                {{ $resourceSubmission }}
                                            </td>

                                            @php
                                                $created = isset($instructor->activitiesByLogName['lesson-created']) ? $instructor->activitiesByLogName['lesson-created'] : [];
                                                $lessonCreation = count($created);
                                            @endphp
                                            <td>
                                                {{ $lessonCreation }}
                                            </td>

                                            @php
                                                $updated = isset($instructor->activitiesByLogName['resource-updated']) ? $instructor->activitiesByLogName['resource-updated'] : [];
                                                $deleted = isset($instructor->activitiesByLogName['resource-deleted']) ? $instructor->activitiesByLogName['resource-deleted'] : [];
                                                $resourceManagement = count($updated) + count($deleted);
                                            @endphp
                                            <td>
                                                {{ $resourceManagement }}
                                            </td>

                                            @php
                                                $updated = isset($instructor->activitiesByLogName['lesson-updated']) ? $instructor->activitiesByLogName['lesson-updated'] : [];
                                                $deleted = isset($instructor->activitiesByLogName['lesson-deleted']) ? $instructor->activitiesByLogName['lesson-deleted'] : [];
                                                $lessonManagement = count($updated) + count($deleted);
                                            @endphp
                                            <td>
                                                {{ $lessonManagement }}
                                            </td>

                                            @php
                                                $createdComments = isset($instructor->activitiesByLogName['comment-created']) ? $instructor->activitiesByLogName['comment-created'] : [];
                                                $createdReplies = isset($instructor->activitiesByLogName['reply-created']) ? $instructor->activitiesByLogName['reply-created'] : [];
                                                $comments = count($createdComments) + count($createdReplies);
                                            @endphp

                                            <td>{{ $comments }}</td>

                                            @php
                                                $loggins = isset($instructor->activitiesByLogName['user-loggedin']) ? $instructor->activitiesByLogName['user-loggedin'] : [];
                                                $dailyLoggedins = count($loggins);
                                            @endphp

                                            <td>{{ $dailyLoggedins }}</td>
                                            <td>
                                                <x-real.btn href="{{route('user.show', $instructor)}}" :tag="'a'" :size="'sm'" :icon="'read_more'">
                                                    View Profile
                                                </x-real.btn>
                                            </td>

                                            <td class="d-none"></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            empty
                                        </tr>
                                    @endforelse
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
                $('#mostActiveInstructorsTable').DataTable({
                    "order": [[8]],
                    "aoColumnDefs": [{
                        "aTargets": [8],
                        "visible": false,
                        "mData": null,
                        "mRender": function(data, type, full) {
                            return Object.values(data).filter(val => !isNaN(parseInt(val))).reduce((acc, cur) => acc + parseInt(cur), 0);
                        }
                    }]
                })
            })
        </script>
    @endsection
</x-app-layout>
