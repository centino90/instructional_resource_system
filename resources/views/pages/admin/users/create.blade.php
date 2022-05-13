<x-app-layout>
   <x-slot name="header">
      Create User
   </x-slot>

   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('admin.users.index') }}">
            <- Go back </a>
      </li>
      <li class="breadcrumb-item ">
         <a href="{{ route('dashboard') }}">Home</a>
      </li>
      <li class="breadcrumb-item ">
         <a href="{{ route('admin.users.index') }}">User Management</a>
      </li>
      <li class="breadcrumb-item active">
         Create User
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-3">
         <x-real.card :vertical="'center'" id="weeklySubmissionChartCard">
            <x-slot name="header">Navigate to</x-slot>
            <x-slot name="body">
               <ul class="nav nav-pills nav-flush persist-default flex-column gap-2">
                  <li class="nav-item">
                     <a href="{{ route('admin.users.index') }}" class="nav-link active">Users</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('admin.programs.index') }}" class="nav-link ">Programs</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('admin.typology.index') }}" class="nav-link ">Typologies</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.syllabus-settings.index') }}" class="nav-link">Syllabus Settings</a>
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
                           Create User Form
                        </x-slot>
                        <x-slot name="body">
                           <x-real.form action="{{ route('admin.users.store') }}">
                              <x-real.input name="role_id" type="select">
                                 <x-slot name="label">Role</x-slot>
                                 <x-slot name="options">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                       <option {{ old('role_id') == $role->id ? 'selected' : '' }}
                                          value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                 </x-slot>
                              </x-real.input>

                              <input type="hidden" name="program_id" value="0" class="d-none" />
                              <div class="d-none" id="programSelectDiv">
                                 <x-real.input name="program_id" type="select" disabled>
                                    <x-slot name="label">Program</x-slot>
                                    <x-slot name="options">
                                       <option value="">Select Program</option>
                                       @foreach ($programs as $program)
                                          <option {{ old('program_id') == $program->id ? 'selected' : '' }}
                                             value="{{ $program->id }}">{{ $program->code }}</option>
                                       @endforeach
                                    </x-slot>
                                 </x-real.input>
                              </div>
                              <div class="d-none" id="deanProgramSelectDiv">
                                 @if (count($deanPrograms) <= 0)
                                    <div class="alert alert-secondary">You can't assign a DEAN to a program. All Programs Are Currently Occupied. <a href="{{route('admin.programs.create')}}">Create a program first</a> or Continue Creation Without Assigning a Program</div>
                                 @else
                                    <x-real.input name="program_id" type="select" disabled>
                                       <x-slot name="label">Program</x-slot>
                                       <x-slot name="options">
                                          <option value="">Select Program</option>
                                          @foreach ($deanPrograms as $program)
                                             <option {{ old('program_id') == $program->id ? 'selected' : '' }}
                                                value="{{ $program->id }}">{{ $program->code }}</option>
                                          @endforeach

                                       </x-slot>
                                    </x-real.input>
                                 @endif
                              </div>

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

                              <x-real.input type="number" name="storage_size" value="{{config('app.max_personal_file_storage_size')}}">
                                <x-slot name="label">Storage Size (in MB)</x-slot>
                             </x-real.input>

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
            showProgramBasedOnRole($('[name=role_id]').val())

            $('[name=role_id]').change(function(event) {
               const $val = $(event.target).val()
               showProgramBasedOnRole($val)
            })

            function showProgramBasedOnRole($val) {
               if ($.inArray($val, ['{{ \App\Models\Role::PROGRAM_DEAN }}']) != -1) {
                  $('#deanProgramSelectDiv').removeClass('d-none')
                  $('#deanProgramSelectDiv select').attr('disabled', false)

                  $('#programSelectDiv').addClass('d-none')
                  $('#programSelectDiv select').attr('disabled', true)
               } else if ($.inArray($val, ['{{ \App\Models\Role::INSTRUCTOR }}']) != -1) {
                  $('#programSelectDiv').removeClass('d-none')
                  $('#programSelectDiv select').attr('disabled', false)

                  $('#deanProgramSelectDiv').addClass('d-none')
                  $('#deanProgramSelectDiv select').attr('disabled', true)
               } else {
                  $('#programSelectDiv, #deanProgramSelectDiv').addClass('d-none')
                  $('#programSelectDiv select, #deanProgramSelectDiv select').attr('disabled', true)
               }
            }
         })
      </script>
   @endsection
</x-app-layout>
