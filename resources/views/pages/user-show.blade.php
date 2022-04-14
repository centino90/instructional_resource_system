<x-app-layout>
    @if ($user->id == auth()->id())
        <x-slot name="header">
            My Profile
        </x-slot>
        <x-slot name="breadcrumb">
            <li class="breadcrumb-item">
                <a class="fw-bold" href="{{ route('dashboard') }}">
                    <- Go back </a>
            </li>

            <li class="breadcrumb-item active">
                My Profile
            </li>
        </x-slot>
    @else
        <x-slot name="header">
            User Profile ({{ $user->name }})
        </x-slot>

        <x-slot name="breadcrumb">
            <li class="breadcrumb-item">
                <a class="fw-bold" href="{{ route('user.index') }}">
                    <- Go back </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('user.index') }}">Users</a>
            </li>

            <li class="breadcrumb-item active">
                User Profile ({{ $user->name }})
            </li>
        </x-slot>
    @endif


    <div class="row g-3">
        <div class="col-4">
            <div class="row g-3">
                <div class="col-12">
                    <x-real.card>
                        <x-slot name="header">Profile Summary</x-slot>
                        <x-slot name="body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <x-real.text-with-subtitle>
                                        <x-slot name="text">{{ $user->name }}</x-slot>
                                        <x-slot name="subtitle">Name</x-slot>
                                    </x-real.text-with-subtitle>
                                </li>
                                <li class="list-group-item">
                                    <x-real.text-with-subtitle>
                                        <x-slot name="text">{{ $user->role->name }}</x-slot>
                                        <x-slot name="subtitle">Role</x-slot>
                                    </x-real.text-with-subtitle>
                                </li>
                                <li class="list-group-item">
                                    <x-real.text-with-subtitle>
                                        <x-slot name="text">
                                            <ul class="nav gap-2">
                                                @foreach ($user->programs as $program)
                                                    @if (!$loop->first)
                                                        <div class="vr"></div>
                                                    @endif
                                                    <li class="nav-item">
                                                        {{ $program->code }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </x-slot>
                                        <x-slot name="subtitle">Program(s)</x-slot>
                                    </x-real.text-with-subtitle>
                                </li>
                            </ul>
                        </x-slot>
                    </x-real.card>
                </div>

                <div class="col-12">
                    <x-real.card :vertical="'center'">
                        <x-slot name="header">Activities Summary</x-slot>
                        <x-slot name="action">
                            <x-real.btn :tag="'a'" :size="'sm'"
                                href="{{ route('user.activities', $user) }}">View more</x-real.btn>
                        </x-slot>
                        <x-slot name="body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <x-real.text-with-subtitle>
                                        <x-slot name="text">
                                            {{ $user->activityLogs()->latest()->first()->created_at->diffForHumans() }}
                                        </x-slot>
                                        <x-slot name="subtitle">Last Activity</x-slot>
                                    </x-real.text-with-subtitle>
                                </li>
                                <li class="list-group-item hstack justify-content-between">
                                    <x-real.text-with-subtitle>
                                        <x-slot name="text">
                                            {{ isset($user->activitiesByLogName['lesson-created'])? $user->activitiesByLogName['lesson-created']->count(): 0 }}
                                        </x-slot>
                                        <x-slot name="subtitle">Lessons Created</x-slot>
                                    </x-real.text-with-subtitle>

                                    <x-real.btn :tag="'a'" :size="'sm'"
                                        href="{{ route('user.lessons', $user) }}">View more</x-real.btn>
                                </li>
                                <li class="list-group-item hstack justify-content-between">
                                    <x-real.text-with-subtitle>
                                        <x-slot name="text">
                                            {{ isset($user->activitiesByLogName['resource-created'])? $user->activitiesByLogName['resource-created']->count(): 0 }}
                                        </x-slot>
                                        <x-slot name="subtitle">Total Submissions</x-slot>
                                    </x-real.text-with-subtitle>

                                    <x-real.btn :tag="'a'" :size="'sm'"
                                        href="{{ route('user.submissions', $user) }}">View more</x-real.btn>
                                </li>
                                @if ($user->id == auth()->id())
                                    <li class="list-group-item hstack justify-content-between">
                                        <x-real.text-with-subtitle>
                                            <x-slot name="text">
                                                {{ $fileCount }}
                                            </x-slot>
                                            <x-slot name="subtitle">Files created</x-slot>
                                        </x-real.text-with-subtitle>
                                        <x-real.btn :tag="'a'" :size="'sm'"
                                            href="{{ route('storage.show', [$user, 'leftPath' => 'users/' . $user->id]) }}">
                                            View more</x-real.btn>
                                    </li>
                                @endif
                                <li class="list-group-item">
                                    <x-real.text-with-subtitle>
                                        <x-slot name="text">
                                            {{ isset($user->activitiesByLogName['user-loggedin'])? $user->activitiesByLogName['user-loggedin']->count(): 0 }}
                                        </x-slot>
                                        <x-slot name="subtitle">Total Daily Signins</x-slot>
                                    </x-real.text-with-subtitle>
                                </li>
                            </ul>
                        </x-slot>
                    </x-real.card>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="row g-3">
                <div class="col-12">
                    <x-real.card>
                        <x-slot name="header">Personal Information</x-slot>
                        <x-slot name="body">
                            <x-real.form action="{{ route('user.updatePersonal', $user) }}" method="PUT">
                                <x-real.input name="fname" value="{{ $user->fname }}">
                                    <x-slot name="label">First name</x-slot>
                                </x-real.input>
                                <x-real.input name="lname" value="{{ $user->lname }}">
                                    <x-slot name="label">Last name</x-slot>
                                </x-real.input>

                                <hr class="mt-5 border">

                                <x-slot name="submit">
                                    <x-real.btn>Submit</x-real.btn>
                                </x-slot>
                            </x-real.form>
                        </x-slot>
                    </x-real.card>
                </div>

                <div class="col-12">
                    <x-real.card>
                        <x-slot name="header">Account Information</x-slot>
                        <x-slot name="action">
                            <ul class="nav nav-pills justify-content-end gap-3" id="courseLessonsTab" role="tablist">
                                <li class="nav-item p-0" role="presentation">
                                    <button class="nav-link py-0 text-dark rounded-0 active" id="allCourseLessonsTab"
                                        data-bs-toggle="pill" data-bs-target="#allCourseLessonsTabPane" type="button"
                                        role="tab">
                                        <small>Change username</small></button>
                                </li>
                                <li class="nav-item p-0" role="presentation">
                                    <button class="nav-link py-0 text-dark rounded-0" id="archivedCourseLessonsTab"
                                        data-bs-toggle="pill" data-bs-target="#archivedCourseLessonsTabpane"
                                        type="button" role="tab">
                                        <small>Change password</small>
                                    </button>
                                </li>
                            </ul>
                        </x-slot>
                        <x-slot name="body">
                            <div class="tab-content" id="courseLessonsTabcontent">
                                <div class="tab-pane fade show active" id="allCourseLessonsTabPane" role="tabpanel">
                                    <x-real.form action="{{ route('user.updateUsername', $user) }}" method="PUT">
                                        <x-real.input name="username" value="{{ $user->username }}">
                                            <x-slot name="label">Username</x-slot>
                                        </x-real.input>

                                        <hr class="mt-5 border">

                                        <x-slot name="submit">
                                            <x-real.btn>Submit</x-real.btn>
                                        </x-slot>
                                    </x-real.form>
                                </div>
                                <div class="tab-pane fade" id="archivedCourseLessonsTabpane" role="tabpanel">
                                    <x-real.form action="{{ route('user.updatePassword', $user) }}" method="PUT">
                                        <x-real.input name="password">
                                            <x-slot name="label">New Password</x-slot>
                                        </x-real.input>
                                        <x-real.input name="confirm_password">
                                            <x-slot name="label">Confirm New Password</x-slot>
                                        </x-real.input>

                                        <hr class="mt-5 border">

                                        <x-slot name="submit">
                                            <x-real.btn>Submit</x-real.btn>
                                        </x-slot>
                                    </x-real.form>
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

            })
        </script>
    @endsection
</x-app-layout>
