<div class="d-flex">
    {{ $breadcrumb }}

    <nav class="navbar navbar-expand navbar-light bg-light ms-auto">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <div class="btn text-inherit text-reset p-0 position-relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell p-0 m-0">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>

                @empty($notifications->count())
                @else
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                    {{ $notifications->count() }}
                </span>
                @endempty
            </div>
            {{-- Notifications --}}
          </a>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#">
                    <x-icon.user :width="'20'" :height="'20'" :viewBox="'0 0 30 30'"></x-icon.user>
                    {{ Auth::user()->name }}
                </a>
              </li>
              <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="nav-link" href="#" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <x-icon.signout :width="'20'" :height="'20'" :viewBox="'0 0 30 30'"></x-icon.signout>{{ __('Logout') }}
                    </a>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    {{-- <ul class="navbar-nav bg-white px-3 rounded shadow-sm ms-auto">
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
    </ul> --}}
</div>
