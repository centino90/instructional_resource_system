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
                     <a href="{{ route('dean.reports.submissions', ['storeType' => 'all']) }}" class="nav-link">
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
            <div class="col-8">
               <x-real.card class="mb-3">
                  <x-slot name="header">Most Active Submitters</x-slot>
                  <x-slot name="body">
                     <ul class="list-group">
                        @foreach ($fiveMostActiveSubmitters as $submitter)
                           <li class="list-group-item">
                              <div class="hstack justify-content-between">
                                 <h6 class="m-0">{{ $submitter->name }}</h6>
                                 <h6 class="fw-bold m-0">{{ $submitter->activityLogs->count() }}</h6>
                              </div>
                           </li>
                        @endforeach
                        <li class="list-group-item">
                           <div class="hstack justify-content-between">
                              <small class="text-muted">Total Submissions</small>
                              <h5 class="m-0 fw-bold">{{ $submissionsActivities->count() }}</h5>
                           </div>
                        </li>
                     </ul>
                  </x-slot>
               </x-real.card>

               <x-real.card>
                  <x-slot name="header">Most Active Instructors (Overall)</x-slot>
                  <x-slot name="body">
                     <ul class="list-group">
                        @foreach ($fiveMostActiveInstructors as $submitter)
                           <li class="list-group-item">
                              <div class="hstack justify-content-between">
                                 <h6 class="m-0">{{ $submitter->name }}</h6>
                                 <div class="hstack align-items-center gap-3">
                                    <div class="btn-group">
                                       <a href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                          aria-expanded="false">
                                          <span class="material-icons">
                                             more_horiz
                                          </span>
                                       </a>
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
                                                <li class="list-group-item">
                                                   <x-real.btn :size="'sm'" :tag="'a'"
                                                      href="{{ route('user.show', $submitter) }}">View profile
                                                   </x-real.btn>
                                                </li>
                                             </ul>
                                          </li>
                                       </ul>
                                    </div>
                                    <h6 class="fw-bold m-0">{{ $submitter->activityLogs->count() }}</h6>
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
                  <x-slot name="header">Instructor Activities Summary</x-slot>
                  <x-slot name="body">
                     <x-real.table id="mostActiveInstructorsTable">
                        <x-slot name="headers">
                           <th>id</th>
                           <th>name</th>
                           <th>email</th>
                           <th>resources_count</th>
                           <th>lessons_count</th>
                           <th>activity_logs_count</th>
                           <th>created_at</th>
                           <th></th>
                        </x-slot>
                     </x-real.table>
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

      <script>
         $(document).ready(function() {
            new DateRangePicker($('#startDateFilter')[0], {
               pickLevel: 0,
               todayBtn: true,
               allowOnesidedRange: true,
               inputs: [$('#startDateFilter')[0], $('#endDateFilter')[0]]
            })

            TABLE_MANAGEMENT_PROPS.dom = 'Bplfrtipl'

            $('#mostActiveInstructorsTable').DataTable({
               ...TABLE_MANAGEMENT_PROPS,
               ajax: `{{ route('dean.reports.instructorsTable') }}`,
               columns: [{
                     data: 'id',
                     name: 'id'
                  },
                  {
                     data: 'name',
                  },
                  {
                     data: 'email',
                  },
                  {
                     data: 'resources_count',

                  },
                  {
                     data: 'lessons_count',

                  },
                  {
                     data: 'activity_logs_count',

                  },
                  {
                     data: 'created_at',
                  },
                  {
                     data: 'action',
                     name: '',
                     width: '120px'
                  },
               ]
            });
         })
      </script>
   @endsection
</x-app-layout>
