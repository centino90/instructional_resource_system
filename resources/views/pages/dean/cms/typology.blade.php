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
                     <a href="{{ route('dean.cms.resources', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link">Resources</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.cms.personnels', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link">Personnels</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.cms.courses', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link">Courses</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.cms.lessons', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link">Lessons</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.cms.typology', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link active">Typology Verbs</a>
                  </li>
               </ul>
            </x-slot>
         </x-real.card>
      </div>

      <div class="col-8">
         <div class="row g-3">
            <div class="col-12">
               <div class="row g-3">
                  <div class="col-12">
                     <x-real.card :vertical="'center'">
                        <x-slot name="header">Typology Verbs</x-slot>
                        <x-slot name="action">
                           <x-real.btn data-bs-toggle="modal" data-bs-target="#courseLessonModal">+ New Verb
                           </x-real.btn>
                        </x-slot>
                        <x-slot name="body">
                           <ul class="list-group" id="verbGroup">
                              <x-real.form method="put" action="{{ route('dean.typology.update', $typology) }}"
                                 onsubmit="return confirm('Do you want to save changes?')">
                                 @foreach ($typology->verbs as $key => $verbs)
                                    <li class="list-group-item position-relative">
                                       <small
                                          class="position-absolute end-0 top-0 verbRemove fw-bold btn btn-sm text-danger">remove</small>

                                       <h5>
                                          <input type="text" name="key-{{ $key }}" value="{{ $key }}"
                                             class="text-uppercase border-0" readonly>
                                       </h5>

                                       <div id="typologyGroup">
                                          @foreach ($verbs as $verb)
                                             <span class="text-nowrap">
                                                <input type="text" name="property-{{ $key }}[]"
                                                   value="{{ $verb }}" class="text-uppercase border-0"
                                                   readonly>
                                                <small
                                                   class="verbRemove opacity-0 fw-bold btn btn-sm text-danger">x</small>
                                             </span>
                                          @endforeach
                                       </div>

                                       <div class="col-12">
                                          <x-real.btn class="addVerb" data-key="{{ $key }}"
                                             :size="'sm'">+ Add verb</x-real.btn>
                                       </div>
                                    </li>
                                 @endforeach
                                 <x-slot name="submit">
                                    <div class="hstack justify-content-between my-3">
                                       <x-real.btn :size="'lg'" onclick="window.location.reload()">Reset
                                       </x-real.btn>
                                       <x-real.btn :size="'lg'" type="submit" class="no-loading">Submit Changes
                                       </x-real.btn>
                                    </div>
                                 </x-slot>
                              </x-real.form>
                           </ul>
                        </x-slot>
                     </x-real.card>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="modal modal-sheet bg-secondary py-5" tabindex="-1" role="dialog" id="courseLessonModal">
      <div class="modal-dialog" role="document">
         <div class="modal-content rounded-6 shadow">
            <div class="modal-header border-bottom-0">
               <h5 class="modal-title">Create new verb standard</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5 py-5">
               <div class="row">
                  <x-real.form action="{{ route('dean.typology.store', $typology) }}">
                     <div class="col-12" id="formGroup">
                        <x-real.input name="checked_verb">
                           <x-slot name="label">Checked verb</x-slot>
                        </x-real.input>

                        <div class="position-relative">
                           <x-real.input name="recommended_verb[]">
                              <x-slot name="label">Recommended verb</x-slot>
                           </x-real.input>
                           <h5 class="verbRemove fw-bold btn btn-sm text-danger position-absolute end-0 top-0">
                              <span class="material-icons">
                                 cancel
                              </span>
                           </h5>
                        </div>
                     </div>

                     <x-real.btn class="createMore">+ Add more</x-real.btn>

                     <x-slot name="submit">
                        <div class="col-12 mt-4">
                           <div class="d-grid gap-2 w-100">
                              <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                                 update</button>
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

   @section('script')
      <script>
         $(document).ready(function() {
            $('#verbGroup input').dblclick(function(event) {
               if ($(event.target).attr('readonly')) {
                  $(event.target).attr('readonly', false)
                  $(event.target).removeClass('border-0')
               } else {
                  $(event.target).attr('readonly', true)
               }
            })

            $('#verbGroup input').focus(function(event) {
               $(event.target).siblings('.verbRemove').removeClass('opacity-0')
            })

            $('#verbGroup input').focusout(function(event) {
               $(event.target).siblings('.verbRemove').addClass('opacity-0')
               $(event.target).attr('readonly', true)
               $(event.target).addClass('border-0')
            })

            $('#verbGroup').delegate('.verbRemove', 'click', function(event) {
               $(event.target).parent().remove();
            })

            $('#formGroup').delegate('.verbRemove', 'click', function(event) {
               $(event.target).closest('.position-relative').remove();
            })

            $('.addVerb').click(function(event) {
               const key = $(event.target).attr('data-key')
               const group = $(event.target).closest('.list-group-item').find('#typologyGroup')
               $(group).append(`
                    <span class="text-nowrap">
                        <input type="text" name="property-${key}[]"
                            class="text-uppercase"
                            >
                        <small
                            class="verbRemove  fw-bold btn btn-sm text-danger">x</small>
                    </span>
                `)
            })


            $('.createMore').click(function(event) {
               const $parent = $('#formGroup')

               $parent.append(`
                    <div class="position-relative">
                        <x-real.input name="recommended_verb[]">
                            <x-slot name="label">Recommended verb</x-slot>
                        </x-real.input>
                        <h5 class="verbRemove fw-bold btn btn-sm text-danger position-absolute end-0 top-0">
                            <span class="material-icons">
                                cancel
                            </span>
                        </h5>
                    </div>
                `)
            })
         })
      </script>
   @endsection
</x-app-layout>
