<div class="d-flex align-items-center px-3 bg-white border-2 border-bottom" style="min-height: 60px; max-height: 60px">
    <header class="hstack gap-3">
        <div class="overflow-hidden">
            <h3 class="text-truncate d-block my-0 fw-bolder ">{{ $header }}</h3>

            @empty($headerTitle)
            @else
                <small class="text-muted">{{ $headerTitle }}</small>
            @endunless
        </div>

        <div class="vr"></div>

        <x-breadcrumb>
            {{ $breadcrumb }}
        </x-breadcrumb>
    </header>

    <nav class="navbar navbar-expand navbar-light ms-auto py-2">
        <div class="container-fluid px-0">
            <div class="btn-group dropstart">

                <button class="navbar-brand btn rounded text-reset position-relative small" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" aria-expanded="false">
                    @empty($notifications->count())
                        <span class="material-icons md-24 align-middle">
                            notifications_none
                        </span>
                    @else
                        <span class="material-icons md-24 align-middle">
                            notifications_active
                        </span>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                            {{ $notifications->count() }}
                        </span>
                    @endempty
                    Notifications
                </button>

                <ul class="dropdown-menu shadow border-0 p-0" aria-labelledby="dropdownMenu2">
                    <li class="dropdown-item p-0">
                        <ul class="list-group" style="min-width: 300px">
                            @forelse ($notifications->take(5) as $notification)
                                <li class="list-group-item">
                                    <a href="{{ route('pending-resources.show', $notification->data['resource_id']) }}"
                                        data-passover="{{ $notification->id }}"
                                        class="notification-show-link btn text-start w-100 overflow-hidden">
                                        <h6>{{ $notification->data['user'] }} submitted a resource</h6>

                                        <span class="form-text">{{ $notification->created_at }}</span>
                                    </a>
                                </li>

                                @if ($loop->iteration == 5)
                                    <li class="list-group-item">
                                        <a href="{{ route('notifications.index') }}"
                                            class="btn btn-link w-100 overflow-hidden">
                                            <h6>Click here to view all notifications</h6>
                                        </a>
                                    </li>
                                @endif
                            @empty
                                <li class="list-group-item">
                                    <img title="alert triangle" alt="alert triangle icon" class="img-thumbnail"
                                        src="{{ asset('images/icons/alert-triangle.svg') }}" />
                                    <h5 class="form-text fw-bold">There are no notifations yet.</h5>
                                </li>
                            @endforelse
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="dropdown dropstart">
                    <button class="btn" type="button" id="dropdownMenuButton1" data-bs-display="static"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-icons md-24 align-middle">
                            settings
                        </span>
                        Settings
                    </button>

                    <ul class="dropdown-menu mx-0 shadow" style="width: 240px">
                        <li class="bg-light">
                            <a class="dropdown-item vstack gap-2 align-items-center" href="#">
                                <img src="#" class="img-thumbnail rounded-pill thumbnail-md" alt="User Avatar">
                                <span class="d-block small fw-bold">Anthony Jay Ansit</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item dropdown-item-danger d-flex gap-2 align-items-center" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    <span class="material-icons md-18">
                                        logout
                                    </span>
                                    Sign out
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
                {{-- <ul class="navbar-nav">
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
                </ul> --}}
            </div>
        </div>
    </nav>
</div>
