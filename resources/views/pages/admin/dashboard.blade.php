<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </x-breadcrumb>
    </x-slot>

    <x-slot name="header">
        <div class="d-flex bg-white p-3 mt-3 rounded shadow-sm mb-3">
            <div>
                <small class="h3 font-weight-bold">
                    Dashboard
                </small>
            </div>
        </div>

        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                <a href="{{ route('admin.dashboard') }}" class="nav-link rounded-0 px-4 border-bottom border-3 border-primary fw-bold">
                    Overview
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.programs.list') }}" class="nav-link rounded-0 px-4 border-bottom border-3">
                    Programs
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.courses.index') }}" class="nav-link rounded-0 px-4 border-bottom border-3">
                    Courses
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('admin.personnels.index') }}"
                    class="nav-link rounded-0 px-4 border-bottom border-3">
                    Members
                </a>
            </li>
        </ul>
    </x-slot>

    <div class="my-4">
        @if (session()->exists('success'))
            <x-alert-success class="mb-3">
                {{ session()->get('success') }}
            </x-alert-success>
        @endif
    </div>

    <div class="mt-5">
        <h5 class="mb-3">Overview</h5>
        <x-card-group>
            <div class="col">
                <x-card>
                    <div class="row cols-6">
                        <div class="col">
                            <h5 class="card-title fw-bold">
                                Total material uploads
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
                                Total material downloads
                                <h1 class="text-primary">
                                    {{ $totalDownloads }}
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
                                Total material views
                                <h1 class="text-primary">
                                    {{ $totalViews }}
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
                                Total programs
                                <h1 class="text-primary">
                                    {{ $totalPrograms }}
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

            <div class="col">
                <x-card>
                    <div class="row cols-6">
                        <div class="col">
                            <h5 class="card-title fw-bold">
                                Total members
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
        </x-card-group>
    </div>

    <div class="row mt-4 g-3">
        <div class="col-6">
            <x-card>
                <h5 class="card-title fw-bold">Overall frequency of uploads by month</h5>

                <div id="barChart"></div>
            </x-card>
        </div>
        <div class="col-6">
            <x-card>
                <h5 class="card-title fw-bold">Percentage of uploads by program</h5>
                
                <div id='ringChart' style="min-height: 250px;"></div>
            </x-card>
        </div>
    </div>

    @section('script')
        <script>    
            let barConfig = {
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
                    values: {{ Illuminate\Support\Js::from($months) }},
                    text: 'Week 2'
                }]
            };
            zingchart.render({
                id: 'barChart',
                data: barConfig,
            });

            var ringConfig = {
 type: 'ring',
  plot: {
    slice: 25,
    valueBox: {
      placement: 'out',
      text: '%t\n%npv%',
      fontFamily: "Open Sans"
    },
    tooltip: {
      fontSize: '18',
      fontFamily: "Open Sans",
      padding: "5 10",
      text: "%npv%"
    },
    animation: {
      effect: 2,
      method: 5,
      speed: 900,
      sequence: 1,
      delay: 3000
    }
  },
  title: {
      offsetX: 10,
       fontColor: "#8e99a9",
    fontSize: "16",
    text: '2021',
    align: "left"
  },
  plotarea: {
    margin: "20 0 0 0"
  },
  series: {{ Illuminate\Support\Js::from($courseCountByProgram) }},
};
 
zingchart.render({
  id: 'ringChart',
  data: ringConfig,
  height: '100%',
  width: '100%'
});
        </script>
    @endsection
</x-app-layout>
