<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.programs.index') }}">Programs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Show program</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <a href="{{ route('admin.programs.index') }}" class="btn btn-link text-decoration-none border">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 28 28" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-arrow-left">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Go Back
        </a>

        <div class="d-flex align-items-end bg-white p-3 mt-3 rounded shadow-sm mb-3">
            <div>
                <small class="h3 font-weight-bold">
                    {{ $program->title }}
                </small>
            </div>

            <div class="ms-auto d-flex gap-2">
                <x-button.edit :passover="route('admin.programs.edit', $program->id)"></x-button.edit>

                <x-form-delete :action="route('admin.programs.destroy', $program->id)"></x-form-delete>
            </div>
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

    @if ($errors->any())
        <x-alert-danger class="my-4">
            <span>Look! You got {{ $errors->count() }} error(s)</span>
        </x-alert-danger>
    @endif

    <div class="mt-5">
        <h5 class="mb-3">Program Overview</h5>
        <x-card-group>
            <div class="col">
                <x-card>
                    <div class="row cols-6">
                        <div class="col">
                            <h5 class="card-title fw-bold">
                                Total uploads
                                <h1 class="text-primary">
                                    {{ $totalUploads }}
                                </h1>
                            </h5>
                        </div>
                        <div class="col">
                            <p class="card-text">
                                This is a longer card with supporting text below.
                            </p>
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="col">
                <x-card>
                    <div class="row cols-6">
                        <div class="col">
                            <h5 class="card-title fw-bold">
                                Total instructors
                                <h1 class="text-primary">
                                    {{ $totalInstructors }}
                                </h1>
                            </h5>
                        </div>
                        <div class="col">
                            <p class="card-text">
                                This is a longer card with supporting text below.
                            </p>
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="col">
                <x-card>
                    <div class="row cols-6">
                        <div class="col">
                            <h5 class="card-title fw-bold">
                                Total courses
                                <h1 class="text-primary">
                                    {{ $totalCourses }}
                                </h1>
                            </h5>
                        </div>
                        <div class="col">
                            <p class="card-text">
                                This is a longer card with supporting text below.
                            </p>
                        </div>
                    </div>
                </x-card>
            </div>
        </x-card-group>
    </div>

    <div class="row mt-4 g-3">
        <div class="col-8">
            <x-card>
                <h5 class="card-title fw-bold">Summary of uploads</h5>

                <div id="myChart"></div>
            </x-card>
        </div>
        <div class="col-4">
            <x-card>
                <h5 class="card-title fw-bold">Course overview</h5>
                <ol class="list-group list-group-numbered">
                    @foreach ($courses as $course)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $course->title }} [{{ $course->code }}]</div>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $course->resources->count() }}
                                uploads</span>
                        </li>
                    @endforeach
                </ol>
            </x-card>
        </div>
    </div>

    @section('script')
        <script>
            (function($) {
                let myConfig = {
                    type: 'bar',
                    scaleX: {
                        label: {
                            text: {{ $year }},
                            fontSize: 18
                        },
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                    },
                    scaleY: {
                        label: {
                            text: 'Frequency of uploads'
                        }
                    },
                    plot: {
                        animation: {
                            effect: 'ANIMATION_EXPAND_BOTTOM',
                            method: 'ANIMATION_STRONG_EASE_OUT',
                            sequence: 'ANIMATION_BY_NODE',
                            speed: 275,
                        }
                    },
                    series: [{
                        values: {{ json_encode($months) }},
                        text: 'Week 2'
                    }]
                };

                zingchart.render({
                    id: 'myChart',
                    data: myConfig,
                });
            })(jQuery);
        </script>
    @endsection
</x-app-layout>
