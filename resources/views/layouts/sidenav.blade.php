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
               <a href="{{ route('admin.users.index') }}" class="nav-link py-2 " title="" data-bs-toggle="tooltip"
                  data-bs-placement="right" data-bs-original-title="Content Management">
                  <span class="material-icons md-18 align-middle">tune</span>
                  <span class="text align-middle">Content Management</span>
               </a>
            </li>
         @endif

         @if (auth()->user()->isProgramDean())
            <li class="nav-item px-2">
               <a href="{{ route('dean.reports.submissions') }}" class="nav-link py-2 " title=""
                  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Reports">
                  <span class="material-icons md-18 align-middle">bar_chart</span>
                  <span class="text align-middle">Reports</span>
               </a>
            </li>
            <li class="nav-item px-2">
               <a href="{{ route('dean.resource.index', ['accessType' => auth()->user()->role_id]) }}"
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
    auth()->user()->isSecretary())
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
                  class="nav-link py-2 position-relative" title="" data-bs-toggle="tooltip" data-bs-placement="right"
                  data-bs-original-title="My storage">

                  <span class="material-icons md-18 align-middle">storage</span>
                  <span class="text align-middle">My storage</span>

                  @if (auth()->user()->isStorageFull())
                     <span class="position-absolute top-0 end-0 badge rounded-pill ">
                        <span class="small material-icons text-danger">
                           report
                        </span>
                     </span>
                  @elseif(auth()->user()->isStorageReachingFull())
                     <span class="position-absolute top-0 end-0 badge rounded-pill ">
                        <span class="small material-icons text-secondary">
                           report
                        </span>
                     </span>
                  @endif
               </a>
            </li>
         @endif

         <li class="nav-item px-2">
            <a href="{{ route('user.notifications', auth()->id()) }}" class="nav-link py-2 position-relative" title=""
               data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="My notifications">
               <span>
                  @empty($notifications->count())
                     <span class="material-icons md-18 align-middle">
                        notifications_none
                     </span>
                  @else
                     <span class="material-icons md-18 align-middle">
                        notifications_active
                     </span>
                  @endempty
               </span>

               <span class="text align-middle">My notifications</span>
               @if ($notifications->count() > 0)
                  <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger">
                     {{ $notifications->count() }}
                  </span>
               @endif
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
            <a href="{{ route('user.show', auth()->id()) }}" class="nav-link py-2 " title="" data-bs-toggle="tooltip"
               data-bs-placement="right" data-bs-original-title="My profile">
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
