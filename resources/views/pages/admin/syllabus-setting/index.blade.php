<x-app-layout>
   <x-slot name="header">
      Syllabus Settings Management
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dashboard') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item active">
         Syllabus Settings Management
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-3">
         <x-real.card :vertical="'center'" id="weeklySubmissionChartCard">
            <x-slot name="header">Navigate to</x-slot>
            <x-slot name="body">
               <ul class="nav nav-pills nav-flush persist-default flex-column gap-2">
                  <li class="nav-item">
                     <a href="{{ route('admin.users.index') }}" class="nav-link">Users</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('admin.programs.index') }}" class="nav-link">Programs</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('admin.typology.index') }}" class="nav-link">Typologies</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('admin.syllabus-settings.index') }}" class="nav-link active">Syllabus
                        Settings</a>
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
                     <x-real.card :vertical="'center'">
                        <x-slot name="header">Syllabus Settings</x-slot>
                        <x-slot name="body">
                           <x-real.form method="put"
                              action="{{ route('admin.syllabus-settings.update', $syllabusSetting) }}"
                              onsubmit="return confirm('Do you want to save changes?')" id="syllabusForm">

                              <h5>Course Outcomes Search Settings</h5>
                              <x-real.input type="number" name="course_outcomes_table_no" value="{{ $syllabusSetting->course_outcomes_table_no }}">
                                <x-slot name="label">
                                    Course Outcomes Table No
                                </x-slot>
                             </x-real.input>
                             <x-real.input type="number" name="course_outcomes_row_no" value="{{ $syllabusSetting->course_outcomes_row_no }}">
                                <x-slot name="label">
                                    Course Outcomes Row No
                                </x-slot>
                             </x-real.input>
                             <x-real.input type="number" name="course_outcomes_col_no" value="{{ $syllabusSetting->course_outcomes_col_no }}">
                                <x-slot name="label">
                                    Course Outcomes Col No
                                </x-slot>
                             </x-real.input>

                              <h5>Student Learning Outcomes Search Settings</h5>
                              <x-real.input type="number" name="student_outcomes_table_no" value="{{ $syllabusSetting->student_outcomes_table_no }}">
                                <x-slot name="label">
                                    Student Learning Outcomes Table No
                                </x-slot>
                             </x-real.input>
                             <x-real.input type="number" name="student_outcomes_row_no" value="{{ $syllabusSetting->student_outcomes_row_no }}">
                                <x-slot name="label">
                                    Student Learning Outcomes Row No
                                </x-slot>
                             </x-real.input>
                             <x-real.input type="number" name="student_outcomes_col_no" value="{{ $syllabusSetting->student_outcomes_col_no }}">
                                <x-slot name="label">
                                    Student Learning Outcomes Col No
                                </x-slot>
                             </x-real.input>

                             <h5>Lesson Search Settings</h5>
                              <x-real.input type="number" name="lesson_table_no" value="{{ $syllabusSetting->lesson_table_no }}">
                                <x-slot name="label">
                                    Lesson Table No
                                </x-slot>
                             </x-real.input>
                             <x-real.input type="number" name="lesson_row_no" value="{{ $syllabusSetting->lesson_row_no }}">
                                <x-slot name="label">
                                    Lesson Row No
                                </x-slot>
                             </x-real.input>
                             <x-real.input type="number" name="lesson_col_no" value="{{ $syllabusSetting->lesson_col_no }}">
                                <x-slot name="label">
                                    Lesson Col No
                                </x-slot>
                             </x-real.input>

                             <x-slot name="submit">
                                 <x-real.btn :btype="'solid'" type="submit" class="no-loading">Update</x-real.btn>
                             </x-slot>
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
