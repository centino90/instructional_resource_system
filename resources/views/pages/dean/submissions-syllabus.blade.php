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
                       <a href="{{ route('dean.reports.syllabus') }}" class="nav-link active">
                          <span class="material-icons md-18 align-middle">schedule_send</span>
                          <small> Ontime and Delayed Syllabus</small>
                       </a>
                    </li>
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
                     <form method="GET" action="{{ route('dean.reports.syllabus') }}" class="row g-3">
                        <div class="col-auto">
                           <x-real.input id="reportFilter" name="year"
                              value="{{ request()->get('year') ?? date('m-d-Y') }}">
                              <x-slot name="label">Year</x-slot>
                           </x-real.input>
                        </div>
                        <div class="col-auto">
                           <x-real.input :type="'select'" name="year_level">
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
                           <x-real.input :type="'select'" name="semester">
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
                           <x-real.input :type="'select'" name="term">
                              <x-slot name="label">Term</x-slot>
                              <x-slot name="options">
                                 <option value="">All</option>
                                 <option value="1">First term</option>
                                 <option value="2">Second term</option>
                              </x-slot>
                           </x-real.input>
                        </div>
                        <div class="col-auto">
                           <x-real.input :type="'select'" name="course">
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
                              <x-real.btn :size="'lg'">Filter</x-real.btn>
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
                     <div id="onTimeDelayedSyllabusChart" style="height: 300px;"></div>
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

            new Datepicker($('#reportFilter')[0], {
               pickLevel: 2
            })

            const yearlyResourcesChart = new Chartisan({
               el: '#onTimeDelayedSyllabusChart',
               url: "@chart('on_time_delayed_syllabus_chart', ['year' => request()->get('year'),'year_level' => request()->get('year_level'),'semester' => request()->get('semester'),'term' => request()->get('term'),'course' => request()->get('course')])",
               hooks: new ChartisanHooks()
                  .legend()
                  .colors()
                  .tooltip()
                  .datasets([{
                     type: 'bar',
                     indexAxis: 'y',
                     backgroundColor: '#298063'
                  }, {
                     type: 'bar',
                     indexAxis: 'y'
                  }]),
            });
         })
      </script>
   @endsection
</x-app-layout>
