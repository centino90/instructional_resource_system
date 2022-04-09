<nav id="sidebar" class="active position-relative bg-light border-end">
    <div id="navbar__header" class="bg-white border-2 border-bottom feature-icon p-2 hstack gap-1 justify-content-center"
        style="min-height: 60px; max-height: 60px">
        <span class="material-icons md-36 align-middle">pageview</span>
        <span class="m-0">IRS</span>
    </div>

    <div class="mt-3">
        <a href="javascript:void(0)" id="sidebarCollapse"
            class="btn btn-light rounded-0 alert alert-primary hstack gap-1 justify-content-center mb-3">
            <span class="material-icons md-18 align-middle">menu</span> <small>MENU</small>
        </a>
        {{-- <div
            class="alert fw-bold text-center border-0 rounded-0
        @switch(auth()->user()->role_id) @case(App\Models\Role::INSTRUCTOR)
            alert-primary
            @break
        @case(App\Models\Role::PROGRAM_DEAN)
            alert-success
            @break
        @case(App\Models\Role::ADMIN)
            alert-warning
            @break
        @default
            alert-info @endswitch
        ">
            Welcome, {{ ucwords(strtolower(auth()->user()->role->name)) }}
        </div> --}}

        <ul class="nav nav-pills nav-flush persist-default flex-column components mb-5">
            <li class="nav-item px-2">
                <a href="{{ route('dashboard') }}" class="nav-link py-2" title="" data-bs-toggle="tooltip"
                    data-bs-placement="right" data-bs-original-title="Home">
                    <span class="material-icons md-18 align-middle">home</span>
                    <span class="text align-middle">Home</span>
                </a>
            </li>

            @if (auth()->user()->isAdmin())
                <li class="nav-item px-2">
                    <a href="{{ route('storage.show', [auth()->id(), 'leftPath' => 'users/' . auth()->id()]) }}"
                        class="nav-link py-2 " title="" data-bs-toggle="tooltip" data-bs-placement="right"
                        data-bs-original-title="Admin Settings">
                        <span class="material-icons md-18 align-middle">manage_accounts</span>
                        <span class="text align-middle">Admin Settings</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->isProgramDean() ||
    auth()->user()->isAdmin())
                <li class="nav-item px-2">
                    <a href="{{ route('user.lessons', auth()->id()) }}" class="nav-link py-2 " title=""
                        data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Submission Report">
                        <span class="material-icons md-18 align-middle">signal_cellular_alt</span>
                        <span class="text align-middle">Submission Report</span>
                    </a>
                </li>
                <li class="nav-item px-2">
                    <a href="{{ route('user.submissions', auth()->id()) }}" class="nav-link py-2 " title=""
                        data-bs-toggle="tooltip" data-bs-placement="right"
                        data-bs-original-title="Instructor Activities">
                        <span class="material-icons md-18 align-middle">settings_accessibility</span>
                        <span class="text align-middle">Instructor Activities</span>
                    </a>
                </li>
                <li class="nav-item px-2">
                    <a href="{{ route('storage.show', [auth()->id(), 'leftPath' => 'users/' . auth()->id()]) }}"
                        class="nav-link py-2 " title="" data-bs-toggle="tooltip" data-bs-placement="right"
                        data-bs-original-title="Content Management">
                        <span class="material-icons md-18 align-middle">tune</span>
                        <span class="text align-middle">Content Management</span>
                    </a>
                </li>
            @endif

            <li class="nav-item px-2">
                <a href="{{ route('resource.index') }}" class="nav-link py-2 " title="" data-bs-toggle="tooltip"
                    data-bs-placement="right" data-bs-original-title="Find resources">
                    <span class="material-icons md-18 align-middle">find_in_page</span>
                    <span class="text align-middle">Find resources</span>
                </a>
            </li>

            <hr class="w-100 ">

            @if (auth()->user()->isInstructor() ||
    auth()->user()->isSecretary() ||
    auth()->user()->isAdmin())
                <li class="nav-item px-2">
                    <a href="{{ route('user.lessons', auth()->id()) }}" class="nav-link py-2 " title=""
                        data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="My lessons">
                        <span class="material-icons md-18 align-middle">menu_book</span>
                        <span class="text align-middle">My lessons</span>
                    </a>
                </li>
                <li class="nav-item px-2">
                    <a href="{{ route('user.submissions', auth()->id()) }}" class="nav-link py-2 " title=""
                        data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="My submissions">
                        <span class="material-icons md-18 align-middle">upload_file</span>
                        <span class="text align-middle">My submissions</span>
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
            @endif

            <li class="nav-item px-2">
                <a href="{{ route('user.notifications', auth()->id()) }}" class="nav-link py-2" title=""
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="My notifications">
                    <span class="position-relative">
                        @empty($notifications->count())
                            <span class="material-icons md-18 align-middle">
                                notifications_none
                            </span>
                        @else
                            <span class="material-icons md-18 align-middle">
                                notifications_active
                            </span>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $notifications->count() }}
                            </span>
                        @endempty
                    </span>

                    <span class="text align-middle">My notifications</span>
                </a>
            </li>

            <li class="nav-item px-2">
                <a href="{{ route('user.activities', auth()->id()) }}" class="nav-link py-2 " title=""
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="My activities">
                    <span class="material-icons md-18 align-middle">feedback</span>
                    <span class="text align-middle">My activities</span>
                </a>
            </li>

            <li class="nav-item px-2">
                <a href="{{ route('user.show', auth()->id()) }}" class="nav-link py-2 " title=""
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="My profile">
                    <span class="material-icons md-18 align-middle">account_circle</span>
                    <span class="text align-middle">My profile</span>
                </a>
            </li>
        </ul>

        {{-- <div class="footer">
            <div class="hstack justify-content-center">
                <button type="button" id="sidebarCollapse" class="px-2 btn btn-primary rounded-circle bg-gradient">
                    <span class="material-icons md-24 align-middle">
                        chevron_right
                    </span>
                </button>
            </div>
        </div> --}}
    </div>
</nav>
