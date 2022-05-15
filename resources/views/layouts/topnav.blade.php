<div class="d-flex align-items-center px-3 bg-white border-2 border-bottom" style="min-height: 60px; max-height: 60px">
    <header class="hstack gap-3">
        <div class="overflow-hidden">
            <h3 class="text-truncate d-block my-0 fw-bolder " style="max-width: 400px">{{ $header }}</h3>

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
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $notifications->count() }}
                        </span>
                    @endempty
                    Notifications
                </button>

                <ul class="dropdown-menu shadow border-0 p-0" aria-labelledby="dropdownMenu2">
                    <li class="dropdown-item p-0">
                        <ul class="list-group" style="min-width: 300px;max-width: 300px">
                            @forelse ($notifications->take(5) as $notification)
                                <li class="list-group-item list-group-item-action"
                                    onclick="$(event.target).find('form').submit()">
                                    <h6 class="whitespace-wrap text-wrap pe-none">{{ $notification->data['message'] }}
                                    </h6>
                                    <span
                                        class="form-text pe-none">{{ $notification->created_at->diffForHumans() }}</span>
                                    <x-real.form action="{{ route('notifications.read', $notification) }}"
                                        :method="'PUT'">
                                    </x-real.form>
                                </li>

                                @if ($loop->iteration == 5)
                                    <li class="list-group-item">
                                        <a href="{{ route('activities.showUserActivities', auth()->user()) }}"
                                            class="w-100 overflow-hidden text-center">
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
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        <span class="material-icons md-24 align-middle">
                            account_circle
                        </span>
                        Account
                    </button>

                    <ul class="dropdown-menu mx-0 shadow" style="width: 240px">
                        <li class="bg-light">
                            <a class="dropdown-item vstack gap-2 align-items-center py-3"
                                href="{{ route('user.show', auth()->user()) }}">
                                <span class="d-block small">
                                    @if (auth()->user()->isAdmin() ||
                                        auth()->user()->isSecretary())
                                        {{ auth()->user()->nameTag }}
                                    @else
                                        <b>{{ auth()->user()->programs->first()->code }}</b> -
                                        {{ auth()->user()->nameTag }}
                                    @endif
                                </span>
                                <span class="form-text text-primary fw-bold">Click to view profile</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item d-flex gap-2 align-items-center" type="submit">
                                    <span class="material-icons md-18">
                                        logout
                                    </span>
                                    Sign out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
