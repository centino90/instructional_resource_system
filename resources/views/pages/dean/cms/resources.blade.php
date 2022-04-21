<x-app-layout>
   <x-slot name="header">
      Content Management
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dashboard') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item active">
         Content Management
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-4">
         <x-real.card :vertical="'center'" id="weeklySubmissionChartCard">
            <x-slot name="header">Navigate to</x-slot>
            <x-slot name="body">
               <ul class="nav nav-pills nav-flush persist-default flex-column gap-2">
                <li class="nav-item">
                    <a href="{{ route('dean.cms.resources', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}" class="nav-link active">Resources</a>
                 </li>
                 <li class="nav-item">
                    <a href="{{ route('dean.cms.personnels',  ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}" class="nav-link ">Personnels</a>
                 </li>
                 <li class="nav-item">
                    <a href="{{ route('dean.cms.courses' , ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}" class="nav-link">Courses</a>
                 </li>
                 <li class="nav-item">
                    <a href="{{ route('dean.cms.lessons' , ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}" class="nav-link">Lessons</a>
                 </li>
                 <li class="nav-item">
                    <a href="{{ route('dean.cms.typology' , ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}" class="nav-link">Typology Verbs</a>
                 </li>
               </ul>
            </x-slot>
         </x-real.card>
      </div>

      <div class="col-8">
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

   @section('script')
      {!! $dataTable->scripts() !!}

      <script>
         $(document).ready(function() {
            const accessType = '{{ auth()->user()->role_id }}'
            if (!$.fn.dataTable.isDataTable('#archivedTable')) {
               $('#archivedTable, #trashedTable').each(function(index, table) {
                  let tableId = $(table).attr('id')
                  if (tableId == 'archivedTable') tableId = 'archived'
                  else if (tableId == 'trashedTable') tableId = 'trashed'

                  $(table).DataTable({
                     dom: 'Bfrtip',
                     processing: true,
                     serverSide: true,
                     bStateSave: true,
                     stateSaveParams: function(settings, data) {
                        data.search.search = ""
                     },
                     buttons: {
                        buttons: ['export', 'print', 'reset', 'reload'],
                        dom: {
                           button: {
                              className: 'btn border text-primary'
                           }
                        }
                     },
                     ajax: `{{ route('dean.cms.resources') }}?storeType=${tableId}&accessType=${accessType}`,
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
