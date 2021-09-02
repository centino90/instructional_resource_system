<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Saved resources</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Saved resources') }}
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
            </x-alert-success>
        @endif

        @if (session()->exists('success-destroyed-saved'))
            <x-alert-success class="mb-3">
                {{ session()->get('success-destroyed-saved') }}

                <x-form-post action="{{ route('saved-resources.store') }}">
                    <input type="hidden" name="resource_id" value="{{ session()->get('resource_id') }}">

                    <x-button type="submit" class="btn btn-link">
                        <strong>Revert your action?</strong>
                    </x-button>
                </x-form-post>
            </x-alert-success>
        @elseif (session()->exists('success-destroyed-resource'))
            <x-alert-success class="mb-3">
                {{ session()->get('success-destroyed-resource') }}

                <x-form-post action="{{ route('deleted-resources.update', session()->get('resource_id')) }}">
                    @csrf
                    @method('PUT')

                    <x-button type="submit" class="btn btn-link">
                        <strong>Revert your action?</strong>
                    </x-button>
                </x-form-post>
            </x-alert-success>
        @endif

        <x-alert-warning>
            You still have not created a single resource this semester!
            <a href="#"><strong class="px-2">Create now?</strong></a>
        </x-alert-warning>
    </div>

    <div class="row">
        <div class="col-12">
            <x-card-body>
                <x-table>
                    <x-slot name="thead">
                        <th scope="col">#</th>
                        <th scope="col">File</th>
                        <th scope="col">Description</th>
                        <th scope="col">Uploaded on</th>
                        <th scope="col">Last update</th>
                        <th></th>
                    </x-slot>

                    @foreach ($resources as $resource)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>
                                <div class="text-muted">
                                    <span class="text-muted">
                                        Submitted by
                                        @if ($resource->user_id != auth()->id())
                                            <strong>
                                                {{ ucwords($resource->users[0]->name) }}
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
                            <td>{{ $resource->courses->code }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($resource->updated_at)->format('M d Y') }}
                            </td>
                            <td>
                                <div class="row g-2">
                                    @isset($resource->getMedia()[0])
                                        <a href="{{ route('resources.download', $resource->id) }}"
                                            class="btn btn-primary">Download</a>
                                    @endisset

                                    @if (!$resource->pivot->is_important)
                                        <form action="{{ route('important-resources.update', $resource->id) }}"
                                            class="px-0" method="post">
                                            @csrf
                                            @method('PUT')

                                            <x-button class="btn-secondary col-12" type="submit">Add to important
                                            </x-button>
                                        </form>
                                    @endif

                                    @if ($resource->user_id != auth()->id())
                                        <form action="{{ route('saved-resources.destroy', $resource->id) }}"
                                            class="px-0" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <x-button class="btn-secondary col-12" type="submit">Unsave
                                            </x-button>
                                        </form>
                                    @else
                                        <form action="{{ route('resources.destroy', $resource->id) }}"
                                            class="px-0" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <x-button class="btn-danger col-12" type="submit">Delete</x-button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card-body>
        </div>
    </div>
</x-app-layout>
