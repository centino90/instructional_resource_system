<x-app-layout>
   @if ($user->id == auth()->id())
      <x-slot name="header">
         My Activities
      </x-slot>
      <x-slot name="breadcrumb">
         <li class="breadcrumb-item">
            <a class="fw-bold" href="{{ route('dashboard') }}">
               <- Go back </a>
         </li>

         <li class="breadcrumb-item active">
            My Activities
         </li>
      </x-slot>
   @else
      <x-slot name="header">
         Activities
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
            Activities
         </li>
      </x-slot>
   @endif

   <div class="row g-3">
      <div class="col-12">
         <div class="tab-pane fade show active" id="tabpaneActivityLogs" role="tabpanel">
            <x-real.card>
               <x-slot name="header">
                  Logs
               </x-slot>
               <x-slot name="body">
                  {!! $dataTable->table(['class' => 'w-100 table align-middle table-hover']) !!}

               </x-slot>
            </x-real.card>
         </div>
      </div>
   </div>

   @section('script')
      {!! $dataTable->scripts() !!}
   @endsection
</x-app-layout>
