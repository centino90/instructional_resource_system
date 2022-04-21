@props(['size' => ''])

<div {{ $attributes->merge(['class' => 'modal modal-sheet bg-secondary py-5']) }} tabindex="-1" role="dialog"
   id="modalManagement">
   <div class="modal-dialog" role="document">
      <div class="modal-content rounded-6 shadow">
         <div class="modal-header border-bottom-0">
            <h5 class="modal-title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body px-5 py-5">
            <div class="archive unarchive collapse">
               <div class="row">
                  <x-real.form :method="'PUT'">
                     <div class="col-12">
                        <div class="confirmAlert alert alert-primary">Do you want to continue this action?</div>
                     </div>
                     <x-slot name="submit">
                        <div class="col-12 mt-4">
                           <div class="d-grid gap-2 w-100">
                              <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                              </button>
                              <button type="button" class="btn btn-lg btn-light mx-0 rounded-4"
                                 data-bs-dismiss="modal">Close</button>
                           </div>
                        </div>
                     </x-slot>
                  </x-real.form>
               </div>
            </div>

            <div class="trash restore collapse">
               <div class="row">
                  <x-real.form :method="'DELETE'">
                     <div class="col-12">
                        <div class="confirmAlert alert alert-primary">Do you want to continue this action?</div>
                     </div>
                     <x-slot name="submit">
                        <div class="col-12 mt-4">
                           <div class="d-grid gap-2 w-100">
                              <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                              </button>
                              <button type="button" class="btn btn-lg btn-light mx-0 rounded-4"
                                 data-bs-dismiss="modal">Close</button>
                           </div>
                        </div>
                     </x-slot>
                  </x-real.form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   $(document).ready(function() {
      const modalManagement = document.getElementById('modalManagement')

      modalManagement.addEventListener('show.bs.modal', function(event) {
         const $button = $(event.relatedTarget)

         const $rowTitle = $button.attr('data-bs-title')
         const $rowMode = $button.attr('data-bs-operation')
         const $rowRoute = $button.attr('data-bs-route')

         const $lessonCollapsedDiv = $(this).find(`.${$rowMode}`)
         const $modalTitle = $(this).find('.modal-title')
         const $collapsedForm = $lessonCollapsedDiv.find('form')

         // Update the modal's content.
         $modalTitle.html(`<b class="text-capitalize">${$rowMode}</b> <span class="text-muted">${$rowTitle}</span>`)
         $collapsedForm.attr('action', $rowRoute)
         $lessonCollapsedDiv.show()
      })

      modalManagement.addEventListener('hidden.bs.modal', function(event) {
         $(this).find('.collapse').hide()
      })
   })
</script>
