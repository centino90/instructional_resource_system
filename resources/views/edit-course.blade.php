<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit course</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <a href="{{ route('courses.index') }}" class="btn btn-link text-decoration-none border">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 28 28" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-arrow-left">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Go Back
        </a>

        <div class="d-flex bg-white p-3 mt-3 rounded shadow-sm mb-3">
            <div>
                <small class="h3 font-weight-bold">
                    {{ __('Edit course') }}
                </small>
                <div class="col-12 col-md-5">
                    <small class="text-secondary">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error deleniti mollitia atque illum
                        dolores vitae, fugit itaque iusto, aliquid ut sequi. Deserunt sit consectetur sequi?
                        Reprehenderit eligendi saepe quaerat deleniti!
                    </small>
                </div>
            </div>

            <div class="ms-auto"></div>
        </div>
    </x-slot>

    @if ($errors->any())
        <x-alert-danger class="my-4">
            <span>Look! You got {{ $errors->count() }} error(s)</span>
        </x-alert-danger>
    @endif

    <div class="row mt-4">
        <div class="col-12">
            <x-card-body class="tab-content rounded-0 rounded-bottom border border-top-0 shadow-sm">
                <x-form-update action="{{ route('courses.update', $course->id) }}" id="courseForm">
                    <div class="col-12 mt-3">
                        <x-label>Title *</x-label>
                        <x-input name="title" value="{{ $course->title }}"></x-input>
                        <x-input-error :for="'title'"></x-input-error>
                    </div>

                    <div class="col-12 mt-3">
                        <x-label>Code *</x-label>
                        <x-input name="code" value="{{ $course->code }}"></x-input>
                        <x-input-error :for="'code'"></x-input-error>
                    </div>

                    <div class="col-12 mt-3">
                        <x-label>Program *</x-label>
                        <x-input-select name="program_id">
                            <option value="">Select option</option>
                            @foreach ($programs as $program)
                                <option {{ $course->program_id == $program->id ? 'selected' : '' }}
                                    value="{{ $program->id }}">{{ $program->title }}</option>
                            @endforeach
                        </x-input-select>
                        <x-input-error :for="'program_id'"></x-input-error>
                    </div>

                    <div class="col-12 mt-3">
                        <x-label>Year level *</x-label>
                        <x-input-select name="year_level">
                            <option value="">Select option</option>
                            <option {{ $course->year_level == 1 ? 'selected' : '' }} value="1">First year</option>
                            <option {{ $course->year_level == 2 ? 'selected' : '' }} value="2">Second year</option>
                            <option {{ $course->year_level == 3 ? 'selected' : '' }} value="3">Third year</option>
                            <option {{ $course->year_level == 4 ? 'selected' : '' }} value="4">Fourth year</option>
                        </x-input-select>
                        <x-input-error :for="'year_level'"></x-input-error>
                    </div>

                    <div class="col-12 mt-3">
                        <x-label>Semester *</x-label>
                        <x-input-select name="semester">
                            <option value="">Select option</option>
                            <option {{ $course->semester == 1 ? 'selected' : '' }} value="1">First semester</option>
                            <option {{ $course->semester == 2 ? 'selected' : '' }} value="2">Second semester</option>
                        </x-input-select>
                        <x-input-error :for="'semester'"></x-input-error>
                    </div>

                    <div class="col-12 mt-3">
                        <x-label>Term *</x-label>
                        <x-input-select name="term">
                            <option value="">Select option</option>
                            <option {{ $course->term == 1 ? 'selected' : '' }} value="1">First term</option>
                            <option {{ $course->term == 2 ? 'selected' : '' }} value="2">Second term</option>
                        </x-input-select>
                        <x-input-error :for="'term'"></x-input-error>
                    </div>

                    <div class="col-12 mt-3">
                        <x-button type="submit" :class="'btn-primary'">Update</x-button>
                    </div>
                </x-form-update>
            </x-card-body>
        </div>
    </div>

    @section('script')
        <script>
            (function($) {
                // alert('yes')
            })(jQuery);
        </script>
    @endsection
</x-app-layout>
