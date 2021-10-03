<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resources.index') }}">Resources</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create resource</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Create resource') }}
            </small>

            {{-- HEADER ACTIONS SECTION --}}
            <div class="ms-auto"></div>
        </div>
    </x-slot>

    @if (session()->exists('success'))
        <div class="my-4">
            <x-alert-success>
                {{ session()->get('success') }}

                <a href="{{ route('resources.index') }}">
                    <strong class="px-2">Go see the resources now?</strong>
                </a>
            </x-alert-success>
        </div>
    @endif

    <h6 class="mt-4 mb-0">
        <x-nav-tabs>
            <x-nav-link href="resources.create" id="home-tab" class="syllabus-tabs
            px-4 py-3">
                Regular
            </x-nav-link>

            <x-nav-link href="syllabi.create" id="profile-tab" class="syllabus-tabs
            px-4 py-3">
                Syllabus
            </x-nav-link>
        </x-nav-tabs>
    </h6>

    <div class="row">
        <div class="col-12">
            <x-card-body class="tab-content rounded-0 rounded-bottom border border-top-0 shadow-sm">
                @if ($errors->any())
                    <x-alert-danger class="my-4">
                        <span>Look! You got an error</span>
                        {{-- <small>files and input fields should not be empty</small> --}}
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </x-alert-danger>
                @endif

                <x-form-post action="{{ route('resources.store') }}" id="resourceForm">
                    <x-slot name="title">
                        Resource Create Form
                    </x-slot>

                    <x-slot name="titleDescription">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste nam iusto aspernatur nemo
                        asperiores quam repellendus nesciunt ipsum qui culpa? Iure hic consequuntur asperiores eos
                        tempore voluptas cupiditate, dolore est.
                    </x-slot>

                    <div class="col-12 col-md-3">
                        <x-input-select :name="'course_id'" required>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }} [{{ $course->code }}]
                                </option>
                            @endforeach
                        </x-input-select>
                    </div>

                    <div class="my-3">
                        <div class="row mb-3" id="fileMaster">
                            <div class="col-12">
                                <x-label>File</x-label>
                            </div>

                            <div class="row-group col-12" id="file-g">
                                <div id="actions" class="row">
                                    <div class="col-lg-7 d-flex justify-content-between">
                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                        <x-button :class="'btn-success fileinput-button dz-clickable'">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Add files...</span>
                                        </x-button>

                                        <x-button :class="'btn-warning cancel'">
                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                            <span>Cancel upload</span>
                                        </x-button>
                                    </div>

                                    <div class="col-lg-5">
                                        <!-- The global file processing state -->
                                        <span class="fileupload-process">
                                            <div id="total-progress" class="progress active" aria-valuemin="0"
                                                aria-valuemax="100" aria-valuenow="0">
                                                <div class="progress-bar progress-bar-striped progress-bar-success"
                                                    role="progressbar" style="width: 0%;" data-dz-uploadprogress="">
                                                </div>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <div class="table-responsive" id="file-upload-container">
                                    <div class="table table-striped">
                                        <div id="template" class="file-row">
                                            <!-- This is used as the file preview template -->
                                            <div>
                                                <span class="preview"><img data-dz-thumbnail /></span>
                                            </div>
                                            <div>
                                                <p class="name" data-dz-name></p>
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                            <div class="file-metadata">
                                                <div class="row">
                                                    <x-input name="file[]" class="file" hidden></x-input>

                                                    <div class="col-12 d-none file-group">
                                                        <x-label>Title</x-label>
                                                        <x-input name="title[]"></x-input>
                                                    </div>

                                                    <div class="col-12 d-none file-group">
                                                        <x-label>Description</x-label>
                                                        <x-input-textarea name="description[]"></x-input-textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="size" data-dz-size></p>
                                                <div class="progress progress-striped active" role="progressbar"
                                                    aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                    <div class="progress-bar progress-bar-success" style="width:0%;"
                                                        data-dz-uploadprogress></div>
                                                </div>
                                                <span class="badge bg-success">Uploaded successfully</span>
                                            </div>
                                            <div class="d-flex justify-content-end ps-5">
                                                <x-button :class="'btn-primary start'">
                                                    <span>Start</span>
                                                </x-button>

                                                <x-button data-dz-remove :class="'btn-warning cancel'">
                                                    <span>Cancel</span>
                                                </x-button>

                                                <x-button data-dz-remove :class="'btn-danger delete'">
                                                    <span>Delete</span>
                                                </x-button>
                                            </div>
                                        </div>

                                        <div id="previews"></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <x-slot name="actions">
                            <div class="col-12 col-md-3">
                                <x-button type="submit" class="btn-primary form-control disabled">Save
                                    changes
                                </x-button>
                            </div>

                            <div class="mt-3">
                                <x-input-check :name="'check_stay'" :label="'Check to stay after submit'" checked>
                                </x-input-check>
                            </div>
                        </x-slot>
                    </div>
                </x-form-post>
            </x-card-body>
        </div>
    </div>

    @section('script')
        <script>
            (function($) {

                let previewNode = $("#template")[0];
                previewNode.id = "";
                let previewTemplate = previewNode.parentNode.innerHTML;
                previewNode.parentNode.removeChild(previewNode);

                let myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
                    url: "{{ route('upload-temporary-file.store') }}", // Set the url
                    params: {
                        _token: "{{ csrf_token() }}"
                    },
                    thumbnailWidth: 80,
                    thumbnailHeight: 80,
                    parallelUploads: 20,
                    previewTemplate: previewTemplate,
                    autoQueue: true, // Make sure the files aren't queued until manually added
                    previewsContainer: "#previews", // Define the container to display the previews
                    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
                });

                myDropzone.on("addedfile", function(file) {
                    // Hookup the start button
                    $(file.previewElement).find('.start').click(function() {
                        myDropzone.enqueueFile(file)
                    })

                    let $input = $('#file-upload-container .file-metadata :input'),
                        $submitButton = $('form button[type="submit"]');

                    $submitButton.addClass('disabled')

                    $('.file-metadata').delegate($input, 'keyup', function(e) {
                        let trigger = false;

                        $input.each(function() {
                            if (!$(this).val()) {
                                trigger = true;
                            }
                        });

                        trigger ? $submitButton.addClass('disabled') : $submitButton
                            .removeClass(
                                'disabled');
                    })
                });

                myDropzone.on("removedfile", function(file) {
                    let $input = $('#file-upload-container .file-metadata :input'),
                        $submitButton = $('form button[type="submit"]');

                    $input.unbind('keyup');
                    let trigger = false;

                    if ($input.length <= 0) {
                        trigger = true;
                    } else {
                        $input.each(function() {
                            if (!$(this).val()) {
                                trigger = true;
                            }
                        });
                    }

                    trigger ? $submitButton.addClass('disabled') : $submitButton
                        .removeClass(
                            'disabled');

                    $('.file-metadata').delegate($input, 'keyup', function(e) {
                        let trigger = false;

                        $input.each(function() {
                            if (!$(this).val()) {
                                trigger = true;
                            }
                        });

                        trigger ? $submitButton.addClass('disabled') : $submitButton
                            .removeClass(
                                'disabled');
                    })
                })

                // Update the total progress bar
                myDropzone.on("totaluploadprogress", function(progress) {
                    $('#total-progress .progress-bar').css('width', progress + '%');
                });

                myDropzone.on("sending", function(file) {
                    // Show the total progress bar when upload starts
                    $('#total-progress').css('opacity', 1);
                    $('#total-progress .progress-bar').css('width', '0%');

                    // And disable the start button
                    $(file.previewElement).find('.start').attr('disabled', 'disabled')
                });

                myDropzone.on("success", function(file) {
                    $(file.previewElement).find('.file').val(file.xhr.responseText)
                    $(file.previewElement).find('.file-group').removeClass('d-none')
                    console.log($(file.previewElement).find('.file'))
                    console.log(file.xhr.responseText)
                });

                // Hide the total progress bar when nothing's uploading anymore
                myDropzone.on("queuecomplete", function(progress) {
                    $('#total-progress').css('opacity', 0);
                });

                // Setup the buttons for all transfers
                // The "add files" button doesn't need to be setup because the config
                // `clickable` has already been specified.
                // document.querySelector("#actions .start").onclick = function(event) {
                //     event.preventDefault()
                //     myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
                // };
                document.querySelector("#actions .cancel").onclick = function() {
                    myDropzone.removeAllFiles(true);
                };
            })(jQuery);
        </script>
    @endsection
</x-app-layout>
