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
                        <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
                            <a href="{{ url('/dashboard') }}">
                                <i class="ti ti-dashboard"></i><span>Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-title"><span>CRM</span></li>
                <li>
                    <ul>
                        <li class="{{ Route::is('companies.*') ? 'active' : '' }}">
                            <a href="{{ url('/companies') }}"><i class="ti ti-building-community"></i><span>Companies</span></a>
                        </li>
                        <li class="{{ Route::is('leads.*') ? 'active' : '' }}">
                            <a href="{{ url('/leads') }}"><i class="ti ti-chart-arcs"></i><span>Leads</span></a>
                        </li>
                        @if(auth()->user()->admin)
                        <li class="{{ Route::is('product.*') ? 'active' : '' }}">
                            <a href="{{ url('/product') }}"><i class="ti ti-atom-2"></i><span>Product</span></a>
                        </li>
                        @endif
                        <li class="{{ Route::is('clients.*') ? 'active' : '' }}">
                            <a href="{{ url('/clients') }}"><i class="ti ti-chart-candle"></i><span>Clients</span></a>
                        </li>
                        <li class="{{ Route::is('calendar') ? 'active' : '' }}">
                            <a href="{{ url('/calendar') }}"><i class="ti ti-calendar"></i><span>Calendar</span></a>
                        </li>
                    </ul>
                </li>
                <li class="menu-title"><span>Lead source</span></li>
                <li>
                    <ul>
                        <li class="{{ Route::is('sms-leads.*') ? 'active' : '' }}">
                            <a href="{{ url('/sms-leads') }}"><i class="ti ti-message-circle"></i><span>Landing Pages Leads</span></a>
                        </li>
                    </ul>
                </li>
                @if(auth()->user()->admin)
                    <li class="menu-title"><span>User Management</span></li>
                    <li>							
                        <ul>
                            <li class="{{ Route::is('users.*') ? 'active' : '' }}">
                                <a href="{{ url('/users') }}"><i class="ti ti-users"></i><span>Manage Users</span></a>
                            </li>
                            <li class="{{ Route::is('attendances.*') ? 'active' : '' }}">
                                <a href="{{ url('/attendances') }}"><i class="ti ti-user-cog"></i><span>Attendances</span></a>
                            </li>
                        </ul>
                    </li>
                @endif
                <!-- <li class="menu-title"><span>Reports</span></li>
                <li>
                    <ul>
                        <li class="{{ Route::is('report.*') ? 'active' : '' }}">
                            <a href="{{ url('/report/leads') }}"><i class="ti ti-report-money"></i><span>Lead Reports</span></a>
                        </li>
                        @if(auth()->user()->admin)
                            <li class="#">
                                <a href="#"><i class="ti ti-report-search"></i><span>Attendance Reports</span></a>
                            </li>
                        @endif 
                    </ul>
                </li> -->
            </ul>
        </div>
    </div>

</div>
