<x-app-layout>
   <x-slot name="header">
      User Management
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dashboard') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item active">
         User Management
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-3">
         <x-real.card :vertical="'center'" id="weeklySubmissionChartCard">
            <x-slot name="header">Navigate to</x-slot>
            <x-slot name="body">
               <ul class="nav nav-pills nav-flush persist-default flex-column gap-2">
                  <li class="nav-item">
                     <a href="{{ route('admin.users.index') }}" class="nav-link active">Users</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('admin.programs.index') }}" class="nav-link ">Programs</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('admin.typology.index') }}" class="nav-link ">Typologies</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.syllabus-settings.index') }}" class="nav-link">Syllabus Settings</a>
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
                     <x-real.table-management :title="'Users Table'">
                        <x-slot name="active">
                           {!! $dataTable->table(['class' => 'w-100 table align-middle table-hover']) !!}
                        </x-slot>

                        <x-slot name="trash">
                           <x-real.table id="trashedTable">
                              <x-slot name="headers">
                                 <th>id</th>
                                 <th>First name</th>
                                 <th>Last name</th>
                                 <th>Role</th>
                                 <th>Email</th>
                                 <th>Contact No</th>
                                 <th>Program</th>
                                 <th>created at</th>
                                 <th>updated at</th>
                                 <th>trashed at</th>
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
               $('#trashedTable').each(function(index, table) {
                  let tableId = $(table).attr('id')
                  if (tableId == 'archivedTable') tableId = 'archived'
                  else if (tableId == 'trashedTable') tableId = 'trashed'

                  TABLE_MANAGEMENT_PROPS.dom = 'Bplfrtipl'
                  $(table).DataTable({
                     ...TABLE_MANAGEMENT_PROPS,
                     ajax: `{{ route('admin.users.index') }}?storeType=${tableId}`,
                     columns: [{
                           data: 'id',
                           name: 'id',
                           width: '120px'
                        },
                        {
                           data: 'first_name',
                           name: 'first_name',
                           width: '120px'
                        },
                        {
                           data: 'last_name',
                           name: 'last_name',
                           width: '120px'
                        },
                        {
                           data: 'role',
                           name: 'role',
                           width: '120px'
                        },
                        {
                           data: 'email',
                           name: 'email',
                           width: '120px'
                        },

                        {
                           data: 'contact_no',
                           name: 'contact_no',
                           width: '120px'
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
                           data: 'updated_at',
                           name: 'updated_at',
                           width: '120px'
                        },
                        {
                           data: 'trashed_at',
                           name: 'trashed_at',
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
