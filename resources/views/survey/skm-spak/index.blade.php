@extends('layouts.app')

@section('content')
<style>
    :root {
        --kemenag-primary: #1e5631;
        --kemenag-secondary: #2d8f47;
        --kemenag-accent: #ffd700;
        --kemenag-light: #f8f9fa;
        --kemenag-dark: #0d2818;
    }

    /* Smart Wizard Customization */
    .wizard-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        margin: 2rem 0;
    }

    .wizard-header {
        background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .wizard-header h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .wizard-steps-container {
        padding: 2rem;
    }

    /* Step Indicator (Stepper) */
    .step-progress {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
        gap: 0.5rem;
    }

    .step-progress-item {
        flex: 1;
        height: 8px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .step-progress-item.active {
        background: linear-gradient(90deg, var(--kemenag-primary), var(--kemenag-secondary));
    }

    .step-indicator {
        text-align: center;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        color: #6c757d;
        font-weight: 500;
    }

    .step-indicator .step-number {
        color: var(--kemenag-primary);
        font-weight: 700;
        font-size: 1.1rem;
    }

    /* Tab Content */
    .form-tab {
        display: none;
        animation: fadeIn 0.3s ease-in;
    }

    .form-tab.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .tab-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--kemenag-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tab-title i {
        font-size: 1.5rem;
    }

    .tab-description {
        color: #6c757d;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    /* Form Groups */
    .form-group-skm {
        background: rgba(30, 86, 49, 0.05);
        border-left: 4px solid var(--kemenag-primary);
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        display: block;
    }

    .form-label .badge {
        margin-left: 0.5rem;
    }

    .form-control {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--kemenag-primary);
        box-shadow: 0 0 0 0.25rem rgba(30, 86, 49, 0.25);
    }

    /* Radio/Checkbox Options */
    .radio-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .radio-option {
        position: relative;
    }

    .radio-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .radio-option label {
        display: block;
        padding: 1rem;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s ease;
        background: white;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .radio-option input[type="radio"]:checked + label {
        border-color: var(--kemenag-primary);
        background: rgba(30, 86, 49, 0.1);
        color: var(--kemenag-primary);
        font-weight: 600;
    }

    .radio-option label:hover {
        border-color: var(--kemenag-secondary);
        box-shadow: 0 4px 12px rgba(45, 143, 71, 0.15);
    }

    /* Intro Tab Styling */
    .intro-content {
        text-align: center;
        padding: 2rem 1rem;
    }

    .intro-icon {
        font-size: 5rem;
        color: var(--kemenag-primary);
        margin-bottom: 1.5rem;
    }

    .intro-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--kemenag-primary);
        margin-bottom: 1.5rem;
    }

    .intro-description {
        font-size: 1rem;
        color: #555;
        line-height: 1.8;
        margin-bottom: 2rem;
        text-align: left;
        background: rgba(30, 86, 49, 0.05);
        padding: 2rem;
        border-radius: 15px;
        border-left: 5px solid var(--kemenag-primary);
    }

    .intro-description p {
        margin-bottom: 1rem;
    }

    .intro-description p:last-child {
        margin-bottom: 0;
    }

    /* Buttons */
    .btn-wizard {
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-next, .btn-finish {
        background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
        color: white;
        border: none;
    }

    .btn-next:hover, .btn-finish:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 86, 49, 0.3);
        color: white;
    }

    .btn-previous {
        background: white;
        color: var(--kemenag-primary);
        border: 2px solid var(--kemenag-primary);
    }

    .btn-previous:hover {
        background: rgba(30, 86, 49, 0.05);
        border-color: var(--kemenag-secondary);
    }

    .btn-wizard:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Navigation */
    .wizard-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 2rem;
        border-top: 1px solid #e9ecef;
        margin-top: 2rem;
        gap: 1rem;
    }

    .wizard-nav-empty {
        flex: 1;
    }

    .wizard-nav-buttons {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    /* Alerts */
    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .alert-danger h6 {
        margin: 0 0 0.5rem 0;
        font-weight: 600;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    .alert-danger li {
        margin-bottom: 0.25rem;
    }

    /* Helper Text */
    .form-text {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #6c757d;
    }

    .form-text.danger {
        color: #dc3545;
    }

    /* Textarea */
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
        font-family: 'Inter', sans-serif;
    }

    /* Error Display */
    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: none;
    }

    .error-message.show {
        display: block;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .radio-group {
            grid-template-columns: 1fr;
        }

        .wizard-header h2 {
            font-size: 1.5rem;
        }

        .tab-title {
            font-size: 1.1rem;
        }

        .wizard-nav {
            flex-direction: column;
        }

        .wizard-nav-buttons {
            width: 100%;
            justify-content: space-between;
        }

        .btn-wizard {
            flex: 1;
        }
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Survey SKM & SPAK</li>
            </ol>
        </nav>
        <h1><i class="fas fa-poll me-3"></i>Survey SKM & SPAK</h1>
        <p class="lead">Survei Kepuasan Masyarakat dan Survei Persepsi Anti Korupsi</p>
    </div>
</div>

<!-- Main Content -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="wizard-container">
                <div class="wizard-header">
                    <h2><i class="fas fa-chart-line me-2"></i>Survey SKM & SPAK</h2>
                </div>

                <div class="wizard-steps-container">
                    <!-- Step Progress Bar -->
                    <div class="step-progress" id="progressBar">
                        <div class="step-progress-item active"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                        <div class="step-progress-item"></div>
                    </div>

                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <span class="step-number" id="currentStep">1</span> dari <span id="totalSteps">23</span>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Terdapat Kesalahan:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Start -->
                    <form action="{{ route('survey.skm-spak.store') }}" method="POST" id="skmspakForm">
                        @csrf

                        <!-- Step 0: Intro -->
                        <div class="form-tab active" data-step="0">
                            <div class="intro-content">
                                <div class="intro-icon">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <h3 class="intro-title">Survei SKM dan SPAK</h3>
                                <div class="intro-description">
                                    <p>Dalam rangka meningkatkan kualitas pelayanan publik di lingkungan Kantor Kementerian Agama Kabupaten Nganjuk, kami mengharapkan partisipasi Bapak/Ibu untuk memberikan pendapat terkait kualitas dan integritas pemberian pelayanan pada satuan kerja ini.</p>
                                    
                                    <p>Pendapat Bapak/Ibu sangat berharga untuk membantu kami melakukan evaluasi dan perbaikan berkelanjutan terhadap sistem dan pelayanan yang ada.</p>

                                    <p>Seluruh data yang terkumpul hanya akan digunakan untuk kepentingan peningkatan mutu layanan.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 1: Jenis Kelamin -->
                        <div class="form-tab" data-step="1">
                            <div class="tab-title">
                                <i class="fas fa-venus-mars"></i> Jenis Kelamin
                            </div>
                            <div class="form-group-skm">
                                <label class="form-label">Jenis Kelamin <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="jk1" name="jenis_kelamin" value="Laki - Laki" {{ old('jenis_kelamin') == 'Laki - Laki' ? 'checked' : '' }} required>
                                        <label for="jk1">Laki - Laki</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="jk2" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                        <label for="jk2">Perempuan</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_jenis_kelamin"></div>
                            </div>
                        </div>

                        <!-- Step 2: Usia -->
                        <div class="form-tab" data-step="2">
                            <div class="tab-title">
                                <i class="fas fa-birthday-cake"></i> Usia
                            </div>
                            <div class="form-group-skm">
                                <label for="usia" class="form-label">Usia <span class="badge bg-danger">Wajib</span></label>
                                <select class="form-control" id="usia" name="usia" required>
                                    <option value="">-- Pilih Usia --</option>
                                    <option value="Kurang dari 20 Tahun" {{ old('usia') == 'Kurang dari 20 Tahun' ? 'selected' : '' }}>Kurang dari 20 Tahun</option>
                                    <option value="21 - 30 Tahun" {{ old('usia') == '21 - 30 Tahun' ? 'selected' : '' }}>21 - 30 Tahun</option>
                                    <option value="31 - 40 Tahun" {{ old('usia') == '31 - 40 Tahun' ? 'selected' : '' }}>31 - 40 Tahun</option>
                                    <option value="41 - 50 Tahun" {{ old('usia') == '41 - 50 Tahun' ? 'selected' : '' }}>41 - 50 Tahun</option>
                                    <option value="51 - 60 Tahun" {{ old('usia') == '51 - 60 Tahun' ? 'selected' : '' }}>51 - 60 Tahun</option>
                                    <option value="Lebih dari 61 Tahun" {{ old('usia') == 'Lebih dari 61 Tahun' ? 'selected' : '' }}>Lebih dari 61 Tahun</option>
                                </select>
                                <div class="error-message" id="err_usia"></div>
                            </div>
                        </div>

                        <!-- Step 3: Pendidikan Terakhir -->
                        <div class="form-tab" data-step="3">
                            <div class="tab-title">
                                <i class="fas fa-graduation-cap"></i> Pendidikan Terakhir
                            </div>
                            <div class="form-group-skm">
                                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir <span class="badge bg-danger">Wajib</span></label>
                                <select class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                                    <option value="">-- Pilih Pendidikan --</option>
                                    <option value="Tidak Tamat SD/MI/Sederajat" {{ old('pendidikan_terakhir') == 'Tidak Tamat SD/MI/Sederajat' ? 'selected' : '' }}>Tidak Tamat SD/MI/Sederajat</option>
                                    <option value="SD/MI/Sederajat" {{ old('pendidikan_terakhir') == 'SD/MI/Sederajat' ? 'selected' : '' }}>SD/MI/Sederajat</option>
                                    <option value="SMP/MTs/Sederajat" {{ old('pendidikan_terakhir') == 'SMP/MTs/Sederajat' ? 'selected' : '' }}>SMP/MTs/Sederajat</option>
                                    <option value="SMA/MA/Sederajat" {{ old('pendidikan_terakhir') == 'SMA/MA/Sederajat' ? 'selected' : '' }}>SMA/MA/Sederajat</option>
                                    <option value="Diploma I/II" {{ old('pendidikan_terakhir') == 'Diploma I/II' ? 'selected' : '' }}>Diploma I/II</option>
                                    <option value="Akademi/Diploma III/S.Muda" {{ old('pendidikan_terakhir') == 'Akademi/Diploma III/S.Muda' ? 'selected' : '' }}>Akademi/Diploma III/S.Muda</option>
                                    <option value="Diploma IV/Strata I" {{ old('pendidikan_terakhir') == 'Diploma IV/Strata I' ? 'selected' : '' }}>Diploma IV/Strata I</option>
                                    <option value="Strata II" {{ old('pendidikan_terakhir') == 'Strata II' ? 'selected' : '' }}>Strata II</option>
                                    <option value="Strata III" {{ old('pendidikan_terakhir') == 'Strata III' ? 'selected' : '' }}>Strata III</option>
                                </select>
                                <div class="error-message" id="err_pendidikan_terakhir"></div>
                            </div>
                        </div>

                        <!-- Step 4: Pekerjaan -->
                        <div class="form-tab" data-step="4">
                            <div class="tab-title">
                                <i class="fas fa-briefcase"></i> Pekerjaan
                            </div>
                            <div class="form-group-skm">
                                <label for="pekerjaan" class="form-label">Pekerjaan <span class="badge bg-danger">Wajib</span></label>
                                <select class="form-control" id="pekerjaan" name="pekerjaan" required>
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <option value="ASN PNS" {{ old('pekerjaan') == 'ASN PNS' ? 'selected' : '' }}>ASN PNS</option>
                                    <option value="ASN PPPK" {{ old('pekerjaan') == 'ASN PPPK' ? 'selected' : '' }}>ASN PPPK</option>
                                    <option value="ASN TNI Polri" {{ old('pekerjaan') == 'ASN TNI Polri' ? 'selected' : '' }}>ASN TNI Polri</option>
                                    <option value="Pegawai/Guru Tidak Tetap" {{ old('pekerjaan') == 'Pegawai/Guru Tidak Tetap' ? 'selected' : '' }}>Pegawai/Guru Tidak Tetap</option>
                                    <option value="Pegawai Swasta/BUMN" {{ old('pekerjaan') == 'Pegawai Swasta/BUMN' ? 'selected' : '' }}>Pegawai Swasta/BUMN</option>
                                    <option value="Wiraswasta" {{ old('pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="Pelajar/Mahasiswa" {{ old('pekerjaan') == 'Pelajar/Mahasiswa' ? 'selected' : '' }}>Pelajar/Mahasiswa</option>
                                    <option value="Belum/Tidak Bekerja" {{ old('pekerjaan') == 'Belum/Tidak Bekerja' ? 'selected' : '' }}>Belum/Tidak Bekerja</option>
                                    <option value="Lainnya" {{ old('pekerjaan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                <div class="error-message" id="err_pekerjaan"></div>
                            </div>
                        </div>

                        <!-- Step 5: Kategori Responden -->
                        <div class="form-tab" data-step="5">
                            <div class="tab-title">
                                <i class="fas fa-user-tag"></i> Kategori Responden
                            </div>
                            <div class="form-group-skm">
                                <label class="form-label">Kategori <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="kat1" name="kategori_responden" value="Internal - Pegawai Kemenag" {{ old('kategori_responden') == 'Internal - Pegawai Kemenag' ? 'checked' : '' }} required>
                                        <label for="kat1">Internal - Pegawai Kemenag</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="kat2" name="kategori_responden" value="Eksternal - Masyarakat Umum" {{ old('kategori_responden') == 'Eksternal - Masyarakat Umum' ? 'checked' : '' }}>
                                        <label for="kat2">Eksternal - Masyarakat Umum</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_kategori_responden"></div>
                            </div>
                        </div>

                        <!-- Step 6: Unit Kerja -->
                        <div class="form-tab" data-step="6">
                            <div class="tab-title">
                                <i class="fas fa-building"></i> Unit Kerja
                            </div>
                            <div class="form-group-skm">
                                <label for="unit_kerja" class="form-label">Unit Kerja <span class="badge bg-danger">Wajib</span></label>
                                <input type="text" class="form-control" id="unit_kerja" name="unit_kerja" placeholder="Contoh: MAN 1 Nganjuk" value="{{ old('unit_kerja') }}" required>
                                <div class="error-message" id="err_unit_kerja"></div>
                            </div>
                        </div>

                        <!-- Step 7: Jabatan -->
                        <div class="form-tab" data-step="7">
                            <div class="tab-title">
                                <i class="fas fa-id-badge"></i> Jabatan
                            </div>
                            <div class="form-group-skm">
                                <label for="jabatan" class="form-label">Jabatan <span class="badge bg-danger">Wajib</span></label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Contoh: Penyuluh" value="{{ old('jabatan') }}" required>
                                <div class="error-message" id="err_jabatan"></div>
                            </div>
                        </div>

                        <!-- Step 8: Jenis Pelayanan -->
                        <div class="form-tab" data-step="8">
                            <div class="tab-title">
                                <i class="fas fa-concierge-bell"></i> Jenis Pelayanan yang Diterima
                            </div>
                            <div class="form-group-skm">
                                <label for="jenis_pelayanan" class="form-label">Jenis Pelayanan yang Diterima <span class="badge bg-danger">Wajib</span></label>
                                <select class="form-control" id="jenis_pelayanan" name="jenis_pelayanan" required>
                                    <option value="">-- Pilih Jenis Pelayanan --</option>
                                    <option value="Humas" {{ old('jenis_pelayanan') == 'Humas' ? 'selected' : '' }}>Humas</option>
                                    <option value="Kepegawaian" {{ old('jenis_pelayanan') == 'Kepegawaian' ? 'selected' : '' }}>Kepegawaian</option>
                                    <option value="Keuangan" {{ old('jenis_pelayanan') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                                    <option value="PTSP" {{ old('jenis_pelayanan') == 'PTSP' ? 'selected' : '' }}>PTSP</option>
                                    <option value="Umum" {{ old('jenis_pelayanan') == 'Umum' ? 'selected' : '' }}>Umum</option>
                                    <option value="Bimbingan Masyarakat Islam" {{ old('jenis_pelayanan') == 'Bimbingan Masyarakat Islam' ? 'selected' : '' }}>Bimbingan Masyarakat Islam</option>
                                    <option value="Pendidikan Agama Islam" {{ old('jenis_pelayanan') == 'Pendidikan Agama Islam' ? 'selected' : '' }}>Pendidikan Agama Islam</option>
                                    <option value="Pendidikan Diniyah dan Pondok Pesantren" {{ old('jenis_pelayanan') == 'Pendidikan Diniyah dan Pondok Pesantren' ? 'selected' : '' }}>Pendidikan Diniyah dan Pondok Pesantren</option>
                                    <option value="Pendidikan Madrasah" {{ old('jenis_pelayanan') == 'Pendidikan Madrasah' ? 'selected' : '' }}>Pendidikan Madrasah</option>
                                    <option value="Zakat dan Wakaf" {{ old('jenis_pelayanan') == 'Zakat dan Wakaf' ? 'selected' : '' }}>Zakat dan Wakaf</option>
                                </select>
                                <div class="error-message" id="err_jenis_pelayanan"></div>
                            </div>
                        </div>

                        <!-- UNSUR SKM (Steps 9-17) -->
                        <!-- Step 9: U1 Persyaratan -->
                        <div class="form-tab" data-step="9">
                            <div class="tab-title">
                                <i class="fas fa-list-check"></i> Unsur SKM - Persyaratan
                            </div>
                            <div class="tab-description">Persyaratan pelayanan yang diinformasikan sesuai dengan persyaratan yang ditetapkan unit layanan ini</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="u1_1" name="u1_persyaratan" value="1" {{ old('u1_persyaratan') == '1' ? 'checked' : '' }} required>
                                        <label for="u1_1"><strong>1</strong><br>Tidak Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u1_2" name="u1_persyaratan" value="2" {{ old('u1_persyaratan') == '2' ? 'checked' : '' }}>
                                        <label for="u1_2"><strong>2</strong><br>Kurang Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u1_3" name="u1_persyaratan" value="3" {{ old('u1_persyaratan') == '3' ? 'checked' : '' }}>
                                        <label for="u1_3"><strong>3</strong><br>Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u1_4" name="u1_persyaratan" value="4" {{ old('u1_persyaratan') == '4' ? 'checked' : '' }}>
                                        <label for="u1_4"><strong>4</strong><br>Sangat Sesuai</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_u1_persyaratan"></div>
                            </div>
                        </div>

                        <!-- Step 10: U2 Prosedur -->
                        <div class="form-tab" data-step="10">
                            <div class="tab-title">
                                <i class="fas fa-wave-square"></i> Unsur SKM - Prosedur
                            </div>
                            <div class="tab-description">Informasi mengenai prosedur/alur pelayanan mudah dipahami dan diikuti serta tersedia dalam media elektronik maupun non-elektronik</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="u2_1" name="u2_prosedur" value="1" {{ old('u2_prosedur') == '1' ? 'checked' : '' }} required>
                                        <label for="u2_1"><strong>1</strong><br>Tidak Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u2_2" name="u2_prosedur" value="2" {{ old('u2_prosedur') == '2' ? 'checked' : '' }}>
                                        <label for="u2_2"><strong>2</strong><br>Kurang Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u2_3" name="u2_prosedur" value="3" {{ old('u2_prosedur') == '3' ? 'checked' : '' }}>
                                        <label for="u2_3"><strong>3</strong><br>Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u2_4" name="u2_prosedur" value="4" {{ old('u2_prosedur') == '4' ? 'checked' : '' }}>
                                        <label for="u2_4"><strong>4</strong><br>Sangat Sesuai</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_u2_prosedur"></div>
                            </div>
                        </div>

                        <!-- Step 11: U3 Waktu Pelayanan -->
                        <div class="form-tab" data-step="11">
                            <div class="tab-title">
                                <i class="fas fa-clock"></i> Unsur SKM - Waktu Pelayanan
                            </div>
                            <div class="tab-description">Jangka waktu penyelesaian pelayanan yang diterima Bapak/Ibu sesuai dengan yang ditetapkan unit layanan ini</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="u3_1" name="u3_waktu_pelayanan" value="1" {{ old('u3_waktu_pelayanan') == '1' ? 'checked' : '' }} required>
                                        <label for="u3_1"><strong>1</strong><br>Tidak Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u3_2" name="u3_waktu_pelayanan" value="2" {{ old('u3_waktu_pelayanan') == '2' ? 'checked' : '' }}>
                                        <label for="u3_2"><strong>2</strong><br>Kurang Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u3_3" name="u3_waktu_pelayanan" value="3" {{ old('u3_waktu_pelayanan') == '3' ? 'checked' : '' }}>
                                        <label for="u3_3"><strong>3</strong><br>Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u3_4" name="u3_waktu_pelayanan" value="4" {{ old('u3_waktu_pelayanan') == '4' ? 'checked' : '' }}>
                                        <label for="u3_4"><strong>4</strong><br>Sangat Sesuai</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_u3_waktu_pelayanan"></div>
                            </div>
                        </div>

                        <!-- Step 12: U4 Biaya Tarif -->
                        <div class="form-tab" data-step="12">
                            <div class="tab-title">
                                <i class="fas fa-money-bill"></i> Unsur SKM - Biaya/Tarif
                            </div>
                            <div class="tab-description">Tarif/biaya pelayanan yang dibayarkan pada unit layanan ini sesuai dengan tarif/biaya yang ditetapkan</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="u4_1" name="u4_biaya_tarif" value="1" {{ old('u4_biaya_tarif') == '1' ? 'checked' : '' }} required>
                                        <label for="u4_1"><strong>1</strong><br>Tidak Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u4_2" name="u4_biaya_tarif" value="2" {{ old('u4_biaya_tarif') == '2' ? 'checked' : '' }}>
                                        <label for="u4_2"><strong>2</strong><br>Kurang Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u4_3" name="u4_biaya_tarif" value="3" {{ old('u4_biaya_tarif') == '3' ? 'checked' : '' }}>
                                        <label for="u4_3"><strong>3</strong><br>Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u4_4" name="u4_biaya_tarif" value="4" {{ old('u4_biaya_tarif') == '4' ? 'checked' : '' }}>
                                        <label for="u4_4"><strong>4</strong><br>Sangat Sesuai</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_u4_biaya_tarif"></div>
                            </div>
                        </div>

                        <!-- Step 13: U5 Hasil Pelayanan -->
                        <div class="form-tab" data-step="13">
                            <div class="tab-title">
                                <i class="fas fa-check-circle"></i> Unsur SKM - Hasil Pelayanan
                            </div>
                            <div class="tab-description">Hasil pelayanan yang Bapak/Ibu terima pada unit layanan ini sesuai dengan ketentuan yang ditetapkan</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="u5_1" name="u5_hasil_pelayanan" value="1" {{ old('u5_hasil_pelayanan') == '1' ? 'checked' : '' }} required>
                                        <label for="u5_1"><strong>1</strong><br>Tidak Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u5_2" name="u5_hasil_pelayanan" value="2" {{ old('u5_hasil_pelayanan') == '2' ? 'checked' : '' }}>
                                        <label for="u5_2"><strong>2</strong><br>Kurang Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u5_3" name="u5_hasil_pelayanan" value="3" {{ old('u5_hasil_pelayanan') == '3' ? 'checked' : '' }}>
                                        <label for="u5_3"><strong>3</strong><br>Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u5_4" name="u5_hasil_pelayanan" value="4" {{ old('u5_hasil_pelayanan') == '4' ? 'checked' : '' }}>
                                        <label for="u5_4"><strong>4</strong><br>Sangat Sesuai</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_u5_hasil_pelayanan"></div>
                            </div>
                        </div>

                        <!-- Step 14: U6 Kompetensi Petugas -->
                        <div class="form-tab" data-step="14">
                            <div class="tab-title">
                                <i class="fas fa-user-tie"></i> Unsur SKM - Kompetensi Petugas
                            </div>
                            <div class="tab-description">Petugas pelayanan memiliki pengetahuan dan keahlian sesuai dengan jenis layanan yang Bapak/Ibu butuhkan pada unit layanan ini</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="u6_1" name="u6_kompetensi_petugas" value="1" {{ old('u6_kompetensi_petugas') == '1' ? 'checked' : '' }} required>
                                        <label for="u6_1"><strong>1</strong><br>Tidak Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u6_2" name="u6_kompetensi_petugas" value="2" {{ old('u6_kompetensi_petugas') == '2' ? 'checked' : '' }}>
                                        <label for="u6_2"><strong>2</strong><br>Kurang Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u6_3" name="u6_kompetensi_petugas" value="3" {{ old('u6_kompetensi_petugas') == '3' ? 'checked' : '' }}>
                                        <label for="u6_3"><strong>3</strong><br>Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u6_4" name="u6_kompetensi_petugas" value="4" {{ old('u6_kompetensi_petugas') == '4' ? 'checked' : '' }}>
                                        <label for="u6_4"><strong>4</strong><br>Sangat Sesuai</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_u6_kompetensi_petugas"></div>
                            </div>
                        </div>

                        <!-- Step 15: U7 Perilaku Petugas -->
                        <div class="form-tab" data-step="15">
                            <div class="tab-title">
                                <i class="fas fa-handshake"></i> Unsur SKM - Perilaku Petugas
                            </div>
                            <div class="tab-description">Petugas pelayanan pada unit layanan ini melayani keperluan Bapak/Ibu dengan sopan dan ramah</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="u7_1" name="u7_perilaku_petugas" value="1" {{ old('u7_perilaku_petugas') == '1' ? 'checked' : '' }} required>
                                        <label for="u7_1"><strong>1</strong><br>Tidak Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u7_2" name="u7_perilaku_petugas" value="2" {{ old('u7_perilaku_petugas') == '2' ? 'checked' : '' }}>
                                        <label for="u7_2"><strong>2</strong><br>Kurang Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u7_3" name="u7_perilaku_petugas" value="3" {{ old('u7_perilaku_petugas') == '3' ? 'checked' : '' }}>
                                        <label for="u7_3"><strong>3</strong><br>Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u7_4" name="u7_perilaku_petugas" value="4" {{ old('u7_perilaku_petugas') == '4' ? 'checked' : '' }}>
                                        <label for="u7_4"><strong>4</strong><br>Sangat Sesuai</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_u7_perilaku_petugas"></div>
                            </div>
                        </div>

                        <!-- Step 16: U8 Pengaduan -->
                        <div class="form-tab" data-step="16">
                            <div class="tab-title">
                                <i class="fas fa-phone"></i> Unsur SKM - Layanan Pengaduan
                            </div>
                            <div class="tab-description">Layanan konsultasi dan pengaduan yang disediakan unit layanan ini mudah digunakan/diakses</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="u8_1" name="u8_pengaduan" value="1" {{ old('u8_pengaduan') == '1' ? 'checked' : '' }} required>
                                        <label for="u8_1"><strong>1</strong><br>Tidak Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u8_2" name="u8_pengaduan" value="2" {{ old('u8_pengaduan') == '2' ? 'checked' : '' }}>
                                        <label for="u8_2"><strong>2</strong><br>Kurang Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u8_3" name="u8_pengaduan" value="3" {{ old('u8_pengaduan') == '3' ? 'checked' : '' }}>
                                        <label for="u8_3"><strong>3</strong><br>Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u8_4" name="u8_pengaduan" value="4" {{ old('u8_pengaduan') == '4' ? 'checked' : '' }}>
                                        <label for="u8_4"><strong>4</strong><br>Sangat Sesuai</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_u8_pengaduan"></div>
                            </div>
                        </div>

                        <!-- Step 17: U9 Sarana Prasarana -->
                        <div class="form-tab" data-step="17">
                            <div class="tab-title">
                                <i class="fas fa-building"></i> Unsur SKM - Sarana & Prasarana
                            </div>
                            <div class="tab-description">Sarana dan prasarana pendukung pelayanan/sistem pelayanan online yang disediakan unit layanan ini memberikan kemudahan/mudah digunakan</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="u9_1" name="u9_sarana_prasarana" value="1" {{ old('u9_sarana_prasarana') == '1' ? 'checked' : '' }} required>
                                        <label for="u9_1"><strong>1</strong><br>Tidak Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u9_2" name="u9_sarana_prasarana" value="2" {{ old('u9_sarana_prasarana') == '2' ? 'checked' : '' }}>
                                        <label for="u9_2"><strong>2</strong><br>Kurang Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u9_3" name="u9_sarana_prasarana" value="3" {{ old('u9_sarana_prasarana') == '3' ? 'checked' : '' }}>
                                        <label for="u9_3"><strong>3</strong><br>Sesuai</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="u9_4" name="u9_sarana_prasarana" value="4" {{ old('u9_sarana_prasarana') == '4' ? 'checked' : '' }}>
                                        <label for="u9_4"><strong>4</strong><br>Sangat Sesuai</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_u9_sarana_prasarana"></div>
                            </div>
                        </div>

                        <!-- UNSUR SPAK (Steps 18-22) -->
                        <!-- Step 18: I1 Tidak Diskriminatif -->
                        <div class="form-tab" data-step="18">
                            <div class="tab-title">
                                <i class="fas fa-balance-scale"></i> SPAK - Tidak Ada Diskriminasi
                            </div>
                            <div class="tab-description">Tidak ada diskriminasi pelayanan pada unit layanan ini</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="i1_1" name="i1_tidak_diskriminatif" value="1" {{ old('i1_tidak_diskriminatif') == '1' ? 'checked' : '' }} required>
                                        <label for="i1_1"><strong>1</strong><br>Ada</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i1_2" name="i1_tidak_diskriminatif" value="2" {{ old('i1_tidak_diskriminatif') == '2' ? 'checked' : '' }}>
                                        <label for="i1_2"><strong>2</strong><br>Jarang</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i1_3" name="i1_tidak_diskriminatif" value="3" {{ old('i1_tidak_diskriminatif') == '3' ? 'checked' : '' }}>
                                        <label for="i1_3"><strong>3</strong><br>Sangat Jarang</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i1_4" name="i1_tidak_diskriminatif" value="4" {{ old('i1_tidak_diskriminatif') == '4' ? 'checked' : '' }}>
                                        <label for="i1_4"><strong>4</strong><br>Tidak Ada</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_i1_tidak_diskriminatif"></div>
                            </div>
                        </div>

                        <!-- Step 19: I2 Tidak Curang -->
                        <div class="form-tab" data-step="19">
                            <div class="tab-title">
                                <i class="fas fa-shield-alt"></i> SPAK - Tidak Ada Kecurangan
                            </div>
                            <div class="tab-description">Tidak ada pelayanan diluar prosedur/kecurangan pelayanan pada unit layanan ini</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="i2_1" name="i2_tidak_curang" value="1" {{ old('i2_tidak_curang') == '1' ? 'checked' : '' }} required>
                                        <label for="i2_1"><strong>1</strong><br>Ada</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i2_2" name="i2_tidak_curang" value="2" {{ old('i2_tidak_curang') == '2' ? 'checked' : '' }}>
                                        <label for="i2_2"><strong>2</strong><br>Jarang</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i2_3" name="i2_tidak_curang" value="3" {{ old('i2_tidak_curang') == '3' ? 'checked' : '' }}>
                                        <label for="i2_3"><strong>3</strong><br>Sangat Jarang</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i2_4" name="i2_tidak_curang" value="4" {{ old('i2_tidak_curang') == '4' ? 'checked' : '' }}>
                                        <label for="i2_4"><strong>4</strong><br>Tidak Ada</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_i2_tidak_curang"></div>
                            </div>
                        </div>

                        <!-- Step 20: I3 Tidak Imbalan -->
                        <div class="form-tab" data-step="20">
                            <div class="tab-title">
                                <i class="fas fa-hand-holding-usd"></i> SPAK - Tidak Ada Imbalan
                            </div>
                            <div class="tab-description">Tidak ada penerimaan imbalan/uang/barang/fasilitas diluar ketentuan yang berlaku pada unit layanan ini</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="i3_1" name="i3_tidak_imbalan" value="1" {{ old('i3_tidak_imbalan') == '1' ? 'checked' : '' }} required>
                                        <label for="i3_1"><strong>1</strong><br>Ada</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i3_2" name="i3_tidak_imbalan" value="2" {{ old('i3_tidak_imbalan') == '2' ? 'checked' : '' }}>
                                        <label for="i3_2"><strong>2</strong><br>Jarang</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i3_3" name="i3_tidak_imbalan" value="3" {{ old('i3_tidak_imbalan') == '3' ? 'checked' : '' }}>
                                        <label for="i3_3"><strong>3</strong><br>Sangat Jarang</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i3_4" name="i3_tidak_imbalan" value="4" {{ old('i3_tidak_imbalan') == '4' ? 'checked' : '' }}>
                                        <label for="i3_4"><strong>4</strong><br>Tidak Ada</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_i3_tidak_imbalan"></div>
                            </div>
                        </div>

                        <!-- Step 21: I4 Tidak Percaloan -->
                        <div class="form-tab" data-step="21">
                            <div class="tab-title">
                                <i class="fas fa-users-slash"></i> SPAK - Tidak Ada Percaloan
                            </div>
                            <div class="tab-description">Tidak ada percaloan/perantara tidak resmi pada unit layanan ini</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="i4_1" name="i4_tidak_percaloan" value="1" {{ old('i4_tidak_percaloan') == '1' ? 'checked' : '' }} required>
                                        <label for="i4_1"><strong>1</strong><br>Ada</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i4_2" name="i4_tidak_percaloan" value="2" {{ old('i4_tidak_percaloan') == '2' ? 'checked' : '' }}>
                                        <label for="i4_2"><strong>2</strong><br>Jarang</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i4_3" name="i4_tidak_percaloan" value="3" {{ old('i4_tidak_percaloan') == '3' ? 'checked' : '' }}>
                                        <label for="i4_3"><strong>3</strong><br>Sangat Jarang</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i4_4" name="i4_tidak_percaloan" value="4" {{ old('i4_tidak_percaloan') == '4' ? 'checked' : '' }}>
                                        <label for="i4_4"><strong>4</strong><br>Tidak Ada</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_i4_tidak_percaloan"></div>
                            </div>
                        </div>

                        <!-- Step 22: I5 Tidak Pungli -->
                        <div class="form-tab" data-step="22">
                            <div class="tab-title">
                                <i class="fas fa-ban"></i> SPAK - Tidak Ada Pungli
                            </div>
                            <div class="tab-description">Tidak ada pungutan liar (pungli) pada unit layanan ini. Pungli bisa dikamuflasekan melalui beberapa istilah seperti "uang administrasi", "uang rokok", "uang terima kasih", dsb.</div>
                            <div class="form-group-skm">
                                <label class="form-label">Pilih jawaban Anda <span class="badge bg-danger">Wajib</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" id="i5_1" name="i5_tidak_pungli" value="1" {{ old('i5_tidak_pungli') == '1' ? 'checked' : '' }} required>
                                        <label for="i5_1"><strong>1</strong><br>Ada</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i5_2" name="i5_tidak_pungli" value="2" {{ old('i5_tidak_pungli') == '2' ? 'checked' : '' }}>
                                        <label for="i5_2"><strong>2</strong><br>Jarang</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i5_3" name="i5_tidak_pungli" value="3" {{ old('i5_tidak_pungli') == '3' ? 'checked' : '' }}>
                                        <label for="i5_3"><strong>3</strong><br>Sangat Jarang</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" id="i5_4" name="i5_tidak_pungli" value="4" {{ old('i5_tidak_pungli') == '4' ? 'checked' : '' }}>
                                        <label for="i5_4"><strong>4</strong><br>Tidak Ada</label>
                                    </div>
                                </div>
                                <div class="error-message" id="err_i5_tidak_pungli"></div>
                            </div>
                        </div>

                        <!-- Step 23: Kritik & Saran -->
                        <div class="form-tab" data-step="23">
                            <div class="tab-title">
                                <i class="fas fa-comments"></i> Kritik & Saran
                            </div>
                            <div class="tab-description">Masukkan kritik dan saran Anda untuk perbaikan layanan kami</div>
                            <div class="form-group-skm">
                                <label for="kritik_saran" class="form-label">Kritik / Saran <span class="badge bg-secondary">Opsional</span></label>
                                <textarea class="form-control" id="kritik_saran" name="kritik_saran" placeholder="Tulis kritik atau saran Anda di sini..." rows="4">{{ old('kritik_saran') }}</textarea>
                                <small class="form-text">Maksimal 1000 karakter</small>
                                <div class="error-message" id="err_kritik_saran"></div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="wizard-nav">
                            <div class="wizard-nav-empty"></div>
                            <div class="wizard-nav-buttons">
                                <button type="button" class="btn btn-wizard btn-previous" id="btnPrevious" onclick="previousStep()" style="display: none;">
                                    <i class="fas fa-chevron-left me-2"></i> Sebelumnya
                                </button>
                                <button type="button" class="btn btn-wizard btn-next" id="btnNext" onclick="nextStep()">
                                    Mulai <i class="fas fa-chevron-right ms-2"></i>
                                </button>
                                <button type="submit" class="btn btn-wizard btn-finish" id="btnFinish" style="display: none;">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStep = 0;
    const totalSteps = 24; // 0-24

    const dynamicFields = {
        1: ['jenis_kelamin'],
        2: ['usia'],
        3: ['pendidikan_terakhir'],
        4: ['pekerjaan'],
        5: ['kategori_responden'],
        6: ['unit_kerja'],
        7: ['jabatan'],
        8: ['jenis_pelayanan'],
        9: ['u1_persyaratan'],
        10: ['u2_prosedur'],
        11: ['u3_waktu_pelayanan'],
        12: ['u4_biaya_tarif'],
        13: ['u5_hasil_pelayanan'],
        14: ['u6_kompetensi_petugas'],
        15: ['u7_perilaku_petugas'],
        16: ['u8_pengaduan'],
        17: ['u9_sarana_prasarana'],
        18: ['i1_tidak_diskriminatif'],
        19: ['i2_tidak_curang'],
        20: ['i3_tidak_imbalan'],
        21: ['i4_tidak_percaloan'],
        22: ['i5_tidak_pungli'],
        23: ['kritik_saran'],
    };

    function showStep(step) {
        // Hide all tabs
        document.querySelectorAll('.form-tab').forEach(tab => {
            tab.classList.remove('active');
        });

        // Show current tab
        document.querySelectorAll('.form-tab')[step].classList.add('active');

        // Update progress bar
        updateProgress();

        // Update buttons
        updateButtons();

        // Update step indicator
        document.getElementById('currentStep').textContent = step;
        document.getElementById('totalSteps').textContent = totalSteps;
    }

    function nextStep() {
        if (currentStep < totalSteps - 1) {
            // Check if current step requires validation
            if (dynamicFields[currentStep]) {
                if (!validateStep(currentStep)) {
                    return;
                }
            }
            currentStep++;
            showStep(currentStep);
        }
    }

    function previousStep() {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    }

    function validateStep(step) {
        const fields = dynamicFields[step];
        let isValid = true;

        fields.forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (!field) return;

            let fieldValue = '';
            if (field.type === 'radio' || field.type === 'checkbox') {
                fieldValue = document.querySelector(`[name="${fieldName}"]:checked`) ? true : false;
            } else {
                fieldValue = field.value.trim();
            }

            if (!fieldValue) {
                isValid = false;
                showError(fieldName, 'Field ini harus diisi');
                field.classList.add('is-invalid');
            } else {
                clearError(fieldName);
                field.classList.remove('is-invalid');
            }
        });

        return isValid;
    }

    function showError(fieldName, message) {
        const errorElement = document.getElementById(`err_${fieldName}`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.add('show');
        }
    }

    function clearError(fieldName) {
        const errorElement = document.getElementById(`err_${fieldName}`);
        if (errorElement) {
            errorElement.textContent = '';
            errorElement.classList.remove('show');
        }
    }

    function updateProgress() {
        const items = document.querySelectorAll('.step-progress-item');
        items.forEach((item, index) => {
            if (index <= currentStep) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    function updateButtons() {
        const btnPrevious = document.getElementById('btnPrevious');
        const btnNext = document.getElementById('btnNext');
        const btnFinish = document.getElementById('btnFinish');

        if (currentStep === 0) {
            btnPrevious.style.display = 'none';
            btnNext.style.display = 'block';
            btnNext.textContent = 'Mulai';
            btnFinish.style.display = 'none';
        } else if (currentStep === totalSteps - 1) {
            btnPrevious.style.display = 'block';
            btnNext.style.display = 'none';
            btnFinish.style.display = 'block';
        } else {
            btnPrevious.style.display = 'block';
            btnNext.style.display = 'block';
            btnNext.innerHTML = 'Selanjutnya <i class="fas fa-chevron-right ms-2"></i>';
            btnFinish.style.display = 'none';
        }
    }

    // Prevent form submission on Enter key
    document.getElementById('skmspakForm').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
            nextStep();
        }
    });

    // Initialize
    showStep(0);
</script>
@endsection
