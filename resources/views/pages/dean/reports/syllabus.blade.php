<x-app-layout>
   <x-slot name="header">
      Syllabus Submission Reports
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dashboard') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item active">
         Syllabus Submissions Reports
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-3">
         <x-real.card :vertical="'center'" id="weeklySubmissionChartCard">
            <x-slot name="header">Navigate to</x-slot>
            <x-slot name="body">
               <ul class="nav nav-pills nav-flush persist-default flex-column gap-2">
                  {{-- <li class="nav-item">
                     <a href="{{ route('dean.reports.index') }}" class="nav-link">Overview</a>
                  </li> --}}
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.submissions', ['storeType' => 'all']) }}" class="nav-link">
                        <span class="material-icons md-18 align-middle">summarize</span>
                        <small>Submissions</small>
                     </a>
                  </li>
                  {{-- <li class="nav-item">
                     <a href="{{ route('dean.reports.syllabus') }}" class="nav-link active">
                        <span class="material-icons md-18 align-middle">schedule_send</span>
                        <small> Ontime and Delayed Syllabus</small>
                     </a>
                  </li> --}}
                  <li class="nav-item">
                     <a href="{{ route('dean.reports.instructors') }}" class="nav-link">
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
                     <form method="GET" action="{{ route('dean.reports.syllabus') }}" class="row g-3">
                        <div class="d-flex col-auto">
                           <x-real.input :marginBottom="'0'" id="startDateFilter" name="start_date"
                              value="{{ request()->get('start_date') ??now()->subYear(1)->format('m-d-Y') }}"
                              class="rounded-0 rounded-start">
                              <x-slot name="label">Start date</x-slot>
                           </x-real.input>
                           <span class="px-3 bg-light hstack border-top border-bottom">TO</span>
                           <x-real.input :marginBottom="'0'" id="endDateFilter" name="end_date"
                              value="{{ request()->get('end_date') ?? date('m-d-Y') }}" class="rounded-0 rounded-end">
                              <x-slot name="label">End date</x-slot>
                           </x-real.input>
                        </div>
                        <div class="col-auto">
                           <x-real.input :marginBottom="'0'" :type="'select'" name="year_level">
                              <x-slot name="label">Year Level</x-slot>
                              <x-slot name="options">
                                 <option value="">All</option>
                                 <option value="1">First Year</option>
                                 <option value="2">Second Year</option>
                                 <option value="3">Third Year</option>
                                 <option value="4">Fourth Year</option>
                              </x-slot>
                           </x-real.input>
                        </div>
                        <div class="col-auto">
                           <x-real.input :marginBottom="'0'" :type="'select'" name="semester">
                              <x-slot name="label">Semester</x-slot>
                              <x-slot name="options">
                                 <option value="">All</option>
                                 <option value="1">First sem</option>
                                 <option value="2">Second sem</option>
                                 <option value="3">Third sem</option>
                              </x-slot>
                           </x-real.input>
                        </div>
                        <div class="col-auto">
                           <x-real.input :marginBottom="'0'" :type="'select'" name="term">
                              <x-slot name="label">Term</x-slot>
                              <x-slot name="options">
                                 <option value="">All</option>
                                 <option value="1">First term</option>
                                 <option value="2">Second term</option>
                              </x-slot>
                           </x-real.input>
                        </div>
                        <div class="col-auto">
                           <x-real.input :marginBottom="'0'" :type="'select'" name="course">
                              <x-slot name="label">Course</x-slot>
                              <x-slot name="options">
                                 <option value="">All</option>
                                 @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                 @endforeach
                              </x-slot>
                           </x-real.input>
                        </div>
                        <div class="col-12">
                           <div class="hstack gap-3">
                              <x-real.btn :size="'lg'" type="submit">Filter</x-real.btn>
                              <x-real.btn :size="'lg'" type="reset">Reset</x-real.btn>
                           </div>
                        </div>
                     </form>
                  </x-slot>
               </x-real.card>
            </div>

            <div class="col-12">
               <x-real.card :vertical="'center'" id="onTimeDelayedSyllabusCard">
                  <x-slot name="header">On-time and Delayed Submissions</x-slot>
                  <x-slot name="body">
                     <ul class="list-group">
                        <li class="list-group-item">
                           <div class="hstack justify-content-between">
                              <h6 class="fw-bolder m-0">On Time</h6>
                              <div class="hstack gap-2">
                                 <h5 class="m-0 fw-bolder">{{ $ontimeSubmissions->count() }}</h5>
                                 /
                                 <span class="text-muted">
                                    @if ($submissions->count() > 0)
                                       {{ ($ontimeSubmissions->count() / $submissions->count()) * 100 }} %
                                    @else
                                       0 %
                                    @endif
                                 </span>
                              </div>
                           </div>
                        </li>
                        <li class="list-group-item">
                           <div class="hstack justify-content-between">
                              <h6 class="fw-bolder m-0">Delayed</h6>
                              <div class="hstack gap-2">
                                 <h5 class="m-0 fw-bolder">{{ $delayedSubmissions->count() }}</h5>
                                 /
                                 <span class="text-muted">
                                    @if ($submissions->count() > 0)
                                       {{ ($delayedSubmissions->count() / $submissions->count()) * 100 }} %
                                    @else
                                       0 %
                                    @endif
                                 </span>
                              </div>
                           </div>
                        </li>
                     </ul>
                  </x-slot>
               </x-real.card>
            </div>

            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">Syllabus Submissions Data</x-slot>
                  <x-slot name="body">
                     {!! $dataTable->table(['class' => 'w-100 table align-middle table-hover']) !!}
                  </x-slot>
               </x-real.card>
            </div>
         </div>
      </div>
   </div>

   @section('script')
      {!! $dataTable->scripts() !!}

      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Chartisan -->
      <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

      <script>
         $(document).ready(function() {
            const year = "{{ request()->get('year') }}"
            const yearLevel = "{{ request()->get('year_level') }}"
            const semester = "{{ request()->get('semester') }}"
            const term = "{{ request()->get('term') }}"
            const course = "{{ request()->get('course') }}"

            $("[name='year_level']").val(yearLevel);
            $("[name='semester']").val(semester);
            $("[name='term']").val(term);
            $("[name='course']").val(course);

            new DateRangePicker($('#startDateFilter')[0], {
               pickLevel: 0,
               todayBtn: true,
               allowOnesidedRange: true,
               inputs: [$('#startDateFilter')[0], $('#endDateFilter')[0]]
            })
         })
      </script>
   @endsection
</x-app-layout>
