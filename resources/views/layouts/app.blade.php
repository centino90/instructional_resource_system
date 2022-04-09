<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link href="https://releases.transloadit.com/uppy/v2.1.1/uppy.min.css" rel="stylesheet">

    <!-- datatable css dependencies -->
    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs5/dt-1.11.3/kt-2.6.4/r-2.2.9/sr-1.1.0/datatables.min.css" /> --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs5/dt-1.11.5/af-2.3.7/b-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sr-1.1.0/datatables.min.css" />


    <!-- codemirror css -->
    {{-- <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css"> --}}

    <!-- summernote css -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet"> --}}



    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">

    @yield('style')

    <!-- custom css -->
    @if (auth()->user()->isProgramDean())
        <link rel="stylesheet" href="{{ asset('css/dean.css') }}">
    @elseif (auth()->user()->isAdmin())
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @elseif (auth()->user()->isSecretary())
        <link rel="stylesheet" href="{{ asset('css/secretary.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif


    <style>
        .note-editor {
            background-color: #fff;
        }

        .comment-section img {
            object-fit: cover;
            width: 100%;
        }

    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css" />


    <script defer type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js">
    </script>
    <script defer type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js">
    </script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/mode/simple.min.js"
        integrity="sha512-9YoNYsegWvbA5aiSshQ2BNW2FAq3CQVLqpg2r6urw9Tfl1GklM9PNgrMRVz8fhEtjM+uZfO/1X3RURkMcil8wg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="bg-light d-flex" style="min-height: 100vh;max-width: 100%">
        @include('layouts.sidenav')

        <main class="container-fluid pb-5 px-0">
            @include('layouts.topnav')

            <section class="mt-3 px-3">
                @include('layouts.placeholder')

                <div class="show-after-load" style="display: none">
                    @include('layouts.status-message')

                    {{ $slot }}
                </div>
            </section>
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
    {{-- <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/dt-1.11.3/kt-2.6.4/r-2.2.9/sr-1.1.0/datatables.min.js"></script> --}}

    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/dt-1.11.5/af-2.3.7/b-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sr-1.1.0/datatables.min.js">
    </script>
    {{-- <script src="https://cdn.zingchart.com/zingchart.min.js"></script> --}}
    <!-- pdfjs script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"
        integrity="sha512-Z8CqofpIcnJN80feS2uccz+pXWgZzeKxDsDNMD/dJ6997/LSRY+W4NmEt9acwR+Gt9OHN0kkI1CTianCwoqcjQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js"></script>

    <!-- codemirror scripts -->
    {{-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script> --}}
    {{-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script> --}}
    {{-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script> --}}

    {{-- <!-- turndown script -->
    <script src="https://unpkg.com/turndown/dist/turndown.js"></script> --}}

    <!-- summernote script -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js" integrity="sha512-6F1RVfnxCprKJmfulcxxym1Dar5FsT/V2jiEUvABiaEiFWoQ8yHvqRM/Slf0qJKiwin6IDQucjXuolCfCKnaJQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    @yield('script')
    <script>
        $(document).ready(function() {
            $('.show-before-load').hide()
            $('.show-after-load').show()

            if (location.hash) {
                const $scrolledToElement = $(`#${location.hash.substr(1)}`)
                $scrolledToElement.addClass('scrolled-focus')
            }

            let tooltips = $('#sidebar [data-bs-toggle="tooltip"]')
            let bsTooltips = $([])
            tooltips.each(function(index, tooltip) {
                bsTooltips.push(bootstrap.Tooltip.getInstance(tooltip))
            })

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');

                bsTooltips.each(function(index, tooltip) {
                    if ($('#sidebar').hasClass('active')) {
                        tooltip.enable()
                        $('#navbar__header .title-wide').removeClass('d-block').addClass('d-none')
                        $('#navbar__header .title-narrow').removeClass('d-none').addClass('d-block')
                    } else {
                        tooltip.disable()
                        $('#navbar__header .title-wide').removeClass('d-none').addClass('d-block')
                        $('#navbar__header .title-narrow').removeClass('d-block').addClass('d-none')
                    }
                })
            })

            // $('.notification-show-link').click(function(event) {
            //     event.preventDefault();
            //     let href = $(this).attr('href')
            //     let notifId = $(this).attr('data-passover')
            //     let formRoute = '{{ route('notifications.update', '') }}'

            //     $.ajax({
            //         url: `${formRoute}/${notifId}`,
            //         type: 'POST',
            //         data: {
            //             notifId: notifId,
            //             _token: '{{ csrf_token() }}',
            //             _method: 'PUT'
            //         },
            //         success: function(result) {
            //             if (result.status === 200) {
            //                 location.href = href
            //             }
            //         },
            //         error: function() {
            //             alert('error');
            //         },
            //     })
            // })


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

        })
    </script>
</body>

</html>
