<x-app-layout>
   <x-slot name="header">
      Resource Reports
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dashboard') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item active">
         Resource Reports
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
                     <a href="{{ route('dean.reports.submissions', ['storeType' => 'all']) }}" class="nav-link active">
                        <span class="material-icons md-18 align-middle">summarize</span>
                        <small>Submissions</small>
                     </a>
                  </li>
                  {{-- <li class="nav-item">
                     <a href="{{ route('dean.reports.syllabus') }}" class="nav-link">
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
                     <form method="GET" action="{{ route('dean.reports.submissions') }}" class="row g-3">
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

            {{-- <div class="col-12">
                <div class="hstack gap-3 justify-content-end">
                    <x-real.btn class="bg-white">DOWNLOAD SUMMARY</x-real.btn>
                </div>
            </div> --}}

            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">Summary of submissions</x-slot>
                  <x-slot name="body">
                     <ul class="list-group">
                        @foreach ($byTypes as $key => $submission)
                           <li class="list-group-item">
                              <div class="hstack justify-content-between">
                                 <div>{{ $key }}</div>
                                 <div><b>{{ $submission->count() }}</b> <span
                                       class="text-muted">({{ $submission->count() == 0 ? 0 : round($submission->count() / $submissions->count(), 2) }}
                                       %)</span></div>
                              </div>
                           </li>
                        @endforeach
                        <li class="list-group-item">
                           <div class="hstack justify-content-between">
                              <small class="text-muted">Total</small>
                              <h5 class="my-0"><b>{{ $submissions->count() }}</b></h5>
                           </div>
                        </li>
                     </ul>
                  </x-slot>
               </x-real.card>
            </div>

            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">More Information</x-slot>
                  <x-slot name="body">
                     <ul class="row row-cols-4 nav px-3">
                        <li class="border p-3 col">
                           <div class="hstack justify-content-between">
                              <small>Courses contributed</small>
                              <h5 class="my-0"><b>{{ $submissions->groupBy('course_id')->count() }}</b>
                              </h5>
                           </div>
                        </li>
                        <li class="border p-3 col">
                           <div class="hstack justify-content-between">
                              <small>Lessons contributed</small>
                              <h5 class="my-0"><b>{{ $submissions->groupBy('lesson_d')->count() }}</b>
                              </h5>
                           </div>
                        </li>
                        <li class="border p-3 col">
                           <div class="hstack justify-content-between">
                              <small>Instructors Submitted</small>
                              <h5 class="my-0"><b>{{ $submissions->groupBy('user_id')->count() }}</b>
                              </h5>
                           </div>
                        </li>
                        <li class="border p-3 col">
                           <div class="hstack justify-content-between">
                              <small>Versions Created</small>
                              <h5 class="my-0"><b>{{ $submissions->sum('media_count') }}</b></h5>
                           </div>
                        </li>
                        <li class="border p-3 col">
                           <div class="hstack justify-content-between">
                              <small>Total Views</small>
                              <h5 class="my-0"><b>{{ $submissions->sum('views') }}</b></h5>
                           </div>
                        </li>
                        <li class="border p-3 col">
                           <div class="hstack justify-content-between">
                              <small>Total Downloads</small>
                              <h5 class="my-0"><b>{{ $submissions->sum('downloads') }}</b></h5>
                           </div>
                        </li>
                        <li class="border p-3 col">
                           <div class="hstack justify-content-between">
                              <small>Approved</small>
                              <h5 class="my-0">
                                 <b>{{ isset($submissions->groupBy('verification_status')['Approved'])? $submissions->groupBy('verification_status')['Approved']->count(): 0 }}</b>
                              </h5>
                           </div>
                        </li>
                        <li class="border p-3 col">
                           <div class="hstack justify-content-between">
                              <small>Pending</small>
                              <h5 class="my-0">
                                 <b>{{ isset($submissions->groupBy('verification_status')['Pending'])? $submissions->groupBy('verification_status')['Pending']->count(): 0 }}</b>
                              </h5>
                           </div>
                        </li>
                        <li class="border p-3 col">
                           <div class="hstack justify-content-between">
                              <small>Current</small>
                              <h5 class="my-0">
                                 <b>{{ isset($submissions->groupBy('storage_status')['Current'])? $submissions->groupBy('storage_status')['Current']->count(): 0 }}</b>
                              </h5>
                           </div>
                        </li>
                        <li class="border p-3 col">
                           <div class="hstack justify-content-between">
                              <small>Archived</small>
                              <h5 class="my-0">
                                 <b>{{ isset($submissions->groupBy('storage_status')['Archived'])? $submissions->groupBy('storage_status')['Archived']->count(): 0 }}</b>
                              </h5>
                           </div>
                        </li>
                        <li class="border p-3 col">
                           <div class="hstack justify-content-between">
                              <small>Trashed</small>
                              <h5 class="my-0">
                                 <b>{{ isset($submissions->groupBy('storage_status')['Trashed'])? $submissions->groupBy('storage_status')['Trashed']->count(): 0 }}</b>
                              </h5>
                           </div>
                        </li>
                     </ul>
                  </x-slot>
               </x-real.card>
            </div>

            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">Submission Data</x-slot>
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
      {{-- <script src="https://unpkg.com/chart.js@^2.9.4/dist/Chart.min.js"></script> --}}
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Chartisan -->
      <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

      <script>
         $(document).ready(function() {
            $("[name='year_level']").val("{{ request()->get('year_level') }}");
            $("[name='semester']").val("{{ request()->get('semester') }}");
            $("[name='term']").val("{{ request()->get('term') }}");
            $("[name='course']").val("{{ request()->get('course') }}");

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
