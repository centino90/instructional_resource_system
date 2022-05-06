<x-app-layout>
   <x-slot name="header">
      {{ $resource->title }}
   </x-slot>

   <x-slot name="headerTitle">
      Resource title
   </x-slot>

   <x-slot name="breadcrumb">
      @can('view', $resource->course)
         @if ($resource->is_syllabus)
            <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('course.show', $resource->course) }}">
                  <- Go back</a>
            </li>


            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a
                  href="{{ route('course.show', $resource->course) }}">{{ $resource->course->code }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $resource->title }}</li>
         @else
            <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('lesson.show', $resource->lesson) }}">
                  <- Go back</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a
                  href="{{ route('course.show', $resource->course) }}">{{ $resource->course->code }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('course.showLessons', $resource->course) }}">Course
                  lessons</a>
            </li>
            <li class="breadcrumb-item"><a
                  href="{{ route('lesson.show', $resource->lesson) }}">{{ $resource->lesson->title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $resource->title }}</li>
         @endif
      @else
         @if ($resource->is_syllabus)
            <li class="breadcrumb-item"><a class="fw-bold" href="{{ route('dashboard') }}">
                  <- Go back</a>
            </li>

            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">{{ $resource->course->code }}</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $resource->title }}</li>
         @else
            <li class="breadcrumb-item">
               <a class="fw-bold" href="{{ route('dashboard') }}">
                  <- Go back </a>
            </li>

            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">{{ $resource->course->code }}</li>
            <li class="breadcrumb-item">
               Course lessons
            </li>
            <li class="breadcrumb-item">{{ $resource->lesson->title }}</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $resource->title }}</li>
         @endif
      @endcan
   </x-slot>

   <div>
      <div class="tab-content" id="pills-tabContent">
         <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="row g-3">
               <div class="col-12">
                  <div class="row g-3">
                     <div class="col-12 col-lg-3">
                        <x-real.card :variant="'secondary'">
                           <x-slot name="header">
                              Views
                           </x-slot>
                           <x-slot name="action">
                              <div class="hstack gap-3">
                                 @can('preview', $resource)
                                    <div class="btn-group dropdown">
                                       <x-real.btn :size="'sm'" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                          aria-expanded="false" class="dropdown-toggle">
                                          More
                                       </x-real.btn>
                                       <ul class="dropdown-menu shadow border-0 p-0">
                                          <li class="dropdown-item p-0">
                                             <ul class="list-group" style="min-width: 300px">
                                                @can('participate', $resource->course)
                                                   @can('update', $resource)
                                                      <li class="list-group-item">
                                                         <a href="{{ route('resource.edit', $resource) }}"
                                                            class="w-100 btn btn-light btn-sm border text-primary fw-bold">
                                                            Edit
                                                         </a>
                                                      </li>
                                                   @endcan
                                                @endcan
                                                <li class="list-group-item">
                                                   <a href="{{ route('resource.addViewCountThenRedirectToPreview', $resource) }}"
                                                      class="w-100 btn btn-light btn-sm border text-primary fw-bold">
                                                      Preview
                                                   </a>
                                                </li>
                                                <li class="list-group-item d-grid gap-2">
                                                   <x-real.download-types :resource="$resource" :btnSize="'sm'">
                                                   </x-real.download-types>
                                                </li>
                                             </ul>
                                          </li>
                                       </ul>
                                    </div>
                                 @endcan
                              </div>
                           </x-slot>
                           <x-slot name="body">
                              <div class="hstack gap-2">
                                 <span class="material-icons md-48 opacity-75 text-muted">
                                    visibility
                                 </span>
                                 <h1 class="m-0 fw-bold">{{ $resource->views }}</h1>
                              </div>
                           </x-slot>
                        </x-real.card>
                     </div>

                     <div class="col-12 col-lg-3">
                        <x-real.card :variant="'secondary'">
                           <x-slot name="header">
                              Downloads
                           </x-slot>
                           <x-slot name="body">
                              <div class="hstack gap-2">
                                 <span class="material-icons md-48 opacity-75 text-muted">
                                    download
                                 </span>
                                 <h1 class="m-0 fw-bold">{{ $resource->downloads }}</h1>
                              </div>
                           </x-slot>
                        </x-real.card>
                     </div>

                     <div class="col-12 col-lg-3">
                        <x-real.card :variant="'secondary'">
                           <x-slot name="header">
                              Comments
                           </x-slot>
                           <x-slot name="body">
                              <div class="hstack gap-2">
                                 <span class="material-icons md-48 opacity-75 text-muted">
                                    comment
                                 </span>
                                 <h1 class="m-0 fw-bold">{{ $resource->comments->count() }}</h1>
                              </div>
                           </x-slot>
                        </x-real.card>
                     </div>

                     <div class="col-12 col-lg-3">
                        <x-real.card :variant="'secondary'">
                           <x-slot name="header">
                              Latest Activity
                           </x-slot>
                           <x-slot name="body">
                              <div class="hstack gap-2">
                                 <span class="material-icons md-48 opacity-75 text-muted">
                                    campaign
                                 </span>
                                 <div>
                                    <small
                                       class="text-muted">{{ $resource->activityLogs()->latest()->first()->created_at->diffForHumans() }}</small>
                                    - {{ $resource->activityLogs()->latest()->first()->description }}
                                 </div>
                              </div>
                           </x-slot>
                        </x-real.card>
                     </div>
                  </div>
               </div>
               <div class="col-12">
                  <div class="row g-3">
                     <div class="col-12 col-lg-3">
                        <div class="row g-3">
                           <div class="col-12">
                              <x-real.card>
                                 <x-slot name="header">
                                    Status
                                 </x-slot>

                                 <x-slot name="action">
                                    <div class="hstack gap-3">
                                       <div class="btn-group dropdown">
                                          <x-real.btn :size="'sm'" data-bs-toggle="dropdown"
                                             data-bs-auto-close="outside" aria-expanded="false" class="dropdown-toggle">
                                             More
                                          </x-real.btn>
                                          <ul class="dropdown-menu shadow border-0 p-0">
                                             <li class="dropdown-item p-0">
                                                <ul class="list-group" style="min-width: 300px">
                                                   <li class="list-group-item">
                                                      @if ($resource->resourceType != 'regular')
                                                         @php
                                                            $btnLabel = 'Review verification';
                                                            if ($resource->verificationStatus == 'Pending') {
                                                                $btnLabel = 'Continue verification';
                                                            }

                                                            if ($resource->resourceType == 'syllabus') {
                                                                $storeNewVerRoute = route('syllabi.storeNewVersion', $resource);
                                                            } elseif ($resource->resourceType == 'presentation') {
                                                                $storeNewVerRoute = route('presentations.storeNewVersion', $resource);
                                                            } else {
                                                                $storeNewVerRoute = route('resource.storeNewVersion', $resource);
                                                            }
                                                         @endphp

                                                         <x-real.form action="{{ $storeNewVerRoute }}">
                                                            <input type="hidden" name="course_id"
                                                               value="{{ $resource->course->id }}">

                                                            <x-slot name="submit">
                                                               <x-real.btn :size="'sm'" type="submit"
                                                                  class="w-100">
                                                                  {{ $btnLabel }}
                                                               </x-real.btn>
                                                            </x-slot>
                                                         </x-real.form>
                                                      @endif
                                                   </li>

                                                   @if ($resource->verificationStatus == 'Approved')
                                                      <li class="list-group-item">
                                                         @php
                                                            $archiveLabel = '';
                                                            if ($resource->archiveStatus == 'Current') {
                                                                $archiveLabel = 'Archive this resource';
                                                            } elseif ($resource->archiveStatus == 'Archived') {
                                                                $archiveLabel = 'Restore this resource';
                                                            }
                                                         @endphp

                                                         <x-real.form
                                                            action="{{ route('resource.toggleArchiveState', $resource) }}"
                                                            method="PUT">
                                                            <input type="hidden" name="course_id"
                                                               value="{{ $resource->course_id }}">
                                                            <x-slot name="submit">
                                                               <x-real.btn :size="'sm'" type="submit"
                                                                  class="w-100">
                                                                  {{ $archiveLabel }}
                                                               </x-real.btn>
                                                            </x-slot>
                                                         </x-real.form>
                                                      </li>
                                                   @endif
                                                </ul>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </x-slot>
                                 <x-slot name="body">
                                    <div class="hstack gap-2">
                                       @if ($resource->archiveStatus == 'Archived')
                                          <span class="material-icons md-48 opacity-75 text-primary">
                                             archive
                                          </span>
                                          <h5 class="m-0 fw-bold text-primary">
                                             Archived
                                          </h5>
                                       @else
                                          @if ($resource->verificationStatus == 'Pending')
                                             <span class="material-icons md-48 opacity-75 text-warning">
                                                error
                                             </span>
                                             <h5 class="m-0 fw-bold text-warning">
                                                {{ $resource->verificationStatus }}
                                             </h5>
                                          @else
                                             <span class="material-icons md-48 opacity-75 text-success">
                                                verified
                                             </span>
                                             <h5 class="m-0 fw-bold text-success">
                                                {{ $resource->verificationStatus }}
                                             </h5>
                                          @endif
                                       @endif
                                    </div>
                                 </x-slot>
                              </x-real.card>
                           </div>

                           <div class="col-12">
                              <x-real.card>
                                 <x-slot name="header">
                                    Versions
                                 </x-slot>
                                 <x-slot name="action">
                                    <div class="hstack gap-3">
                                       <div class="btn-group dropdown">
                                          <x-real.btn :size="'sm'" data-bs-toggle="dropdown"
                                             data-bs-auto-close="outside" aria-expanded="false" class="dropdown-toggle">
                                             More
                                          </x-real.btn>
                                          <ul class="dropdown-menu shadow border-0 p-0">
                                             <li class="dropdown-item p-0">
                                                <ul class="list-group" style="min-width: 300px">
                                                   <li class="list-group-item">
                                                      <a href="{{ route('resource.createNewVersion', $resource->id) }}"
                                                         class="w-100 btn btn-light btn-sm border text-primary fw-bold">
                                                         Submit new version
                                                      </a>
                                                   </li>
                                                   <li class="list-group-item">
                                                      <a href="{{ route('resource.viewVersions', $resource->id) }}"
                                                         class="w-100 btn btn-light btn-sm border text-primary fw-bold">
                                                         View all versions
                                                      </a>
                                                   </li>
                                                </ul>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </x-slot>
                                 <x-slot name="body">
                                    <div class="hstack gap-2">
                                       <span class="material-icons md-48 opacity-75 text-muted">
                                          content_copy
                                       </span>
                                       <h1 class="m-0 fw-bold">{{ $resource->getMedia()->count() }}
                                       </h1>
                                    </div>
                                 </x-slot>
                              </x-real.card>
                           </div>
                        </div>
                     </div>
                     <div class="col-12 col-lg-9">
                        <x-real.card :variant="'secondary'">
                           <x-slot name="header">
                              Resource Details
                           </x-slot>
                           <x-slot name="body">
                              <ul class="nav flex-column gap-2">
                                 <li class="nav-item border-bottom">
                                    <x-real.text-with-subtitle>
                                       <x-slot name="text">
                                          {{ $resource->resourceType }}
                                       </x-slot>
                                       <x-slot name="subtitle">Type</x-slot>
                                    </x-real.text-with-subtitle>
                                 </li>
                                 <li class="nav-item border-bottom">
                                    <x-real.text-with-subtitle>
                                       <x-slot name="text">
                                          {{ $resource->id }}
                                       </x-slot>
                                       <x-slot name="subtitle">ID</x-slot>
                                    </x-real.text-with-subtitle>
                                 </li>
                                 <li class="nav-item border-bottom">
                                    <x-real.text-with-subtitle>
                                       <x-slot name="text">
                                          {{ $resource->title }}
                                       </x-slot>
                                       <x-slot name="subtitle">Title</x-slot>
                                    </x-real.text-with-subtitle>
                                 </li>
                                 <li class="nav-item border-bottom">
                                    <x-real.text-with-subtitle>
                                       <x-slot name="text">
                                          @if ($resource->description)
                                             {{ $resource->description }}
                                          @else
                                             <i>No description</i>
                                          @endif
                                       </x-slot>
                                       <x-slot name="subtitle">Description</x-slot>
                                    </x-real.text-with-subtitle>
                                 </li>
                                 <li class="nav-item border-bottom">
                                    <x-real.text-with-subtitle>
                                       <x-slot name="text">
                                          {{ $resource->currentMediaVersion->file_name }}
                                       </x-slot>
                                       <x-slot name="subtitle">Current media</x-slot>
                                    </x-real.text-with-subtitle>
                                 </li>
                                 <li class="nav-item border-bottom">
                                    <x-real.text-with-subtitle>
                                       <x-slot name="text">
                                          {{ $resource->user->name }}
                                       </x-slot>
                                       <x-slot name="subtitle">Submitted by</x-slot>
                                    </x-real.text-with-subtitle>
                                 </li>
                                 <li class="nav-item border-bottom">
                                    <x-real.text-with-subtitle>
                                       <x-slot name="text">
                                          @isset($resource->lesson)
                                             <a
                                                href="{{ route('lesson.show', $resource->lesson) }}">{{ $resource->lesson->title }}</a>
                                          @else
                                             <i>No Lesson</i>
                                          @endisset
                                       </x-slot>
                                       <x-slot name="subtitle">Lesson</x-slot>
                                    </x-real.text-with-subtitle>
                                 </li>
                                 <li class="nav-item border-bottom">
                                    <x-real.text-with-subtitle>
                                       <x-slot name="text">
                                          <a
                                             href="{{ route('course.show', $resource->course) }}">{{ $resource->course->code }}</a>
                                       </x-slot>
                                       <x-slot name="subtitle">Course</x-slot>
                                    </x-real.text-with-subtitle>
                                 </li>
                                 <li class="nav-item border-bottom">
                                    <x-real.text-with-subtitle>
                                       <x-slot name="text">
                                          {{ $resource->created_at }}
                                       </x-slot>
                                       <x-slot name="subtitle">Submitted at</x-slot>
                                    </x-real.text-with-subtitle>
                                 </li>
                                 @if ($resource->archiveStatus == 'Archived')
                                    <li class="nav-item border-bottom">
                                       <x-real.text-with-subtitle>

                                          <x-slot name="text">
                                             {{ $resource->archived_at }}
                                          </x-slot>
                                          <x-slot name="subtitle">Archived at</x-slot>
                                       </x-real.text-with-subtitle>
                                    </li>
                                 @else
                                    @if ($resource->verificationStatus == 'Approved')
                                       <li class="nav-item border-bottom">
                                          <x-real.text-with-subtitle>
                                             <x-slot name="text">
                                                {{ $resource->approved_at }}
                                             </x-slot>
                                             <x-slot name="subtitle">Verified at</x-slot>
                                          </x-real.text-with-subtitle>
                                       </li>
                                    @elseif($resource->verificationStatus == 'Pending' && $resource->hasMultipleMedia)
                                       <li class="nav-item border-bottom">
                                          <x-real.text-with-subtitle>
                                             <x-slot name="text">
                                                {{ $resource->updated_at }}
                                             </x-slot>
                                             <x-slot name="subtitle">Resubmitted at</x-slot>
                                          </x-real.text-with-subtitle>
                                       </li>
                                    @endif
                                 @endif
                              </ul>
                           </x-slot>
                        </x-real.card>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>


   <div class="mt-5">
      <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
         <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
               role="tab" aria-controls="home" aria-selected="true">Comments</button>
         </li>
         <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
               type="button" role="tab" aria-controls="profile" aria-selected="false">History Logs</button>
         </li>
      </ul>
      <div class="tab-content" id="myTabContent">
         <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row g-3">
               <div class="col-12">
                  @comments([
                  'model' => $resource,
                  'maxIndentationLevel' => 1,
                  'perPage' => 5
                  ])
               </div>
            </div>
         </div>
         <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row g-3">
               <div class="col-12">
                  {!! $dataTable->table(['class' => 'accordionTableRes w-100 table align-middle table-hover']) !!}
               </div>
            </div>
         </div>
      </div>
   </div>


   @section('script')
      {!! $dataTable->scripts() !!}

      <script>
         $(document).ready(function() {
            $('.comment-textarea').summernote({
               height: 200,
               width: '100%'
            })

            $('.storeSavedresourceHiddenSubmit').click(function() {
               let form = $($(this).attr('data-form-target'))
               let passoverData = $(this).attr('data-passover')
               let input = form.find('input[name="resource_id"]')
               input.val(passoverData)

               form.submit()
            })

            $('#download-bulk').click(function(e) {
               e.preventDefault()
               let downloadBtn = $(this)
               let table = $(this.closest('table'))
               let checkboxes = table.find('th:first-child .check, td:first-child .check')
               $(checkboxes).each(function() {
                  if ($(this).is(":checked")) {
                     $(this).closest('th, td').find(':hidden').removeAttr('disabled')
                  } else {
                     $(this).closest('th, td').find(':hidden').attr('disabled', 'disabled')
                  }
               })

               table.closest('form').submit();
               checkboxes.prop('checked', false);
               downloadBtn.removeClass('loading')
            })

            $('#check-all').change(function(e) {
               let table = $(this.closest('table'))
               let checkboxes = table.find('td:first-child .check')

               if ($(this).is(':checked')) {
                  checkboxes.prop('checked', true)
               } else {
                  checkboxes.prop('checked', false)
               }
            })

            $('.check').change(function(e) {
               let table = $(this.closest('table'))
               let downloadBtn = table.find('#download-bulk')
               let checkboxes = table.find('td:first-child .check')
               let currentCheckbox = $(this)

               if (checkboxes.filter(':checked').length > 0) {
                  downloadBtn.removeClass('disabled')
                  console.log('yes')
               } else {
                  downloadBtn.addClass('disabled')
               }
            })
         })
      </script>
   @endsection
</x-app-layout>
