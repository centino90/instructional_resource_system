<x-app-layout>
    <x-slot name="header">
        Update Resource
    </x-slot>

    <x-slot name="breadcrumb">
        @if ($resource->is_syllabus)
            <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('resource.show', $resource) }}">
                    <- Go back</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('course.show', $resource->course) }}">{{ $resource->course->code }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resource.show', $resource) }}">{{ $resource->title }}</a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">Update Resource</li>
        @else
            <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('resource.show', $resource) }}">
                    <- Go back</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('course.show', $resource->course) }}">{{ $resource->course->code }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('course.showLessons', $resource->course) }}">Course
                    lessons</a>
            </li>
            <li class="breadcrumb-item"><a
                    href="{{ route('lesson.show', $resource->lesson) }}">{{ $resource->lesson->title }}</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('resource.show', $resource) }}">{{ $resource->title }}</a></li>

            <li class="breadcrumb-item active" aria-current="page">Update Resource</li>
        @endif
    </x-slot>

    <div class="row">
        <div class="col-12">
            <x-real.card>
                <x-slot name="header">Update Form</x-slot>
                <x-slot name="body">
                    <x-real.form action="{{ route('resource.update', $resource) }}" :method="'PUT'">
                        <x-real.input name="title" value="{{ $resource->title }}">
                            <x-slot name="label">Resource title</x-slot>
                        </x-real.input>
                        <x-real.input :type="'textarea'" name="description" id="inp_description">
                            <x-slot name="label">Description</x-slot>
                        </x-real.input>
                        <x-slot name="submit">
                            <x-real.btn type="submit" :btype="'solid'">
                                Update
                            </x-real.btn>
                        </x-slot>
                    </x-real.form>
                </x-slot>
            </x-real.card>
        </div>
    </div>
    </div>


    @section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.4/jquery.simplePagination.min.js"
                integrity="sha512-J4OD+6Nca5l8HwpKlxiZZ5iF79e9sgRGSf0GxLsL1W55HHdg48AEiKCXqvQCNtA1NOMOVrw15DXnVuPpBm2mPg=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {
                $('#inp_description').val('{{ $resource->description }}')
            })
        </script>
    @endsection
</x-app-layout>
