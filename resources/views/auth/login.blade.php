<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="82" />
            </a>
        </x-slot>

        <div class="card-body">
            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username Address -->
                <div class="form-group">
                    <x-label for="username" :value="__('Username')" />

                    <x-input id="username" type="text" name="username" :value="old('username')" autofocus />
                </div>

                <!-- Password -->
                <div class="form-group mt-3">
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" type="password" name="password" autocomplete="current-password" />
                </div>

                <div class="mt-3">
                    <div class="d-flex justify-content-end align-items-baseline">
                        <x-button :class="'btn-dark'" :type="'submit'">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
