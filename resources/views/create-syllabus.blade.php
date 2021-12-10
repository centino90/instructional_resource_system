<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resources.index') }}">Resources</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create syllabus</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex mt-4">
            <small class="h4 font-weight-bold">
                {{ __('Create syllabus') }}
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

                <x-form-post action="{{ route('syllabi.upload') }}" id="syllabusForm" enctype="multipart/form-data">
                    <x-slot name="title">
                        Course Syllabus Create Form
                    </x-slot>

                    <x-slot name="titleDescription">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste nam iusto aspernatur nemo
                        asperiores quam repellendus nesciunt ipsum qui culpa? Iure hic consequuntur asperiores eos
                        tempore voluptas cupiditate, dolore est.
                    </x-slot>

                    <div class="row mb-3">
                        <x-label> Syllabus *</x-label>
                        <x-input :name="'syllabus'" type="file" ></x-input>
                        @error('syllabus')
                            <x-input-error :for="'syllabus'"></x-input-error>
                        @enderror
                    </div>

                    <x-slot name="actions">
                        <x-button type="submit" class="btn-primary col-12 col-md-3">Save changes</x-button>

                            {{-- <div class="mt-3">
                                <x-input-check :name="'check_stay'" :label="'Check to stay after submit'" checked>
                                </x-input-check>
                            </div> --}}
                    </x-slot>
                </x-form-post>
            </x-card-body>
        </div>
    </div>

    @section('script')
        <script>
            (function($) {})(jQuery);
        </script>
    @endsection
</x-app-layout>
