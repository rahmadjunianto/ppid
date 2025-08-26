<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Survey Kepuasan Pelayanan PPID Kementerian Agama Kabupaten Nganjuk">
    <meta name="keywords" content="Survey, PPID, Kemenag, Nganjuk, Kepuasan, Pelayanan">

    <title>Survey Kepuasan Pelayanan PPID - PPID Kemenag Nganjuk</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            background: #f8f9fa;
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

        .btn-kemenag {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .btn-kemenag:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 86, 49, 0.3);
            color: white;
        }

        .survey-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .survey-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .card-header-gradient {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 20px;
        }

        .survey-question {
            border-left: 4px solid var(--kemenag-primary);
            padding-left: 15px;
            background: rgba(30, 86, 49, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .survey-question:hover {
            background: rgba(30, 86, 49, 0.08);
            transform: translateX(5px);
        }

        .form-check-input:checked {
            background-color: var(--kemenag-primary);
            border-color: var(--kemenag-primary);
        }

        .form-check-input:focus {
            border-color: var(--kemenag-secondary);
            box-shadow: 0 0 0 0.25rem rgba(30, 86, 49, 0.25);
        }

        .form-check-label {
            font-weight: 500;
            cursor: pointer;
        }

        .stats-card {
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        .stats-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .footer-kemenag {
            background: var(--kemenag-dark);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-logo {
            height: 80px;
            margin-bottom: 20px;
        }

        .footer-link {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--kemenag-accent);
        }

        .breadcrumb {
            background: none;
            padding: 0;
        }

        .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--kemenag-accent);
        }

        .breadcrumb-item.active {
            color: var(--kemenag-accent);
        }

        .page-header {
            background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
            color: white;
            padding: 4rem 0 2rem;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .alert-gradient {
            background: linear-gradient(135deg, rgba(30, 86, 49, 0.1), rgba(45, 143, 71, 0.1));
            border: 1px solid rgba(30, 86, 49, 0.2);
            border-radius: 15px;
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
                    <li class="breadcrumb-item active">Survey PPID</li>
                </ol>
            </nav>
            <h1><i class="fas fa-poll me-3"></i>Survey PPID</h1>
            <p class="lead">Lembar Kuesioner Survey Kepuasan Pelayanan PPID</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5">
        <!-- Information Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="alert alert-gradient mx-auto" style="max-width: 800px;">
                    <div class="text-center">
                        <h4 class="fw-bold mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Petunjuk Pengisian Survey
                        </h4>
                        <p class="mb-2">
                            <strong>Mohon kesediaan Anda untuk memberikan penilaian dan masukan kepada Kami,</strong>
                            dimana hal ini sangat bermanfaat untuk meningkatkan kualitas layanan kami.
                        </p>
                        <p class="mb-0">
                            Sebelum melanjutkan, <strong>Mohon mengisi Biodata Anda</strong> pada form yang telah disediakan dibawah.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if($statistics['total_responden'] > 0)
        <!-- Statistics Section -->
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="text-center mb-4">Statistik Survey</h3>
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="stats-card text-center p-4">
                            <i class="fas fa-users stats-icon text-primary"></i>
                            <h3 class="text-primary mb-2">{{ $statistics['total_responden'] }}</h3>
                            <p class="text-muted mb-0">Total Responden</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="stats-card text-center p-4">
                            <i class="fas fa-star stats-icon text-warning"></i>
                            <h3 class="text-warning mb-2">{{ number_format($statistics['rata_rata_kepuasan'], 1) }}/4.0</h3>
                            <p class="text-muted mb-0">Rata-rata Kepuasan</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="stats-card text-center p-4">
                            <i class="fas fa-percentage stats-icon text-success"></i>
                            <h3 class="text-success mb-2">{{ round(($statistics['rata_rata_kepuasan'] / 4) * 100) }}%</h3>
                            <p class="text-muted mb-0">Tingkat Kepuasan</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="stats-card text-center p-4">
                            <i class="fas fa-thumbs-up stats-icon text-info"></i>
                            <h3 class="text-info mb-2">{{ $statistics['distribusi_rating'][3] + $statistics['distribusi_rating'][4] }}</h3>
                            <p class="text-muted mb-0">Responden Puas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Survey Form -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="survey-card">
                    <div class="card-header-gradient">
                        <h4 class="mb-0"><i class="fas fa-user me-2"></i> Biodata Responden</h4>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('survey.store') }}" method="POST" id="surveyForm">
                            @csrf

                            <!-- Biodata Section -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama" class="form-label fw-bold">Nama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                               value="{{ old('nama') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="umur" class="form-label fw-bold">Umur <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="umur" name="umur"
                                               value="{{ old('umur') }}" min="10" max="100" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="jenis_kelamin" class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="no_hp" class="form-label fw-bold">No HP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                                               value="{{ old('no_hp') }}" placeholder="081234567890" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="pendidikan" class="form-label fw-bold">Pendidikan <span class="text-danger">*</span></label>
                                        <select class="form-control" id="pendidikan" name="pendidikan" required>
                                            <option value="">Pilih Pendidikan</option>
                                            <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA/SMK" {{ old('pendidikan') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                            <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                                            <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                                            <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                                            <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="pekerjaan" class="form-label fw-bold">Pekerjaan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                               value="{{ old('pekerjaan') }}" placeholder="Contoh: PNS, Wiraswasta, Mahasiswa" required>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-5">

                            <!-- Survey Questions -->
                            <div class="survey-card">
                                <div class="card-header-gradient">
                                    <h4 class="mb-0"><i class="fas fa-question-circle me-2"></i> Pertanyaan Survey</h4>
                                </div>
                                <div class="card-body p-4">

                                    <!-- Question 1 -->
                                    <div class="survey-question">
                                        <label class="form-label fw-bold fs-6">
                                            1. Kemudahan akses informasi PPID pada website <span class="text-danger">*</span>
                                        </label>
                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kemudahan_akses_informasi"
                                                           id="akses1" value="1" {{ old('kemudahan_akses_informasi') == '1' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="akses1">Tidak Mudah</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kemudahan_akses_informasi"
                                                           id="akses2" value="2" {{ old('kemudahan_akses_informasi') == '2' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="akses2">Kurang Mudah</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kemudahan_akses_informasi"
                                                           id="akses3" value="3" {{ old('kemudahan_akses_informasi') == '3' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="akses3">Mudah</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kemudahan_akses_informasi"
                                                           id="akses4" value="4" {{ old('kemudahan_akses_informasi') == '4' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="akses4">Sangat Mudah</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Question 2 -->
                                    <div class="survey-question">
                                        <label class="form-label fw-bold fs-6">
                                            2. Ketersediaan/kualitas informasi terkait layanan informasi PPID? <span class="text-danger">*</span>
                                        </label>
                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kualitas_informasi"
                                                           id="kualitas1" value="1" {{ old('kualitas_informasi') == '1' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="kualitas1">Tidak Baik</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kualitas_informasi"
                                                           id="kualitas2" value="2" {{ old('kualitas_informasi') == '2' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="kualitas2">Kurang Baik</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kualitas_informasi"
                                                           id="kualitas3" value="3" {{ old('kualitas_informasi') == '3' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="kualitas3">Baik</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kualitas_informasi"
                                                           id="kualitas4" value="4" {{ old('kualitas_informasi') == '4' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="kualitas4">Sangat Baik</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Question 3 -->
                                    <div class="survey-question">
                                        <label class="form-label fw-bold fs-6">
                                            3. Kemudahan dalam mengajukan permintaan informasi? <span class="text-danger">*</span>
                                        </label>
                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kemudahan_permintaan"
                                                           id="permintaan1" value="1" {{ old('kemudahan_permintaan') == '1' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="permintaan1">Tidak Mudah</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kemudahan_permintaan"
                                                           id="permintaan2" value="2" {{ old('kemudahan_permintaan') == '2' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permintaan2">Kurang Mudah</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kemudahan_permintaan"
                                                           id="permintaan3" value="3" {{ old('kemudahan_permintaan') == '3' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permintaan3">Mudah</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kemudahan_permintaan"
                                                           id="permintaan4" value="4" {{ old('kemudahan_permintaan') == '4' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permintaan4">Sangat Mudah</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Question 4 -->
                                    <div class="survey-question">
                                        <label class="form-label fw-bold fs-6">
                                            4. Ketepatan waktu dalam menjawab permintaan informasi? <span class="text-danger">*</span>
                                        </label>
                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ketepatan_waktu_jawab"
                                                           id="waktu1" value="1" {{ old('ketepatan_waktu_jawab') == '1' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="waktu1">Tidak Tepat</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ketepatan_waktu_jawab"
                                                           id="waktu2" value="2" {{ old('ketepatan_waktu_jawab') == '2' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="waktu2">Kurang Tepat</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ketepatan_waktu_jawab"
                                                           id="waktu3" value="3" {{ old('ketepatan_waktu_jawab') == '3' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="waktu3">Tepat</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ketepatan_waktu_jawab"
                                                           id="waktu4" value="4" {{ old('ketepatan_waktu_jawab') == '4' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="waktu4">Sangat Tepat</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Question 5 -->
                                    <div class="survey-question">
                                        <label class="form-label fw-bold fs-6">
                                            5. Kelengkapan/kesesuaian informasi yang diberikan dengan permintaan yang diajukan? <span class="text-danger">*</span>
                                        </label>
                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kelengkapan_informasi"
                                                           id="kelengkapan1" value="1" {{ old('kelengkapan_informasi') == '1' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="kelengkapan1">Tidak Sesuai</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kelengkapan_informasi"
                                                           id="kelengkapan2" value="2" {{ old('kelengkapan_informasi') == '2' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="kelengkapan2">Kurang Sesuai</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kelengkapan_informasi"
                                                           id="kelengkapan3" value="3" {{ old('kelengkapan_informasi') == '3' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="kelengkapan3">Sesuai</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kelengkapan_informasi"
                                                           id="kelengkapan4" value="4" {{ old('kelengkapan_informasi') == '4' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="kelengkapan4">Sangat Sesuai</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Question 6 -->
                                    <div class="survey-question">
                                        <label class="form-label fw-bold fs-6">
                                            6. Ketepatan waktu dalam menjawab/menanggapi permintaan informasi? <span class="text-danger">*</span>
                                        </label>
                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ketepatan_tanggap"
                                                           id="tanggap1" value="1" {{ old('ketepatan_tanggap') == '1' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="tanggap1">Tidak Tepat</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ketepatan_tanggap"
                                                           id="tanggap2" value="2" {{ old('ketepatan_tanggap') == '2' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="tanggap2">Kurang Tepat</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ketepatan_tanggap"
                                                           id="tanggap3" value="3" {{ old('ketepatan_tanggap') == '3' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="tanggap3">Tepat</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="ketepatan_tanggap"
                                                           id="tanggap4" value="4" {{ old('ketepatan_tanggap') == '4' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="tanggap4">Sangat Tepat</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Question 7 -->
                                    <div class="survey-question">
                                        <label class="form-label fw-bold fs-6">
                                            7. Pelayanan petugas dalam melayani permintaan informasi? <span class="text-danger">*</span>
                                        </label>
                                        <div class="row mt-3">
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pelayanan_petugas"
                                                           id="pelayanan1" value="1" {{ old('pelayanan_petugas') == '1' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="pelayanan1">Tidak Ramah</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pelayanan_petugas"
                                                           id="pelayanan2" value="2" {{ old('pelayanan_petugas') == '2' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pelayanan2">Kurang Ramah</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pelayanan_petugas"
                                                           id="pelayanan3" value="3" {{ old('pelayanan_petugas') == '3' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pelayanan3">Ramah</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pelayanan_petugas"
                                                           id="pelayanan4" value="4" {{ old('pelayanan_petugas') == '4' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pelayanan4">Sangat Ramah</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Saran dan Masukan -->
                                    <div class="survey-question">
                                        <label for="saran_masukan" class="form-label fw-bold fs-6">
                                            Saran dan masukan yang Membangun
                                        </label>
                                        <textarea class="form-control mt-3" id="saran_masukan" name="saran_masukan"
                                                  rows="4" placeholder="Berikan saran dan masukan Anda untuk meningkatkan pelayanan PPID">{{ old('saran_masukan') }}</textarea>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn-kemenag btn-lg px-5">
                                            <i class="fas fa-paper-plane me-2"></i> KIRIM DATA
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const form = document.getElementById('surveyForm');

        form.addEventListener('submit', function(e) {
            const requiredRadios = [
                'kemudahan_akses_informasi',
                'kualitas_informasi',
                'kemudahan_permintaan',
                'ketepatan_waktu_jawab',
                'kelengkapan_informasi',
                'ketepatan_tanggap',
                'pelayanan_petugas'
            ];

            let allAnswered = true;

            requiredRadios.forEach(function(name) {
                if (!document.querySelector(`input[name="${name}"]:checked`)) {
                    allAnswered = false;
                }
            });

            if (!allAnswered) {
                e.preventDefault();
                alert('Mohon jawab semua pertanyaan survey!');
                return false;
            }

            // Konfirmasi sebelum submit
            if (!confirm('Apakah Anda yakin dengan jawaban yang diberikan?')) {
                e.preventDefault();
                return false;
            }
        });

        // Add animation to questions when in view
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'slideInLeft 0.6s ease-out';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.survey-question').forEach(question => {
            observer.observe(question);
        });
    });
    </script>

    <style>
    @keyframes slideInLeft {
        from {
            transform: translateX(-50px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .fw-bold {
        font-weight: 600 !important;
    }

    .fs-6 {
        font-size: 1.1rem !important;
    }
    </style>
</body>
</html>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #1e5631, #2d8f47);
}

.survey-question {
    border-left: 4px solid #1e5631;
    padding-left: 15px;
    background: rgba(30, 86, 49, 0.05);
    border-radius: 5px;
    padding: 15px;
}

.form-check-input:checked {
    background-color: #1e5631;
    border-color: #1e5631;
}

.btn-primary {
    background: linear-gradient(135deg, #1e5631, #2d8f47);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(30, 86, 49, 0.3);
}
</style>
</body>
</html>
