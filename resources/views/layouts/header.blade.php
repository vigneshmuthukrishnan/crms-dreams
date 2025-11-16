<header class="navbar-header">
    <div class="page-container topbar-menu">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ url('/dashboard') }}" class="logo">
                <span class="logo-light">
                    <span class="logo-lg"><img src="{{ asset('assets/img/logo.svg') }}" alt="logo"></span>
                    <span class="logo-sm"><img src="{{ asset('assets/img/logo-small.svg') }}" alt="small logo"></span>
                </span>
                <span class="logo-dark">
                    <span class="logo-lg"><img src="{{ asset('assets/img/logo-white.svg') }}" alt="dark logo"></span>
                </span>
            </a>
            <a id="mobile_btn" class="mobile-btn" href="#sidebar">
                <i class="ti ti-menu-deep fs-24"></i>
            </a>
            <button class="sidenav-toggle-btn btn border-0 p-0" id="toggle_btn2"> 
                <i class="ti ti-arrow-bar-to-right"></i>
            </button> 
        </div>

        <div class="d-flex align-items-center">
            <div class="header-item">
                <div class="dropdown me-2">
                    <a href="javascript:void(0);" class="btn topbar-link btnFullscreen"><i class="ti ti-maximize"></i></a>
                </div> 
            </div> 

            <div class="header-item d-none d-sm-flex me-2">
                <button class="topbar-link btn topbar-link" id="light-dark-mode" type="button">
                    <i class="ti ti-moon fs-16"></i>
                </button>
            </div>

            <div class="header-line"></div>
            <div class="dropdown profile-dropdown d-flex align-items-center justify-content-center">
                <a href="javascript:void(0);" class="topbar-link dropdown-toggle drop-arrow-none position-relative" data-bs-toggle="dropdown" data-bs-offset="0,22" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('assets/img/users/avatar.jpg') }}" width="38" class="rounded-1 d-flex" alt="user-image">
                    <span class="online text-success"><i class="ti ti-circle-filled d-flex bg-white rounded-circle border border-1 border-white"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">
                
                    <div class="d-flex align-items-center bg-light rounded-3 p-2 mb-2">
                        <img src="{{ asset('assets/img/users/avatar.jpg') }}" class="rounded-circle" width="42" height="42" alt="Img">
                        <div class="ms-2">
                            <p class="fw-medium text-dark mb-0">{{ Auth::user()->email }}</p>
                            <span class="d-block fs-13">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                    <a href="profile-settings.html" class="dropdown-item">
                        <i class="ti ti-user-circle me-1 align-middle"></i>
                        <span class="align-middle">Profile Settings</span>
                    </a>
                    <a href="profile-settings.html" class="dropdown-item">
                        <i class="ti ti-settings me-1 align-middle"></i>
                        <span class="align-middle">Settings</span>
                    </a>            
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <div class="pt-2 mt-2 border-top"> 
                            <a href="{{ route('logout') }}" 
                            class="dropdown-item text-danger"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                                <span class="align-middle">Sign Out</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
                
        </div>
    </div>
</header>