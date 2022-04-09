<x-app-layout>
    @if ($user->id == auth()->id())
        <x-slot name="header">
            My Notifications
        </x-slot>
        <x-slot name="breadcrumb">
            <li class="breadcrumb-item">
                <a class="fw-bold" href="{{ route('dashboard') }}">
                    <- Go back </a>
            </li>

            <li class="breadcrumb-item active">
                My Notifications
            </li>
        </x-slot>
    @else
        <x-slot name="header">
            Notifications
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
                Notifications
            </li>
        </x-slot>
    @endif

    <div class="row g-3">
        <div class="col-12">
            <div class="row g-3">
                <div class="col-md-4">
                    <x-real.card>
                        <x-slot name="header">Filter by</x-slot>
                        <x-slot name="body">
                            @if ($notifications->count() > 0)
                                <x-real.input :type="'select'">
                                    <x-slot name="options">
                                        <x-slot name="label">Type</x-slot>
                                        @foreach ($notifications->groupBy('type')->keys() as $type)
                                            @php
                                                $type = collect(explode('\\', $type))->pop();
                                            @endphp
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </x-slot>
                                </x-real.input>
                            @else
                                <x-real.alert :variant="'warning'" :dismiss="false" class="justify-content-center">
                                    There are no notifications yet
                                </x-real.alert>
                            @endif
                        </x-slot>
                    </x-real.card>
                </div>

                <div class="col-md-8">
                    <x-real.card>
                        <x-slot name="header">
                            Notifications
                        </x-slot>
                        <x-slot name="action">
                            <ul class="nav nav-pills justify-content-end gap-3" id="notificationCardTab" role="tablist">
                                <li class="nav-item p-0" role="presentation">
                                    <button class="nav-link py-0 text-dark rounded-0 active"
                                        id="notificationCardFormTab" data-bs-toggle="pill"
                                        data-bs-target="#notificationCardFormTabpane" type="button"
                                        role="tab">New</button>
                                </li>
                                <li class="nav-item p-0" role="presentation">
                                    <button class="storageUploadStandaloneBtn nav-link py-0 text-dark rounded-0"
                                        id="notificationCardUrlTab" data-bs-toggle="pill"
                                        data-bs-target="#notificationCardUrlTabpane" type="button" role="tab">
                                        Viewed
                                    </button>
                                </li>
                            </ul>
                        </x-slot>
                        <x-slot name="body">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="notificationCardFormTabpane" role="tabpanel">
                                    <x-real.table class="notificationsTable">
                                        <x-slot name="headers">
                                            <th>Message</th>
                                            <th></th>
                                        </x-slot>
                                        <x-slot name="rows">
                                            @foreach ($notifications->whereNull('read_at') as $notification)
                                                <tr>
                                                    <td>{{ $notification->data['message'] }}</td>
                                                    <td><a class="notification-show-link"
                                                            data-passover="{{ $notification->id }}"
                                                            href="{!! $notification->data['link'] !!}">View</a></td>
                                                </tr>
                                            @endforeach
                                        </x-slot>
                                    </x-real.table>
                                </div>
                                <div class="tab-pane fade" id="notificationCardUrlTabpane" role="tabpanel">
                                    <x-real.table class="notificationsTable">
                                        <x-slot name="headers">
                                            <th>Message</th>
                                            <th></th>
                                        </x-slot>
                                        <x-slot name="rows">
                                            @foreach ($notifications->whereNotNull('read_at') as $notification)
                                                <tr>
                                                    <td>{{ $notification->data['message'] }}</td>
                                                    <td>
                                                        <x-real.form
                                                            action="{{ route('notifications.read', $notification) }}"
                                                            :method="'PUT'">
                                                            <x-slot name="submit">
                                                                <x-real.btn :size="'sm'">Review</x-real.btn>
                                                            </x-slot>
                                                        </x-real.form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </x-slot>
                                    </x-real.table>
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


                const subjectLesson = `{{ session()->get('subjectLesson') }}`;
                if (subjectLesson) {
                    const $scrolledToElement = $(`#lesson${subjectLesson}`)
                    $scrolledToElement.addClass('scrolled-focus')
                }

                $('.logsTable, .notificationsTable').DataTable({
                    "bStateSave": true,
                    "stateSaveParams": function(settings, data) {
                        data.search.search = ""
                        data.order = [
                            [2, "desc"]
                        ]
                    }
                })

                const exampleModal = document.getElementById('courseLessonModal')
                exampleModal.addEventListener('show.bs.modal', function(event) {
                    const $button = $(event.relatedTarget)

                    const $recipient = $button.attr('data-bs-title')
                    const $mode = $button.attr('data-bs-mode')
                    const $lessonId = $button.attr('data-bs-lesson-id')
                    const $toggleType = $button.attr('data-bs-toggle-type')

                    const $lessonTitle = $button.closest('tr').find('.lessonTitle')
                    const $lessonDescription = $button.closest('tr').find('.lessonDescription')

                    // Update the modal's content.
                    const $lessonCollapsedDiv = $(this).find(`.${$mode}Lesson`)
                    const $modalTitle = $(this).find('.modal-title')
                    const $collapsedForm = $lessonCollapsedDiv.find('form')

                    $collapsedForm.find('[name="title"]').val($lessonTitle.text().trim())
                    $collapsedForm.find('[name="description"]').val($lessonDescription.text().trim())
                    $collapsedForm.attr('action',
                        `{{ route('lesson.index') }}/${$lessonId}${$.inArray($mode, ['archive', 'archive-remove']) != -1 ? '/archive' : ''}`
                    )
                    if ($toggleType == 'remove') {
                        $lessonCollapsedDiv.find('.confirmAlert').text(
                            `Do you want to remove this lesson from ${$mode}?`)
                        let regex = new RegExp(`${$mode}`, 'gi');
                        $modalTitle.text($recipient.replace(regex, `Remove from ${$mode}`))
                    } else {
                        $lessonCollapsedDiv.find('.confirmAlert').text(
                            `Do you want to move this lesson to ${$mode}?`)
                        $modalTitle.text($recipient)
                    }
                    $lessonCollapsedDiv.show()

                })

                exampleModal.addEventListener('hidden.bs.modal', function(event) {
                    $(this).find('.collapse').hide()
                })
            })
        </script>
    @endsection
</x-app-layout>
