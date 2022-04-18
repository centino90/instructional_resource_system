<x-app-layout>
   <x-slot name="header">
      {{ $lesson->title }}
   </x-slot>

   <x-slot name="headerTitle">
      Lesson
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('course.showLessons', $lesson->course) }}">
            <- Go back</a>
      </li>
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a
            href="{{ route('course.show', $lesson->course) }}">{{ $lesson->course->code }}</a>
      </li>
      <li class="breadcrumb-item"><a href="{{ route('course.showLessons', $lesson->course) }}">Course lessons</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $lesson->title }}</li>
   </x-slot>

   <div class="row g-3">
      <div class="col-3">
         <div class="row g-3">

            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">Some actions</x-slot>
                  <x-slot name="body">
                     <div class="d-grid gap-2">
                        <x-real.btn :tag="'a'" href="{{ route('lesson.edit', $lesson) }}">
                           Edit lesson
                        </x-real.btn>

                        @if (!$lesson->trashed())
                           <a href="{{ route('resource.create', $lesson) }}" class="btn btn-primary">Submit
                              resource</a>
                        @endif

                        @if ($lesson->resources->count() > 0)
                           <x-real.form action="{{ route('resource.downloadAllByLesson', $lesson) }}">
                              <x-slot name="submit">
                                 <x-real.btn type="submit" :icon="'file_download'" class="me-auto no-loading w-100">
                                    Download all resources
                                 </x-real.btn>
                              </x-slot>
                           </x-real.form>
                        @endif
                     </div>
                  </x-slot>
               </x-real.card>
            </div>


            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">Status</x-slot>
                  <x-slot name="body">
                     @if ($lesson->storage_status == 'Trashed')
                        <span class="badge bg-danger text-white">{{ $lesson->storage_status }}</span>
                     @elseif ($lesson->storage_status == 'Archived')
                        <span class="badge bg-warning text-dark">{{ $lesson->storage_status }}</span>
                     @else
                        <span class="badge bg-success text-white">{{ $lesson->storage_status }}</span>
                     @endif
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
   </div>

   @section('script')
      {!! $dataTable->scripts() !!}

      <script>
         $(document).ready(function() {

         })
      </script>
   @endsection
</x-app-layout>
