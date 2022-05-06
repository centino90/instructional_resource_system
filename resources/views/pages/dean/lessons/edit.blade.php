<x-app-layout>
   <x-slot name="header">
      Edit lesson
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dean.lesson.index') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item ">
         <a href="{{ route('dashboard') }}">Home</a>
      </li>
      <li class="breadcrumb-item ">
         <a href="{{ route('dean.lesson.index') }}">Lesson Management</a>
      </li>
      <li class="breadcrumb-item active">
         Edit Lesson
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-3">
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
                        class="nav-link ">Courses</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.cms.lessons', ['accessType' => \App\Models\Role::PROGRAM_DEAN]) }}"
                        class="nav-link active">Lessons</a>
                  </li>
               </ul>
            </x-slot>
         </x-real.card>
      </div>

      <div class="col-9">
         <div class="row g-3">
            <div class="col-12">
               <div class="row g-3">
                  <div class="col-12">
                     <x-real.card>
                        <x-slot name="header">
                           Edit Course Form
                        </x-slot>
                        <x-slot name="body">
                           <x-real.form>
                              <x-real.input name="title" value="{{ $course->title }}">
                                 <x-slot name="label">Title</x-slot>
                              </x-real.input>

                              <x-real.input name="code" value="{{ $course->code }}">
                                 <x-slot name="label">Code</x-slot>
                              </x-real.input>

                              <x-real.input name="year_level" type="select">
                                 <x-slot name="label">Year Level</x-slot>
                                 <x-slot name="options">
                                    <option value="">Select Year Level</option>
                                    <option {{ $course->year_level == 1 ? 'selected' : '' }} value="1">First year
                                    </option>
                                    <option {{ $course->year_level == 2 ? 'selected' : '' }} value="2">Second year
                                    </option>
                                    <option {{ $course->year_level == 3 ? 'selected' : '' }} value="3">Third year
                                    </option>
                                    <option {{ $course->year_level == 4 ? 'selected' : '' }} value="4">Fourth year
                                    </option>
                                 </x-slot>
                              </x-real.input>

                              <x-real.input name="semester" type="select">
                                 <x-slot name="label">Semester</x-slot>
                                 <x-slot name="options">
                                    <option value="">Select Semester</option>
                                    <option {{ $course->semester == 1 ? 'selected' : '' }} value="1">First semester
                                    </option>
                                    <option {{ $course->semester == 2 ? 'selected' : '' }} value="2">Second semester
                                    </option>
                                    <option {{ $course->semester == 3 ? 'selected' : '' }} value="2">Third semester
                                    </option>
                                 </x-slot>
                              </x-real.input>

                              <x-real.input name="term" type="select">
                                 <x-slot name="label">Term</x-slot>
                                 <x-slot name="options">
                                    <option value="">Select Term</option>
                                    <option {{ $course->term == 1 ? 'selected' : '' }} value="1">First term</option>
                                    <option {{ $course->term == 2 ? 'selected' : '' }} value="2">Second term</option>
                                 </x-slot>
                              </x-real.input>
                           </x-real.form>
                        </x-slot>
                     </x-real.card>
                  </div>
               </div>
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
