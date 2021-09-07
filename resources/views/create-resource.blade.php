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

    @if (auth()->user()->role_id = 1)
        <div class="my-3">
            @forelse ($notifications as $notification)
                @isset($notification->data['program_id'])
                    @if ($notification->data['program_id'] == auth()->user()->program_id)
                        <div class="alert alert-success">
                            [{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->toDayDateTimeString() }}]
                            {{ $notification->data['user'] }} created
                            {{ $notification->data['file_name'] }}
                        </div>
                    @endif
                @endisset
            @empty
                There are no notifications
            @endforelse
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <x-card-body class="tab-content rounded-0 rounded-bottom border border-top-0 shadow-sm">
                @if ($errors->any())
                    <x-alert-danger class="my-4">
                        <span>Look! You got an error</span>

                        <ul class="nav flex-column mt-3">
                            @foreach ($errors->all() as $error)
                                <li class="nav-item">{{ $error }}</li>
                            @endforeach
                        </ul>

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
                            <option value="1">Course 1</option>
                            <option value="2">Course 2</option>
                            <option value="3">Course 3</option>
                            <option value="4">Course 4</option>
                        </x-input-select>
                    </div>

                    <div class="my-3">
                        <div class="row">
                            <div class="col-12 col-md-7">
                                <x-label>File</x-label>
                                <x-input type="file" name="file[]" :error="'file.0'" class="filepond" multiple
                                    data-allow-reorder="true"></x-input>

                                @error('file')
                                    <x-input-error :for="'file'">
                                    </x-input-error>
                                @enderror
                            </div>

                            <div class="col-12 col-md-5">
                                <x-label>Description (optional)</x-label>
                                <x-input name="description"></x-input>

                                @error('description.')
                                    <x-input-error :for="'description'">
                                    </x-input-error>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <x-slot name="actions">
                        <div class="col-12 col-md-3">
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

                $('.filepond').filepond({
                    allowMultiple: true,
                    credits: false,
                    server: {
                        url: 'http://localhost:8000',
                        process: {
                            url: '/upload-temporary-files',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        revert: (uniqueFileId, load, error) => {
                            $.ajax({
                                    url: `/upload-temporary-files/${uniqueFileId}`,
                                    method: "DELETE",
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content'),
                                        _method: "DELETE"
                                    }
                                })
                                .done(function(data) {
                                    console.log(data)
                                })
                        },
                    }
                });
            })(jQuery);
        </script>
    @endsection
</x-app-layout>
