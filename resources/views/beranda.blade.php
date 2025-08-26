<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PPID Kementerian Agama Kabupaten Nganjuk - Portal Informasi Publik">
    <meta name="keywords" content="PPID, Kemenag, Nganjuk, Informasi Publik, Kementerian Agama">

    <title>PPID Kemenag Kabupaten Nganjuk</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --kemenag-primary: #1e5631;
            --kemenag-secondary: #2d8f47;
            --kemenag-accent: #ffd700;
            --kemenag-light: #f8f9fa;
            --kemenag-dark: #0d2818;
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

        /* Hero Section */
        .hero-section {
            position: relative;
            height: 60vh;
            overflow: hidden;
        }

        .hero-image {
            height: 60vh;
            object-fit: cover;
            object-position: center;
        }        .hero-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.1);
            z-index: 1;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .carousel-indicators {
            bottom: 30px;
            z-index: 15;
        }

        .carousel-indicators button {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid white;
            margin: 0 5px;
            opacity: 0.7;
        }

        .carousel-indicators button.active {
            background-color: var(--kemenag-accent);
            border-color: var(--kemenag-accent);
            opacity: 1;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 60px;
            height: 60px;
            background: rgba(30, 86, 49, 0.8);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            margin: 0 20px;
            opacity: 0.9;
            transition: all 0.3s ease;
            z-index: 15;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: var(--kemenag-primary);
            opacity: 1;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 24px;
            height: 24px;
            background-size: 100%, 100%;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .hero-image {
                height: 40vh;
            }

            .hero-section {
                height: 40vh;
            }

            .carousel-control-prev,
            .carousel-control-next {
                width: 45px;
                height: 45px;
                margin: 0 10px;
            }

            .carousel-indicators {
                bottom: 20px;
            }

            .carousel-indicators button {
                width: 12px;
                height: 12px;
                margin: 0 3px;
            }
        }

        @media (max-width: 576px) {
            .hero-image {
                height: 35vh;
            }

            .hero-section {
                height: 35vh;
            }

            .carousel-control-prev,
            .carousel-control-next {
                display: none;
            }
        }

        /* Carousel transition */
        .carousel-item {
            transition-duration: .6s;
        }

        .carousel-item.active,
        .carousel-item-next,
        .carousel-item-prev {
            display: block;
        }

        .service-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .service-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .stats-section {
            background: var(--kemenag-light);
            padding: 80px 0;
        }

        .stat-item {
            text-align: center;
            padding: 30px 20px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--kemenag-primary);
            margin-bottom: 10px;
            display: block;
        }

        .news-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .news-image {
            height: 200px;
            object-fit: cover;
        }

        .btn-kemenag {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-kemenag:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 86, 49, 0.3);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--kemenag-primary);
            margin-bottom: 20px;
        }

        .section-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 50px;
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

        .quick-access {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-top: -100px;
            position: relative;
            z-index: 10;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .quick-access {
                margin-top: -80px;
                padding: 20px;
                border-radius: 10px;
            }
        }

        @media (max-width: 576px) {
            .quick-access {
                margin-top: -60px;
                padding: 15px;
            }
        }

        .quick-access-item {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .quick-access-item:hover {
            background: var(--kemenag-light);
            color: var(--kemenag-primary);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    @include('partials.navbar')

    <!-- Hero Slideshow Section -->
    <section class="hero-section" id="beranda">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <img src="https://ppid.kemenagnganjuk.id/wp-content/uploads/2025/08/1753840064_2a3d67b4c23ec708ddf0.jpg"
                         class="d-block w-100 hero-image"
                         alt="PPID Kemenag Nganjuk"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1800 600\'%3E%3Cdefs%3E%3ClinearGradient id=\'grad1\' x1=\'0%25\' y1=\'0%25\' x2=\'100%25\' y2=\'100%25\'%3E%3Cstop offset=\'0%25\' style=\'stop-color:%231e5631;stop-opacity:1\' /%3E%3Cstop offset=\'100%25\' style=\'stop-color:%232d8f47;stop-opacity:1\' /%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width=\'1800\' height=\'600\' fill=\'url(%23grad1)\'/%3E%3Ctext x=\'900\' y=\'250\' text-anchor=\'middle\' fill=\'white\' font-family=\'Arial\' font-size=\'48\' font-weight=\'bold\'%3EPPID KEMENAG NGANJUK%3C/text%3E%3Ctext x=\'900\' y=\'320\' text-anchor=\'middle\' fill=\'%23ffd700\' font-family=\'Arial\' font-size=\'24\'%3EKabupaten Nganjuk%3C/text%3E%3C/svg%3E';">
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <img src="https://ppid.kemenagnganjuk.id/wp-content/uploads/2025/08/1753760691_14395792b5a7ede2dd62.png"
                         class="d-block w-100 hero-image"
                         alt="PPID Kemenag Nganjuk"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1800 600\'%3E%3Cdefs%3E%3ClinearGradient id=\'grad2\' x1=\'0%25\' y1=\'0%25\' x2=\'100%25\' y2=\'100%25\'%3E%3Cstop offset=\'0%25\' style=\'stop-color:%232d8f47;stop-opacity:1\' /%3E%3Cstop offset=\'100%25\' style=\'stop-color:%231e5631;stop-opacity:1\' /%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width=\'1800\' height=\'600\' fill=\'url(%23grad2)\'/%3E%3Ctext x=\'900\' y=\'250\' text-anchor=\'middle\' fill=\'white\' font-family=\'Arial\' font-size=\'48\' font-weight=\'bold\'%3ELayanan Informasi%3C/text%3E%3Ctext x=\'900\' y=\'320\' text-anchor=\'middle\' fill=\'%23ffd700\' font-family=\'Arial\' font-size=\'24\'%3ETransparan & Akuntabel%3C/text%3E%3C/svg%3E';">
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <img src="https://ppid.kemenagnganjuk.id/wp-content/uploads/2025/08/1753840064_2a3d67b4c23ec708ddf0.jpg"
                         class="d-block w-100 hero-image"
                         alt="PPID Kemenag Nganjuk"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1800 600\'%3E%3Cdefs%3E%3ClinearGradient id=\'grad3\' x1=\'0%25\' y1=\'0%25\' x2=\'100%25\' y2=\'100%25\'%3E%3Cstop offset=\'0%25\' style=\'stop-color:%23ffd700;stop-opacity:0.9\' /%3E%3Cstop offset=\'50%25\' style=\'stop-color:%232d8f47;stop-opacity:1\' /%3E%3Cstop offset=\'100%25\' style=\'stop-color:%231e5631;stop-opacity:1\' /%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width=\'1800\' height=\'600\' fill=\'url(%23grad3)\'/%3E%3Ctext x=\'900\' y=\'250\' text-anchor=\'middle\' fill=\'white\' font-family=\'Arial\' font-size=\'48\' font-weight=\'bold\'%3EVisi & Misi%3C/text%3E%3Ctext x=\'900\' y=\'320\' text-anchor=\'middle\' fill=\'white\' font-family=\'Arial\' font-size=\'24\'%3EKemenag Nganjuk%3C/text%3E%3C/svg%3E';">
                </div>

            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- Quick Access Section -->
    <section class="py-5">
        <div class="container">
            <div class="quick-access">
                <div class="row">
                    <div class="col-md-3 col-6 mb-3">
                        <a href="https://ptspjatim.kemenag.go.id/index.php/layananv2/sekjen/layanan-permohonan-informasi" target="_blank" class="quick-access-item">
                            <div class="service-icon mx-auto">
                                <i class="bi bi-file-earmark-text text-white fs-4"></i>
                            </div>
                            <h6 class="fw-semibold">Permohonan Informasi</h6>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ url('/survey') }}" class="quick-access-item">
                            <div class="service-icon mx-auto">
                                <i class="bi bi-clipboard-check text-white fs-4"></i>
                            </div>
                            <h6 class="fw-semibold">Isi Survey</h6>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="#" class="quick-access-item">
                            <div class="service-icon mx-auto">
                                <i class="bi bi-calendar-event text-white fs-4"></i>
                            </div>
                            <h6 class="fw-semibold">Daftar Agenda</h6>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="#" class="quick-access-item">
                            <div class="service-icon mx-auto">
                                <i class="bi bi-list-ul text-white fs-4"></i>
                            </div>
                            <h6 class="fw-semibold">Daftar Informasi Publik</h6>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="#" class="quick-access-item">
                            <div class="service-icon mx-auto">
                                <i class="bi bi-people text-white fs-4"></i>
                            </div>
                            <h6 class="fw-semibold">Data Pegawai</h6>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="#" class="quick-access-item">
                            <div class="service-icon mx-auto">
                                <i class="bi bi-buildings text-white fs-4"></i>
                            </div>
                            <h6 class="fw-semibold">Satuan Kerja</h6>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="#" class="quick-access-item">
                            <div class="service-icon mx-auto">
                                <i class="bi bi-book text-white fs-4"></i>
                            </div>
                            <h6 class="fw-semibold">Daftar Regulasi</h6>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="#" class="quick-access-item">
                            <div class="service-icon mx-auto">
                                <i class="bi bi-chat-square-dots text-white fs-4"></i>
                            </div>
                            <h6 class="fw-semibold">Saran dan Kritik</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number" data-count="1250">0</span>
                        <h5>Permohonan Informasi</h5>
                        <p class="text-muted">Total permohonan yang telah diterima</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number" data-count="1198">0</span>
                        <h5>Dikabulkan</h5>
                        <p class="text-muted">Permohonan yang telah dikabulkan</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number" data-count="38">0</span>
                        <h5>Proses</h5>
                        <p class="text-muted">Sedang dalam proses</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number" data-count="14">0</span>
                        <h5>Ditolak</h5>
                        <p class="text-muted">Permohonan yang ditolak</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Layanan Kami</h2>
                <p class="section-subtitle">Berbagai layanan informasi publik yang dapat Anda akses</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body p-4">
                            <div class="service-icon">
                                <i class="bi bi-file-earmark-check text-white fs-4"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Daftar Informasi Publik</h5>
                            <p class="card-text">Akses lengkap daftar informasi publik yang tersedia di Kanwil Kemenag Jawa Timur.</p>
                            <a href="#" class="btn btn-kemenag text-white">Lihat Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body p-4">
                            <div class="service-icon">
                                <i class="bi bi-clipboard-data text-white fs-4"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Standar Layanan</h5>
                            <p class="card-text">Informasi standar pelayanan dan prosedur permohonan informasi publik.</p>
                            <a href="#" class="btn btn-kemenag text-white">Lihat Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body p-4">
                            <div class="service-icon">
                                <i class="bi bi-book text-white fs-4"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Regulasi</h5>
                            <p class="card-text">Kumpulan peraturan dan regulasi terkait keterbukaan informasi publik.</p>
                            <a href="#" class="btn btn-kemenag text-white">Lihat Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body p-4">
                            <div class="service-icon">
                                <i class="bi bi-journal-check text-white fs-4"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Laporan Keuangan</h5>
                            <p class="card-text">Laporan keuangan dan pertanggungjawaban anggaran secara berkala.</p>
                            <a href="#" class="btn btn-kemenag text-white">Lihat Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body p-4">
                            <div class="service-icon">
                                <i class="bi bi-chat-square-dots text-white fs-4"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Pengaduan</h5>
                            <p class="card-text">Layanan pengaduan dan saran untuk perbaikan kualitas layanan.</p>
                            <a href="#" class="btn btn-kemenag text-white">Lihat Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body p-4">
                            <div class="service-icon">
                                <i class="bi bi-phone text-white fs-4"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Kontak & Lokasi</h5>
                            <p class="card-text">Informasi kontak dan lokasi kantor untuk kemudahan komunikasi.</p>
                            <a href="#" class="btn btn-kemenag text-white">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Berita Terbaru</h2>
                <p class="section-subtitle">Informasi dan berita terkini dari Kanwil Kemenag Jawa Timur</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card news-card">
                        <img src="https://jatim.kemenag.go.id/file/fotoberita/544359-17558331162119-berita.jpg" class="card-img-top news-image" alt="Kanwil Kemenag Jatim Terima Penghargaan">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">22 Agustus 2025</small>
                                <span class="badge bg-primary">Prestasi</span>
                            </div>
                            <h6 class="card-title">Kanwil Kemenag Jatim Terima Penghargaan dari Kemenkum</h6>
                            <p class="card-text">Kanwil Kemenag Jatim meraih penghargaan pada peringatan Hari Pengayoman ke-80 sebagai bentuk apresiasi atas kontribusi dalam bidang pengayoman...</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card news-card">
                        <img src="https://jatim.kemenag.go.id/file/fotoberita/544350-17558421815314-berita.jpg" class="card-img-top news-image" alt="Sinergi Pelayanan Umat Katolik">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">21 Agustus 2025</small>
                                <span class="badge bg-success">Kegiatan</span>
                            </div>
                            <h6 class="card-title">Sinergi Tingkatkan Pelayanan Umat Katolik</h6>
                            <p class="card-text">Bimas Katolik, Keuskupan Surabaya dan Keuskupan Malang sepakati sinergi untuk meningkatkan kualitas pelayanan kepada umat Katolik...</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card news-card">
                        <img src="https://jatim.kemenag.go.id/file/fotoberita/544273-1755398225778-berita.jpg" class="card-img-top news-image" alt="Upacara HUT ke-80 RI">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">17 Agustus 2025</small>
                                <span class="badge bg-warning">Kemerdekaan</span>
                            </div>
                            <h6 class="card-title">Kakanwil Membacakan Doa pada Upacara HUT ke-80 RI</h6>
                            <p class="card-text">Kakanwil Kemenag Jatim membacakan doa pada upacara peringatan HUT ke-80 RI di Grahadi Surabaya dengan khidmat dan penuh rasa syukur...</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn btn-kemenag text-white btn-lg">Lihat Semua Artikel</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Initialize carousel
        document.addEventListener('DOMContentLoaded', function() {
            const heroCarousel = document.querySelector('#heroCarousel');
            if (heroCarousel) {
                const carousel = new bootstrap.Carousel(heroCarousel, {
                    interval: 5000,
                    ride: 'carousel',
                    pause: 'hover',
                    wrap: true
                });
            }
        });

        // Animated Counter
        function animateCounter() {
            const counters = document.querySelectorAll('.stat-number');

            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counter.textContent = Math.floor(current);
                }, 16);
            });
        }

        // Intersection Observer for counter animation
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            const statsSection = document.querySelector('.stats-section');
            if (statsSection) {
                observer.observe(statsSection);
            }
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
