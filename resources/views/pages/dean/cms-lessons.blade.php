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
                     <a href="{{ route('dean.cms.resources', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link">Resources</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.cms.personnels', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link">Personnels</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.cms.courses', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link">Courses</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.cms.lessons', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link active">Lessons</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.cms.typology', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link">Typology Verbs</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.cms.watermarks', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link">Watermarks</a>
                  </li>
               </ul>
            </x-slot>
         </x-real.card>
      </div>

      <div class="col-8">
         <div class="row g-3">
            <div class="col-12">
               <div class="row g-3">
                  <div class="col-12">
                     <x-real.table-management :title="'Lessons'">
                        <x-slot name="active">
                           {!! $dataTable->table(['class' => 'w-100 table align-middle table-hover']) !!}
                        </x-slot>

                        <x-slot name="archive">
                           <x-real.table id="archivedTable">
                              <x-slot name="headers">
                                 <th>title</th>
                                 <th>description</th>
                                 <th>course</th>
                                 <th>submitter</th>
                                 <th>resources_count</th>
                                 <th>created_at</th>
                                 <th></th>
                              </x-slot>
                           </x-real.table>
                        </x-slot>

                        <x-slot name="trash">
                           <x-real.table id="trashedTable">
                              <x-slot name="headers">
                                 <th>title</th>
                                 <th>description</th>
                                 <th>course</th>
                                 <th>submitter</th>
                                 <th>resources_count</th>
                                 <th>created_at</th>
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

   <div class="modal modal-sheet bg-secondary py-5" tabindex="-1" role="dialog" id="courseLessonModal">
      <div class="modal-dialog" role="document">
         <div class="modal-content rounded-6 shadow">
            <div class="modal-header border-bottom-0">
               <h5 class="modal-title"></h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5 py-5">
               <div class="editLesson collapse">
                  <div class="row">
                     <x-real.form action="{{ route('lesson.index') }}" :method="'PUT'">
                        <div class="col-12">
                           <x-real.input name="title">
                              <x-slot name="label">Name</x-slot>
                           </x-real.input>

                           <x-real.input :type="'textarea'" name="description">
                              <x-slot name="label">Description</x-slot>
                           </x-real.input>
                        </div>

                        <x-slot name="submit">
                           <div class="col-12 mt-4">
                              <div class="d-grid gap-2 w-100">
                                 <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                                    update</button>
                                 <button type="button" class="btn btn-lg btn-light mx-0 rounded-4"
                                    data-bs-dismiss="modal">Close</button>
                              </div>
                           </div>
                        </x-slot>
                     </x-real.form>
                  </div>
               </div>

               <div class="archiveLesson collapse">
                  <div class="row">
                     <x-real.form action="{{ route('lesson.index') }}" :method="'PUT'">
                        <div class="col-12">
                           <div class="confirmAlert alert alert-primary">Do you want to move this lesson to
                              archive?</div>
                        </div>
                        <x-slot name="submit">
                           <div class="col-12 mt-4">
                              <div class="d-grid gap-2 w-100">
                                 <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                                 </button>
                                 <button type="button" class="btn btn-lg btn-light mx-0 rounded-4"
                                    data-bs-dismiss="modal">Close</button>
                              </div>
                           </div>
                        </x-slot>
                     </x-real.form>
                  </div>
               </div>

               <div class="trashLesson collapse">
                  <div class="row">
                     <x-real.form action="{{ route('lesson.index') }}" :method="'DELETE'">
                        <div class="col-12">
                           <div class="confirmAlert alert alert-primary">Do you want to move this lesson to
                              trash?
                           </div>
                        </div>
                        <x-slot name="submit">
                           <div class="col-12 mt-4">
                              <div class="d-grid gap-2 w-100">
                                 <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                                 </button>
                                 <button type="button" class="btn btn-lg btn-light mx-0 rounded-4"
                                    data-bs-dismiss="modal">Close</button>
                              </div>
                           </div>
                        </x-slot>
                     </x-real.form>
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
                     ajax: `{{ route('dean.cms.lessons') }}?storeType=${tableId}&accessType=${accessType}`,
                     columns: [{
                           data: 'title',
                           name: 'title'
                        },
                        {
                           data: 'description',
                           name: 'description'
                        },
                        {
                           data: 'course',
                           name: 'course',
                           width: '110px'
                        },
                        {
                           data: 'submitter',
                           name: 'submitter',
                           width: '120px'
                        },
                        {
                           data: 'resources_count',
                           name: 'resources_count',
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
