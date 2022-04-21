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
                     <a href="{{ route('dean.reports.submissions', ['storeType' => 'all']) }}" class="nav-link ">
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
                     <a href="{{ route('dean.reports.courses') }}" class="nav-link active">
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
                     <form method="GET" action="{{ route('dean.reports.courses') }}" class="row g-3">
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
               <x-real.card>
                  <x-slot name="header">Syllabus Status Summary</x-slot>
                  <x-slot name="body">
                     <ul class="list-group">
                        <li class="list-group-item">
                           <div class="hstack justify-content-between">
                              <h6 class="fw-bold badge text-white bg-danger m-0 fs-6">No Syllabi</h6>
                              <div class="hstack gap-2">
                                 <h5 class="m-0">{{ $withoutSyllabi->count() }}</h5>
                                 /
                                 @if (!empty($courses))
                                    {{ round($withoutSyllabi->count() / $courses->count(), 2) * 100 }} %
                                 @endif
                              </div>
                           </div>
                        </li>
                        <li class="list-group-item">
                           <div class="hstack justify-content-between">
                              <h6 class="fw-bold badge text-white bg-success m-0 fs-6">Updated Syllabi</h6>
                              <div class="hstack gap-2">
                                 <h5 class="m-0">{{ $updatedSyllabi->count() }}</h5>
                                 /
                                 @if (!empty($courses))
                                    {{ round($updatedSyllabi->count() / $courses->count(), 2) * 100 }} %
                                 @endif
                              </div>
                           </div>
                        </li>
                        <li class="list-group-item">
                           <div class="hstack justify-content-between">
                              <h6 class="fw-bold badge text-dark bg-warning m-0 fs-6">Old Syllabi</h6>
                              <div class="hstack gap-2">
                                 <h5 class="m-0">{{ $oldSyllabi->count() }}</h5>
                                 /
                                 @if (!empty($courses))
                                    {{ round($oldSyllabi->count() / $courses->count(), 2) * 100 }} %
                                 @endif
                              </div>
                           </div>
                        </li>
                        <li class="list-group-item">
                           <div class="hstack justify-content-between">
                              <small class="text-muted">Total</small>
                              <div class="hstack gap-2">
                                 <h5 class="m-0">{{ $courses->count() }}</h5>
                                 /
                                 100 %
                              </div>
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
                                <small>Total Courses</small>
                                <h5 class="m-0 fw-bolder">{{$totalCourse}}</h5>
                            </div>
                        </li>
                        <li class="border p-3 col">
                            <div class="hstack justify-content-between">
                                <small>With Syllabi</small>
                                <h5 class="m-0 fw-bolder">{{$withSyllabi->count()}}</h5>
                            </div>
                        </li>
                        <li class="border p-3 col">
                            <div class="hstack justify-content-between">
                                <small>Without Syllabi</small>
                                <h5 class="m-0 fw-bolder">{{$withoutSyllabi->count()}}</h5>
                            </div>
                        </li>
                        <li class="border p-3 col">
                            <div class="hstack justify-content-between">
                                <small>With Lessons</small>
                                <h5 class="m-0 fw-bolder">{{$withLessons->count()}}</h5>
                            </div>
                        </li>
                        <li class="border p-3 col">
                            <div class="hstack justify-content-between">
                                <small>Without Lessons</small>
                                <h5 class="m-0 fw-bolder">{{$withoutLessons->count()}}</h5>
                            </div>
                        </li>
                        <li class="border p-3 col">
                            <div class="hstack justify-content-between">
                                <small>Total Submissions</small>
                                <h5 class="m-0 fw-bolder">{{$totalSubmissions}}</h5>
                            </div>
                        </li>
                        <li class="border p-3 col">
                            <div class="hstack justify-content-between">
                                <small>Total Lessons</small>
                                <h5 class="m-0 fw-bolder">{{$totalLessons}}</h5>
                            </div>
                        </li>
                        <li class="border p-3 col">
                            <div class="hstack justify-content-between">
                                <small>Submitters</small>
                                <h5 class="m-0 fw-bolder">{{$resourceAuthors->count()}}</h5>
                            </div>
                        </li>
                        <li class="border p-3 col">
                            <div class="hstack justify-content-between">
                                <small>Lesson Authors</small>
                                <h5 class="m-0 fw-bolder">{{$lessonAuthors->count()}}</h5>
                            </div>
                        </li>
                     </ul>
                  </x-slot>
               </x-real.card>
            </div>

            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">Course Data</x-slot>
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
