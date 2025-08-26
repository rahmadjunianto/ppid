<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas, Fungsi, dan Wewenang PPID - Kementerian Agama Kabupaten Nganjuk</title>
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
            margin-bottom: 4rem;
        }

        .section-title {
            color: var(--kemenag-primary);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 0.5rem;
            text-align: center;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--kemenag-accent);
        }

        /* Section Cards */
        .section-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 3rem;
            border-top: 5px solid var(--kemenag-secondary);
            transition: all 0.3s ease;
        }

        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .section-card h2 {
            color: var(--kemenag-primary);
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-card h2 i {
            width: 40px;
            height: 40px;
            background: var(--kemenag-secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        /* Task Items */
        .task-item {
            background: rgba(46, 143, 71, 0.05);
            border-radius: 10px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--kemenag-secondary);
            transition: all 0.3s ease;
            position: relative;
        }

        .task-item:hover {
            transform: translateX(10px);
            background: rgba(46, 143, 71, 0.08);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .task-number {
            background: var(--kemenag-secondary);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            float: left;
            margin-right: 1rem;
            margin-top: 0.1rem;
        }

        .task-content {
            overflow: hidden;
            color: #555;
            line-height: 1.6;
        }

        .task-content strong {
            color: var(--kemenag-primary);
        }

        /* Sub-tasks */
        .sub-task {
            background: white;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin: 0.5rem 0 0.5rem 2.5rem;
            border-left: 3px solid var(--kemenag-accent);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            font-size: 0.9rem;
        }

        .sub-task::before {
            content: '◦';
            color: var(--kemenag-secondary);
            font-weight: bold;
            margin-right: 0.5rem;
        }

        /* Function Card */
        .function-card {
            background: linear-gradient(135deg, var(--kemenag-light), white);
            border-top-color: var(--kemenag-accent);
        }

        /* Authority Card */
        .authority-card {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.05), white);
            border-top-color: var(--kemenag-primary);
        }

        /* Summary Cards */
        .summary-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border-top: 3px solid var(--kemenag-secondary);
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }

        .summary-icon {
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

        .summary-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--kemenag-primary);
            margin-bottom: 0.5rem;
        }

        .summary-label {
            color: #666;
            font-weight: 500;
        }

        /* Highlight Box */
        .highlight-box {
            background: linear-gradient(135deg, var(--kemenag-accent), #ffed4e);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
            color: var(--kemenag-primary);
            font-weight: 600;
            text-align: center;
            box-shadow: 0 5px 20px rgba(255, 215, 0, 0.3);
        }

        .highlight-box i {
            font-size: 1.5rem;
            margin-right: 0.5rem;
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
            
            .section-card {
                padding: 1.5rem;
            }
            
            .task-item {
                padding: 1rem;
            }
            
            .task-number {
                width: 25px;
                height: 25px;
                font-size: 0.8rem;
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
                    <li class="breadcrumb-item active">Tugas, Fungsi, dan Wewenang</li>
                </ol>
            </nav>
            <h1><i class="bi bi-list-task"></i> Tugas, Fungsi, dan Wewenang PPID</h1>
            <p class="lead">Uraian lengkap tugas, fungsi, dan wewenang Pejabat Pengelola Informasi dan Dokumentasi Kementerian Agama</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Summary Stats -->
        <div class="content-section">
            <div class="row">
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="bi bi-list-check"></i>
                        </div>
                        <div class="summary-number">20</div>
                        <div class="summary-label">Tugas Utama PPID</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="bi bi-gear"></i>
                        </div>
                        <div class="summary-number">1</div>
                        <div class="summary-label">Fungsi Utama</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="summary-number">13</div>
                        <div class="summary-label">Wewenang PPID</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tugas PPID -->
        <div class="content-section">
            <div class="section-card">
                <h2>
                    <i class="bi bi-list-check"></i>
                    Tugas PPID
                </h2>
                
                <div class="task-item">
                    <div class="task-number">1</div>
                    <div class="task-content">
                        <strong>Penyediaan dan Pengamanan Informasi Publik</strong><br>
                        Menyediakan dan mengamankan Informasi Publik sesuai dengan ketentuan peraturan perundang-undangan.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">2</div>
                    <div class="task-content">
                        <strong>Pelayanan Informasi Publik</strong><br>
                        Memberikan pelayanan Informasi Publik yang cepat, tepat, dan sederhana kepada masyarakat.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">3</div>
                    <div class="task-content">
                        <strong>Penyusunan SOP</strong><br>
                        Menyusun standar operasional prosedur pelaksanaan tugas dan kewenangan PPID Kementerian Agama dalam rangka penyebarluasan Informasi Publik.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">4</div>
                    <div class="task-content">
                        <strong>Penetapan Daftar Informasi Publik</strong><br>
                        Menetapkan Daftar Informasi Publik dalam bentuk keputusan PPID Kementerian Agama, paling lambat akhir bulan Januari tahun berjalan.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">5</div>
                    <div class="task-content">
                        <strong>Pengklasifikasian Informasi Publik</strong><br>
                        Melaksanakan Pengklasifikasian Informasi Publik atau perubahannya dengan persetujuan Atasan PPID Kementerian Agama.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">6</div>
                    <div class="task-content">
                        <strong>Penetapan Informasi yang Dikecualikan</strong><br>
                        Menetapkan Informasi Publik yang Dikecualikan sebagai Informasi Publik yang dapat diakses dalam hal:
                        <div class="sub-task">Telah dinyatakan terbuka bagi masyarakat berdasarkan mekanisme keberatan</div>
                        <div class="sub-task">Telah dinyatakan terbuka berdasarkan putusan ajudikasi, pengadilan, atau Mahkamah Agung</div>
                        <div class="sub-task">Telah habis jangka waktu pengecualiannya</div>
                        <div class="sub-task">Ditentukan oleh peraturan perundang-undangan</div>
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">7</div>
                    <div class="task-content">
                        <strong>Pertimbangan Tertulis</strong><br>
                        Menetapkan pertimbangan tertulis atas setiap kebijakan guna memenuhi hak atas Informasi Publik.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">8</div>
                    <div class="task-content">
                        <strong>Koordinasi Informasi</strong><br>
                        Mengoordinasikan:
                        <div class="sub-task">Pengumpulan seluruh Informasi Publik berkala, serta merta, dan setiap saat</div>
                        <div class="sub-task">Pengumpulan Informasi yang Dikecualikan</div>
                        <div class="sub-task">Pengumuman informasi melalui media efektif dan efisien</div>
                        <div class="sub-task">Penyampaian informasi dalam Bahasa Indonesia yang baik dan mudah dipahami</div>
                        <div class="sub-task">Pemenuhan permohonan informasi yang dapat diakses publik</div>
                        <div class="sub-task">Pengklasifikasian dan pengubahan klasifikasi informasi</div>
                        <div class="sub-task">Prosedur keberatan dan proses layanan berjalan dengan baik</div>
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">9</div>
                    <div class="task-content">
                        <strong>Uji Konsekuensi</strong><br>
                        Melakukan Uji Konsekuensi bersama PPID Unit eselon I.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">10</div>
                    <div class="task-content">
                        <strong>Alasan Penolakan</strong><br>
                        Memberikan alasan tertulis atas penolakan permohonan informasi.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">11</div>
                    <div class="task-content">
                        <strong>Penghitaman Informasi</strong><br>
                        Melakukan penghitaman atau pengaburan informasi yang dikecualikan beserta alasannya.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">12</div>
                    <div class="task-content">
                        <strong>Petugas Layanan</strong><br>
                        Menetapkan dan menugaskan petugas layanan informasi.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">13</div>
                    <div class="task-content">
                        <strong>Pengembangan Kompetensi</strong><br>
                        Mengembangkan kompetensi petugas layanan informasi.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">14</div>
                    <div class="task-content">
                        <strong>Sistem Informasi PPID</strong><br>
                        Menggunakan Sistem Informasi PPID dalam pengelolaan layanan informasi.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">15</div>
                    <div class="task-content">
                        <strong>Informasi Mutakhir</strong><br>
                        Menyediakan informasi mutakhir di portal Kementerian Agama dan sistem PPID.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">16</div>
                    <div class="task-content">
                        <strong>Pemeliharaan Informasi</strong><br>
                        Memelihara dan/atau memutakhirkan informasi minimal 1 kali per bulan.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">17</div>
                    <div class="task-content">
                        <strong>Koordinasi Perangkat PPID</strong><br>
                        Melakukan koordinasi, harmonisasi, dan fasilitasi Perangkat PPID.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">18</div>
                    <div class="task-content">
                        <strong>Fasilitas Layanan</strong><br>
                        Menyediakan ruangan dan/atau meja layanan informasi publik.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">19</div>
                    <div class="task-content">
                        <strong>Laporan Berkala</strong><br>
                        Membuat dan menyampaikan laporan empat bulanan kepada Atasan PPID.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">20</div>
                    <div class="task-content">
                        <strong>Laporan Tahunan</strong><br>
                        Membuat dan mengumumkan laporan tahunan serta menyampaikannya ke Komisi Informasi Pusat.
                    </div>
                </div>
            </div>
        </div>

        <!-- Fungsi PPID -->
        <div class="content-section">
            <div class="section-card function-card">
                <h2>
                    <i class="bi bi-gear"></i>
                    Fungsi PPID
                </h2>
                
                <div class="highlight-box">
                    <i class="bi bi-bullseye"></i>
                    <strong>Pembinaan dan Pengelolaan Pejabat Pengelola Informasi dan Dokumentasi di lingkungan Kementerian Agama Pusat dan Daerah</strong>
                </div>
                
                <p class="text-muted mt-3">
                    Fungsi utama PPID adalah melakukan pembinaan dan pengelolaan seluruh PPID di lingkungan Kementerian Agama, 
                    baik di tingkat pusat maupun daerah, untuk memastikan pelaksanaan keterbukaan informasi publik 
                    yang konsisten dan sesuai dengan peraturan perundang-undangan.
                </p>
            </div>
        </div>

        <!-- Wewenang PPID -->
        <div class="content-section">
            <div class="section-card authority-card">
                <h2>
                    <i class="bi bi-shield-check"></i>
                    Wewenang PPID
                </h2>
                
                <div class="task-item">
                    <div class="task-number">1</div>
                    <div class="task-content">
                        <strong>Penetapan Panitia</strong><br>
                        Menetapkan Panitia Pengelola dan Pelayanan Informasi PPID Kementerian Agama.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">2</div>
                    <div class="task-content">
                        <strong>Keputusan Akses Informasi</strong><br>
                        Memutuskan informasi dapat diakses/tidak berdasarkan Uji Konsekuensi bersama PPID Unit Eselon I Pusat.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">3</div>
                    <div class="task-content">
                        <strong>Penolakan Permohonan</strong><br>
                        Menolak permohonan secara tertulis jika informasi termasuk yang dikecualikan, serta memberikan hak dan tata cara keberatan.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">4</div>
                    <div class="task-content">
                        <strong>Partisipasi Rapat</strong><br>
                        Menghadiri rapat pembahasan PPID tingkat kementerian/lembaga.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">5</div>
                    <div class="task-content">
                        <strong>Permintaan Informasi</strong><br>
                        Meminta informasi ke PPID Unit jika informasi dikuasai oleh mereka.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">6</div>
                    <div class="task-content">
                        <strong>Koordinasi Keberatan</strong><br>
                        Melakukan koordinasi dalam menyelesaikan keberatan.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">7</div>
                    <div class="task-content">
                        <strong>Pendampingan dan Koordinasi</strong><br>
                        Melakukan pendampingan dan koordinasi dengan unit terkait termasuk unit hukum.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">8</div>
                    <div class="task-content">
                        <strong>Usulan Gugatan</strong><br>
                        Mengusulkan gugatan atas putusan Komisi Informasi ke lembaga peradilan.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">9</div>
                    <div class="task-content">
                        <strong>Koordinasi Portal dan Sistem</strong><br>
                        Koordinasi penyediaan informasi mutakhir pada portal dan sistem PPID.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">10</div>
                    <div class="task-content">
                        <strong>Pelaporan Ketidaksesuaian</strong><br>
                        Melaporkan ketidaksesuaian proses sidang Sengketa Informasi ke Komisi Informasi.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">11</div>
                    <div class="task-content">
                        <strong>Sosialisasi</strong><br>
                        Melakukan sosialisasi pemahaman keterbukaan informasi publik.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">12</div>
                    <div class="task-content">
                        <strong>Pembinaan PPID Unit</strong><br>
                        Pembinaan PPID Unit Kemenag Pusat dan Daerah.
                    </div>
                </div>

                <div class="task-item">
                    <div class="task-number">13</div>
                    <div class="task-content">
                        <strong>Monitoring Pelaksanaan</strong><br>
                        Monitoring pelaksanaan PPID Unit di seluruh satuan kerja.
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
