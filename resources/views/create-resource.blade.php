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
                        <span>Look! You got <strong>{{ $errors->count() }}</strong> errors</span>
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

                    <div class="col-3">
                        <x-input-select :name="'course_id'" required>
                            <option value="1">Course 1</option>
                            <option value="2">Course 2</option>
                            <option value="3">Course 3</option>
                            <option value="4">Course 4</option>
                        </x-input-select>
                    </div>

                    <x-table id="sortable">
                        <x-slot name="thead">
                            <th></th>
                            <th>File</th>
                            <th>Description</th>
                            <th></th>
                        </x-slot>

                        @for ($i = 0; $i < $resourceLists; $i++)
                            <tr class="ui-state-default">
                                <td class="col-1">{{ $i + 1 . '.' }}</td>

                                <td class="col-5">
                                    <x-input type="file" name="file" :error="'file.' .$i" class="filepond"
                                        data-allow-reorder="true" multiple required></x-input>

                                    @error('file.' . $i)
                                        <x-input-error :for="'file.' .$i">
                                        </x-input-error>
                                    @enderror
                                </td>

                                <td class="col-4">
                                    <x-input name="description[]" :error="'description.' .$i"></x-input>

                                    @error('description.' . $i)
                                        <x-input-error :for="'description.' .$i">
                                        </x-input-error>
                                    @enderror
                                </td>

                                @if ($i === 0)
                                    <td class="col-2"></td>
                                @else
                                    <td class="col-2">
                                        <a href="#" class="btn btn-link remove">remove</a>
                                    </td>
                                @endif
                            </tr>
                        @endfor
                    </x-table>

                    <x-slot name="actions">
                        <div class="col-6 col-xl-3">
                            <x-button class="btn-secondary form-control" id="addfile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 30 30"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-plus-square">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                    <line x1="12" y1="8" x2="12" y2="16" />
                                    <line x1="8" y1="12" x2="16" y2="12" />
                                </svg>

                                Add a resource
                            </x-button>
                        </div>

                        <div class="col-6 col-xl-3">
                            <x-button type="submit" class="btn-primary form-control">Save changes</x-button>
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
                $('#sortable').find('input[type="file"]').change(function() {
                    if (!this.value) {
                        return
                    }

                    $(this).addClass('is-valid')
                })

                $('#addfile').click(function() {
                    $('#sortable tbody').append(
                        `    <tr class="ui-state-default">
                            <td class="col-1">
                                *
                            </td>

                            <td class="col-3">
                                <input type="file" name="file[]" id="" class="form-control">
                            </td>

                            <td class="col-3">
                                <input type="text" name="description[]" id="" class="form-control">
                            </td>

                            <td class="col-12 col-lg-2">
                                <a href="#" class="btn btn-link remove">remove</a>
                            </td>
                        </tr>`
                    )

                    $('#sortable').find('input[type="file"]').change(function() {
                        if (!this.value) {
                            return
                        }

                        $(this).addClass('is-valid')
                    })

                    $('.remove').click(function(e) {
                        e.preventDefault();
                        $(this).closest('tr').remove();
                    })
                })

                $('.remove').click(function() {
                    e.preventDefault();
                    $(this).closest('tr').remove();
                })

                $('#profile-tab, #home-tab').click(function(event) {
                    showLeaveConfirmationCheck(event);
                })

                function showLeaveConfirmationCheck(event) {
                    var required = $('form input ,form textarea, form select').filter(
                        ':not([type="checkbox"]):not([type="hidden"]):not([name="course_id"]):not([type="submit"])');
                    var allRequired = false;

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

                let resourceFilePond;
                $.each($('input[type="file"]'), function(key, element) {
                    resourceFilePond = FilePond.create(
                        element
                    )
                })

                resourceFilePond.setOptions({
                    labelIdle: 'Drag & Drop your files or <span class="filepond--label-action"> Browse </span><br><i class="fas fa-cloud-upload-alt"></i>',
                    allowMultiple: true,
                    credits: false,
                    server: {
                        url: 'http://localhost:8000',
                        process: {
                            url: '/uploadTemporaryFiles',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        revert: (uniqueFileId, load, error) => {
                            $.ajax({
                                    url: `/uploadTemporaryFiles/${uniqueFileId}`,
                                    method: "DELETE",
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content')
                                    }
                                })
                                .done(function(data) {
                                    console.log(data)
                                })

                            error('oh my goodness')
                            load()
                        },
                    }
                })
            })(jQuery);
        </script>
    @endsection
</x-app-layout>
