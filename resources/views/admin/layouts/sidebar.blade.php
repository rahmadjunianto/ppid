<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Emblem_of_Ministry_of_Religious_Affairs_of_Indonesia.svg/200px-Emblem_of_Ministry_of_Religious_Affairs_of_Indonesia.svg.png"
             alt="Logo Kemenag" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin PPID</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=1e5631&color=fff&size=40" 
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block text-white">{{ auth()->user()->name ?? 'Admin' }}</a>
                <small class="text-muted">{{ auth()->user()->email ?? 'Administrator' }}</small>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu..." aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <!-- Survey Management -->
                <li class="nav-item {{ request()->routeIs('admin.surveys.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.surveys.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-poll"></i>
                        <p>
                            Survey Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.surveys.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.surveys.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Survey</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.surveys.statistics') }}" 
                               class="nav-link {{ request()->routeIs('admin.surveys.statistics') ? 'active' : '' }}">
                                <i class="far fa-chart-bar nav-icon"></i>
                                <p>Statistik & Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.surveys.export') }}" 
                               class="nav-link">
                                <i class="far fa-file-excel nav-icon"></i>
                                <p>Export Data</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- User Management -->
                @if(auth()->user() && auth()->user()->role === 'admin')
                <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- Settings -->
                <li class="nav-header">PENGATURAN</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Pengaturan Umum</p>
                    </a>
                </li>

                <!-- Website Link -->
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link" target="_blank">
                        <i class="nav-icon fas fa-external-link-alt"></i>
                        <p>
                            Lihat Website
                            <span class="badge badge-info right">Live</span>
                        </p>
                    </a>
                </li>

                <!-- Survey Public Link -->
                <li class="nav-item">
                    <a href="{{ route('survey.index') }}" class="nav-link" target="_blank">
                        <i class="nav-icon fas fa-poll"></i>
                        <p>
                            Survey Publik
                            <span class="badge badge-success right">Public</span>
                        </p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="#" class="nav-link text-danger" 
                       onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
