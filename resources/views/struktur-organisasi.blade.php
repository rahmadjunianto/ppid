<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi PPID - Kementerian Agama Kabupaten Nganjuk</title>
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

        /* Organizational Chart */
        .org-chart {
            margin: 2rem 0;
        }

        .org-level {
            margin: 2rem 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .org-box {
            background: white;
            border: 3px solid var(--kemenag-secondary);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 0.5rem;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            min-width: 280px;
        }

        .org-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            border-color: var(--kemenag-primary);
        }

        .org-box.top-level {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            color: white;
            border-color: var(--kemenag-accent);
        }

        .org-box.mid-level {
            background: linear-gradient(135deg, var(--kemenag-light), white);
            border-color: var(--kemenag-secondary);
        }

        .org-box.bottom-level {
            background: rgba(46, 143, 71, 0.05);
            border-color: rgba(46, 143, 71, 0.3);
        }

        .org-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .org-subtitle {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Connection Lines */
        .org-connection {
            width: 2px;
            height: 30px;
            background: var(--kemenag-secondary);
            margin: 0 auto;
        }

        .org-horizontal {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Structure Grid */
        .structure-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        .structure-item {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            border-left: 5px solid var(--kemenag-secondary);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .structure-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            border-left-color: var(--kemenag-primary);
        }

        .structure-item h4 {
            color: var(--kemenag-primary);
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .structure-item h4 i {
            color: var(--kemenag-secondary);
        }

        .structure-item ul {
            list-style: none;
            padding: 0;
        }

        .structure-item li {
            background: rgba(46, 143, 71, 0.05);
            padding: 0.75rem;
            margin: 0.5rem 0;
            border-radius: 8px;
            border-left: 3px solid var(--kemenag-accent);
            transition: all 0.3s ease;
        }

        .structure-item li:hover {
            background: rgba(46, 143, 71, 0.1);
            transform: translateX(5px);
        }

        .structure-item li::before {
            content: '◦';
            color: var(--kemenag-secondary);
            font-weight: bold;
            margin-right: 0.5rem;
        }

        /* Info Cards */
        .info-card {
            background: linear-gradient(135deg, var(--kemenag-light), white);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 1rem 0;
            border-top: 3px solid var(--kemenag-accent);
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .info-card h5 {
            color: var(--kemenag-primary);
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-card h5 i {
            color: var(--kemenag-secondary);
        }

        /* Statistics */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border-top: 3px solid var(--kemenag-secondary);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }

        .stat-icon {
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

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--kemenag-primary);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-weight: 500;
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
            
            .section-card {
                padding: 1.5rem;
            }
            
            .org-box {
                min-width: 250px;
                padding: 1rem;
            }
            
            .org-horizontal {
                flex-direction: column;
                align-items: center;
            }
            
            .structure-grid {
                grid-template-columns: 1fr;
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
                    <li class="breadcrumb-item active">Struktur Organisasi</li>
                </ol>
            </nav>
            <h1><i class="bi bi-diagram-3"></i> Struktur Organisasi PPID</h1>
            <p class="lead">Struktur organisasi Pejabat Pengelola Informasi dan Dokumentasi Kementerian Agama</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div class="stat-number">2</div>
                <div class="stat-label">Kategori Utama PPID</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <div class="stat-number">3</div>
                <div class="stat-label">Sub-kategori Unit</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-number">35+</div>
                <div class="stat-label">PPID Kabupaten/Kota</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-mortarboard"></i>
                </div>
                <div class="stat-number">100+</div>
                <div class="stat-label">PPID Perguruan Tinggi</div>
            </div>
        </div>

        <!-- Organizational Chart -->
        <div class="section-card">
            <h2>
                <i class="bi bi-diagram-3"></i>
                Bagan Organisasi PPID
            </h2>
            
            <div class="org-chart">
                <!-- Top Level -->
                <div class="org-level">
                    <div class="org-box top-level">
                        <div class="org-title">PPID KEMENTERIAN AGAMA</div>
                        <div class="org-subtitle">Koordinator Utama</div>
                    </div>
                </div>

                <div class="org-connection"></div>

                <!-- Second Level -->
                <div class="org-level">
                    <div class="org-horizontal">
                        <div class="org-box mid-level">
                            <div class="org-title">PPID KEMENTERIAN AGAMA</div>
                            <div class="org-subtitle">Tingkat Pusat</div>
                        </div>
                        <div class="org-box mid-level">
                            <div class="org-title">PPID UNIT</div>
                            <div class="org-subtitle">Satuan Kerja Bawahan</div>
                        </div>
                    </div>
                </div>

                <div class="org-connection"></div>

                <!-- Third Level -->
                <div class="org-level">
                    <div class="org-horizontal">
                        <div class="org-box bottom-level">
                            <div class="org-title">PPID PUSAT</div>
                            <div class="org-subtitle">Unit Eselon I</div>
                        </div>
                        <div class="org-box bottom-level">
                            <div class="org-title">PPID PERGURUAN TINGGI</div>
                            <div class="org-subtitle">UIN, IAIN, STAIN</div>
                        </div>
                        <div class="org-box bottom-level">
                            <div class="org-title">PPID DAERAH</div>
                            <div class="org-subtitle">Kanwil & Kankemenag</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Structure Details -->
        <div class="structure-grid">
            <!-- PPID Kementerian Agama -->
            <div class="structure-item">
                <h4><i class="bi bi-building"></i> PPID Kementerian Agama</h4>
                <p class="text-muted mb-3">Koordinator utama yang mengelola dan mengkoordinasikan seluruh PPID di lingkungan Kementerian Agama.</p>
                <ul>
                    <li>Sekretariat Jenderal</li>
                    <li>Direktorat Jenderal Bimbingan Masyarakat Islam</li>
                    <li>Direktorat Jenderal Pendidikan Islam</li>
                    <li>Direktorat Jenderal Penyelenggaraan Haji dan Umrah</li>
                    <li>Direktorat Jenderal Bimbingan Masyarakat Kristen</li>
                    <li>Direktorat Jenderal Bimbingan Masyarakat Katolik</li>
                    <li>Direktorat Jenderal Bimbingan Masyarakat Hindu</li>
                    <li>Direktorat Jenderal Bimbingan Masyarakat Buddha</li>
                </ul>
            </div>

            <!-- PPID Unit Pusat -->
            <div class="structure-item">
                <h4><i class="bi bi-geo-alt"></i> PPID Unit Pusat</h4>
                <p class="text-muted mb-3">Unit-unit di tingkat pusat yang memiliki PPID tersendiri untuk melayani informasi publik sesuai bidangnya.</p>
                <ul>
                    <li>Inspektorat Jenderal</li>
                    <li>Badan Litbang dan Diklat</li>
                    <li>Sekretariat Ditjen BMI</li>
                    <li>Sekretariat Ditjen Pendis</li>
                    <li>Sekretariat Ditjen PHU</li>
                    <li>Sekretariat Ditjen Bimas Kristen</li>
                    <li>Sekretariat Ditjen Bimas Katolik</li>
                    <li>Sekretariat Ditjen Bimas Hindu</li>
                    <li>Sekretariat Ditjen Bimas Buddha</li>
                </ul>
            </div>

            <!-- PPID Perguruan Tinggi -->
            <div class="structure-item">
                <h4><i class="bi bi-mortarboard"></i> PPID Perguruan Tinggi</h4>
                <p class="text-muted mb-3">PPID di lingkungan perguruan tinggi keagamaan negeri dan swasta di bawah Kementerian Agama.</p>
                <ul>
                    <li>Universitas Islam Negeri (UIN)</li>
                    <li>Institut Agama Islam Negeri (IAIN)</li>
                    <li>Sekolah Tinggi Agama Islam Negeri (STAIN)</li>
                    <li>Universitas Hindu Dharma Negeri</li>
                    <li>Institut Agama Buddha Negeri</li>
                    <li>Sekolah Tinggi Agama Kristen Negeri</li>
                    <li>Institut Agama Katolik Negeri</li>
                </ul>
            </div>

            <!-- PPID Daerah -->
            <div class="structure-item">
                <h4><i class="bi bi-people"></i> PPID Daerah</h4>
                <p class="text-muted mb-3">PPID di tingkat daerah yang melayani masyarakat di wilayah provinsi dan kabupaten/kota.</p>
                <ul>
                    <li>Kantor Wilayah Kemenag Provinsi (34 Kanwil)</li>
                    <li>Kantor Kemenag Kabupaten/Kota (500+ Kankemenag)</li>
                    <li>Kantor Urusan Agama Kecamatan (KUA)</li>
                    <li>Madrasah Negeri</li>
                    <li>Balai Diklat Keagamaan</li>
                    <li>Museum Keagamaan</li>
                </ul>
            </div>
        </div>

        <!-- PPID Nganjuk Position -->
        <div class="section-card">
            <h2>
                <i class="bi bi-geo-alt-fill"></i>
                Posisi PPID Kementerian Agama Kabupaten Nganjuk
            </h2>
            
            <div class="info-card">
                <h5><i class="bi bi-diagram-2"></i> Hierarki Organisasi</h5>
                <p>PPID Kementerian Agama Kabupaten Nganjuk berada di bawah koordinasi:</p>
                <ol>
                    <li><strong>PPID Kementerian Agama Pusat</strong> - Sebagai koordinator utama</li>
                    <li><strong>PPID Kantor Wilayah Kemenag Jawa Timur</strong> - Sebagai koordinator tingkat provinsi</li>
                    <li><strong>PPID Kankemenag Nganjuk</strong> - Sebagai pelaksana tingkat kabupaten</li>
                </ol>
            </div>

            <div class="info-card">
                <h5><i class="bi bi-bullseye"></i> Cakupan Wilayah Kerja</h5>
                <p>PPID Kankemenag Nganjuk melayani informasi publik untuk:</p>
                <div class="row">
                    <div class="col-md-6">
                        <ul>
                            <li>20 Kecamatan di Kabupaten Nganjuk</li>
                            <li>292 Desa/Kelurahan</li>
                            <li>20 Kantor Urusan Agama (KUA)</li>
                            <li>Madrasah Negeri se-Kabupaten Nganjuk</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li>Pondok Pesantren terdaftar</li>
                            <li>Lembaga Keagamaan</li>
                            <li>Organisasi Kemasyarakatan Islam</li>
                            <li>Tempat Ibadah (Masjid, Musholla)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <h5><i class="bi bi-people-fill"></i> Koordinasi dan Pelaporan</h5>
                <p>Dalam menjalankan tugasnya, PPID Kankemenag Nganjuk:</p>
                <ul>
                    <li>Berkoordinasi dengan PPID Kanwil Kemenag Jawa Timur</li>
                    <li>Melaporkan kegiatan kepada PPID Kementerian Agama Pusat</li>
                    <li>Bekerjasama dengan KUA-KUA di wilayah Kabupaten Nganjuk</li>
                    <li>Menjalin komunikasi dengan Komisi Informasi Provinsi Jawa Timur</li>
                    <li>Berkoordinasi dengan Pemerintah Daerah Kabupaten Nganjuk</li>
                </ul>
            </div>
        </div>

        <!-- Support Units -->
        <div class="section-card">
            <h2>
                <i class="bi bi-gear-fill"></i>
                Unit Pendukung PPID
            </h2>
            
            <div class="structure-grid">
                <div class="structure-item">
                    <h4><i class="bi bi-file-earmark-text"></i> Bagian Perencanaan</h4>
                    <ul>
                        <li>Penyusunan program kerja PPID</li>
                        <li>Koordinasi lintas seksi</li>
                        <li>Monitoring dan evaluasi</li>
                    </ul>
                </div>

                <div class="structure-item">
                    <h4><i class="bi bi-database"></i> Bagian Dokumentasi</h4>
                    <ul>
                        <li>Pengelolaan arsip dan dokumen</li>
                        <li>Digitalisasi informasi</li>
                        <li>Pemeliharaan database</li>
                    </ul>
                </div>

                <div class="structure-item">
                    <h4><i class="bi bi-headset"></i> Bagian Pelayanan</h4>
                    <ul>
                        <li>Layanan informasi publik</li>
                        <li>Penanganan permohonan informasi</li>
                        <li>Penyelesaian keberatan</li>
                    </ul>
                </div>

                <div class="structure-item">
                    <h4><i class="bi bi-laptop"></i> Bagian Teknologi</h4>
                    <ul>
                        <li>Pengelolaan website PPID</li>
                        <li>Sistem informasi online</li>
                        <li>Dukungan teknis IT</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
