<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Read Notifications</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Read Notifications') }}
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
            @forelse ($readNotifications as $notification)
                @isset($notification->data['program_id'])
                    @if ($notification->data['program_id'] == auth()->user()->program_id)
                        <div class="alert alert-success">
                            [{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->toDayDateTimeString() }}]
                            {{ $notification->data['user'] }} created a

                            @if (isset($notification->data['resource_id']))
                                <a class="notification-show-link text-decoration-none"
                                    href="{{ route('syllabi.show', $notification->data['resource_id']) }}"
                                    data-passover="{{ $notification->id }}">
                                    <b> syllabus [{{ $notification->data['file_name'] }}]</b>
                                </a>
                                on {{ $notification->data['course_code'] }}
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
            <a href="{{ route('notifications.index') }}">View unread
                notifications</a>
        </div>
    </div>
</div>

@section('script')
    <script>

    </script>
@endsection
</x-app-layout>
