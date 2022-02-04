<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Programs</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex bg-white p-3 mt-3 rounded shadow-sm mb-3">
            <div>
                <small class="h3 font-weight-bold">
                    {{ __('Programs') }}
                </small>
            </div>

            <div class="ms-auto">
                <a href="{{ route('admin.programs.create') }}" class="btn btn-success">
                    {{ __('Create program') }}
                </a>
            </div>
        </div>

        <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.dashboard') }}" class="nav-link rounded-0 px-4 border-bottom border-3 ">
                    Overview
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.programs.list') }}" class="nav-link rounded-0 px-4 border-bottom border-3 border-primary fw-bold">
                    Programs
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.courses.index') }}" class="nav-link rounded-0 px-4 border-bottom border-3">
                    Courses
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.personnels.index') }}" class="nav-link rounded-0 px-4 border-bottom border-3">
                    Members
                </a>
            </li>
        </ul>
    </x-slot>

    <div class="my-4">
        @if (session()->exists('success'))
            <x-alert-success class="mb-3">
                {{ session()->get('success') }}
            </x-alert-success>
        @endif
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <x-table>
                <x-slot name="thead">
                    <th scope="col">#</th>
                    <th scope="col">title</th>
                    <th></th>
                </x-slot>

                @foreach ($programs as $program)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $program->title }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <x-button.show :passover="route('admin.programs.show', $program->id)"></x-button.show>
                                <x-button.edit :passover="route('admin.programs.edit', $program->id)"></x-button.edit>

                                <x-form-delete action="{{ route('admin.programs.destroy', $program->id) }}">
                                </x-form-delete>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
    </div>

    @section('script')
        <script>
        </script>
    @endsection
</x-app-layout>
