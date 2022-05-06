<x-app-layout>
   <x-slot name="header">
      Create Course
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
         Create Course
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
                           Create Course Form
                        </x-slot>
                        <x-slot name="body">
                           <x-real.form action="{{ route('dean.course.store') }}">
                              <x-real.input name="title">
                                 <x-slot name="label">Title</x-slot>
                                 <x-slot name="oldValue">{{ old('title') }}</x-slot>
                              </x-real.input>

                              <x-real.input name="code">
                                 <x-slot name="label">Code</x-slot>
                                 <x-slot name="oldValue">{{ old('code') }}</x-slot>
                              </x-real.input>

                              <x-real.input name="year_level" type="select">
                                 <x-slot name="label">Year Level</x-slot>
                                 <x-slot name="options">
                                    <option value="">Select Year Level</option>
                                    <option {{ old('year_level') == '1' ? 'selected' : '' }} value="1">First year
                                    </option>
                                    <option {{ old('year_level') == '2' ? 'selected' : '' }} value="2">Second year
                                    </option>
                                    <option {{ old('year_level') == '3' ? 'selected' : '' }} value="3">Third year
                                    </option>
                                    <option {{ old('year_level') == '4' ? 'selected' : '' }} value="4">Fourth year
                                    </option>
                                 </x-slot>
                                 <x-slot name="oldValue"></x-slot>
                              </x-real.input>

                              <x-real.input name="semester" type="select">
                                 <x-slot name="label">Semester</x-slot>
                                 <x-slot name="options">
                                    <option value="">Select Semester</option>
                                    <option {{ old('semester') == '1' ? 'selected' : '' }} value="1">First semester
                                    </option>
                                    <option {{ old('semester') == '2' ? 'selected' : '' }} value="2">Second semester
                                    </option>
                                    <option {{ old('semester') == '3' ? 'selected' : '' }} value="2">Third semester
                                    </option>
                                 </x-slot>
                              </x-real.input>

                              <x-real.input name="term" type="select">
                                 <x-slot name="label">Term</x-slot>
                                 <x-slot name="options">
                                    <option value="">Select Term</option>
                                    <option {{ old('term') == '1' ? 'selected' : '' }} value="1">First term</option>
                                    <option {{ old('term') == '2' ? 'selected' : '' }} value="2">Second term</option>
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
                                            @if (!empty(old('read')) && isset(old('read')[$user->id]) && boolval(old('read')[$user->id]))
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
                                            @if (!empty(old('write')) && isset(old('write')[$user->id]) && boolval(old('write')[$user->id]))
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
