<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Courses</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex bg-white p-3 my-3 rounded shadow-sm">
            <small class="h4 font-weight-bold">
                {{ __('Courses') }}
            </small>

            <div class="ms-auto">
                <a href="{{ route('courses.create') }}" class="btn btn-success">
                    {{ __('Create course') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="my-4">
        @if (session()->exists('status'))
            <x-alert-success class="mb-3">
                {{ session()->get('message') }}
                <a href="{{route('courses.show', session()->get('course_id'))}}">Click to view</a>
            </x-alert-success>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <x-card-body>
                <x-table>
                    <x-slot name="thead">
                        <th scope="col">#</th>
                        <th scope="col">code</th>
                        <th scope="col">title</th>
                        <th></th>
                    </x-slot>

                    @foreach ($courses as $course)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $course->code }}</td>
                            <td>{{ $course->title }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('resources.download', ['all', 'course_id' => $course->id]) }}"
                                        class="btn btn-primary">Download resources</a>
                                    <a href="{{ route('courses.show', $course->id) }}"
                                        class="btn btn-secondary">View</a>

                                    @can('manage')
                                        <a href="{{ route('courses.edit', $course->id) }}"
                                            class="btn btn-secondary">Edit</a>
                                        <x-form-delete action="{{route('courses.destroy', $course->id)}}">
                                            <x-button :class="'btn-danger'" type="submit" onclick="return confirm('Are you sure you want to delete this course?')">Delete</x-button>
                                        </x-form-delete>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card-body>
        </div>
    </div>
</x-app-layout>
