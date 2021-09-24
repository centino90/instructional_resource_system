<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notifications</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Unread Notifications') }}
            </small>

            <div class="ms-auto">
            </div>
        </div>
    </x-slot>

    <div class="my-4">
        @if (session()->exists('success'))
            <x-alert-success class="mb-3">
                {{ session()->get('success') }}

                <a href="{{ route('resources.create') }}"><strong class="px-2">Go back to creating
                        resource?</strong></a>
            </x-alert-success>

        @elseif(session()->get('status') == 'success')
            <x-alert-success class="mb-3">
                <strong>Success!</strong> {{ session()->get('message') }}
            </x-alert-success>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            @forelse ($notifications as $notification)
                @isset($notification->data['program_id'])
                    @if ($notification->data['program_id'] == auth()->user()->program_id)
                        <div class="alert alert-success">
                            [{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->toDayDateTimeString() }}]
                            {{ $notification->data['user'] }} created a

                            @if (isset($notification->data['resource_id']))
                                <a class="notification-show-link text-decoration-none"
                                    href="{{ route('pending-resources.show', $notification->data['resource_id']) }}"
                                    data-passover="{{ $notification->id }}">
                                    <b> syllabus [{{ $notification->data['file_name'] }}]</b>
                                </a>
                                on {{ $notification->data['course_code'] }}
                                <i>Click to read</i>
                            @else
                                {{ $notification->data['file_name'] }}
                            @endisset
                    </div>
                @endif
            @endisset
        @empty
            There are no notifications
        @endforelse

        <div>
            <a href="{{ route('notifications.index', ['view' => 'read-notifications']) }}">View read
                notifications</a>
        </div>
    </div>
</div>

@section('script')
    <script>
        $('.notification-show-link').click(function(event) {
            event.preventDefault();
            let href = $(this).attr('href')
            let notifId = $(this).attr('data-passover')
            let formRoute = '{{ route('notifications.update', '') }}'

            $.ajax({
                url: `${formRoute}/${notifId}`,
                type: 'POST',
                data: {
                    notifId: notifId,
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT'
                },
                success: function(result) {
                    if (result.status === 200) {
                        location.href = href
                    }
                },
                error: function() {
                    alert('error');
                },
            })
        })

        $('.storeSavedresourceHiddenSubmit').click(function() {
            let form = $($(this).attr('data-form-target'))
            let passoverData = $(this).attr('data-passover')
            let input = form.find('input[name="resource_id"]')
            input.val(passoverData)

            form.submit()
        })

        $('#download-bulk').click(function(e) {
            e.preventDefault()
            let downloadBtn = $(this)
            let table = $(this.closest('table'))
            let checkboxes = table.find('th:first-child .check, td:first-child .check')
            $(checkboxes).each(function() {
                if ($(this).is(":checked")) {
                    $(this).closest('th, td').find(':hidden').removeAttr('disabled')
                } else {
                    $(this).closest('th, td').find(':hidden').attr('disabled', 'disabled')
                }
            })

            table.closest('form').submit();
            checkboxes.prop('checked', false);
            downloadBtn.removeClass('loading')
        })

        $('#check-all').change(function(e) {
            let table = $(this.closest('table'))
            let checkboxes = table.find('td:first-child .check')

            if ($(this).is(':checked')) {
                checkboxes.prop('checked', true)
            } else {
                checkboxes.prop('checked', false)
            }
        })

        $('.check').change(function(e) {
            let table = $(this.closest('table'))
            let downloadBtn = table.find('#download-bulk')
            let checkboxes = table.find('td:first-child .check')
            let currentCheckbox = $(this)

            if (checkboxes.filter(':checked').length > 0) {
                downloadBtn.removeClass('disabled')
                console.log('yes')
            } else {
                downloadBtn.addClass('disabled')
            }
        })
    </script>
@endsection
</x-app-layout>
