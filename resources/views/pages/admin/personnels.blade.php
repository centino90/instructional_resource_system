<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Personnels</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex bg-white p-3 mt-3 rounded shadow-sm mb-3">
            <small class="h4 font-weight-bold">
                {{ __('Personnels') }}
            </small>

            <div class="ms-auto">
                <a href="{{route('admin.personnels.create')}}" class="btn btn-success">
                    {{ __('Create personnel') }}
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
                <a href="{{ route('admin.programs.list') }}" class="nav-link rounded-0 px-4 border-bottom border-3 ">
                    Programs
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.courses.index') }}" class="nav-link rounded-0 px-4 border-bottom border-3 ">
                    Courses
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.personnels.index') }}" class="nav-link rounded-0 px-4 border-bottom border-3 border-primary fw-bold">
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

    <div class="row">
        <div class="col-12">
            <x-card-body>
                <x-table>
                    <x-slot name="thead">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Role</th>
                        <th scope="col">Program</th>
                        <th></th>
                    </x-slot>

                    @foreach ($personnels as $personnel)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $personnel->name }}</td>
                            <td>{{ $personnel->role->name }}</td>
                            <td>
                                    @foreach ($personnel->programs as $program)
                                    <span class="badge bg-primary">{{$program->title}}</span>
                                    @endforeach
                            </td>
                            <td>
                                <div class="row g-2">
                                    <a href="{{ route('admin.personnels.show', $personnel->id) }}"
                                        class="btn btn-secondary">View</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card-body>
        </div>
    </div>
</x-app-layout>
