<x-app-layout>
   <x-slot name="header">
      Create Instructor
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('dean.instructor.index') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item ">
         <a href="{{ route('dashboard') }}">Home</a>
      </li>
      <li class="breadcrumb-item ">
         <a href="{{ route('dean.instructor.index') }}">Instructor Management</a>
      </li>
      <li class="breadcrumb-item active">
         Create Instructor
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
                     <a href="{{ route('dean.instructor.index') }}" class="nav-link active">Instructors</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('dean.course.index') }}" class="nav-link">Courses</a>
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
                           Create Instructor Form
                        </x-slot>
                        <x-slot name="body">
                           <x-real.form action="{{ route('dean.instructor.store') }}" method="POST">
                              <x-real.input name="fname" value="{{ old('fname') }}">
                                 <x-slot name="label">First name</x-slot>
                              </x-real.input>
                              <x-real.input name="lname" value="{{ old('lname') }}">
                                 <x-slot name="label">Last name</x-slot>
                              </x-real.input>
                              <x-real.input name="contact_no" value="{{ old('contact_no') }}">
                                 <x-slot name="label">Contact No</x-slot>
                              </x-real.input>
                              <x-real.input name="email" value="{{ old('email') }}">
                                 <x-slot name="label">Email</x-slot>
                              </x-real.input>

                              <h6 class="fw-bold mt-5">Assign to Courses</h6>
                              <x-real.table id="assignToCourseTable">
                                 <x-slot name="headers">
                                    <th>Course</th>
                                    <th>Year Level</th>
                                    <th>Read Rights</th>
                                    <th>Write Rights</th>
                                 </x-slot>
                                 <x-slot name="rows">
                                    @foreach ($courses->sortBy('year_level') as $course)
                                       <tr>
                                          <td>
                                             {{ $course->title }} ({{ $course->code }})
                                          </td>
                                          <td>
                                             Year Level: {{ $course->year_level }}
                                          </td>
                                          <td>
                                             <x-real.input type="hidden" name="read[{{ $course->id }}]" value="0" />
                                             @if (!empty(old('read')) && isset(old('read')[$course->id]) && boolval(old('read')[$course->id]))
                                                <x-real.input type="checkbox" name="read[{{ $course->id }}]"
                                                   value="1" checked>
                                                </x-real.input>
                                             @else
                                                <x-real.input type="checkbox" name="read[{{ $course->id }}]"
                                                   value="1">
                                                </x-real.input>
                                             @endif
                                          </td>
                                          <td>
                                             <x-real.input type="hidden" name="write[{{ $course->id }}]" value="0" />
                                             @if (!empty(old('write')) && isset(old('write')[$course->id]) && boolval(old('write')[$course->id]))
                                                <x-real.input type="checkbox" name="write[{{ $course->id }}]"
                                                   value="1" checked>
                                                </x-real.input>
                                             @else
                                                <x-real.input type="checkbox" name="write[{{ $course->id }}]"
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
            $('#assignToCourseTable').DataTable({
               pageLength: 5,
               dom: 'ftip',
               "aaSorting": [],
               "columnDefs": [{
                  "visible": false,
                  "targets": [1]
               }],
               "drawCallback": function(settings) {
                  var api = this.api();
                  var rows = api.rows().nodes();
                  var last = null;

                  api.column(1).data().each(function(group, i) {
                     if (last !== group) {
                        $(rows).eq(i).before(
                           '<tr class="group"><td class="fw-bold bg-light p-2" colspan="5">' + group +
                           '</td></tr>'
                        );

                        last = group;
                     }
                  });
               }
            })
         })
      </script>
   @endsection
</x-app-layout>
