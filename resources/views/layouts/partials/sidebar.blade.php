<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand"
                    href="../../../html/ltr/vertical-menu-template/index.html"><span class="brand-logo">
                        <h2 class="brand-text">IOT PH</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('dashboard.index') }}"><i
                        data-feather="home"></i><span class="menu-title text-truncate"
                        data-i18n="Dashboards">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('device*') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('devices.index') }}"><i
                        data-feather="airplay"></i><span class="menu-title text-truncate"
                        data-i18n="Dashboards">Device</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('monitoring*') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('monitoring.index') }}"><i
                        data-feather='activity'></i><span class="menu-title text-truncate"
                        data-i18n="Dashboards">Monitoring</span>
                </a>
            </li>
            @if (auth()->user()->hasRole('user_p'))
                <li class="nav-item {{ request()->is('control*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('control.index') }}"><i
                            data-feather="rss"></i><span class="menu-title text-truncate"
                            data-i18n="Dashboards">Control Notifikasi</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->hasRole('admin'))
                <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('user.index') }}"><i
                            data-feather="users"></i><span class="menu-title text-truncate"
                            data-i18n="Dashboards">Kelola User</span>
                    </a>
                </li>
            @endif
            <li class="nav-item {{ request()->is('cetak*') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('cetak.index') }}"><i
                        data-feather="printer"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Cetak
                        Data</span>
                </a>
            </li>
            @if (auth()->user()->hasRole('user_p'))
                <li class="nav-item {{ request()->is('mode*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('mode.index') }}"><i
                            data-feather='toggle-left'></i><span class="menu-title text-truncate"
                            data-i18n="Dashboards">Mode Device</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
