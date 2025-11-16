<div class="sidebar" id="sidebar"> 

    <div class="sidebar-logo">
        <div>
            <a href="{{ url('/dashboard') }}" class="logo logo-normal">
                <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo">
            </a>
            <a href="{{ url('/dashboard') }}" class="logo-small">
                <img src="{{ asset('assets/img/logo-small.svg') }}" alt="Logo">
            </a>
            <a href="{{ url('/dashboard') }}" class="dark-logo">
                <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Logo">
            </a>
        </div>
        <button class="sidenav-toggle-btn btn border-0 p-0 active" id="toggle_btn"> 
            <i class="ti ti-arrow-bar-to-left"></i>
        </button>
        <button class="sidebar-close">
            <i class="ti ti-x align-middle"></i>
        </button>                
    </div>


    <div class="sidebar-inner" data-simplebar>                
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"><span>Main Menu</span></li>
                <li>
                    <ul>
                        <li>
                            <a href="{{ url('/dashboard') }}">
                                <i class="ti ti-dashboard"></i><span>Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-title"><span>CRM</span></li>
                <li>
                    <ul>
                        <li>
                            <a href="{{ url('/companies') }}"><i class="ti ti-building-community"></i><span>Companies</span></a>
                        </li>
                        <li>
                            <a href="{{ url('/companies') }}"><i class="ti ti-chart-arcs"></i><span>Leads</span></a>
                        </li>
                        <li>
                            <a href="{{ url('/companies') }}"><i class="ti ti-atom-2"></i><span>Projects</span></a>
                        </li>
                    </ul>
                </li>

                <li class="menu-title"><span>User Management</span></li>
                <li>							
                    <ul>
                        <li><a href="{{ url('/users') }}"><i class="ti ti-users"></i><span>Manage Users</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

</div>
