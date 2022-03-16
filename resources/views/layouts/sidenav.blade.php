<nav id="sidebar" class="active position-relative bg-light border-end">
    <div id="navbar__header" class="bg-white border-2 border-bottom feature-icon py-2 hstack justify-content-center"
        style="min-height: 60px; max-height: 60px">
        <span class="material-icons md-36 align-middle">pageview</span>
        <span>IRS</span>
    </div>

    <div class="mt-3">
        <div
            class="alert fw-bold text-center border-0 rounded-0
        @switch(auth()->user()->role_id)
        @case(App\Models\Role::INSTRUCTOR)
            alert-primary
            @break
        @case(App\Models\Role::PROGRAM_DEAN)
            alert-success
            @break
        @case(App\Models\Role::ADMIN)
            alert-warning
            @break
        @default
            alert-info
        @endswitch
        ">
            Welcome, {{ ucwords(strtolower(auth()->user()->role->name)) }}
        </div>

        <ul class="nav nav-pills nav-flush persist-default flex-column components mb-5">
            <li class="nav-item px-2">
                <a href="{{ route('dashboard') }}" class="nav-link py-2" title="" data-bs-toggle="tooltip"
                    data-bs-placement="right" data-bs-original-title="Home">
                    <span class="material-icons md-18 align-middle">home</span>
                    <span class="text align-middle">Home</span>
                </a>
            </li>
            <li class="nav-item px-2">
                <a href="#" class="nav-link py-2 " title="" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-original-title="Lessons">
                    <span class="material-icons md-18 align-middle">menu_book</span>
                    <span class="text align-middle">My lessons</span>
                </a>
            </li>
            <li class="nav-item px-2">
                <a href="{{ route('storage.show', [auth()->id(), 'leftPath' => 'users/' . auth()->id()]) }}"
                    class="nav-link py-2 " title="" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-original-title="My storage">
                    <span class="material-icons md-18 align-middle">storage</span>
                    <span class="text align-middle">My storage</span>
                </a>
            </li>
            <li class="nav-item px-2">
                <a href="#" class="nav-link py-2 " title="" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-original-title="My activities">
                    <span class="material-icons md-18 align-middle">feedback</span>
                    <span class="text align-middle">My activities</span>
                </a>
            </li>
        </ul>

        <div class="footer">
            <div class="hstack justify-content-center">
                <button type="button" id="sidebarCollapse" class="px-2 btn btn-primary rounded-circle bg-gradient">
                    <span class="material-icons md-24 align-middle">
                        chevron_right
                    </span>
                </button>
            </div>
        </div>
    </div>
</nav>
