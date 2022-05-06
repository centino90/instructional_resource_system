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
                       <a href="{{ route('dean.resource.index') }}" class="nav-link">Resources</a>
                    </li>
                    <li class="nav-item">
                       <a href="{{ route('dean.instructor.index') }}" class="nav-link active">Instructors</a>
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
                     <x-real.table-management :title="'Instructor Table'">
                        <x-slot name="active">
                           {!! $dataTable->table(['class' => 'w-100 table align-middle table-hover']) !!}
                        </x-slot>

                        <x-slot name="trash">
                           <x-real.table id="trashedTable">
                              <x-slot name="headers">
                                 <th>first name</th>
                                 <th>last name</th>
                                 <th>email</th>
                                 <th>contact no</th>
                                 <th>program</th>
                                 <th>created at</th>
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
            const accessType = '{{ auth()->user()->role_id }}'
            if (!$.fn.dataTable.isDataTable('#archivedTable')) {
               $('#trashedTable').each(function(index, table) {
                  let tableId = $(table).attr('id')
                  if (tableId == 'archivedTable') tableId = 'archived'
                  else if (tableId == 'trashedTable') tableId = 'trashed'

                  TABLE_MANAGEMENT_PROPS.dom = 'Bplfrtipl'
                  $(table).DataTable({
                     ...TABLE_MANAGEMENT_PROPS,
                     ajax: `{{ route('dean.instructor.index') }}?storeType=${tableId}`,
                     columns: [{
                           data: 'first_name',
                           name: 'first_name'
                        },
                        {
                           data: 'last_name',
                           name: 'last_name'
                        },
                        {
                           data: 'email',
                           name: 'email',
                           width: '110px'
                        },
                        {
                           data: 'contact_no',
                           name: 'contact_no',
                           width: '110px'
                        },
                        {
                           data: 'program',
                           name: 'program',
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
