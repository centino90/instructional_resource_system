<x-app-layout>
   <x-slot name="header">
      Instructor Activities
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dashboard') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item active">
         Instructor Activities
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-3">
         <x-real.card :vertical="'center'" id="weeklySubmissionChartCard">
            <x-slot name="header">Navigate to</x-slot>
            <x-slot name="body">
               <ul class="nav nav-pills nav-flush persist-default flex-column gap-2">
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.index') }}" class="nav-link">Overview</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.submissions', ['storeType' => 'all']) }}" class="nav-link">
                        <span class="material-icons md-18 align-middle">summarize</span>
                        <small>Submissions</small>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.syllabus') }}" class="nav-link">
                        <span class="material-icons md-18 align-middle">schedule_send</span>
                        <small> Ontime and Delayed Syllabus</small>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.instructors') }}" class="nav-link active">
                        <span class="material-icons md-18 align-middle">settings_accessibility</span>
                        <small>Instructor Activities</small>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.courses') }}" class="nav-link">
                        <span class="material-icons md-18 align-middle">account_tree</span>
                        <small>Courses</small>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.lessons') }}" class="nav-link">
                        <span class="material-icons md-18 align-middle">cast_for_education</span>
                        <small>Lessons</small>
                     </a>
                  </li>
               </ul>
            </x-slot>
         </x-real.card>
      </div>

      <div class="col-9">
         <div class="row g-3">
            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">Filter</x-slot>
                  <x-slot name="body">
                     <form method="GET" action="{{ route('dean.reports.instructors') }}" class="row g-3">
                        <div class="col-auto">
                           <x-real.input id="reportFilter" name="year"
                              value="{{ request()->get('year') ?? date('m-d-Y') }}">
                              <x-slot name="label">Year</x-slot>
                           </x-real.input>
                        </div>
                        <div class="col-auto">
                           <x-real.input id="reportFilter" name="type" type="select">
                              <x-slot name="label">Type</x-slot>
                              <x-slot name="options">
                                 <option value="">All</option>
                                 @foreach ($activityTypes as $type)
                                    <option value="{{ $type->log_name }}">
                                       {{ str_replace('-', ' ', $type->log_name) }}
                                    </option>
                                 @endforeach
                              </x-slot>
                           </x-real.input>
                        </div>
                        <div class="col-12">
                           <div class="hstack gap-3">
                              <x-real.btn :size="'lg'">Filter</x-real.btn>
                              <x-real.btn :size="'lg'" type="reset">Reset</x-real.btn>
                           </div>
                        </div>
                     </form>
                  </x-slot>
               </x-real.card>
            </div>
            <div class="col-8">
               <x-real.card>
                  <x-slot name="header">Most Active Instructors</x-slot>
                  <x-slot name="body">
                     <ul class="list-group">
                        @foreach ($fiveMostActiveSubmitters as $submitter)
                           <li class="list-group-item">
                              <div class="hstack justify-content-between">
                                 <h6 class="m-0">{{ $submitter->name }}</h6>
                                 <span>{{ $submitter->activityLogs->count() }}</span>
                                 <div class="btn-group">
                                    <x-real.btn :size="'sm'" class="dropdown-toggle" data-bs-toggle="dropdown"
                                       data-bs-auto-close="outside" aria-expanded="false"> View more</x-real.btn>
                                    <ul class="dropdown-menu shadow-lg p-0 border-0" style="min-width: 400px"
                                       id="dropdownMega">
                                       <li class="dropdown-item p-0">
                                          <ul class="list-group p-0">
                                             @foreach ($submitter->activityLogs->groupBy('log_name')->forget('user-created') as $key => $activity)
                                                <li class="list-group-item">
                                                   <div class="hstack justify-content-between">
                                                      <h6>{{ str_replace('-', ' ', $key) }}</h6>
                                                      <span>{{ $activity->count() }}</span>
                                                   </div>
                                                </li>
                                             @endforeach
                                          </ul>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </li>
                        @endforeach
                        <li class="list-group-item">
                           <div class="hstack justify-content-between">
                              <small class="text-muted">Total Activities</small>
                              <h5 class="m-0 fw-bold">{{ $activities->count() }}</h5>
                           </div>
                        </li>
                     </ul>
                  </x-slot>
               </x-real.card>
            </div>
            <div class="col-4">
               <x-real.card>
                  <x-slot name="header">More Activities</x-slot>
                  <x-slot name="body">
                     <ul class="list-group">
                        @foreach ($activities->groupBy('log_name')->forget('user-created') as $key => $activity)
                           <li class="list-group-item">
                              <div class="hstack justify-content-between">
                                 <h6>{{ str_replace('-', ' ', $key) }}</h6>
                                 <span>{{ $activity->count() }}</span>
                              </div>
                           </li>
                        @endforeach
                     </ul>
                  </x-slot>
               </x-real.card>
            </div>

            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">Instructor Activities Data</x-slot>
                  <x-slot name="body">
                     <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'w-100 table align-middle table-hover']) !!}
                     </div>
                  </x-slot>
               </x-real.card>
            </div>
         </div>
      </div>
   </div>

   @section('script')
      {!! $dataTable->scripts() !!}

      <!-- Charting library -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Chartisan -->
      <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

      <script>
         $(document).ready(function() {
            const type = "{{ request()->get('type') }}"
            $("[name='type']").val(type);

            new Datepicker($('#reportFilter')[0], {
               pickLevel: 2
            })
         })
      </script>
   @endsection
</x-app-layout>
