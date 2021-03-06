<x-app-layout>
   <x-slot name="header">
      Instructor Management
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dashboard') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item active">
         Instructor Management
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-3">
         <x-real.card :vertical="'center'" id="weeklySubmissionChartCard">
            <x-slot name="header">Navigate to</x-slot>
            <x-slot name="body">
               <ul class="nav nav-pills nav-flush persist-default flex-column gap-2">
                  <li class="nav-item">
                     <a href="{{ route('dean.resource.index') }}" class="nav-link active">Resources</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.instructor.index') }}" class="nav-link ">Instructors</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.course.index') }}" class="nav-link">Courses</a>
                  </li>
               </ul>
            </x-slot>
         </x-real.card>
      </div>

      <div class="col-9">
         <div class="row g-3">
            <div class="col-12">
               <div class="row g-3">
                  <div class="col-12">
                     <x-real.table-management :title="'Resources'">
                        <x-slot name="active">
                           {!! $dataTable->table(['class' => 'w-100 table align-middle table-hover']) !!}
                        </x-slot>

                        <x-slot name="archive">
                           <x-real.table id="archivedTable">
                              <x-slot name="headers">
                                 <th>Title</th>
                                 <th>Media</th>
                                 <th>Description</th>
                                 <th>Course</th>
                                 <th>Lesson</th>
                                 <th>Created At</th>
                                 <th></th>
                              </x-slot>
                           </x-real.table>
                        </x-slot>

                        <x-slot name="trash">
                           <x-real.table id="trashedTable">
                              <x-slot name="headers">
                                 <th>Title</th>
                                 <th>Media</th>
                                 <th>Description</th>
                                 <th>Course</th>
                                 <th>Lesson</th>
                                 <th>Created At</th>
                                 <th></th>
                              </x-slot>
                           </x-real.table>
                        </x-slot>
                     </x-real.table-management>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>


   @section('script')
      {!! $dataTable->scripts() !!}

      <script>
         $(document).ready(function() {
            if (!$.fn.dataTable.isDataTable('#archivedTable')) {
               $('#archivedTable, #trashedTable').each(function(index, table) {
                  let tableId = $(table).attr('id')
                  if (tableId == 'archivedTable') tableId = 'archived'
                  else if (tableId == 'trashedTable') tableId = 'trashed'

                  TABLE_MANAGEMENT_PROPS.dom = 'Bplfrtipl'
                  $(table).DataTable({
                     ...TABLE_MANAGEMENT_PROPS,
                     ajax: `{{ route('dean.resource.index') }}?storeType=${tableId}`,
                     columns: [{
                           data: 'title',
                           name: 'Title'
                        },
                        {
                           data: 'media',
                           name: 'Media'
                        },
                        {
                           data: 'description',
                           name: 'Description',
                           width: '110px'
                        },
                        {
                           data: 'course',
                           name: 'Course',
                           width: '120px'
                        },
                        {
                           data: 'lesson',
                           name: 'Lesson',
                           width: '120px'
                        },
                        {
                           data: 'created_at',
                           name: 'created_at',
                           width: '120px'
                        },
                        {
                           data: 'action',
                           name: '',
                           width: '120px'
                        },
                     ]
                  });
               })
            }
         })
      </script>
   @endsection
</x-app-layout>
