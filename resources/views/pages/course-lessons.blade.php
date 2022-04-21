<x-app-layout>
   <x-slot name="header">
      Course Lessons
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('course.show', $course) }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('course.show', $course) }}">{{ $course->code }}</a></li>
      <li class="breadcrumb-item active">
         Course Lessons
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-12">
         <div class="row g-3">
            <div class="col-12">
               <x-real.card>
                  <x-slot name="header">Lessons</x-slot>
                  <x-slot name="body">
                     {!! $dataTable->table(['class' => 'w-100 table align-middle table-hover']) !!}
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

         })
      </script>
   @endsection
</x-app-layout>
