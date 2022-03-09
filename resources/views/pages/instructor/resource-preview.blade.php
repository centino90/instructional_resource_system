<x-app-layout>
    <x-slot name="header">
        {{$resource->title}}
    </x-slot>

    <x-slot name="headerTitle">
        Resource title
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('instructor.resource.show', $resource->id) }}"><- Go back</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('instructor.course.index') }}">Courses</a></li>
        <li class="breadcrumb-item"><a href="{{ route('instructor.course.show', $resource->course->id) }}">{{$resource->course->code}}</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('instructor.resource.show', $resource->id) }}">{{$resource->title}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">preview</li>
    </x-slot>

    <div class="row">
        <div class="col-lg-3">
            <div class="p-3 bg-white rounded shadow-sm">
                <h6 class="pb-2 border-bottom">Some actions</h6>

                <div class="gap-2 d-lg-grid">
                    <button class="btn btn-secondary">Fullscreen</button>
                    <button class="btn btn-primary">Download Original</button>
                    <button class="btn btn-danger">Download as PDF</button>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="bg-white shadow-sm overflow-auto p-3" style="min-height: 500px">
                <header class="pb-2 overflow-hidden border-bottom">
                    <h6 class="text-truncate d-block my-0 fw-bolder">{{$resource->getFirstMedia()->file_name}}</h6>

                    <small class="text-muted">File name</small>
                </header>

                <div id="previewContainer" class="mt-2"></div>
            </div>
        </div>
    </div>


    @section('script')
        <script>
            $(document).ready(function() {
                let previewFiletype = '{{ $fileType ?? '' }}'
                let previewResourceUrl = '{{ $resourceUrl ?? '' }}'
                let previewResourceText = `{{ $resourceText ?? '' }}`

                if (previewFiletype === 'text_filetypes') {
                    $('#previewContainer').append(
                        '<textarea class="preview-resource-summernote" id="previewGeneralSummernote"></textarea>'
                    )
                    $('#previewContainer').summernote({
                        'toolbar': [],
                        codeviewFilter: false,
                        codeviewIframeFilter: true
                    })
                    $('#previewContainer').summernote(
                        'code',
                        previewResourceText)
                    $('#previewContainer').summernote(
                        'disable')
                }

                if (previewFiletype === 'img_filetypes') {
                    $('#previewContainer').append(
                        `<img style="width: 100%" src="${previewResourceUrl}" />`
                    )
                }

                if (previewFiletype === 'video_filetypes') {
                    $('#previewContainer').append(
                        `<video width="320" height="240" controls autoplay>
                                                <source src="${previewResourceUrl}" type="video/mp4">
                                            </video>`
                    )
                }

                if (previewFiletype === 'audio_filetypes') {
                    $('#previewContainer').append(
                        `<audio controls autoplay>
                                                <source src="${previewResourceUrl}" type="audio/mpeg">
                                            </audio>`
                    )
                }
            })
        </script>
    @endsection
</x-app-layout>
