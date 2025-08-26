<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Survey Berhasil Dikirim - PPID Kementerian Agama Kabupaten Nganjuk">
    <meta name="keywords" content="Survey, PPID, Kemenag, Nganjuk, Sukses">

    <title>Survey Berhasil Dikirim - PPID Kemenag Nganjuk</title>

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

        .success-card {
            background: white;
            border: none;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
            animation: slideInUp 0.8s ease-out;
        }

        .success-header {
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
            padding: 60px 40px 40px;
            text-align: center;
            position: relative;
        }

        .success-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none"><polygon fill="rgba(255,255,255,0.1)" points="1000,100 1000,0 0,0 0,80"/></svg>');
            background-size: cover;
        }

        .success-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            animation: bounceIn 1s ease-out 0.3s both;
        }

        .success-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            animation: fadeInUp 0.8s ease-out 0.5s both;
        }

        .success-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            animation: fadeInUp 0.8s ease-out 0.7s both;
        }

        .success-body {
            padding: 50px 40px;
            text-align: center;
        }

        .info-card {
            background: rgba(30, 86, 49, 0.05);
            border: 1px solid rgba(30, 86, 49, 0.1);
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            animation: fadeInUp 0.8s ease-out 0.9s both;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            animation: slideInLeft 0.6s ease-out calc(1.1s + var(--delay)) both;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 15px;
            font-size: 1.1rem;
        }

        .action-buttons {
            margin-top: 40px;
            animation: fadeInUp 0.8s ease-out 1.3s both;
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

        @keyframes slideInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .celebration {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: var(--kemenag-accent);
            animation: confetti-fall 3s linear infinite;
        }

        @keyframes confetti-fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
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
                    <li class="breadcrumb-item"><a href="{{ route('survey.index') }}">Survey PPID</a></li>
                    <li class="breadcrumb-item active">Survey Berhasil</li>
                </ol>
            </nav>
            <h1><i class="fas fa-check-circle me-3"></i>Survey Berhasil</h1>
            <p class="lead">Terima kasih atas partisipasi Anda dalam survey kepuasan pelayanan PPID</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5">

        <!-- Success Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-card">
                    <!-- Celebration Effect -->
                    <div class="celebration" id="celebration"></div>

                    <!-- Success Header -->
                    <div class="success-header">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h1 class="success-title">SURVEY BERHASIL DIKIRIM!</h1>
                        <p class="success-subtitle">Terima kasih atas partisipasi Anda dalam survey kepuasan pelayanan PPID</p>
                    </div>

                    <!-- Success Body -->
                    <div class="success-body">
                        @if(session('survey_data'))
                        <div class="info-card">
                            <h4 class="text-primary mb-4">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Survey Anda
                            </h4>

                            <div class="info-item" style="--delay: 0s;">
                                <div class="info-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="text-start">
                                    <strong>Nama:</strong> {{ session('survey_data.nama', 'Tidak tersedia') }}
                                </div>
                            </div>

                            <div class="info-item" style="--delay: 0.1s;">
                                <div class="info-icon">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="text-start">
                                    <strong>Waktu Pengisian:</strong> {{ date('d F Y, H:i') }} WIB
                                </div>
                            </div>

                            <div class="info-item" style="--delay: 0.2s;">
                                <div class="info-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="text-start">
                                    <strong>Rating Kepuasan Anda:</strong>
                                    @php
                                        $surveyData = session('survey_data', []);
                                        $averageRating = 0;

                                        if (!empty($surveyData)) {
                                            $ratings = [
                                                $surveyData['kemudahan_akses_informasi'] ?? 0,
                                                $surveyData['kualitas_informasi'] ?? 0,
                                                $surveyData['kemudahan_permintaan'] ?? 0,
                                                $surveyData['ketepatan_waktu_jawab'] ?? 0,
                                                $surveyData['kelengkapan_informasi'] ?? 0,
                                                $surveyData['ketepatan_tanggap'] ?? 0,
                                                $surveyData['pelayanan_petugas'] ?? 0
                                            ];

                                            $totalRatings = array_filter($ratings);
                                            $averageRating = count($totalRatings) > 0 ? array_sum($totalRatings) / count($totalRatings) : 0;
                                        }
                                    @endphp
                                    <span class="text-warning">
                                        {{ number_format($averageRating, 1) }}/4.0
                                        @for($i = 1; $i <= 4; $i++)
                                            @if($i <= round($averageRating))
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </span>
                                </div>
                            </div>

                            <div class="info-item" style="--delay: 0.3s;">
                                <div class="info-icon">
                                    <i class="fas fa-check-double"></i>
                                </div>
                                <div class="text-start">
                                    <strong>Status:</strong>
                                    <span class="badge bg-success fs-6">Berhasil Tersimpan</span>
                                </div>
                            </div>

                            @if(session('survey_data.saran_masukan'))
                            <div class="info-item" style="--delay: 0.4s;">
                                <div class="info-icon">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div class="text-start">
                                    <strong>Saran/Masukan:</strong><br>
                                    <em>"{{ session('survey_data.saran_masukan') }}"</em>
                                </div>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="info-card">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                <h4 class="text-warning mb-3">Data Survey Tidak Ditemukan</h4>
                                <p class="text-muted mb-4">
                                    Sepertinya Anda mengakses halaman ini secara langsung.
                                    Silakan isi survey terlebih dahulu untuk melihat informasi Anda.
                                </p>
                                <a href="{{ route('survey.index') }}" class="btn-kemenag">
                                    <i class="fas fa-clipboard-list me-2"></i> Isi Survey Sekarang
                                </a>
                            </div>
                        </div>
                        @endif

                        @if(session('survey_data'))
                        <div class="alert alert-info">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>Catatan:</strong> Data survey Anda telah tersimpan dengan aman dan akan digunakan untuk meningkatkan kualitas pelayanan PPID Kementerian Agama Kabupaten Nganjuk.
                        </div>

                        <div class="action-buttons">
                            <a href="{{ route('survey.results') }}" class="btn-kemenag me-3">
                                <i class="fas fa-chart-bar me-2"></i> Lihat Hasil Survey
                            </a>
                            <a href="{{ route('survey.index') }}" class="btn btn-outline-primary btn-lg px-4 me-3">
                                <i class="fas fa-plus me-2"></i> Isi Survey Lagi
                            </a>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-home me-2"></i> Kembali ke Beranda
                            </a>
                        </div>

                        <div class="mt-5 pt-4 border-top">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-share-alt me-2"></i> Bagikan Survey Ini
                            </h5>
                            <p class="text-muted mb-3">Ajak teman dan keluarga untuk ikut memberikan penilaian</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="https://wa.me/?text=Ayo%20ikut%20survey%20kepuasan%20pelayanan%20PPID%20Kemenag%20Nganjuk%20di%20{{ urlencode(route('survey.index')) }}"
                                   target="_blank" class="btn btn-success btn-sm">
                                    <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('survey.index')) }}"
                                   target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fab fa-facebook me-1"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('survey.index')) }}&text=Survey%20Kepuasan%20Pelayanan%20PPID%20Kemenag%20Nganjuk"
                                   target="_blank" class="btn btn-info btn-sm">
                                    <i class="fab fa-twitter me-1"></i> Twitter
                                </a>
                            </div>
                        </div>
                        @endif
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
        // Create confetti effect
        function createConfetti() {
            const celebration = document.getElementById('celebration');
            const colors = ['#ffd700', '#1e5631', '#2d8f47', '#198754', '#20c997'];

            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.animationDelay = Math.random() * 3 + 's';
                confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';

                celebration.appendChild(confetti);

                // Remove confetti after animation
                setTimeout(() => {
                    if (confetti.parentNode) {
                        confetti.parentNode.removeChild(confetti);
                    }
                }, 5000);
            }
        }

        // Start confetti effect after page load
        setTimeout(createConfetti, 500);

        // Auto-hide celebration after 10 seconds
        setTimeout(() => {
            const celebration = document.getElementById('celebration');
            if (celebration) {
                celebration.style.display = 'none';
            }
        }, 10000);

        // Copy link functionality
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show temporary success message
                const toast = document.createElement('div');
                toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3';
                toast.setAttribute('role', 'alert');
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-check me-2"></i>Link berhasil disalin!
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;
                document.body.appendChild(toast);

                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();

                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 3000);
            });
        }

        // Add click-to-copy for survey link
        const surveyUrl = "{{ route('survey.index') }}";
        document.addEventListener('click', function(e) {
            if (e.target.closest('[data-copy]')) {
                e.preventDefault();
                copyToClipboard(surveyUrl);
            }
        });
    });
    </script>
</body>
</html>

<style>
.gap-3 {
    gap: 1rem !important;
}

@media (max-width: 576px) {
    .d-flex.gap-3 {
        flex-direction: column;
    }

    .d-flex.gap-3 > * {
        margin-bottom: 0.5rem;
    }
}
</style>
</body>
</html>
