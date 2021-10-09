<div class="d-flex">
    {{ $breadcrumb }}

    <ul class="navbar-nav ms-auto">
    @auth
        <x-dropdown id="settingsDropdown">
            <x-slot name="trigger">
                {{ Auth::user()->name }}
            </x-slot>

            <x-slot name="content">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link>
                        <x-icon.user :width="'20'" :height="'20'" :viewBox="'0 0 30 30'"></x-icon.user>{{ __('Profile Settings') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <x-icon.signout :width="'20'" :height="'20'" :viewBox="'0 0 30 30'"></x-icon.signout>{{ __('Logout') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    @endauth
    </ul>
</div>