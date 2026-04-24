<!-- Navigation -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('logo-kemenag.png') }}" alt="Logo Kemenag" class="navbar-logo me-2" style="height: 40px;"> PPID Kemenag Nganjuk
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') || request()->is('beranda') ? 'active' : '' }}" href="{{ url('/') }}">
                        <i class="bi bi-house"></i> Beranda
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('profil*') || request()->is('pejabat*') || request()->is('visi-misi*') || request()->is('struktur*') || request()->is('tugas-fungsi*') ? 'active' : '' }}" href="#" id="profilDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-lines-fill"></i> Profil PPID
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->is('profil') ? 'active' : '' }}" href="{{ url('/profil') }}">
                            <i class="bi bi-info-circle me-2"></i>Profil PPID
                        </a></li>
                        <li><a class="dropdown-item {{ request()->is('profil-pejabat') ? 'active' : '' }}" href="{{ url('/profil-pejabat') }}">
                            <i class="bi bi-person-badge me-2"></i>Profil Pejabat
                        </a></li>
                        <li><a class="dropdown-item {{ request()->is('visi-misi') ? 'active' : '' }}" href="{{ url('/visi-misi') }}">
                            <i class="bi bi-eye me-2"></i>Visi dan Misi
                        </a></li>
                        <li><a class="dropdown-item {{ request()->is('struktur-organisasi') ? 'active' : '' }}" href="{{ url('/struktur-organisasi') }}">
                            <i class="bi bi-diagram-3 me-2"></i>Struktur Organisasi
                        </a></li>
                        <li><a class="dropdown-item {{ request()->is('tugas-fungsi') ? 'active' : '' }}" href="{{ url('/tugas-fungsi') }}">
                            <i class="bi bi-list-task me-2"></i>Tugas dan Fungsi
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('informasi-berkala*') || request()->is('informasi-setiap-saat*') ? 'active' : '' }}" href="#" id="informasiDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-info-circle"></i> Informasi Publik
                    </a>
                    <ul class="dropdown-menu">
                        {{-- <li><a class="dropdown-item" href="#">
                            <i class="bi bi-list-ul me-2"></i>Daftar Informasi Publik
                        </a></li> --}}
                        <li><a class="dropdown-item {{ request()->is('informasi-berkala*') ? 'active' : '' }}" href="{{ url('informasi-berkala') }}">
                            <i class="bi bi-calendar-week me-2"></i>Informasi Berkala
                        </a></li>
                        <li><a class="dropdown-item" href="https://kemenagnganjuk.id/berita" target="_blank">
                            <i class="bi bi-clock-history me-2"></i>Informasi Serta Merta
                        </a></li>
                        <li><a class="dropdown-item {{ request()->is('informasi-setiap-saat*') ? 'active' : '' }}" href="{{ url('informasi-setiap-saat') }}">
                            <i class="bi bi-hourglass-split me-2"></i>Informasi Setiap Saat
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('permohonan-informasi*') || request()->is('pengajuan-keberatan*') || request()->is('status-permohonan*') ? 'active' : '' }}" href="#" id="layananDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-gear"></i> Layanan Informasi
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->is('permohonan-informasi*') ? 'active' : '' }}" href="#">
                            <i class="bi bi-file-earmark-text me-2"></i>Permohonan Informasi
                        </a></li>
                        <li><a class="dropdown-item {{ request()->is('pengajuan-keberatan*') ? 'active' : '' }}" href="#">
                            <i class="bi bi-exclamation-triangle me-2"></i>Pengajuan Keberatan
                        </a></li>
                        <li><a class="dropdown-item {{ request()->is('status-permohonan*') ? 'active' : '' }}" href="#">
                            <i class="bi bi-search me-2"></i>Status Permohonan
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('maklumat-pelayanan*') || request()->is('sop-layanan*') || request()->is('biaya-layanan*') || request()->is('waktu-layanan*') ? 'active' : '' }}" href="#" id="standarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-award"></i> Standar Layanan
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->is('maklumat-pelayanan*') ? 'active' : '' }}" href="#">
                            <i class="bi bi-megaphone me-2"></i>Maklumat Pelayanan
                        </a></li>
                        <li><a class="dropdown-item {{ request()->is('sop-layanan*') ? 'active' : '' }}" href="#">
                            <i class="bi bi-clipboard-check me-2"></i>SOP Layanan
                        </a></li>
                        <li><a class="dropdown-item {{ request()->is('biaya-layanan*') ? 'active' : '' }}" href="#">
                            <i class="bi bi-currency-dollar me-2"></i>Biaya Layanan
                        </a></li>
                        <li><a class="dropdown-item {{ request()->is('waktu-layanan*') ? 'active' : '' }}" href="#">
                            <i class="bi bi-clock me-2"></i>Waktu Layanan
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('survey*') ? 'active' : '' }}" href="#" id="surveyDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-graph-up me-1"></i>Survey
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->is('survey') && !request()->is('survey/skm-spak') ? 'active' : '' }}" href="{{ url('/survey') }}">
                            <i class="bi bi-clipboard-check me-2"></i>Survey PPID
                        </a></li>
                        <li><a class="dropdown-item {{ request()->is('survey/skm-spak') ? 'active' : '' }}" href="{{ url('/survey/skm-spak') }}">
                            <i class="bi bi-bar-chart me-2"></i>Survey SKM & SPAK
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Navbar Styles */
    .navbar {
        background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 0.75rem 0;
        transition: all 0.3s ease;
        flex-wrap: wrap;
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.1rem;
        color: white !important;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .navbar-brand img {
        height: 35px !important;
    }

    .navbar-brand:hover {
        color: var(--kemenag-accent) !important;
        transform: scale(1.05);
    }

    .navbar-nav {
        flex-wrap: wrap;
        gap: 0;
    }

    .navbar-nav .nav-link {
        color: white !important;
        font-weight: 500;
        padding: 0.4rem 0.75rem !important;
        transition: all 0.3s ease;
        border-radius: 5px;
        margin: 0 1px;
        font-size: 0.95rem;
        white-space: nowrap;
    }

    .navbar-nav .nav-link:hover {
        color: var(--kemenag-accent) !important;
        transform: translateY(-2px);
        background: rgba(255,255,255,0.1);
    }

    .navbar-nav .nav-link.active {
        color: var(--kemenag-accent) !important;
        background: rgba(255,255,255,0.15);
        font-weight: 600;
    }

    .dropdown-menu {
        border: none;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        padding: 10px 0;
        min-width: 260px;
        background: white;
        margin-top: 5px;
    }

    .dropdown-item {
        padding: 10px 18px;
        transition: all 0.3s ease;
        border-radius: 5px;
        margin: 2px 10px;
        color: #333;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
        color: white !important;
        transform: translateX(5px);
    }

    .dropdown-item.active {
        background: var(--kemenag-accent);
        color: var(--kemenag-primary) !important;
        font-weight: 600;
    }

    .dropdown-item i {
        width: 16px;
        text-align: center;
    }

    /* Mobile Menu */
    .navbar-toggler {
        border: none;
        color: white;
        font-size: 1.25rem;
        padding: 0.25rem 0.5rem;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    /* Tablet and Medium Devices */
    @media (max-width: 1199px) {
        .navbar-brand {
            font-size: 1rem;
        }

        .navbar-nav .nav-link {
            padding: 0.35rem 0.6rem !important;
            font-size: 0.9rem;
            margin: 0;
        }

        .dropdown-menu {
            min-width: 240px;
        }

        .dropdown-item {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .navbar {
            padding: 0.5rem 0;
        }

        .navbar-brand {
            font-size: 0.95rem;
        }

        .navbar-brand img {
            height: 30px !important;
        }

        .navbar-nav {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 8px;
            margin-top: 8px;
            width: 100%;
        }

        .navbar-nav .nav-link {
            padding: 0.4rem 0.8rem !important;
            font-size: 0.9rem;
            margin: 2px 1px;
            border-radius: 5px;
        }

        .dropdown-menu {
            position: static !important;
            transform: none !important;
            box-shadow: none;
            border: none;
            background: rgba(255,255,255,0.1);
            margin-top: 5px;
            margin-left: 15px;
            min-width: auto;
            width: calc(100% - 30px);
        }

        .dropdown-item {
            color: white !important;
            margin: 2px 8px;
            padding: 8px 15px;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background: rgba(255,255,255,0.2);
            transform: none;
        }

        .dropdown-item.active {
            background: var(--kemenag-accent);
            color: var(--kemenag-primary) !important;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .navbar-brand {
            font-size: 0.85rem;
        }

        .navbar-brand img {
            height: 28px !important;
        }

        .navbar-nav .nav-link {
            padding: 0.35rem 0.5rem !important;
            font-size: 0.85rem;
        }

        .dropdown-menu {
            min-width: auto;
        }

        .dropdown-item {
            padding: 8px 12px;
            font-size: 0.85rem;
            margin: 2px 5px;
        }
    }
</style>
