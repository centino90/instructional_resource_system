<header class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <x-application-logo width="36" />
            <small>ACD Instructional Resource System</small>
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="ms-auto navbar-nav">
                @auth
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn px-3" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 28 28" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-log-out">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Signout
                        </button>
                    </form>
                @endauth
            </ul>
        </div>
    </div>
</header>
