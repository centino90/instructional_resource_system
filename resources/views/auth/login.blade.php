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

            <div class="alert alert-info">
                Login using the login credentials given by your program dean
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username Address -->
                <div class="form-group">
                    <x-label for="username" :value="__('Username')" />

                    <x-input id="username" type="text" name="username" :value="old('username')" autofocus />

                    <x-input-error :for="'username'"></x-input-error>
                </div>

                <!-- Password -->
                <div class="form-group mt-3">
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" type="password" name="password" autocomplete="current-password" />

                    <x-input-error :for="'password'"></x-input-error>
                </div>

                <div class="mt-3">
                    <div class="d-grid">
                        <x-button :class="'btn-primary'" :type="'submit'">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
