<x-app-layout>
   <x-slot name="header">
      {{ $lesson->title }}
   </x-slot>
   <x-slot name="headerTitle">
      Update Lesson
   </x-slot>
   <x-slot name="breadcrumb">
      <li class="breadcrumb-item">
         <a class="fw-bold" href="{{ route('user.lessons', $user) }}">
            <- Go back </a>
      </li>

      <li class="breadcrumb-item">
         <a href="{{ route('user.index') }}">Users</a>
      </li>


      <li class="breadcrumb-item">
         <a href="{{ route('user.show', $user) }}">{{ $user->name }}</a>
      </li>

      <li class="breadcrumb-item">
         <a href="{{ route('user.lessons', $user) }}">Lessons</a>
      </li>


      <li class="breadcrumb-item active">
         Update Lesson
      </li>
   </x-slot>

   <div class="row g-3">
      <div class="col-12">
         <x-real.card>
            <x-slot name="header">Update Form</x-slot>
            <x-slot name="body">
               <x-real.form action="{{ route('lesson.update', $lesson) }}" method="put">
                  <x-real.input name="title" value="{{ $lesson->title }}">
                     <x-slot name="label">Title</x-slot>
                  </x-real.input>
                  <x-real.input name="description" value="{{ $lesson->description }}">
                     <x-slot name="label">Description</x-slot>
                  </x-real.input>

                  <x-slot name="submit">
                     <x-real.btn type="submit">Update</x-real.btn>
                  </x-slot>
               </x-real.form>
            </x-slot>
         </x-real.card>
      </div>
   </div>

   @section('script')
      <script>
         $(document).ready(function() {

         })
      </script>
   @endsection
</x-app-layout>
