<x-guest-layout>
   <x-auth-card>
      <x-slot name="logo">
         <div class="card-body">
            <x-application-logo width="82" />
            <h1 class="text-light">Online Instructional Resource System</h1>
         </div>
      </x-slot>

      <div class="card-body py-5">
         <!-- Session Status -->
         <x-auth-session-status class="mb-3" :status="session('status')" />

         <!-- Validation Errors -->
         <x-auth-validation-errors class="mb-3" :errors="$errors" />

         @if (!$errors->any())
            <div class="alert alert-info">
               Login using the login credentials given by your program dean
            </div>
         @endif

         <x-real.form action="{{ route('login') }}">
            <x-real.input name="username" :value="old('username')" autofocus>
               <x-slot name="label">Username</x-slot>

               @error('username')
                  <x-slot name="formText">
                     {{ $message }}
                  </x-slot>
               @enderror
            </x-real.input>


            <x-real.input type="password" name="password" :value="old('password')">
               <x-slot name="label">Password</x-slot>

               @error('password')
                  <x-slot name="formText">
                     {{ $message }}
                  </x-slot>
               @enderror
            </x-real.input>

            <x-slot name="submit">
               <x-real.btn :btype="'solid'" type="submit" class="w-100">Log in</x-real.btn>
            </x-slot>
         </x-real.form>
      </div>
   </x-auth-card>
</x-guest-layout>
