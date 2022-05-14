<x-app-layout>
   <x-slot name="header">
      ({{ $course->code }}) {{ $course->title }}
   </x-slot>

   <x-slot name="headerTitle">
      Course
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dashboard') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">
         {{ $course->code }}
      </li>
   </x-slot>

   <div class="modal modal-sheet bg-secondary py-5" tabindex="-1" role="dialog" id="createResourceModal">
      <div class="modal-dialog" role="document">
         <div class="modal-content rounded-6 shadow py-5 px-5">
            <div class="modal-header border-bottom-0">
               <h5 class="modal-title">Choose or create a lesson</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">
               <form action="{{ route('lesson.store') }}" method="POST" class="row g-3">
                  @method('POST')
                  @csrf
                  <input type="hidden" name="course_id" value="{{ $course->id }}">
                  <input type="hidden" name="mode">

                  <div class="col-12">
                     <div class="form-floating mb-3">
                        <input list="lessons" type="text" name="title" class="form-control rounded-4" id="floatingInput"
                           placeholder="_">
                        <label for="floatingInput">Lesson</label>

                        @if ($course->lessons->isEmpty())
                           <small class="form-text">There are no lessons yet. Create one.</small>
                        @else
                           <small class="form-text">Search all items in the datalist by typing their
                              values.</small>

                           <datalist id="lessons">
                              @foreach ($course->lessons as $lesson)
                                 <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                              @endforeach
                           </datalist>
                        @endif
                     </div>
                  </div>

                  <div class="col-12">
                     <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btn-lg btn-primary mx-0 rounded-4">Continue
                           submission</button>
                        <button type="button" class="btn btn-lg btn-light mx-0 rounded-4"
                           data-bs-dismiss="modal">Close</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>

   <div class="row g-3">
      <div class="col-md-8">
         <div class="row g-3">
            @cannot('participate', $course)
               <div class="col-12">
                  <x-real.alert :variant="'info'">Currently, you are only allowed to view and download the contents of this
                     course. You can ask the designated PD for further access rights.</x-real.alert>
               </div>
            @endcan

            <div class="col-12">
               <div class="hstack justify-content-end gap-2">
                  @if ($course->resources->count() > 0)
                     <x-real.form action="{{ route('resource.downloadAllByCourse', $course) }}">
                        <x-slot name="submit">
                           <x-real.btn type="submit" :icon="'file_download'" class="me-auto no-loading bg-white">
                              Download resources
                           </x-real.btn>
                        </x-slot>
                     </x-real.form>
                  @endif

                  @can('participate', $course)
                     <x-real.btn :tag="'a'" :btype="'solid'" :icon="'post_add'" class="ms-auto"
                        data-mode="new" data-bs-toggle="modal" data-bs-target="#createResourceModal">
                        New resource
                     </x-real.btn>
                  @endcan
               </div>
            </div>

            <div class="col-12">

               <x-real.card :vertical="'center'">
                  <x-slot name="header">Syllabus</x-slot>
                  <x-slot name="action">
                     @empty($course->latestSyllabus)
                        @can('participate', $course)
                           <x-real.btn :size="'sm'" :tag="'a'" href="{{ route('syllabi.create', $course) }}">
                              Submit Syllabus
                           </x-real.btn>
                        @endcan
                     @else
                        @can('participate', $course)
                           @can('validate', $course->latestSyllabus)
                              <x-real.form action="{{ route('syllabi.storeNewVersion', $course->latestSyllabus) }}">
                                 <input type="hidden" name="course_id" value="{{ $course->id }}">

                                 <x-slot name="submit">
                                    <x-real.btn :size="'sm'" type="submit">
                                       Continue
                                       Validation
                                    </x-real.btn>
                                 </x-slot>
                              </x-real.form>
                           @else
                              <x-real.btn :size="'sm'" :tag="'a'"
                                 href="{{ route('resource.createNewVersion', $course->latestSyllabus) }}">Submit
                                 New
                                 Version
                              </x-real.btn>
                           @endcan
                        @endcan

                        @can('preview', $course->latestSyllabus)
                           <x-real.btn :size="'sm'" :tag="'a'"
                              href="{{ route('resource.addViewCountThenRedirectToPreview', $course->latestSyllabus) }}">
                              Preview
                           </x-real.btn>
                           <x-real.btn :size="'sm'" :tag="'a'"
                              href="{{ route('resources.download', $course->latestSyllabus) }}">Download
                           </x-real.btn>
                        @endcan

                        <x-real.btn :size="'sm'" :tag="'a'"
                           href="{{ route('resource.addViewCountThenRedirectToShow', $course->latestSyllabus) }}">
                           View more
                        </x-real.btn>
                     @endempty
                  </x-slot>
                  <x-slot name="body">
                     <div class="row">
                        <div class="col-12 hstack justify-content-center text-muted">
                           @empty($course->latestSyllabus)
                              <x-real.no-rows>
                                 <x-slot name="label">There is no syllabus in this course yet</x-slot>
                              </x-real.no-rows>
                           @else
                              <div class="w-100 vstack gap-3 ">
                                 @can('unarchive', auth()->user(), $course->latestSyllabus)
                                    <x-real.alert :variant="'warning'" :dismiss="false" class="w-100 justify-content-center">
                                       <div>
                                          The current Syllabus is archived

                                          <div class="hstack gap-3 mt-3">
                                             <x-real.form
                                                action="{{ route('resource.toggleArchiveState', $course->latestSyllabus) }}"
                                                method="PUT">
                                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                <x-slot name="submit">
                                                   <x-real.btn :size="'sm'" type="submit" class="w-100">
                                                      Restore
                                                   </x-real.btn>
                                                </x-slot>
                                             </x-real.form>
                                             <x-real.btn :size="'sm'" :tag="'a'"
                                                href="{{ route('resource.createNewVersion', $course->latestSyllabus) }}">
                                                Submit
                                                New
                                             </x-real.btn>
                                          </div>
                                       </div>
                                    </x-real.alert>
                                 @else
                                    <div>
                                       @if ($course->latestSyllabus->verificationStatus == 'Approved')
                                          <span class="badge bg-success">Approved</span>
                                       @elseif($course->latestSyllabus->verificationStatus == 'Rejected')
                                          <span class="badge bg-danger">Rejected</span>
                                       @elseif($course->latestSyllabus->verificationStatus == 'Pending')
                                          <span class="badge bg-warning">Pending</span>
                                       @endif
                                    </div>

                                    <div class="mb-0 small lh-sm">
                                       <h6 class="text-dark fw-bolder">{{ $course->latestSyllabus->title }} - <i
                                             class="fw-normal">{{ $course->latestSyllabus->current_media_version->file_name }}</i>
                                       </h6>

                                       <small class="d-block">
                                          {{ $course->latestSyllabus->description ?? 'No Description' }}
                                       </small>

                                       <small class="d-block mt-3">
                                          Last updated {{ $course->latestSyllabus->updated_at->diffForHumans() }}
                                       </small>
                                    </div>

                                    @can('archive', $course->latestSyllabus)
                                       <div class="accordion accordion-flush" id="lessonAccordion">
                                          <div class="accordion-item">
                                             <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                   data-bs-target="#lessonAccCollapse" aria-expanded="true"
                                                   aria-controls="lessonAccCollapse">
                                                   Highlighted Lessons
                                                </button>
                                             </h2>
                                             <div id="lessonAccCollapse" class="accordion-collapse collapse "
                                                aria-labelledby="headingOne" data-bs-parent="#lessonAccordion">
                                                <div class="accordion-body">
                                                   <ul class="list-group">
                                                      @forelse ($course->current_lessons ?? [] as $row)
                                                         <li class="list-group-item">{{ $row }}</li>
                                                      @empty
                                                         <x-real.no-rows>
                                                            <x-slot name="label">There are no lessons included</x-slot>
                                                         </x-real.no-rows>
                                                      @endforelse
                                                   </ul>
                                                </div>
                                             </div>
                                          </div>
                                       </div>

                                       <div class="accordion accordion-flush" id="courseOutcomesAccordion">
                                          <div class="accordion-item">
                                             <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                   data-bs-target="#courseOutcomesCollapse" aria-expanded="true"
                                                   aria-controls="courseOutcomesCollapse">
                                                   Current Course Outcomes
                                                </button>
                                             </h2>
                                             <div id="courseOutcomesCollapse" class="accordion-collapse collapse "
                                                aria-labelledby="headingOne" data-bs-parent="#courseOutcomesAccordion">
                                                <div class="accordion-body">
                                                   <ul class="list-group">
                                                      @foreach ($course->current_course_outcomes ?? [] as $row)
                                                         <li class="list-group-item">{{ $row }}</li>
                                                      @endforeach
                                                   </ul>
                                                </div>
                                             </div>
                                          </div>
                                       </div>

                                       <div class="accordion accordion-flush" id="learnintOutcomesAccordion">
                                          <div class="accordion-item">
                                             <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                   data-bs-target="#learningOutcomesCollapse" aria-expanded="true"
                                                   aria-controls="learningOutcomesCollapse">
                                                   Current Student Learning Outcomes
                                                </button>
                                             </h2>
                                             <div id="learningOutcomesCollapse" class="accordion-collapse collapse "
                                                aria-labelledby="headingOne" data-bs-parent="#learnintOutcomesAccordion">
                                                <div class="accordion-body">
                                                   <ul class="list-group">
                                                      @foreach ($course->current_learning_outcomes ?? [] as $row)
                                                         <li class="list-group-item">{{ $row }}</li>
                                                      @endforeach
                                                   </ul>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    @endcan
                                 @endcan
                              </div>
                           @endempty
                        </div>
                     </div>
                  </x-slot>
               </x-real.card>
            </div>

            <div class="col-12">
               <x-real.card id="lessonSection" :vertical="'center'">
                  <x-slot name="header">Lessons</x-slot>
                  <x-slot name="action">
                     @if (!auth()->user()->isSecretary())
                     <a href="{{ route('course.showUserLessons', [$course, auth()->id()]) }}"
                        class="btn btn-light btn-sm text-primary border fw-bold">Manage Your Course Lessons</a>
                     @endif

                     <a href="{{ route('course.showLessons', [$course]) }}"
                        class="btn btn-light btn-sm text-primary border fw-bold">View All Course Lessons</a>
                  </x-slot>
                  <x-slot name="body">
                     <div class="row mt-4">
                        <div class="accordion accordion-flush" id="accordionLessons">
                           <table class="w-100 tableAccordion py-3">
                              <thead class="d-none">
                                 <tr>
                                    <th></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach ($course->lessons as $lesson)
                                    <tr>
                                       <td>
                                          <div class="accordion-item bg-transparent">
                                             <h2 class="accordion-header" id="flushHeading{{ $loop->index }}">
                                                <button class="accordion-button collapsed" type="button"
                                                   data-bs-toggle="collapse"
                                                   data-bs-target="#flushCollapse{{ $loop->index }}"
                                                   aria-expanded="false">
                                                   <div class="hstack align-items-center gap-3 text-muted">
                                                      <p class="mb-0 small lh-sm">
                                                         <strong
                                                            class="d-block text-gray-dark">{{ $lesson->title }}</strong>
                                                         <small
                                                            class="pt-2">{{ $lesson->description }}</small>
                                                      </p>
                                                   </div>
                                                </button>
                                             </h2>
                                             <div id="flushCollapse{{ $loop->index }}"
                                                class="border-start ms-3 my-3 accordion-collapse collapse"
                                                aria-labelledby="flushHeading{{ $loop->index }}"
                                                data-bs-parent="#accordionLessons">
                                                <div class="accordion-body">
                                                   <a href="{{ route('lesson.show', $lesson) }}">View lesson</a>

                                                   {!! $dataTable->table(['data-lesson-id' => $lesson->id, 'class' => 'accordionTableRes w-100 table align-middle table-hover']) !!}
                                                </div>
                                             </div>
                                          </div>
                                       </td>
                                    </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </x-slot>
               </x-real.card>
            </div>
         </div>
      </div>
      <div class="col-md-4">
         <div class="row g-3">
            <div class="col-12">
               <x-real.card :variant="'secondary'" :vertical="'center'">
                  <x-slot name="header">Course Details</x-slot>
                  <x-slot name="body">

                     <x-real.text-with-subtitle>
                        <x-slot name="text">{{ $course->code }} - {{ $course->title }}</x-slot>
                        <x-slot name="subtitle">Course Label</x-slot>
                     </x-real.text-with-subtitle>
                     <br>
                     <x-real.text-with-subtitle>
                        <x-slot name="text">{{ $course->program->code }} - {{ $course->program->title }}</x-slot>
                        <x-slot name="subtitle">Program</x-slot>
                     </x-real.text-with-subtitle>
                  </x-slot>
               </x-real.card>
            </div>

            <div class="col-12">
               <x-real.card :variant="'secondary'" :vertical="'center'">
                  <x-slot name="header">Recent submissions</x-slot>
                  <x-slot name="action">
                     <a href="{{ route('course.showResources', $course) }}"
                        class="btn btn-light btn-sm text-primary border fw-bold">View More</a>
                  </x-slot>
                  <x-slot name="body">
                     @forelse ($course->resources()->latest()->limit(4)->get() as $submission)
                        <div class="py-2 border-bottom">
                           <small class="text-muted">{{ $submission->created_at->diffForHumans() }}</small>
                           -
                           {{ $submission->title }} ({{ $submission->currentMediaVersion->file_name }})
                           <div>
                              <small>Submitted by <b>{{ $submission->user->name }}</b></small>
                           </div>
                           <a href="{{ route('resource.addViewCountThenRedirectToShow', $submission) }}"><small>View
                                 resource >></small></a>
                        </div>
                     @empty
                        <x-real.no-rows>
                           <x-slot name="label">
                              There are no recent submissions
                           </x-slot>
                        </x-real.no-rows>
                     @endforelse
                  </x-slot>
               </x-real.card>
            </div>
            <div class="col-12">
               <x-real.card :variant="'secondary'" :vertical="'center'">
                  <x-slot name="header">Most active instructors</x-slot>
                  <x-slot name="body">
                     <div class="vstack gap-3">
                        @forelse ($course->program->users()->withCount('activityLogs')
                     ->orderByDesc("activity_logs_count")
                     ->instructors()
                     ->limit(4)
                     ->get() as $instructor)
                           <div class="d-flex align-items-center gap-3 text-muted overflow-hidden pb-2 border-bottom">
                              <div
                                 class="{{ $loop->iteration > 1 ? 'bg-secondary' : 'bg-primary' }} bg-gradient text-white rounded px-3 py-2">
                                 <b>{{ $loop->iteration }}</b>
                              </div>

                              <div class="row">
                                 <div class="col-12">
                                    <div class="hstack gap-3 align-items-center">
                                       <strong class="d-block text-gray-dark">{{ $instructor->name }}</strong>
                                    </div>
                                 </div>

                                 <div class="hstack gap-3 mt-1">
                                    <small>Total activities:
                                       <b> {{ $instructor->activityLogs->count() }}</b>
                                    </small>
                                 </div>
                              </div>
                           </div>
                        @empty
                           <x-real.no-rows>
                              <x-slot name="label">
                                 There are no activities coming from instructors
                              </x-slot>
                           </x-real.no-rows>
                        @endforelse
                     </div>
                  </x-slot>
               </x-real.card>
            </div>
         </div>
      </div>
   </div>

   @section('script')
      <script>
         $(document).ready(function() {
            $('.accordionTableRes').each(function(index, table) {
               if (!$.fn.dataTable.isDataTable(table)) {
                  $(table).DataTable({
                     ...TABLE_MANAGEMENT_PROPS,
                     ajax: `{{ route('course.show', $course) }}?lesson=${$(table).attr('data-lesson-id')}`,
                     columns: [{
                           data: 'title',
                           name: 'title',
                           width: '120px'
                        },
                        {
                           data: 'type',
                           name: 'type',
                           width: '120px'
                        },
                        {
                           data: 'media',
                           name: 'media.file_name',
                           width: '120px'
                        },
                        {
                           data: 'verification',
                           name: 'verification',
                           width: '110px'
                        },
                        {
                           data: 'created_at',
                           name: 'created_at',
                           width: '120px'
                        },
                        {
                           data: 'action',
                           name: '',
                           width: '120px'
                        },
                     ]
                  });
               }
            })


            // $('#lessonSection .tableInsideAccordion').DataTable({
            //    sDom: 'frtip',
            //    language: {
            //       emptyTable: 'No resources available in this table'
            //    }
            // })
            $('#lessonSection .tableAccordion').DataTable({
               language: {
                  emptyTable: 'No lessons available in this table'
               }
            })

            var exampleModal = document.getElementById('createResourceModal')
            exampleModal.addEventListener('show.bs.modal', function(event) {
               let button = event.relatedTarget

               let mode = button.getAttribute('data-mode')

               let modalTitle = exampleModal.querySelector('.modal-title')
               let modalBodyInput = exampleModal.querySelector('[name="mode"]')

               modalBodyInput.value = mode
            })
         })
      </script>
   @endsection
</x-app-layout>
