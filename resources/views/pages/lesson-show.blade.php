<x-app-layout>
   <x-slot name="header">
      {{ $lesson->title }}
   </x-slot>

   <x-slot name="headerTitle">
      Lesson
   </x-slot>

   <x-slot name="breadcrumb">
      @can('view', $lesson->course)
         <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('course.showLessons', $lesson->course) }}">
               <- Go back</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
         <li class="breadcrumb-item"><a
               href="{{ route('course.show', $lesson->course) }}">{{ $lesson->course->code }}</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ route('course.showLessons', $lesson->course) }}">Course lessons</a></li>
         <li class="breadcrumb-item active" aria-current="page">{{ $lesson->title }}</li>
      @else
         <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('dashboard') }}">
               <- Go back</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">
            {{ $lesson->course->code }}
         </li>
         <li class="breadcrumb-item">
            Course lessons
         </li>
         <li class="breadcrumb-item active" aria-current="page">{{ $lesson->title }}</li>
      @endcan
   </x-slot>

   <div class="row g-3">
      @cannot('participate', $lesson->course)
         <div class="col-12">
            <x-real.alert :variant="'info'">Currently, you are only allowed to edit this lesson or submit resources on this
               lesson. You can ask the designated PD for further access rights.</x-real.alert>
         </div>
      @endcan

      <div class="col-3">
         <div class="row g-3">

            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">Some actions</x-slot>
                  <x-slot name="body">
                     <div class="d-grid gap-2">
                        @can('participate', $lesson->course)
                           @can('update', $lesson)
                              <x-real.btn :tag="'a'" href="{{ route('lesson.edit', $lesson) }}">
                                 Edit lesson
                              </x-real.btn>

                              @if (!$lesson->trashed())
                                 <a href="{{ route('resource.create', $lesson) }}" class="btn btn-primary">Submit
                                    resource</a>
                              @endif
                           @endcan
                        @endcan

                        @if ($lesson->resources->count() > 0)
                           <x-real.form action="{{ route('resource.downloadAllByLesson', $lesson) }}">
                              <x-slot name="submit">
                                 <x-real.btn type="submit" :icon="'file_download'" class="me-auto no-loading w-100">
                                    Download all resources
                                 </x-real.btn>
                              </x-slot>
                           </x-real.form>
                        @else
                           <x-real.no-rows>
                              <x-slot name="label">There are no resources to download</x-slot>
                           </x-real.no-rows>
                        @endif
                     </div>
                  </x-slot>
               </x-real.card>
            </div>


            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">Lesson Details</x-slot>
                  <x-slot name="body">
                     <x-real.text-with-subtitle>
                        <x-slot name="text">
                           {{ $lesson->title }}
                        </x-slot>
                        <x-slot name="subtitle">Title</x-slot>
                     </x-real.text-with-subtitle>

                     <x-real.text-with-subtitle class="mt-2">
                        <x-slot name="text">
                           {{ $lesson->user->name }}
                        </x-slot>
                        <x-slot name="subtitle">Author</x-slot>
                     </x-real.text-with-subtitle>

                     <x-real.text-with-subtitle class="mt-2">
                        <x-slot name="text">
                           {{ $lesson->course->code }} - {{ $lesson->course->title }}
                        </x-slot>
                        <x-slot name="subtitle">Course</x-slot>
                     </x-real.text-with-subtitle>

                     <x-real.text-with-subtitle class="mt-2">
                        <x-slot name="text">
                           {{ $lesson->course->program->code }} - {{ $lesson->course->program->title }}
                        </x-slot>
                        <x-slot name="subtitle">Program</x-slot>
                     </x-real.text-with-subtitle>

                     <x-real.text-with-subtitle class="mt-2">
                        <x-slot name="text">
                           @if ($lesson->storage_status == 'Trashed')
                              <span class="badge bg-danger text-white">{{ $lesson->storage_status }}</span>
                           @elseif ($lesson->storage_status == 'Archived')
                              <span class="badge bg-warning text-dark">{{ $lesson->storage_status }}</span>
                           @else
                              <span class="badge bg-success text-white">{{ $lesson->storage_status }}</span>
                           @endif
                        </x-slot>
                        <x-slot name="subtitle">Status</x-slot>
                     </x-real.text-with-subtitle>
                  </x-slot>
               </x-real.card>
            </div>
         </div>
      </div>
      <div class="col-9">
         <x-real.card>
            <x-slot name="header">Resources</x-slot>
            <x-slot name="body">
               {!! $dataTable->table(['class' => 'w-100 table align-middle table-hover']) !!}
            </x-slot>
         </x-real.card>
      </div>
   </div>

   @section('script')
      {!! $dataTable->scripts() !!}

      <script>
         $(document).ready(function() {

         })
      </script>
   @endsection
</x-app-layout>
