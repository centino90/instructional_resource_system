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

   <script src="{{ asset('js/app.js') }}"></script>
   <script defer src="{{ asset('js/setup.js') }}"></script>
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

   <x-real.modal-management></x-real.modal-management>

   <!-- NON-blocking Styles -->

   <link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sr-1.1.0/datatables.min.css" />

   <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/css/datepicker-bs5.min.css">

   <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">

   <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/css/datepicker.min.css">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css" />

   <!-- NON-blocking Scripts -->

   <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>

   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js">
   </script>

   <script type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js">
   </script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/mode/simple.min.js"
      integrity="sha512-9YoNYsegWvbA5aiSshQ2BNW2FAq3CQVLqpg2r6urw9Tfl1GklM9PNgrMRVz8fhEtjM+uZfO/1X3RURkMcil8wg=="
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>

   <script type="text/javascript"
      src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sr-1.1.0/datatables.min.js">
   </script>

   <script src="/vendor/datatables/buttons.server-side.js"></script>

   <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/js/datepicker-full.min.js"></script>

   <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

   <script>
    //   $.extend(true, $.fn.dataTable.defaults, {
    //     //  "order": [],
    //     //  "bsort": false,
    //      "bStateSave": true,
    //      "stateSaveParams": function(settings, data) {
    //         // data.search.search = ""
    //         // data.order = []
    //      }
    //   });
   </script>

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
      })
   </script>
</body>

</html>
