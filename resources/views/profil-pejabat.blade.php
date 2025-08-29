<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pejabat PPID - Kementerian Agama Kabupaten Nganjuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
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
            margin-bottom: 3rem;
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

        /* Profile Cards */
        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-top: 4px solid var(--kemenag-secondary);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--kemenag-accent), transparent);
            border-radius: 0 0 0 100%;
            opacity: 0.1;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid var(--kemenag-accent);
            padding: 3px;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            margin: 0 auto 1.5rem;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--kemenag-primary);
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .profile-position {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--kemenag-secondary);
            margin-bottom: 1rem;
            text-align: center;
        }

        .profile-nip {
            background: var(--kemenag-light);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            color: var(--kemenag-primary);
            display: inline-block;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .profile-details {
            background: rgba(46, 143, 71, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(46, 143, 71, 0.1);
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            background: var(--kemenag-secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 1rem;
            font-size: 1.1rem;
        }

        .detail-content h6 {
            margin: 0;
            font-weight: 600;
            color: var(--kemenag-primary);
            font-size: 0.9rem;
        }

        .detail-content p {
            margin: 0;
            color: #666;
            font-size: 1rem;
        }

        /* Organizational Structure */
        .org-structure {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .org-level {
            margin-bottom: 2rem;
            text-align: center;
        }

        .org-level h4 {
            color: var(--kemenag-primary);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .org-box {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            color: white;
            padding: 1rem;
            border-radius: 10px;
            margin: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .org-box:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .org-arrow {
            color: var(--kemenag-secondary);
            font-size: 2rem;
            margin: 1rem 0;
        }

        /* Responsibilities */
        .responsibility-item {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--kemenag-accent);
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .responsibility-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }

        .responsibility-item h5 {
            color: var(--kemenag-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .responsibility-item p {
            margin: 0;
            color: #666;
        }

        /* Stats Cards */
        .stats-card {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Footer */
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

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .profile-image {
                width: 120px;
                height: 120px;
                font-size: 2.5rem;
            }

            .profile-name {
                font-size: 1.3rem;
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
                    <li class="breadcrumb-item active">Profil Pejabat</li>
                </ol>
            </nav>
            <h1><i class="bi bi-person-badge"></i> Profil Pejabat PPID</h1>
            <p class="lead">Struktur Pimpinan dan Pengelola Informasi Publik Kementerian Agama Kabupaten Nganjuk</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">


        <!-- Atasan PPID Profile -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="bi bi-person-check"></i> Atasan Pejabat Pengelola Informasi dan Dokumentasi
            </h2>

            <div class="row">
                <div class="col-lg-6">
                    <div class="profile-card">
                        <div class="profile-image">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="profile-name">ABDUL RAHMAN S.Ag, M.PdI</div>
                        <div class="profile-position">Kepala Kantor Kementerian Agama Kabupaten Nganjuk</div>
                        <div class="text-center">
                            <span class="profile-nip">NIP: 196902151997031006</span>
                        </div>

                        <div class="profile-details">
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="detail-content">
                                    <h6>Jabatan</h6>
                                    <p>Atasan Pejabat Pengelola Informasi dan Dokumentasi</p>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="detail-content">
                                    <h6>Unit Kerja</h6>
                                    <p>Kankemenag Kabupaten Nganjuk</p>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-calendar"></i>
                                </div>
                                <div class="detail-content">
                                    <h6>Periode Jabatan</h6>
                                    <p>2025 - Sekarang</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="profile-card">
                        <h4 class="text-center mb-3" style="color: var(--kemenag-primary);">
                            <i class="bi bi-gear"></i> Wewenang dan Fungsi
                        </h4>

                        <div class="responsibility-item">
                            <h5><i class="bi bi-check-circle me-2"></i>Kebijakan Akses Publik</h5>
                            <p>Memutuskan dan mengevaluasi kebijakan akses publik pada Kantor Kementerian Agama Kabupaten Nganjuk</p>
                        </div>

                        <div class="responsibility-item">
                            <h5><i class="bi bi-file-ruled me-2"></i>Evaluasi Kinerja Struktur</h5>
                            <p>Mengevaluasi kinerja struktur dan para penanggung jawab akses Informasi Publik Kantor Kementerian Agama Kabupaten Nganjuk</p>
                        </div>

                        <div class="responsibility-item">
                            <h5><i class="bi bi-award me-2"></i>Manajemen Pengelolaan</h5>
                            <p>Memastikan manajemen pengelolaan dan pelayanan Informasi Publik pada Kantor Kementerian Agama Kabupaten Nganjuk telah sesuai dengan peraturan perundang-undangan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PPID Unit Profile -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="bi bi-person-workspace"></i> Pejabat Pengelola Informasi dan Dokumentasi Unit
            </h2>

            <div class="row">
                <div class="col-lg-6">
                    <div class="profile-card">
                        <div class="profile-image">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="profile-name">FARID WAJDI S.Ag.,MM</div>
                        <div class="profile-position">Kepala Bagian Tata Usaha Kantor Kementerian Agama Kabupaten Nganjuk</div>
                        <div class="text-center">
                            <span class="profile-nip">NIP: 197101191998031002</span>
                        </div>

                        <div class="profile-details">
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="detail-content">
                                    <h6>Jabatan</h6>
                                    <p>Pejabat Pengelola Informasi dan Dokumentasi Unit</p>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="detail-content">
                                    <h6>Unit Kerja</h6>
                                    <p>Kankemenag Kabupaten Nganjuk</p>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-calendar"></i>
                                </div>
                                <div class="detail-content">
                                    <h6>Periode Jabatan</h6>
                                    <p>2023 - 2029</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="profile-card">
                        <h4 class="text-center mb-3" style="color: var(--kemenag-primary);">
                            <i class="bi bi-gear"></i> Tugas dan Tanggung Jawab
                        </h4>

                        <div class="responsibility-item">
                            <h5><i class="bi bi-collection me-2"></i>Koordinasi Pengumpulan Informasi</h5>
                            <p>Mengkoordinasikan pengumpulan seluruh informasi publik dari Unit Kerja pada Kantor Kementerian Agama Kabupaten Nganjuk</p>
                        </div>

                        <div class="responsibility-item">
                            <h5><i class="bi bi-database me-2"></i>Pendataan Informasi Publik</h5>
                            <p>Mengkoordinasikan pendataan Informasi Publik yang dikuasai oleh setiap Unit Kerja dalam rangka pembuatan dan pemuktahiran Daftar Informasi Publik</p>
                        </div>

                        <div class="responsibility-item">
                            <h5><i class="bi bi-shield-check me-2"></i>Pengujian Konsekuensi</h5>
                            <p>Melakukan pengujian tentang konsekuensi sebagaimana dimaksud Pasal 17 Undang-Undang Keterbukaan Informasi Publik dengan seksama dan penuh ketelitian</p>
                        </div>

                        <div class="responsibility-item">
                            <h5><i class="bi bi-file-text me-2"></i>Pertimbangan Tertulis</h5>
                            <p>Menetapkan pertimbangan tertulis atas kebijakan yang diambil untuk memenuhi hak setiap pemohon informasi</p>
                        </div>

                        <div class="responsibility-item">
                            <h5><i class="bi bi-exclamation-triangle me-2"></i>Alasan Pengecualian</h5>
                            <p>Menyertakan alasan tertulis pengecualian Informasi Publik secara jelas dan tegas dalam hal permohonan Informasi Publik ditolak</p>
                        </div>

                        <div class="responsibility-item">
                            <h5><i class="bi bi-people me-2"></i>Pelayanan Informasi</h5>
                            <p>Mengkoordinasikan penyediaan dan pelayanan seluruh Informasi Publik melalui pengumuman dan/atau permohonan</p>
                        </div>

                        <div class="responsibility-item">
                            <h5><i class="bi bi-clipboard-data me-2"></i>Pelaporan Tugas</h5>
                            <p>Melaporkan pelaksanaan tugas kepada Pejabat Pengelola Informasi dan Dokumentasi Utama Kementerian Agama</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Organizational Structure -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="bi bi-diagram-3"></i> Struktur Organisasi PPID
            </h2>

            <div class="org-structure">
                <div class="org-level">
                    <h4>Atasan PPID Unit</h4>
                    <div class="org-box">
                        ABDUL RAHMAN S.Ag, M.PdI<br>
                        Kepala Kantor Kementerian Agama<br>
                        Kabupaten Nganjuk
                    </div>
                </div>

                <div class="org-arrow text-center">
                    <i class="bi bi-arrow-down"></i>
                </div>

                <div class="org-level">
                    <h4>PPID Unit</h4>
                    <div class="org-box">
                        FARID WAJDI S.Ag.,MM<br>
                        Kepala Bagian Tata Usaha<br>
                        Kantor Kementerian Agama Kabupaten Nganjuk
                    </div>
                </div>

                <div class="org-arrow text-center">
                    <i class="bi bi-arrow-down"></i>
                </div>

                <div class="org-level">
                    <h4>Tim Pendukung PPID</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="org-box">
                                Bidang Pelayanan
Informasi,
Dokumentasi dan
Arsip
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="org-box">Bidang Pengelolaan
Informasi
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="org-box">Bidang Aduan dan
Pelayanan Sengketa
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
