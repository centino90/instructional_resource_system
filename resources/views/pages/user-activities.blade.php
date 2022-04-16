<x-app-layout>
    @if ($user->id == auth()->id())
        <x-slot name="header">
            My Activities
        </x-slot>
        <x-slot name="breadcrumb">
            <li class="breadcrumb-item">
                <a class="fw-bold" href="{{ route('dashboard') }}">
                    <- Go back </a>
            </li>

            <li class="breadcrumb-item active">
                My Activities
            </li>
        </x-slot>
    @else
        <x-slot name="header">
            Activities
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
                Activities
            </li>
        </x-slot>
    @endif

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
                <div class="col-md-4">
                    <x-real.card>
                        <x-slot name="header">Filter by</x-slot>
                        <x-slot name="body">
                            w
                        </x-slot>
                    </x-real.card>
                </div>

                <div class="col-md-8">
                    <div class="tab-pane fade show active" id="tabpaneActivityLogs" role="tabpanel">
                        <x-real.card>
                            <x-slot name="header">
                                Logs
                            </x-slot>
                            <x-slot name="body">
                                <x-real.table class="logsTable">
                                    <x-slot name="headers">
                                        <th>Log name</th>
                                        <th>Description</th>
                                        <th>Logged at</th>
                                        <th>Updated properties</th>
                                        <th></th>
                                    </x-slot>
                                    <x-slot name="rows">
                                        @foreach ($userLogs as $log)
                                            <tr>
                                                <td>{{ explode('-', $log->log_name)[1] . ' a ' . explode('-', $log->log_name)[0] }}
                                                </td>
                                                <td>{{ $log->description }}</td>
                                                <td>{{ $log->created_at }}</td>
                                                <td>
                                                    <div class="overflow-hidden line-clamp" style="max-width: 300px" >
                                                        <code>
                                                            {{ json_encode($log->properties) }}
                                                        </code>
                                                    </div>
                                                </td>
                                                <td>
                                                    <x-real.btn href="{{route('activities.show', $log)}}" :tag="'a'" :size="'sm'">View more</x-real.btn>
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
    </div>

    @section('script')
        <script>
            $(document).ready(function() {
                $('.logsTable').DataTable({
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
