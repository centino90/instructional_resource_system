<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Courses</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Courses') }}
            </small>

            <div class="ms-auto">
            </div>
        </div>
    </x-slot>

    <div class="my-4">
        @if (session()->exists('success'))
            <x-alert-success class="mb-3">
                {{ session()->get('success') }}
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
                                <div class="row g-2">
                                    <a href="{{ route('resources.download', ['all', 'course_id' => $course->id]) }}"
                                        class="btn btn-primary">Download resources</a>
                                    <a href="{{ route('courses.show', $course->id) }}"
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
