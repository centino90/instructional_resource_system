<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete resources</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Delete resources') }}
            </small>

            {{-- HEADER ACTIONS SECTION --}}
            <div class="ms-auto"></div>
        </div>
    </x-slot>

    @if (session()->exists('success'))
        <div class="my-4">
            <x-alert-success>
                {{ session()->get('success') }}

                <a href="{{ route('saved-resources.index') }}">
                    <strong class="px-2">Go see the restored resources now?</strong>
                </a>
            </x-alert-success>
        </div>
    @endif

    {{-- CONTENT SECTION --}}
    <div class="row">
        <div class="col-12">
            <x-card-body>
                <x-form-update action="{{ route('deleted-resources.update', 'all') }}" class="d-flex mb-3 mx-1">
                    <x-button class="btn-success ms-auto" type="submit"
                        onclick="return confirm('Are you sure you want to proceed? Confirming this will restore all resources in the trash.')">

                        <strong>Remove all from trash</strong>
                    </x-button>
                </x-form-update>

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

                                    <x-form-update action="{{ route('deleted-resources.update', $resource->id) }}">

                                        <x-button type="submit" class="btn-success col-12">
                                            Remove from trash
                                        </x-button>
                                    </x-form-update>

                                    <form action="{{ route('deleted-resources.destroy', $resource->id) }}"
                                        class="px-0" method="post"
                                        onclick="return confirm('Are you sure you want to proceed? Confirming this action will permanently delete the file(s).')">
                                        @csrf
                                        @method('DELETE')

                                        <x-button class="btn-danger col-12" type="submit">Delete permanently</x-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card-body>
        </div>
    </div>
</x-app-layout>
