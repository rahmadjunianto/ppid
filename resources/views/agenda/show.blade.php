<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $agenda->judul }} - PPID Kementerian Agama</title>
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

        .agenda-detail-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            margin-top: -50px;
            position: relative;
            z-index: 3;
        }

        .agenda-header {
            background: linear-gradient(135deg, var(--primary-color), #0a5a2f);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 40px;
        }

        .agenda-date-large {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .agenda-date-large .day {
            font-size: 3rem;
            font-weight: bold;
            display: block;
            line-height: 1;
        }

        .agenda-date-large .month-year {
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        .agenda-content {
            padding: 40px;
        }

        .info-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary-color);
        }

        .info-item h6 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item .value {
            color: #333;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .status-badge {
            font-size: 1rem;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 500;
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

        .description-section {
            background: white;
            border-radius: 15px;
            border: 1px solid #e9ecef;
            padding: 30px;
            margin-top: 30px;
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .section-title i {
            margin-right: 10px;
        }

        .description-content {
            line-height: 1.8;
            color: #333;
            font-size: 1.05rem;
        }

        .back-button {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 25px;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: rgba(255,255,255,0.3);
            color: white;
            transform: translateY(-2px);
        }

        .share-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
            text-align: center;
        }

        .share-btn {
            background: #3b5998;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            margin: 0 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .share-btn:hover {
            transform: translateY(-2px);
            color: white;
        }

        .share-btn.twitter { background: #1da1f2; }
        .share-btn.whatsapp { background: #25d366; }
        .share-btn.linkedin { background: #0077b5; }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 50px 0 30px;
            margin-top: 60px;
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

        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0 40px;
            }

            .agenda-header {
                padding: 30px 20px;
            }

            .agenda-content {
                padding: 30px 20px;
            }

            .agenda-date-large .day {
                font-size: 2.5rem;
            }

            .info-item {
                padding: 15px;
            }

            .description-section {
                padding: 20px;
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
                        <li class="breadcrumb-item"><a href="{{ route('agenda.index') }}">Agenda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($agenda->judul, 50) }}</li>
                    </ol>
                </nav>
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <h1 class="display-5 fw-bold mb-3">Detail Agenda</h1>
                        <p class="lead mb-0">Informasi lengkap mengenai kegiatan dan acara</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('agenda.index') }}" class="back-button">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="agenda-detail-card">
                <!-- Agenda Header -->
                <div class="agenda-header">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="agenda-date-large">
                                <span class="day">{{ $agenda->tanggal_mulai->format('d') }}</span>
                                <span class="month-year">
                                    {{ $agenda->tanggal_mulai->format('M Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h1 class="fw-bold mb-3">{{ $agenda->judul }}</h1>
                            <div class="d-flex align-items-center gap-3 mb-3">
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agenda Content -->
                <div class="agenda-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <h6><i class="bi bi-calendar-event me-2"></i>Tanggal Mulai</h6>
                                <div class="value">{{ $agenda->formatted_date }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <h6><i class="bi bi-calendar-check me-2"></i>Tanggal Selesai</h6>
                                <div class="value">{{ $agenda->tanggal_selesai->format('d F Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <h6><i class="bi bi-clock me-2"></i>Waktu</h6>
                                <div class="value">
                                    {{ $agenda->tanggal_mulai->format('H:i') }} WIB
                                    @if($agenda->tanggal_selesai->format('H:i') !== '00:00')
                                        - {{ $agenda->tanggal_selesai->format('H:i') }} WIB
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <h6><i class="bi bi-geo-alt me-2"></i>Tempat</h6>
                                <div class="value">{{ $agenda->tempat }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <h6><i class="bi bi-people me-2"></i>Penyelenggara</h6>
                        <div class="value">{{ $agenda->penyelenggara }}</div>
                    </div>

                    @if($agenda->deskripsi)
                        <div class="description-section">
                            <h3 class="section-title">
                                <i class="bi bi-file-text"></i>Deskripsi Kegiatan
                            </h3>
                            <div class="description-content">
                                {!! nl2br(e($agenda->deskripsi)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Share Section -->
                    <div class="share-section">
                        <h5 class="mb-3">
                            <i class="bi bi-share me-2"></i>Bagikan Agenda Ini
                        </h5>
                        <div class="d-flex justify-content-center flex-wrap gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                               target="_blank" class="share-btn">
                                <i class="bi bi-facebook"></i>
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($agenda->judul) }}&url={{ urlencode(request()->fullUrl()) }}"
                               target="_blank" class="share-btn twitter">
                                <i class="bi bi-twitter"></i>
                                Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($agenda->judul . ' - ' . request()->fullUrl()) }}"
                               target="_blank" class="share-btn whatsapp">
                                <i class="bi bi-whatsapp"></i>
                                WhatsApp
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}"
                               target="_blank" class="share-btn linkedin">
                                <i class="bi bi-linkedin"></i>
                                LinkedIn
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
