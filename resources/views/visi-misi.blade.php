<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi, Misi, dan Motto PPID - Kementerian Agama Kabupaten Nganjuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --kemenag-primary: #1e5631;
            --kemenag-secondary: #2d8f47;
            --kemenag-accent: #ffd700;
            --kemenag-light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            padding-top: 80px;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
            color: white;
            padding: 4rem 0 2rem;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            position: relative;
            z-index: 2;
        }

        .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--kemenag-accent);
        }

        /* Content Sections */
        .content-section {
            margin-bottom: 4rem;
        }

        .section-title {
            color: var(--kemenag-primary);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--kemenag-accent);
        }

        /* Hero Cards */
        .hero-card {
            background: white;
            border-radius: 20px;
            padding: 3rem 2rem;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-top: 5px solid var(--kemenag-secondary);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,215,0,0.05) 0%, transparent 70%);
            transition: all 0.3s ease;
        }

        .hero-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }

        .hero-card:hover::before {
            opacity: 1;
        }

        .hero-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--kemenag-primary);
            text-align: center;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .hero-content {
            font-size: 1.1rem;
            text-align: center;
            color: #555;
            position: relative;
            z-index: 2;
        }

        /* Visi Card Specific */
        .visi-card {
            background: linear-gradient(135deg, #fff, rgba(30, 86, 49, 0.02));
            border-top-color: var(--kemenag-primary);
        }

        .visi-card .hero-icon {
            background: linear-gradient(135deg, var(--kemenag-primary), #064420);
        }

        /* Misi Cards */
        .misi-item {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--kemenag-secondary);
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .misi-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, var(--kemenag-secondary), var(--kemenag-accent));
        }

        .misi-item:hover {
            transform: translateX(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }

        .misi-number {
            width: 40px;
            height: 40px;
            background: var(--kemenag-secondary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            float: left;
            margin-right: 1rem;
            margin-top: 0.25rem;
        }

        .misi-content {
            overflow: hidden;
        }

        .misi-content h5 {
            color: var(--kemenag-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .misi-content p {
            margin: 0;
            color: #666;
        }

        /* Motto Card */
        .motto-card {
            background: linear-gradient(135deg, var(--kemenag-accent), #ffed4e);
            color: var(--kemenag-primary);
            border-top-color: var(--kemenag-accent);
        }

        .motto-card .hero-icon {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
        }

        .motto-card .hero-title {
            color: var(--kemenag-primary);
        }

        .motto-card .hero-content {
            color: var(--kemenag-primary);
            font-weight: 600;
            font-size: 1.3rem;
        }

        /* Commitment Section */
        .commitment-box {
            background: linear-gradient(135deg, var(--kemenag-light) 0%, #fff 100%);
            border-radius: 20px;
            padding: 2rem;
            border: 2px solid rgba(46, 143, 71, 0.1);
            margin: 2rem 0;
            position: relative;
        }

        .commitment-box::before {
            content: '💻';
            position: absolute;
            top: -15px;
            left: 20px;
            background: white;
            padding: 0 10px;
            font-size: 1.5rem;
        }

        .commitment-box h4 {
            color: var(--kemenag-primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .commitment-box p {
            margin: 0;
            color: #555;
            font-style: italic;
        }

        /* Values Grid */
        .value-item {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            text-align: center;
            border-top: 3px solid var(--kemenag-secondary);
        }

        .value-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }

        .value-icon {
            width: 60px;
            height: 60px;
            background: var(--kemenag-secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }

        .value-item h6 {
            color: var(--kemenag-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .value-item p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer h5 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--kemenag-accent);
        }

        .footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--kemenag-accent);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
            
            .hero-card {
                padding: 2rem 1.5rem;
            }
            
            .hero-title {
                font-size: 1.5rem;
            }
            
            .hero-content {
                font-size: 1rem;
            }
            
            body {
                padding-top: 70px;
            }
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    @include('partials.navbar')

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/profil') }}">Profil PPID</a></li>
                    <li class="breadcrumb-item active">Visi, Misi, dan Motto</li>
                </ol>
            </nav>
            <h1><i class="bi bi-eye"></i> Visi, Misi, dan Motto PPID</h1>
            <p class="lead">Komitmen PPID dalam memberikan pelayanan informasi yang akuntabel dan transparan kepada masyarakat</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Introduction -->
        <div class="content-section">
            <div class="commitment-box">
                <h4>📢 Komitmen Pelayanan PPID</h4>
                <p>
                    Visi, Misi, dan Motto PPID Kementerian Agama Kabupaten Nganjuk telah kami tetapkan sebagai 
                    komitmen dalam memberikan pelayanan informasi yang akuntabel dan transparan kepada masyarakat.
                </p>
            </div>
        </div>

        <!-- Visi Section -->
        <div class="content-section">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="hero-card visi-card">
                        <div class="hero-icon">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h2 class="hero-title">✨ Visi</h2>
                        <div class="hero-content">
                            <strong>Terwujudnya Pelayanan Informasi yang Akuntabel dan Transparan</strong>
                            <br><br>
                            Mewujudkan pelayanan informasi publik yang dapat dipertanggungjawabkan, 
                            mudah diakses, dan terbuka bagi seluruh masyarakat sesuai dengan 
                            prinsip-prinsip keterbukaan informasi publik.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Misi Section -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="bi bi-bullseye"></i> Misi PPID
            </h2>
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="misi-item">
                        <div class="misi-number">1</div>
                        <div class="misi-content">
                            <h5>Pelayanan Cepat, Tepat, dan Transparan</h5>
                            <p>Memberikan pelayanan informasi publik yang cepat dalam merespon, tepat dalam menyajikan informasi, dan transparan dalam proses pelayanan kepada masyarakat.</p>
                        </div>
                    </div>
                    
                    <div class="misi-item">
                        <div class="misi-number">2</div>
                        <div class="misi-content">
                            <h5>Pengembangan SDM PPID yang Kompeten</h5>
                            <p>Mengembangkan sumber daya manusia PPID yang memiliki kompetensi, integritas, dan profesionalisme dalam mengelola dan melayani informasi publik.</p>
                        </div>
                    </div>
                    
                    <div class="misi-item">
                        <div class="misi-number">3</div>
                        <div class="misi-content">
                            <h5>Koordinasi Lintas Sektoral</h5>
                            <p>Membangun koordinasi yang efektif dengan berbagai unit kerja dan stakeholder terkait untuk mengoptimalkan pelayanan informasi publik.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="value-item">
                                <div class="value-icon">
                                    <i class="bi bi-speedometer2"></i>
                                </div>
                                <h6>Cepat</h6>
                                <p>Respon maksimal 24 jam untuk setiap permohonan informasi</p>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="value-item">
                                <div class="value-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <h6>Tepat</h6>
                                <p>Informasi akurat sesuai kebutuhan pemohon</p>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="value-item">
                                <div class="value-icon">
                                    <i class="bi bi-eye"></i>
                                </div>
                                <h6>Transparan</h6>
                                <p>Proses terbuka dan dapat dipertanggungjawabkan</p>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="value-item">
                                <div class="value-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h6>Kompeten</h6>
                                <p>SDM profesional dan berpengalaman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Motto Section -->
        <div class="content-section">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="hero-card motto-card">
                        <div class="hero-icon">
                            <i class="bi bi-heart"></i>
                        </div>
                        <h2 class="hero-title">💬 Motto</h2>
                        <div class="hero-content">
                            <strong>"Melayani dengan Ikhlas"</strong>
                            <br><br>
                            Memberikan pelayanan informasi publik dengan hati yang tulus, 
                            penuh dedikasi, dan komitmen untuk kepentingan masyarakat.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values and Principles -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="bi bi-gem"></i> Nilai-Nilai dan Prinsip Pelayanan
            </h2>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h6>Integritas</h6>
                        <p>Konsisten dalam menjalankan tugas dengan jujur dan dapat dipercaya</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <h6>Profesional</h6>
                        <p>Melakukan tugas dengan standar kualitas tinggi dan keahlian yang memadai</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="bi bi-hand-thumbs-up"></i>
                        </div>
                        <h6>Responsif</h6>
                        <p>Tanggap terhadap kebutuhan masyarakat akan informasi publik</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="bi bi-universal-access"></i>
                        </div>
                        <h6>Inklusif</h6>
                        <p>Memberikan akses informasi yang sama kepada seluruh lapisan masyarakat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commitment Section -->
        <div class="content-section">
            <div class="commitment-box">
                <h4>🎯 Komitmen PPID Kemenag Kabupaten Nganjuk</h4>
                <p>
                    Kami berkomitmen untuk terus meningkatkan kualitas pelayanan informasi publik 
                    melalui inovasi, teknologi, dan pengembangan SDM yang berkelanjutan. 
                    Bersama-sama mewujudkan <strong>#PPIDKemenag</strong> yang 
                    <strong>#MelayaniDenganIkhlas</strong> untuk <strong>#KeterbukaanInformasiPublik</strong> 
                    dan mendukung <strong>#ZonaIntegritas</strong> Kementerian Agama.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h5><i class="bi bi-building"></i> PPID Kemenag Nganjuk</h5>
                    <p>Pejabat Pengelola Informasi dan Dokumentasi Kementerian Agama Kabupaten Nganjuk</p>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="me-3"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="me-3"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h5><i class="bi bi-link-45deg"></i> Tautan Penting</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Kementerian Agama RI</a></li>
                        <li><a href="#">Kanwil Kemenag Jawa Timur</a></li>
                        <li><a href="#">PPID Kemenag Pusat</a></li>
                        <li><a href="#">Portal Data Indonesia</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5><i class="bi bi-geo-alt"></i> Kontak</h5>
                    <p><i class="bi bi-geo-alt"></i> Jl. Raya Surabaya-Madiun KM. 45, Nganjuk</p>
                    <p><i class="bi bi-telephone"></i> (0358) 321175</p>
                    <p><i class="bi bi-envelope"></i> ppid@kemenagnganjuk.id</p>
                </div>
            </div>
            <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center">
                <p>&copy; 2025 PPID Kementerian Agama Kabupaten Nganjuk. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
