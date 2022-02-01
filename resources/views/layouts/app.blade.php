<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link href="https://releases.transloadit.com/uppy/v2.1.1/uppy.min.css" rel="stylesheet">

    <!-- datatable css dependencies -->
    <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs5/dt-1.11.3/kt-2.6.4/r-2.2.9/sr-1.1.0/datatables.min.css" />


    <!-- codemirror css -->
    {{-- <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css"> --}}

    <!-- summernote css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.css" integrity="sha512-m52YCZLrqQpQ+k+84rmWjrrkXAUrpl3HK0IO4/naRwp58pyr7rf5PO1DbI2/aFYwyeIH/8teS9HbLxVyGqDv/A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">

    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script> --}}

</head>

<body class="font-sans antialiased">
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

            <section class="mt-3">
                {{ $header }}
            </section>

            {{ $slot }}
        </main>
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <!-- jquerydatatable dependencies script -->
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/dt-1.11.3/kt-2.6.4/r-2.2.9/sr-1.1.0/datatables.min.js"></script>
    {{-- <script src="https://cdn.zingchart.com/zingchart.min.js"></script> --}}
    <!-- pdfjs script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js" integrity="sha512-Z8CqofpIcnJN80feS2uccz+pXWgZzeKxDsDNMD/dJ6997/LSRY+W4NmEt9acwR+Gt9OHN0kkI1CTianCwoqcjQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js"></script>

    <!-- codemirror scripts -->
    {{-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script> --}}
    {{-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script> --}}
    {{-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script> --}}

    <!-- summernote script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js" integrity="sha512-6F1RVfnxCprKJmfulcxxym1Dar5FsT/V2jiEUvABiaEiFWoQ8yHvqRM/Slf0qJKiwin6IDQucjXuolCfCKnaJQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js" integrity="sha512-6rE6Bx6fCBpRXG/FWpQmvguMWDLWMQjPycXMr35Zx/HRD9nwySZswkkLksgyQcvrpYMx0FELLJVBvWFtubZhDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

    @yield('script')
    <script>
        $(function() {
            // let dataTable = new simpleDatatables.DataTable("table", {
            //     searchable: true,
            //     fixedHeight: true
            // })

            //     dataTable.wrapper.querySelector('.dataTable-top').classList.add('p-0');
            //     dataTable.wrapper.querySelector('.dataTable-top input').classList.add('form-control');
            //     dataTable.wrapper.querySelector('.dataTable-top select').classList.add('form-select');
            // dataTable.wrapper.querySelector('.dataTable-bottom .dataTable-pagination-list').classList.add('pagination');
            // dataTable.wrapper.querySelector('.dataTable-bottom .dataTable-pagination-list li').classList.add('page-item');
            // dataTable.wrapper.querySelector('.dataTable-bottom .dataTable-pagination-list li a').classList.add('page-link')
            // dataTable.wrapper.querySelector('.dataTable-bottom .dataTable-pagination-list .pager a').classList.add('pagination');

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
