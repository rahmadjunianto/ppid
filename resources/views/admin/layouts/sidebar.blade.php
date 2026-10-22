<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('logo-kemenag.png') }}" alt="Logo Kemenag" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin PPID</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- <!-- Survey Management -->
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
                    </ul>
                </li>

                <!-- Survey SKM & SPAK -->
                <li class="nav-item {{ request()->routeIs('admin.surveys-skm-spak.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.surveys-skm-spak.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Survey SKM & SPAK
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.surveys-skm-spak.index') }}"
                               class="nav-link {{ request()->routeIs('admin.surveys-skm-spak.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Responden</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- IKM & SPAK Management -->
                <li class="nav-item {{ request()->routeIs('admin.survey-periods.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.survey-periods.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-poll-h"></i>
                        <p>
                            IKM & SPAK
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.survey-periods.index') }}"
                               class="nav-link {{ request()->routeIs('admin.survey-periods.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kelola Periode Survei</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.survey-export.index') }}"
                               class="nav-link {{ request()->routeIs('admin.survey-export.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Export Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/ikm-spak') }}" target="_blank"
                               class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lihat Publik</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class="nav-item {{ request()->routeIs(['admin.pegawai.*', 'admin.agenda.*', 'admin.pages.*', 'admin.sops.*', 'admin.informasi-berkala.*', 'admin.grup-dokumens.*', 'admin.pustaka-dokumens.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs(['admin.pegawai.*', 'admin.agenda.*', 'admin.pages.*', 'admin.sops.*', 'admin.informasi-berkala.*', 'admin.grup-dokumens.*', 'admin.pustaka-dokumens.*']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Kelola <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.pegawai.index') }}" class="nav-link {{ request()->routeIs('admin.pegawai.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pegawai</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.agenda.index') }}" class="nav-link {{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Agenda</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Halaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sops.index') }}" class="nav-link {{ request()->routeIs('admin.sops.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> SOP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.informasi-berkala.index') }}" class="nav-link {{ request()->routeIs('admin.informasi-berkala.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Informasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.grup-dokumens.index') }}" class="nav-link {{ request()->routeIs('admin.grup-dokumens.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Grup Dokumen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pustaka-dokumens.index') }}" class="nav-link {{ request()->routeIs('admin.pustaka-dokumens.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Daftar Informasi Publik</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @if(auth()->user() && auth()->user()->role === 'admin')
                <li class="nav-header">PENGATURAN</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Manajemen User</p>
                    </a>
                </li>
                @endif

                <li class="nav-header">LAINNYA</li>
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link" target="_blank">
                        <i class="nav-icon fas fa-external-link-alt"></i>
                        <p>Lihat Website <span class="badge badge-info right">Live</span></p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>