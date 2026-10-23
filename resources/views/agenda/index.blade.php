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
            margin-bottom: 1rem;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--kemenag-secondary);
        }

        .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 600;
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
            .agenda-date {
                margin-bottom: 10px;
            }

            .agenda-date .day {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Agenda Kegiatan</li>
                </ol>
            </nav>

            <div class="row mb-3 align-items-center g-3">
                <div class="col-lg-5">
                    <h4 class="fw-bold text-success mb-1"><i class="bi bi-calendar-event me-2"></i>Agenda Kegiatan</h4>
                    <p class="text-muted mb-0 small">Informasi lengkap mengenai kegiatan dan acara Kementerian Agama</p>
                </div>
                <div class="col-lg-7">
                    <form method="GET" action="{{ route('agenda.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari agenda..." aria-label="Pencarian" value="{{ request('search') }}">
                            <select name="bulan" class="form-select" style="max-width: 140px;" aria-label="Filter bulan" onchange="this.form.submit()">
                                <option value="">Semua Bulan</option>
                                @foreach($bulanList as $key => $bulan)
                                    <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>{{ $bulan }}</option>
                                @endforeach
                            </select>
                            <select name="tahun" class="form-select" style="max-width: 120px;" aria-label="Filter tahun" onchange="this.form.submit()">
                                <option value="">Semua Tahun</option>
                                @foreach($tahunList as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="form-select" style="max-width: 140px;" aria-label="Filter status" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                                <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            <button class="btn btn-success" type="submit" title="Cari"><i class="bi bi-search"></i></button>
                            @if(request()->anyFilled(['search', 'bulan', 'tahun', 'status']))
                                <a href="{{ route('agenda.index') }}" class="btn btn-outline-secondary" title="Hapus filter"><i class="bi bi-x"></i></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            @if($agendas->count() > 0)
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
                    <div class="d-flex justify-content-center mt-4">
                        {{ $agendas->appends(request()->query())->links('custom-pagination') }}
                    </div>
                @endif
                <p class="text-muted small text-center mt-3 mb-0">
                    Menampilkan {{ $agendas->firstItem() ?? 0 }} - {{ $agendas->lastItem() ?? 0 }} dari {{ $agendas->total() }} agenda
                </p>
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
