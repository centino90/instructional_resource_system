<x-app-layout>
   @if ($user->id == auth()->id())
      <x-slot name="header">
         My Lessons
      </x-slot>
      <x-slot name="breadcrumb">
         <li class="breadcrumb-item">
            <a class="fw-bold" href="{{ route('dashboard') }}">
               <- Go back </a>
         </li>

         <li class="breadcrumb-item active">
            My Lessons
         </li>
      </x-slot>
   @else
      <x-slot name="header">
         Lessons
      </x-slot>

      <x-slot name="breadcrumb">
         <li class="breadcrumb-item">
            <a class="fw-bold" href="{{ route('user.show', $user) }}">
               <- Go back </a>
         </li>

         <li class="breadcrumb-item">
            <a href="{{ route('user.index') }}">Users</a>
         </li>


         <li class="breadcrumb-item">
            <a href="{{ route('user.show', $user) }}">{{ $user->name }}</a>
         </li>

         <li class="breadcrumb-item active">
            Lessons
         </li>
      </x-slot>
   @endif

   <div class="modal modal-sheet bg-secondary py-5" tabindex="-1" role="dialog" id="courseLessonModal">
      <div class="modal-dialog" role="document">
         <div class="modal-content rounded-6 shadow">
            <div class="modal-header border-bottom-0">
               <h5 class="modal-title">Add new lesson</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5 py-5">
               <div class="row">
                  <x-real.form action="{{ route('lesson.store') }}">
                     <input hidden type="check" name="returnRoute" checked value=1 />

                     <div class="col-12">
                        <x-real.input :type="'select'" name="course_id">
                           <x-slot name="options">
                              @foreach ($user->programs->first()->courses as $course)
                                 <option value="{{ $course->id }}">{{ $course->title }}
                                    ({{ $course->code }})
                                 </option>
                              @endforeach
                           </x-slot>
                           <x-slot name="label">Course</x-slot>
                        </x-real.input>
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
                              <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Submit</button>
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

   <div class="row g-3">
      @if ($user->id == auth()->id())
         <div class="col-12">
            <div class="hstack justify-content-end">
               <a data-bs-toggle="modal" id="newLessonModalBtn" data-bs-target="#courseLessonModal"
                  data-bs-title="Create Lesson" data-bs-mode="create" data-bs-toggle-type="create"
                  class="btn btn-primary ms-auto">
                  <span class="material-icons align-middle md-18">
                     upload_file
                  </span>
                  New lesson
               </a>
            </div>
         </div>
      @endif

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

   @section('script')
      {!! $dataTable->scripts() !!}

      <script>
         $(document).ready(function() {
            if (!$.fn.dataTable.isDataTable('#archivedTable')) {
               $('#archivedTable, #trashedTable').each(function(index, table) {
                  let tableId = $(table).attr('id')
                  if (tableId == 'archivedTable') tableId = 'archived'
                  else if (tableId == 'trashedTable') tableId = 'trashed'

                  $(table).DataTable({
                    ...TABLE_MANAGEMENT_PROPS,
                    ajax: `{{ route('user.lessons', $user) }}?storeType=${tableId}`,
                    columns: [
                        {
                           data: 'created_at',
                           name: 'created_at',
                           width: '120px'
                        },
                        {
                           data: 'title',
                           name: 'title',
                           width: '120px'
                        },
                        {
                           data: 'description',
                           name: 'description',
                           width: '120px'
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
