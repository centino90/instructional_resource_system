<div class="d-flex">
    {{ $breadcrumb }}

    <nav class="navbar navbar-expand navbar-light bg-light ms-auto">
        <div class="container-fluid">
            <div class="btn-group dropstart">

                <button class="navbar-brand btn rounded text-reset p-0 position-relative" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                    aria-expanded="false">
                    @empty($notifications->count())
                    <img title="notifications" alt="notifications" class="img-thumbnail" src="{{asset('images/icons/notifications.svg')}}" />
                @else
                    <img title="notifications active" alt="notifications active" class="img-thumbnail" src="{{asset('images/icons/notifications-active.svg')}}" />
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                        {{ $notifications->count() }}
                    </span>
                @endempty
                </button>

                <ul class="dropdown-menu shadow border-0 p-0" aria-labelledby="dropdownMenu2">
                    <li class="dropdown-item p-0">
                        <ul class="list-group" style="min-width: 300px">
                            @forelse ($notifications->take(5) as $notification)
                                <li class="list-group-item">
                                    <a href="{{route('pending-resources.show', $notification->data['resource_id'])}}" data-passover="{{$notification->id}}" class="notification-show-link btn text-start w-100 overflow-hidden">
                                        <h6>{{ $notification->data['user'] }} submitted a resource</h6>

                                        <span class="form-text">{{ $notification->created_at }}</span>
                                    </a>
                                </li>

                                @if($loop->iteration == 5)
                                    <li class="list-group-item">
                                        <a href="{{route('notifications.index')}}" class="btn btn-link w-100 overflow-hidden">
                                            <h6>Click here to view all notifications</h6>
                                        </a>
                                    </li>
                                @endif
                            @empty
                                <li class="list-group-item">
                                    <img title="alert triangle" alt="alert triangle icon" class="img-thumbnail" src="{{asset('images/icons/alert-triangle.svg')}}" />
                                    <h5 class="form-text fw-bold">There are no notifations yet.</h5>
                                </li>
                            @endforelse
                        </ul>
                    </li>
                </ul>
            </div>
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
                                <x-icon.signout :width="'20'" :height="'20'" :viewBox="'0 0 30 30'"></x-icon.signout>
                                {{ __('Logout') }}
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
