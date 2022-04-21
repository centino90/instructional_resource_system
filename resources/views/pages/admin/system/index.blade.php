<x-app-layout>
   <x-slot name="header">
      System Settings
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dashboard') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">
         System Settings
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-12">
         <div class="row g-3">
            <div class="col-6">
               <x-real.card>
                  <x-slot name="header">OLD SYLLABUS YEARLY INTERVAL</x-slot>

                  <x-slot name="body">
                     <x-real.form method="PUT" action="{{ route('admin.system.updateOldSyllabusInterval') }}">
                        <x-real.input value="{{ $settings->old_syllabus_year_interval }}" name="old_syllabus_year_interval">
                           <x-slot name="label">Yearly Interval</x-slot>
                        </x-real.input>
                        <x-real.btn type="submit">Update</x-real.btn>
                     </x-real.form>
                  </x-slot>
               </x-real.card>

            </div>
            <div class="col-6">
               <x-real.card>
                  <x-slot name="header">DELAYED SYLLABUS WEEKLY INTERVAL</x-slot>
                  <x-slot name="body">
                     <x-real.form method="PUT" action="{{ route('admin.system.updateDelayedSyllabusInterval') }}">
                        <x-real.input value="{{ $settings->delayed_syllabus_week_interval }}" name="delayed_syllabus_week_interval">
                           <x-slot name="label" >Monthly Interval</x-slot>
                        </x-real.input>
                        <x-real.btn type="submit">Update</x-real.btn>
                     </x-real.form>
                  </x-slot>
               </x-real.card>
            </div>
         </div>
      </div>
   </div>

   @section('script')
      <script>
         $(document).ready(function() {

         })
      </script>
   @endsection
</x-app-layout>
