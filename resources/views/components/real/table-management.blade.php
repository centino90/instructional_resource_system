@props(['title' => ''])

<x-real.card>
   <x-slot name="header">{{ $title }}</x-slot>

   <x-slot name="action">
      <ul class="nav nav-pills justify-content-end gap-3" id="tableManagementTab" role="tablist">
         @isset($active)
            <li class="nav-item p-0" role="presentation">
               <button class="nav-link py-0 text-dark rounded-0 active" id="active{{ $title }}Tab"
                  data-bs-toggle="pill" data-bs-target="#active{{ $title }}TabPane" type="button" role="tab">
                  Active</button>
            </li>
         @endisset

         @isset($archive)
            <li class="nav-item p-0" role="presentation">
               <button class="nav-link py-0 text-dark rounded-0" id="archived{{ $title }}Tab" data-bs-toggle="pill"
                  data-bs-target="#archived{{ $title }}Tabpane" type="button" role="tab">
                  Archived
               </button>
            </li>
         @endisset

         @isset($trash)
            <li class="nav-item p-0" role="presentation">
               <button class="nav-link py-0 text-dark rounded-0" id="trashed{{ $title }}Tab" data-bs-toggle="pill"
                  data-bs-target="#trashed{{ $title }}Tabpane" type="button" role="tab">
                  Trashed
               </button>
            </li>
         @endisset
      </ul>
   </x-slot>
   <x-slot name="body">
      <div class="tab-content" id="{{ $title }}Tabcontent">
         @isset($active)
            <div class="tab-pane fade show active" id="active{{ $title }}TabPane" role="tabpanel">
               {{ $active }}
            </div>
         @endisset
         @isset($archive)
            <div class="tab-pane fade" id="archived{{ $title }}Tabpane" role="tabpanel">
               {{ $archive }}
            </div>
         @endisset
         @isset($trash)
            <div class="tab-pane fade" id="trashed{{ $title }}Tabpane" role="tabpanel">
               {{ $trash }}
            </div>
         @endisset
      </div>
   </x-slot>
</x-real.card>

<script>
   $(document).ready(function() {
      $(document).on('init.dt', function(e, settings) {
         const updatedSubject = `{{ session()->get('updatedSubject') }}`;

         if (updatedSubject) {
            const $scrolledToElement = $(`#subject${updatedSubject}`)
            $scrolledToElement.addClass('scrolled-focus')
         }
      })
   })
</script>
