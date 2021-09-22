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
                        <small>files and input fields should not be empty</small>
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

                            <div class="row-group col-12 col-md-7">
                                <x-input type="file" class="file" name="file[]" multiple></x-input>
                                <x-button :class="'btn-link remove-group'">Remove</x-button>

                                <div class="images-to-upload border-bottom mt-3"></div>
                            </div>

                            <div class="col-12 mt-3">
                                <x-button class="btn-secondary disabled" id="add-more-file">Add another file</x-button>
                            </div>
                        </div>


                        <x-slot name="actions">
                            <div class="col-12 col-md-3">
                                <x-button type="submit" class="btn-primary form-control no-loading disabled">Save
                                    changes
                                </x-button>
                            </div>

                            <div class="mt-3">
                                <x-input-check :name="'check_stay'" :label="'Check to stay after submit'" checked>
                                </x-input-check>
                            </div>
                        </x-slot>
                </x-form-post>
            </x-card-body>
        </div>
    </div>

    @section('script')
        <script>
            (function($) {
                var fileCollection = new Array();
                setWhenFileChanged()

                $('#add-more-file').click(function() {
                    $('form button[type="submit"]').addClass('disabled')
                    if ($('.row-group').last().find('.file')[0].files.length == 0) return

                    let fileTemplate = `
                        <div class="row-group col-12 col-md-7 my-3">
                                <x-input type="file" :class="'file'" name="file[]" multiple></x-input>
                                <x-button :class="'btn-link remove-group'">Remove</x-button>

                                <div class="images-to-upload col-12"></div>
                            </div>
                        `

                    $('.row-group').last().after(fileTemplate)

                    if ($('.row-group').last().find('.file')[0].files.length == 0) {
                        $('#add-more-file').addClass('disabled')
                    }
                })
                $('#profile-tab, #home-tab').click(function(event) {
                    showLeaveConfirmationCheck(event);
                })

                $('#fileMaster').delegate('.remove-group', 'click', (function(event) {
                    event.preventDefault()
                    $('#add-more-file').removeClass('disabled')
                    let fileMaster = $(this).closest('#fileMaster')
                    let fileRowGroup = $(this).closest('.row-group')
                    let fileInput = fileRowGroup.find('.file')

                    if (fileRowGroup[0] != fileMaster.find('.row-group').first()[0] || fileMaster.find('.row-group').length > 1) {
                        fileRowGroup.remove()
                        removeFileFromFileList(null, fileInput[0]);
                    } else {
                        removeFileFromFileList(null, fileInput[0]);
                        fileRowGroup.find('.file-group').remove()
                        fileInput.removeClass('opacity-50 pe-none')

                    }
                }))

                function setWhenFileChanged() {
                    $('#fileMaster').delegate('.file', 'change', function(e) {
                        let fileMaster = $('#fileMaster')
                        let fileRowGroup = $(this).closest('.row-group')
                        let fileInput = $(this)
                        let files = fileInput[0].files;

                        $('#add-more-file').removeClass('disabled')

                        $.each(files, function(i, file) {

                            fileCollection.push(file);

                            var template =
                                `<div class="file-group border-bottom pb-1 mb-3">
                                <div><b>${file.name}</b></div>
                                <div class="row">
                                <div class="col-12 col-lg-6">
                                <x-label>Title</x-label>
                                <x-input name="title[]" required></x-input>
                                </div>
                                <div class="col-12 col-lg-6">
                                <x-label>Description</x-label>
                                <x-input-textarea name="description[]" required></x-input-textarea>
                                </div>
                                </div>
                                <div class="d-flex justify-content-end"><a href="#" class="btn btn-sm btn-secondary mt-1 remove">Remove</a></div>
                                </div>`;

                            fileRowGroup.find('.images-to-upload').append(template);
                        });


                        $('.remove').click(function(event) {
                            event.preventDefault()

                            let fileGroup = $(this).closest('.file-group')
                            removeFileFromFileList(fileGroup.index(), fileInput[0])
                            fileGroup.remove()

                            if (fileInput[0].files.length == 0) {
                                fileInput.removeClass('opacity-50 pe-none')

                                if (fileMaster.find('.row-group').length > 1) {
                                    fileInput.closest('.row-group').remove()
                                }
                            }

                            if (fileMaster.find('.row-group').first().find('.file')[0].files
                                .length == 0) {
                                $('button[type="submit"]').addClass('disabled')
                                $('#add-more-file').addClass('disabled')
                            }
                        })

                        let $input = fileMaster.find('input'),
                            $submitButton = $('button[type="submit"]');

                        fileRowGroup.delegate($input, 'keyup', function() {
                            let trigger = false;
                            $input.each(function() {
                                console.log($(this))
                                if (!$(this).val()) {
                                    trigger = true;
                                }
                            });
                            trigger ? $submitButton.addClass('disabled') : $submitButton
                                .removeClass(
                                    'disabled');
                        });

                        fileInput.addClass('opacity-50 pe-none')
                    });
                }

                function removeFileFromFileList(index = null, input) {
                    const dt = new DataTransfer()
                    // const input = fileInput[0]
                    const {
                        files
                    } = input

                    if (index == null) {
                        $(input).val(null);
                        return
                    }

                    for (let i = 0; i < files.length; i++) {
                        const file = files[i]
                        if (index !== i)
                            dt.items.add(
                                file
                            ) // here you exclude the file. thus removing it.
                    }

                    input.files = dt.files // Assign the updates list
                }

                function showLeaveConfirmationCheck(event) {
                    let required = $('form input ,form textarea, form select').filter(
                        ':not([type="checkbox"]):not([type="hidden"]):not([name="course_id"]):not([type="submit"])');
                    let allRequired = false;

                    required.each(function(index, value) {

                        if ($(value).val().length > 0) {
                            allRequired = true;
                        }
                    });

                    if (allRequired == true) {
                        let conf = confirm('Are you sure you want to leave this page without saving your changes?');

                        if (conf === false) {
                            event.preventDefault();
                        }
                    }
                }

            })(jQuery);
        </script>
    @endsection
</x-app-layout>
