<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Kegiatan - PPID Kementerian Agama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --kemenag-primary: #1e5631;
            --kemenag-secondary: #2d8f47;
            --kemenag-accent: #ffd700;
            --kemenag-light: #f8f9fa;
            --kemenag-dark: #0d2818;
            --kemenag-green: #0d6e3a;
            --kemenag-gold: #ffd700;
            --primary-color: var(--kemenag-green);
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            padding-top: 80px;
        }

        .navbar-kemenag {
            background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
            box-shadow: 0 2px 20px rgba(30, 86, 49, 0.1);
        }

        .navbar-brand img {
            height: 40px;
        }

        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            padding: 10px 0;
            min-width: 280px;
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s ease;
            border-radius: 5px;
            margin: 2px 10px;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            color: white;
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 16px;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--kemenag-accent) !important;
        }

        .footer-kemenag {
            background: var(--kemenag-dark);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-logo {
            height: 60px;
            margin-bottom: 20px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: var(--kemenag-secondary);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: var(--kemenag-accent);
            color: var(--kemenag-dark);
            transform: translateY(-3px);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), #0a5a2f);
            color: white;
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="0.3" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="0.4" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: 100px 100px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .filter-section {
            background: #f8f9fa;
            padding: 30px 0;
            border-bottom: 3px solid var(--primary-color);
        }

        .filter-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }

        .agenda-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            height: 100%;
        }

        .agenda-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .agenda-date {
            background: var(--primary-color);
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .agenda-date .day {
            font-size: 2rem;
            font-weight: bold;
            display: block;
        }

        .agenda-date .month-year {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .agenda-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .agenda-meta {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .agenda-meta i {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .status-badge {
            font-size: 0.8rem;
            padding: 4px 8px;
            border-radius: 20px;
        }

        .status-upcoming {
            background: #e3f2fd;
            color: #1976d2;
        }

        .status-ongoing {
            background: #fff3e0;
            color: #f57c00;
        }

        .status-past {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .btn-filter {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: white;
            font-weight: 500;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .btn-filter:hover,
        .btn-filter.active {
            background: var(--primary-color);
            color: white;
        }

        .pagination-wrapper {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .page-link {
            border: none;
            color: var(--primary-color);
            font-weight: 500;
            border-radius: 8px !important;
            margin: 0 2px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 50px 0 30px;
        }

        .footer h5 {
            color: var(--kemenag-gold);
            margin-bottom: 20px;
        }

        .footer a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--kemenag-gold);
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
        }

        .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: white;
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .no-results i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0 40px;
            }

            .agenda-date {
                margin-bottom: 10px;
            }

            .agenda-date .day {
                font-size: 1.5rem;
            }

            .filter-section {
                padding: 20px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    @include('partials.navbar')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Agenda Kegiatan</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3">Agenda Kegiatan</h1>
                <p class="lead mb-0">Informasi lengkap mengenai kegiatan dan acara Kementerian Agama</p>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="container">
            <div class="filter-card p-4">
                <form method="GET" action="{{ route('agenda.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="search" class="form-label fw-semibold">
                            <i class="bi bi-search me-1"></i>Pencarian
                        </label>
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="Cari agenda...">
                    </div>

                    <div class="col-md-2">
                        <label for="bulan" class="form-label fw-semibold">
                            <i class="bi bi-calendar-month me-1"></i>Bulan
                        </label>
                        <select class="form-select" id="bulan" name="bulan">
                            <option value="">Semua Bulan</option>
                            @foreach($bulanList as $key => $bulan)
                                <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                                    {{ $bulan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="tahun" class="form-label fw-semibold">
                            <i class="bi bi-calendar-year me-1"></i>Tahun
                        </label>
                        <select class="form-select" id="tahun" name="tahun">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="status" class="form-label fw-semibold">
                            <i class="bi bi-clock me-1"></i>Status
                        </label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>
                                Akan Datang
                            </option>
                            <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-filter flex-fill">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                            <a href="{{ route('agenda.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            @if($agendas->count() > 0)
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fw-bold text-dark">
                                <i class="bi bi-calendar-event text-success me-2"></i>
                                Daftar Agenda
                            </h3>
                            <span class="badge bg-light text-dark fs-6">
                                {{ $agendas->total() }} agenda ditemukan
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($agendas as $agenda)
                        <div class="col-lg-4 col-md-6">
                            <div class="agenda-card p-4">
                                <div class="agenda-date">
                                    <span class="day">{{ $agenda->tanggal_mulai->format('d') }}</span>
                                    <span class="month-year">
                                        {{ $agenda->tanggal_mulai->format('M Y') }}
                                    </span>
                                </div>

                                <h5 class="agenda-title">{{ $agenda->judul }}</h5>

                                <div class="agenda-meta mb-3">
                                    <div class="mb-2">
                                        <i class="bi bi-clock"></i>
                                        {{ $agenda->formatted_date }}
                                        @if($agenda->tanggal_mulai->format('Y-m-d') !== $agenda->tanggal_selesai->format('Y-m-d'))
                                            - {{ $agenda->tanggal_selesai->format('d M Y') }}
                                        @endif
                                    </div>
                                    <div class="mb-2">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $agenda->tempat }}
                                    </div>
                                    <div class="mb-2">
                                        <i class="bi bi-people"></i>
                                        {{ $agenda->penyelenggara }}
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="status-badge
                                        @if($agenda->tanggal_mulai->isFuture()) status-upcoming
                                        @elseif($agenda->tanggal_selesai->isPast()) status-past
                                        @else status-ongoing
                                        @endif">
                                        @if($agenda->tanggal_mulai->isFuture())
                                            <i class="bi bi-clock me-1"></i>Akan Datang
                                        @elseif($agenda->tanggal_selesai->isPast())
                                            <i class="bi bi-check-circle me-1"></i>Selesai
                                        @else
                                            <i class="bi bi-play-circle me-1"></i>Berlangsung
                                        @endif
                                    </span>

                                    <a href="{{ route('agenda.show', $agenda) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                </div>

                                @if($agenda->deskripsi)
                                    <div class="mt-3 pt-3 border-top">
                                        <p class="text-muted mb-0 small">
                                            {{ Str::limit($agenda->deskripsi, 100) }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($agendas->hasPages())
                    <div class="pagination-wrapper">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-muted">
                                Menampilkan {{ $agendas->firstItem() }} - {{ $agendas->lastItem() }}
                                dari {{ $agendas->total() }} agenda
                            </div>
                        </div>
                        {{ $agendas->appends(request()->query())->links('custom-pagination') }}
                    </div>
                @endif
            @else
                <div class="no-results">
                    <i class="bi bi-calendar-x"></i>
                    <h4>Tidak ada agenda ditemukan</h4>
                    <p class="mb-3">
                        @if(request()->anyFilled(['search', 'bulan', 'tahun', 'status']))
                            Tidak ada agenda yang sesuai dengan filter yang Anda pilih.
                        @else
                            Belum ada agenda yang dipublikasikan.
                        @endif
                    </p>
                    @if(request()->anyFilled(['search', 'bulan', 'tahun', 'status']))
                        <a href="{{ route('agenda.index') }}" class="btn btn-outline-success">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
