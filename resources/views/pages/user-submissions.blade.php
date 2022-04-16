<x-app-layout>
    @if ($user->id == auth()->id())
        <x-slot name="header">
            My Submissions
        </x-slot>
        <x-slot name="breadcrumb">
            <li class="breadcrumb-item">
                <a class="fw-bold" href="{{ route('dashboard') }}">
                    <- Go back </a>
            </li>

            <li class="breadcrumb-item active">
                My Submissions
            </li>
        </x-slot>
    @else
        <x-slot name="header">
            Submissions
        </x-slot>

        <x-slot name="breadcrumb">
            <li class="breadcrumb-item">
                <a class="fw-bold" href="{{ route('user.show', $user) }}">
                    <- Go back </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('user.index') }}">Users</a>
            </li>


            <li class="breadcrumb-item">
                <a href="{{ route('user.show', $user) }}">{{ $user->name }}</a>
            </li>

            <li class="breadcrumb-item active">
                Submissions
            </li>
        </x-slot>
    @endif

    <div class="row g-3">
        <div class="col-12">
            <x-real.card>
                <x-slot name="header">Submissions</x-slot>
                <x-slot name="body">
                    <x-real.table id="submissionsTable">
                        <x-slot name="headers">
                            <th>Title</th>
                            <th>Media name</th>
                            <th>Lesson</th>
                            <th>Course</th>
                            <th>Submitted at</th>
                            <th>Versions</th>
                            <th>Comments</th>
                            <th></th>
                        </x-slot>
                        <x-slot name="rows">
                            @foreach ($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->title }}</td>
                                    <td>{{ $submission->currentMediaVersion->file_name }}</td>
                                    <td>
                                        <a
                                            href="{{ route('lesson.show', $submission->lesson) }}">{{ $submission->lesson->title }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('course.show', $submission->course) }}">{{ $submission->course->title }}
                                            ({{ $submission->course->code }})
                                        </a>
                                    </td>
                                    <td>{{ $submission->created_at }}</td>
                                    <td>{{ $submission->getMedia()->count() }}</td>
                                    <td>{{ $submission->comments()->count() }}</td>
                                    <td>
                                        <div class="hstack gap-3">
                                            <x-real.btn :tag="'a'" :size="'sm'"
                                                href="{{ route('resource.addViewCountThenRedirectToShow', $submission) }}">
                                                View more
                                            </x-real.btn>
                                            <x-real.btn :tag="'a'" :size="'sm'"
                                                href="{{ route('resource.addViewCountThenRedirectToPreview', $submission) }}">
                                                Preview
                                            </x-real.btn>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-real.table>
                </x-slot>
            </x-real.card>
        </div>
    </div>

    @section('script')
        <script>
            $(document).ready(function() {
                $('#submissionsTable').DataTable({
                    "bStateSave": true,
                    "stateSaveParams": function(settings, data) {
                        data.search.search = ""
                        data.order = [
                            [2, "desc"]
                        ]
                    }
                })
            })
        </script>
    @endsection
</x-app-layout>
