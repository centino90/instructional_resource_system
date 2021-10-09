<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link href="https://releases.transloadit.com/uppy/v2.1.1/uppy.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="font-sans antialiased">
    {{-- @include('layouts.topnav') --}}
    <button class="d-lg-none btn btn-dark position-fixed start-0 bottom-0 ms-3 mb-3 sidebar-menu-btn"
        style="z-index: 100" type="button" role="button" aria-controls="offcanvasExample">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-menu">
            <line x1="3" y1="12" x2="21" y2="12" />
            <line x1="3" y1="6" x2="21" y2="6" />
            <line x1="3" y1="18" x2="21" y2="18" />
        </svg>
    </button>

    <!-- Page Heading -->

    <div class="bg-light d-flex">
        @include('layouts.leftnav')

        <main class="container-fluid pb-5 pt-2 px-3">
            @include('layouts.topnav')
            
            {{ $header }}

            {{ $slot }}
        </main>
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="https://releases.transloadit.com/uppy/v2.1.1/uppy.min.js"></script> --}}
    {{-- <script src="node_modules/blueimp-file-upload/js/jquery.fileupload.js"></script> --}}
    @yield('script')
    <script>
        $(function() {

            // $('#fileupload').fileupload();

            // var uppy = new Uppy.Core()
            //     .use(Uppy.Dashboard, {
            //         trigger: '.UppyModalOpenerBtn',
            //         inline: true,
            //         target: '#drag-drop-area',
            //         showProgressDetails: true,
            //         note: 'Images and video only, 2–3 files, up to 1 MB',
            //         height: 470,
            //         metaFields: [{
            //                 id: 'name',
            //                 name: 'Name',
            //                 placeholder: 'file name'
            //             },
            //             {
            //                 id: 'caption',
            //                 name: 'Caption',
            //                 placeholder: 'describe what the image is about'
            //             }
            //         ],
            //         browserBackButtonClose: false
            //     })
            //     // .use(Uppy.FileInput, {
            //     //     target: '#file',
            //     //     pretty: true,
            //     //     inputName: 'files[]',
            //     //     locale: {
            //     //         strings: {
            //     //             chooseFiles: 'Choose files',
            //     //         },
            //     //     },
            //     // })

            //     .use(Uppy.XHRUpload, {
            //         endpoint: 'http://localhost:8000/upload-temporary-files/',
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },

            //         formData: true,
            //         fieldName: 'file[]'
            //     })


            // uppy.on('complete', (result) => {
            //     console.log('Upload complete! We’ve uploaded these files:', result.successful)
            // })

        });
    </script>
</body>

</html>
