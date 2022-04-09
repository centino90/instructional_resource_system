<x-app-layout>
    <x-slot name="header">
        Versions
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('resource.show', $resource) }}">
                <- Go back</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('course.show', $resource->course) }}">{{ $resource->course->code }}</a></li>
        @if (!$resource->is_syllabus)
            <li class="breadcrumb-item"><a href="{{ route('course.showLessons', $resource->course) }}">Course
                    lessons</a>
            </li>

            <li class="breadcrumb-item"><a
                    href="{{ route('lesson.show', $resource->lesson) }}">{{ $resource->lesson->title }}</a></li>
        @endif
        <li class="breadcrumb-item"><a href="{{ route('resource.show', $resource) }}">{{ $resource->title }}</a></li>

        <li class="breadcrumb-item active" aria-current="page">versions</li>
    </x-slot>

    <div class="row">
        <div class="col-lg-3">
            <x-real.card>
                <x-slot name="header">Some actions</x-slot>
                <x-slot name="body">
                    <div class="gap-2 d-lg-grid">
                        <a href="{{ route('resource.createNewVersion', $resource->id) }}"
                            class="btn btn-secondary">Submit
                            New Version</a>
                    </div>
                </x-slot>
            </x-real.card>
        </div>

        <div class="col-lg-9">
            <x-real.card>
                <x-slot name="header">
                    List of {{ $resource->title }}'s media versions
                </x-slot>

                <x-slot name="body">
                    <ul class="list-group">
                        @foreach ($resource->getMedia()->sortByDesc('order_column') as $media)
                            <li class="list-group-item hstack gap-3 position-relative">
                                @if ($loop->index == 0)
                                    <span
                                        class="position-absolute top-0 start-0 badge bg-primary text-white m-3">LATEST</span>
                                @endif

                                <x-real.text-with-subtitle class="col">
                                    <x-slot name="text">{{ $media->file_name }}</x-slot>
                                </x-real.text-with-subtitle>

                                <x-real.text-with-subtitle class="col">
                                    <x-slot name="text">{{ $media->created_at }}</x-slot>
                                    <x-slot name="subtitle">Submitted on</x-slot>
                                </x-real.text-with-subtitle>
                                <x-real.text-with-subtitle class="col">
                                    <x-slot name="text">{{ $media->model->user->username }}</x-slot>
                                    <x-slot name="subtitle">Submitted by</x-slot>
                                </x-real.text-with-subtitle>


                                <div class="col">
                                    <div class="vstack gap-2">
                                        <a href="{{ route('resource.preview', [$resource->id, 'mediaId' => $media->id]) }}"
                                            class="btn btn-light btn-sm border text-primary fw-bold">Preview</a>
                                        <a href="{{ route('resources.download', [$resource->id, 'mediaId' => $media->id]) }}"
                                            class="btn btn-light btn-sm border text-primary fw-bold">Download</a>

                                        @if ($loop->index > 0)
                                            @if ($resource->verificationStatus != 'Pending')
                                                <x-real.form :method="'PUT'"
                                                    action="{{ route('resource.toggleCurrentVersion', [$resource->id, $media->id]) }}">
                                                    <x-slot name="submit">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm w-100">Assign as
                                                            Current</button>
                                                    </x-slot>
                                                </x-real.form>
                                            @endif
                                        @else
                                            @if ($resource->verificationStatus == 'Pending')
                                                @php
                                                    $route = route('resource.storeNewVersion', $resource);
                                                    if ($resource->resourceType == 'syllabus') {
                                                        $route = route('syllabi.storeNewVersion', $resource);
                                                    } elseif ($resource->resourceType == 'presentation') {
                                                        $route = route('presentations.storeNewVersion', $resource);
                                                    }
                                                @endphp

                                                <x-real.form action="{{ $route }}">
                                                    <input type="hidden" name="course_id"
                                                        value="{{ $resource->course->id }}">

                                                    <x-slot name="submit">
                                                        <x-real.btn :size="'sm'" type="submit" :btype="'solid'"
                                                            :variant="'warning-dark'" class="w-100">
                                                            Continue
                                                            Validation
                                                        </x-real.btn>
                                                    </x-slot>
                                                </x-real.form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </x-slot>
            </x-real.card>
        </div>
    </div>


    @section('script')
        <script>
            $(document).ready(function() {

            })
        </script>
    @endsection
</x-app-layout>
