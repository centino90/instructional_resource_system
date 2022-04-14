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
                     <a href="" class="nav-link">Resources</a>
                  </li>
                  <li class="nav-item">
                     <a href="" class="nav-link">Personnels</a>
                  </li>
                  <li class="nav-item">
                     <a href="" class="nav-link">Courses</a>
                  </li>
                  <li class="nav-item">
                     <a href="" class="nav-link">Lessons</a>
                  </li>
                  <li class="nav-item">
                     <a href="" class="nav-link active">Typology Verbs</a>
                  </li>
                  <li class="nav-item">
                     <a href="" class="nav-link">Watermarks</a>
                  </li>
               </ul>
            </x-slot>
         </x-real.card>
      </div>

      <div class="col-8">
         <div class="row g-3">
            <div class="col-12">
               <x-real.table-management :title="'Typlogy'">
                  <x-slot name="active">
                     {!! $dataTable->table(['class' => 'w-100 table align-middle table-hover']) !!}
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

         })
      </script>
   @endsection
</x-app-layout>
