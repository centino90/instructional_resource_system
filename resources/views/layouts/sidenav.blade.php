<nav id="sidebar" class="active position-relative flex-column justify-content-start flex-shrink-0 bg-white">
    <div id="navbar__header" class="feature-icon bg-primary bg-gradient py-3 pb-4 text-center text-light position-relative">
        <span class="material-icons md-36 align-middle">pageview</span>
        <span class="title-wide d-none">INSTRUCTIONAL RESOURCE SYSTEM</span>
        <span class="title-narrow d-block fs-5">IRS</span>

        <button type="button" id="sidebarCollapse" class="position-absolute start-50 top-100 translate-middle btn btn-primary bg-gradient shadow ">
            <span class="material-icons md-24 align-middle">
                menu
            </span>
        </button>
    </div>

    <ul class="nav nav-pills nav-flush persist-default flex-column components my-5">
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="rounded-0 nav-link active py-2 border-bottom" title="" data-bs-toggle="tooltip"
                data-bs-placement="right" data-bs-original-title="Home">
                <span class="material-icons md-18 align-middle">home</span>
                <span class="text align-middle">Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="rounded-0 nav-link py-2 border-bottom" title="" data-bs-toggle="tooltip"
                data-bs-placement="right" data-bs-original-title="Lessons">
                <span class="material-icons md-18 align-middle">menu_book</span>
                <span class="text align-middle">My lessons</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('storage.show', [auth()->id(), 'leftPath' => 'users/' . auth()->id()])}}" class="rounded-0 nav-link py-2 border-bottom" title="" data-bs-toggle="tooltip"
                data-bs-placement="right" data-bs-original-title="My storage">
                <span class="material-icons md-18 align-middle">storage</span>
                <span class="text align-middle">My storage</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="rounded-0 nav-link py-2 border-bottom" title="" data-bs-toggle="tooltip"
                data-bs-placement="right" data-bs-original-title="My activities">
                <span class="material-icons md-18 align-middle">feedback</span>
                <span class="text align-middle">My activities</span>
            </a>
        </li>
    </ul>

    {{-- <div class="footer">
        <p>
         Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
        </p>
    </div> --}}
</nav>
