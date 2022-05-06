<x-app-layout>
   <x-slot name="header">
      Edit Course
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dean.course.index') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item ">
         <a href="{{ route('dashboard') }}">Home</a>
      </li>
      <li class="breadcrumb-item ">
         <a href="{{ route('dean.course.index') }}">Course Management</a>
      </li>
      <li class="breadcrumb-item active">
         Edit Course
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-3">
         <x-real.card :vertical="'center'" id="weeklySubmissionChartCard">
            <x-slot name="header">Navigate to</x-slot>
            <x-slot name="body">
               <ul class="nav nav-pills nav-flush persist-default flex-column gap-2">
                  <li class="nav-item">
                     <a href="{{ route('dean.resource.index') }}" class="nav-link">Resources</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.instructor.index') }}" class="nav-link ">Instructors</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.course.index') }}" class="nav-link active">Courses</a>
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
                           <x-real.form action="{{ route('dean.course.update', $course) }}" method="PUT">
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

                              <h6 class="fw-bold mt-5">Assign Instructors</h6>
                              <x-real.table id="assignInstructorsTable">
                                 <x-slot name="headers">
                                    <th>Instructor</th>
                                    <th>Read Rights</th>
                                    <th>Write Rights</th>
                                 </x-slot>
                                 <x-slot name="rows">
                                    @foreach ($users as $user)
                                       <tr>
                                          <td>
                                             {{ $user->name }}
                                          </td>

                                          <td>
                                             <x-real.input type="hidden" name="read[{{ $user->id }}]" value="0" />
                                             @if ($user->courses()->where(['view' => true, 'course_id' => $course->id])->exists())
                                                <x-real.input type="checkbox" name="read[{{ $user->id }}]"
                                                   value="1" checked>
                                                </x-real.input>
                                             @else
                                                <x-real.input type="checkbox" name="read[{{ $user->id }}]"
                                                   value="1">
                                                </x-real.input>
                                             @endif
                                          </td>
                                          <td>
                                             <x-real.input type="hidden" name="write[{{ $user->id }}]" value="0" />
                                             @if ($user->courses()->where(['participate' => true, 'course_id' => $course->id])->exists())
                                                <x-real.input type="checkbox" name="write[{{ $user->id }}]"
                                                   value="1" checked>
                                                </x-real.input>
                                             @else
                                                <x-real.input type="checkbox" name="write[{{ $user->id }}]"
                                                   value="1">
                                                </x-real.input>
                                             @endif
                                          </td>
                                       </tr>
                                    @endforeach
                                 </x-slot>
                              </x-real.table>

                              <x-slot name="submit">
                                 <x-real.btn type="submit" :btype="'solid'" :size="'lg'">Confirm</x-real.btn>
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
            $('#assignInstructorsTable').DataTable({
               pageLength: 5,
               dom: 'ftip',
               "aaSorting": [],
            })
         })
      </script>
   @endsection
</x-app-layout>
