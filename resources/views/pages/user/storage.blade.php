<x-app-layout>
   <x-slot name="header">
      @if (auth()->id() === $user->id)
         My storage
      @else
         {{ $user->username . "'\s'" . ' storage' }}
      @endif
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('dashboard') }}">
            <- Go back</a>
      </li>
      <li class="breadcrumb-item active">
         @if (auth()->id() === $user->id)
            My storage
         @else
            {{ $user->username . "'\s'" . ' storage' }}
         @endif
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-3">
         <div class="row g-3">
            <div class="col12">
               <x-real.card>
                  <x-slot name="header">
                     Storage Details
                  </x-slot>
                  <x-slot name="body">
                     <x-real.text-with-subtitle class="border-bottom">
                        <x-slot name="text">{{ $fileCount }}</x-slot>
                        <x-slot name="subtitle">Total files</x-slot>
                     </x-real.text-with-subtitle>

                     <x-real.text-with-subtitle class="mt-2 border-bottom">
                        <x-slot name="text">{{ $storageSize }} MB</x-slot>
                        <x-slot name="subtitle">Storage Size</x-slot>
                     </x-real.text-with-subtitle>

                     <x-real.text-with-subtitle class="mt-2 border-bottom">
                        <x-slot name="text">
                           {{ auth()->user()->storage_size - $storageSize }} MB
                           @if (auth()->user()->isStorageFull())
                              <span class="position-absolute top-0 end-0 badge rounded-pill text-muted">
                                 <span class="small material-icons text-danger">
                                    report
                                 </span>
                                 Full
                              </span>
                           @elseif(auth()->user()->isStorageReachingFull())
                              <span class="position-absolute top-0 end-0 badge rounded-pill hstack text-muted gap-1">
                                 <span class="small material-icons text-secondary">
                                    report
                                 </span>
                                 Almost Full
                              </span>
                           @endif
                        </x-slot>
                        <x-slot name="subtitle">Storage Left</x-slot>
                     </x-real.text-with-subtitle>

                     <x-real.text-with-subtitle class="mt-2 border-bottom">
                        <x-slot name="text">{{ auth()->user()->storage_size }} MB</x-slot>
                        <x-slot name="subtitle">Maximum Capacity</x-slot>
                     </x-real.text-with-subtitle>
                  </x-slot>
               </x-real.card>
            </div>
         </div>
      </div>

      <div class="col-9">
         <x-real.card :vertical="'center'">
            <x-slot name="header">
               Storage
            </x-slot>
            <x-slot name="action">
               <x-real.tablist :direction="'horizontal'" :id="'tes'">
                  <x-real.tab class="text-dark" :id="'CurrentStorage'" :active="true">
                     <small>Current</small>
                  </x-real.tab>
                  <x-real.tab class="text-dark" :id="'TrashedStorage'">
                     <small>Trashed</small>
                  </x-real.tab>
               </x-real.tablist>
            </x-slot>
            <x-slot name="body">
               <x-real.tabcontent>
                  <x-real.tabpane :id="'CurrentStorage'" :active="true">
                     <div class="col-4 mb-1">
                        <input type="text" class="form-control" placeholder="Search Storage" id="storageSearch">
                     </div>
                     <div id="fm"></div>
                  </x-real.tabpane>
                  <x-real.tabpane :id="'TrashedStorage'">
                     <x-real.table id="trashedTable">
                        <x-slot name="headers">
                           <td>File name</td>
                           <td>Type</td>
                           <td>Last update</td>
                           <td></td>
                        </x-slot>
                        <x-slot name="rows">
                           @foreach ($mergedDeleted as $folderOrFile)
                              @if (is_object($folderOrFile))
                                 <tr>
                                    <td>
                                       {{ $folderOrFile->getFileName() }}
                                    </td>
                                    <td>
                                       File
                                    </td>
                                    <td>
                                       {{ $folderOrFile->created_at }}
                                    </td>
                                    <td>
                                       <div class="hstack justify-content-end gap-2">
                                          <x-real.btn :size="'sm'" :tag="'a'"
                                             href="{{ route('storage.restore', ['path' => $folderOrFile->getPathName()]) }}">
                                             Restore
                                          </x-real.btn>
                                       </div>
                                    </td>
                                 </tr>
                              @else
                                 <tr>
                                    <td>
                                       {{ $folderOrFile['name'] }}
                                    </td>
                                    <td>
                                       Folder
                                    </td>
                                    <td>
                                       {{ $folderOrFile['created_at'] }}
                                    </td>
                                    <td>
                                       <div class="hstack justify-content-end gap-2">
                                          <x-real.btn :size="'sm'" :tag="'a'"
                                             href="{{ route('storage.restore', ['path' => $folderOrFile['path']]) }}">
                                             Restore
                                          </x-real.btn>
                                       </div>
                                    </td>
                                 </tr>
                              @endif
                           @endforeach
                        </x-slot>
                     </x-real.table>
                  </x-real.tabpane>
               </x-real.tabcontent>
            </x-slot>
         </x-real.card>
      </div>
   </div>

   @section('style')
      <link href="{{ asset('vendor/file-manager/css/file-manager.css') }}" rel="stylesheet">
   @endsection

   @section('script')
      <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>

      <script>
         $(document).ready(function() {
            $('#trashedTable').DataTable({
               order: [
                  [2: 'desc']
               ]
            });

            $("#storageSearch").on("keyup", function() {
               var value = $(this).val().toLowerCase();
               $(".fm .table tbody tr").filter(function() {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
               });
            });

            $('.fm .fm-navbar .btn-group').last().remove()
         })
      </script>
   @endsection
</x-app-layout>
