<x-app-layout>
   @if ($user->id == auth()->id())
      <x-slot name="header">
         Activity
      </x-slot>
      <x-slot name="breadcrumb">
         <li class="breadcrumb-item">
            <a class="fw-bold" href="{{ route('user.activities', $user) }}">
               <- Go back </a>
         </li>

         <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Home</a>
         </li>

         <li class="breadcrumb-item">
            <a href="{{ route('user.activities', $user) }}"> My Activities</a>
         </li>

         <li class="breadcrumb-item active">
            Activity
         </li>
      </x-slot>
   @else
      <x-slot name="header">
         Activity
      </x-slot>

      <x-slot name="breadcrumb">
         <li class="breadcrumb-item">
            <a class="fw-bold" href="{{ route('user.activities', $user) }}">
               <- Go back </a>
         </li>

         <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Home</a>
         </li>


         <li class="breadcrumb-item">
            <a href="{{ route('user.index') }}">Users</a>
         </li>

         <li class="breadcrumb-item">
            <a href="{{ route('user.show', $user) }}">{{ $user->name }}</a>
         </li>

         <li class="breadcrumb-item">
            <a href="{{ route('user.activities', $user) }}"> My Activities</a>
         </li>

         <li class="breadcrumb-item active">
            Activity
         </li>
      </x-slot>
   @endif

   <div class="row g-3">
      <div class="col-8">
         <x-real.card>
            <x-slot name="header">
               Activity Details
            </x-slot>
            <x-slot name="body">
               <ul class="nav flex-column gap-2">
                  <li class="nav-item border-bottom">
                     <x-real.text-with-subtitle>
                        <x-slot name="text">
                           {{ $activity->log_name ?? 'No value' }}
                        </x-slot>
                        <x-slot name="subtitle">Log type</x-slot>
                     </x-real.text-with-subtitle>
                  </li>
                  <li class="nav-item border-bottom">
                     <x-real.text-with-subtitle>
                        <x-slot name="text">
                           {{ $activity->description ?? 'No value' }}
                        </x-slot>
                        <x-slot name="subtitle">Description</x-slot>
                     </x-real.text-with-subtitle>
                  </li>
                  <li class="nav-item border-bottom">
                     <x-real.text-with-subtitle>
                        <x-slot name="text">
                           {{ $activity->created_at ?? 'No value' }}
                        </x-slot>
                        <x-slot name="subtitle">Logged at</x-slot>
                     </x-real.text-with-subtitle>
                  </li>
                  <li class="nav-item border-bottom">
                     <x-real.text-with-subtitle>
                        <x-slot name="text">
                           {{ $activity->causer->name ?? 'No value' }}
                        </x-slot>
                        <x-slot name="subtitle">Logged by</x-slot>
                     </x-real.text-with-subtitle>
                  </li>
               </ul>
            </x-slot>
         </x-real.card>
      </div>
   </div>

   @section('script')
      <script>
         $(document).ready(function() {



         })
      </script>
   @endsection
</x-app-layout>
