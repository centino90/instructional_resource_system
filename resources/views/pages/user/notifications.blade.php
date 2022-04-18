<x-app-layout>
   @if ($user->id == auth()->id())
      <x-slot name="header">
         My Notifications
      </x-slot>
      <x-slot name="breadcrumb">
         <li class="breadcrumb-item">
            <a class="fw-bold" href="{{ route('dashboard') }}">
               <- Go back </a>
         </li>

         <li class="breadcrumb-item active">
            My Notifications
         </li>
      </x-slot>
   @else
      <x-slot name="header">
         Notifications
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
            Notifications
         </li>
      </x-slot>
   @endif

   <div class="row g-3">
      <div class="col-12">
         <x-real.card>
            <x-slot name="header">
               Notifications
            </x-slot>
            <x-slot name="action">
               <ul class="nav nav-pills justify-content-end gap-3" id="notificationCardTab" role="tablist">
                  <li class="nav-item p-0" role="presentation">
                     <button class="nav-link py-0 text-dark rounded-0 active" id="notificationCardFormTab"
                        data-bs-toggle="pill" data-bs-target="#notificationCardFormTabpane" type="button"
                        role="tab">New</button>
                  </li>
                  <li class="nav-item p-0" role="presentation">
                     <button class="storageUploadStandaloneBtn nav-link py-0 text-dark rounded-0"
                        id="notificationCardUrlTab" data-bs-toggle="pill" data-bs-target="#notificationCardUrlTabpane"
                        type="button" role="tab">
                        Viewed
                     </button>
                  </li>
               </ul>
            </x-slot>
            <x-slot name="body">
               <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="notificationCardFormTabpane" role="tabpanel">
                     <x-real.table class="notificationsTable">
                        <x-slot name="headers">
                           <th>Created at</th>
                           <th>Message</th>
                           <th></th>
                        </x-slot>
                        <x-slot name="rows">
                           @foreach ($notifications->whereNull('read_at') as $notification)
                              <tr>
                                 <td>{{ $notification->created_at }}</td>
                                 <td>{{ $notification->data['message'] }}</td>
                                 <td>
                                    <x-real.btn :tag="'a'" href="{!! $notification->data['link'] !!}">View</x-real.btn>
                              </tr>
                           @endforeach
                        </x-slot>
                     </x-real.table>
                  </div>
                  <div class="tab-pane fade" id="notificationCardUrlTabpane" role="tabpanel">
                     {!! $dataTable->table(['class' => 'w-100 table align-middle table-hover']) !!}
                  </div>
               </div>
            </x-slot>
         </x-real.card>
      </div>
   </div>

   @section('script')
      {!! $dataTable->scripts() !!}

      <script>
         $(document).ready(function() {
            delete TABLE_MANAGEMENT_PROPS.processing
            delete TABLE_MANAGEMENT_PROPS.serverSide

            $('.notificationsTable').DataTable({
               ...TABLE_MANAGEMENT_PROPS
            });
         })
      </script>
   @endsection
</x-app-layout>
