<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Resources</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Resources') }}
            </small>

            <div class="ms-auto">
                <a href="{{ route('resources.create') }}" class="btn btn-success">
                    {{ __('Create resource') }}
                </a>
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
        @endif

        <x-alert-warning>
            You still have not created a single resource this semester!
            <a href="#"><strong class="px-2">Create now?</strong></a>
        </x-alert-warning>
    </div>

    <div class="row">
        <div class="col-12 mb-3">
            <x-card-body>
                <x-table>
                    <x-slot name="thead">
                        <th>#</th>
                        <th>File</th>
                        <th>Description</th>
                        <th>Last update</th>
                        <th></th>
                    </x-slot>

                    @foreach ($resources as $resource)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="text-muted">
                                    <span class="text-muted">
                                        Submitted by
                                        @if ($resource->user_id != auth()->id())
                                            <strong>
                                                {{ ucwords($resource->users->first()->name ?? 'unknown user') }}
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

                            <td>{{ \Carbon\Carbon::parse($resource->updated_at)->format('M d Y') }}</td>

                            <td>
                                @if (!$resource->auth->first())
                                    <x-form-post action="{{ route('saved-resources.store') }}" class="px-0"
                                        method="post">
                                        <x-input value="{{ $resource->id }}" name="resource_id" hidden></x-input>

                                        <x-button class="btn-secondary col-12" type="submit">Save
                                        </x-button>
                                    </x-form-post>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card-body>
        </div>

        <div class="col-12 mb-3">
            <h5>History log</h5>

            @foreach ($activities as $activity)
                <span>
                    <b>{{ $activity->causer->name ?? 'unknown user' }}</b>
                    {{ $activity->description }}
                    {{ $activity->subject->getMedia()[0]->file_name ?? 'not available' }}
                    <small class="badge rounded-pill bg-success mx-1">{{ $loop->index == 0 ? 'latest' : '' }}</small>
                </span>

                <div class="lh-1 mb-1">
                    <small
                        class="text-muted">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->created_at)->diffForHumans() }}</small>
                </div>
            @endforeach
            <div class="my-2">
                <small class="text-muted">
                    <a href="#">Click to view more</a>
                </small>
            </div>
        </div>
    </div>
</x-app-layout>
