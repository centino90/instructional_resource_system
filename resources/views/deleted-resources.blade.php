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

    @if (session()->exists('status'))
        <div class="my-4">
            <x-alert-success>
                <strong>Success</strong> {{ session()->get('message') }}

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
                <div class="d-flex mb-3">
                    <x-form-update action="{{ route('deleted-resources.update', 'all') }}" class="ms-auto">
                        <x-button class="btn-success me-2" type="submit" data-form="put-all">

                            <strong>Restore all</strong>
                        </x-button>
                    </x-form-update>

                    <x-form-delete action="{{ route('deleted-resources.destroy', 'all') }}">
                        <x-button class="btn-danger" type="submit" data-form="delete-all">

                            <strong>Permenently delete all</strong>
                        </x-button>
                    </x-form-delete>
                </div>

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
                                            Restore
                                        </x-button>
                                    </x-form-update>

                                    <form action="{{ route('deleted-resources.destroy', $resource->id) }}"
                                        class="px-0" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <x-button class="btn-danger col-12" type="submit" data-form="delete">
                                            Delete permanently
                                        </x-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card-body>
        </div>
    </div>

    @section('script')
        <script>
            $('[data-form="delete"], [data-form="put"], [data-form="delete-all"], [data-form="put-all"]').click(function(
            event) {
                let m;
                if ($(this).attr('data-form') == 'delete-all') {
                    m =
                        'Danger Alert! Are you sure you want to proceed? Confirming this will permanently delete all of the deleted resources in this page';
                } else if ($(this).attr('data-form') == 'put-all') {
                    m =
                        'Warning Alert! Are you sure you want to proceed? Confirming this will restore all of the deleted resources in this page';
                } else if ($(this).attr('data-form') == 'delete') {
                    m =
                        'Warning Alert! Are you sure you want to proceed? Confirming this will delete that resource';
                }

                let c = confirm(m);

                if (!c) {
                    event.preventDefault();
                    $(this).removeClass('disabled loading');
                }
            })
        </script>
    @endsection
</x-app-layout>
