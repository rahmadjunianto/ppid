<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hasil Survey Kepuasan Pelayanan PPID Kementerian Agama Kabupaten Nganjuk">
    <meta name="keywords" content="Survey, PPID, Kemenag, Nganjuk, Hasil, Statistik">

    <title>Hasil Survey PPID - PPID Kemenag Nganjuk</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        .chart-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .card-header-gradient {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 20px;
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

        .rating-bar {
            height: 30px;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }

        .rating-progress {
            height: 100%;
            border-radius: 15px;
            transition: width 1s ease-in-out;
        }

        .rating-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: 600;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .animate-on-scroll.in-view {
            opacity: 1;
            transform: translateY(0);
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
                    <li class="breadcrumb-item active">Hasil Survey</li>
                </ol>
            </nav>
            <h1><i class="fas fa-chart-bar me-3"></i>Hasil Survey</h1>
            <p class="lead">Statistik dan Analisis Survey Kepuasan Pelayanan PPID</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5">

        @if($statistics['total_responden'] > 0)
        <!-- Overview Statistics -->
        <div class="row mb-5 animate-on-scroll">
            <div class="col-12">
                <h3 class="text-center mb-4">Statistik Umum</h3>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stats-card text-center p-4">
                            <i class="fas fa-users stats-icon text-primary"></i>
                            <h3 class="text-primary mb-2">{{ $statistics['total_responden'] }}</h3>
                            <p class="text-muted mb-0">Total Responden</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stats-card text-center p-4">
                            <i class="fas fa-star stats-icon text-warning"></i>
                            <h3 class="text-warning mb-2">{{ number_format($statistics['rata_rata_kepuasan'], 1) }}/4.0</h3>
                            <p class="text-muted mb-0">Rata-rata Kepuasan</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stats-card text-center p-4">
                            <i class="fas fa-percentage stats-icon text-success"></i>
                            <h3 class="text-success mb-2">{{ round(($statistics['rata_rata_kepuasan'] / 4) * 100) }}%</h3>
                            <p class="text-muted mb-0">Tingkat Kepuasan</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stats-card text-center p-4">
                            <i class="fas fa-thumbs-up stats-icon text-info"></i>
                            <h3 class="text-info mb-2">{{ $statistics['distribusi_rating'][3] + $statistics['distribusi_rating'][4] }}</h3>
                            <p class="text-muted mb-0">Responden Puas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Statistics -->
        <div class="row mb-5">
            <!-- Rating Distribution Chart -->
            <div class="col-lg-6 mb-4 animate-on-scroll">
                <div class="chart-card">
                    <div class="card-header-gradient">
                        <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i> Distribusi Rating</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="ratingChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Average Ratings by Question -->
            <div class="col-lg-6 mb-4 animate-on-scroll">
                <div class="chart-card">
                    <div class="card-header-gradient">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Rata-rata per Pertanyaan</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="averageChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Rating Breakdown -->
        <div class="row mb-5 animate-on-scroll">
            <div class="col-12">
                <div class="chart-card">
                    <div class="card-header-gradient">
                        <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i> Detail Rating per Pertanyaan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            @php
                                $questions = [
                                    'kemudahan_akses_informasi' => 'Kemudahan akses informasi PPID pada website',
                                    'kualitas_informasi' => 'Ketersediaan/kualitas informasi terkait layanan informasi PPID',
                                    'kemudahan_permintaan' => 'Kemudahan dalam mengajukan permintaan informasi',
                                    'ketepatan_waktu_jawab' => 'Ketepatan waktu dalam menjawab permintaan informasi',
                                    'kelengkapan_informasi' => 'Kelengkapan/kesesuaian informasi yang diberikan',
                                    'ketepatan_tanggap' => 'Ketepatan waktu dalam menanggapi permintaan informasi',
                                    'pelayanan_petugas' => 'Pelayanan petugas dalam melayani permintaan informasi'
                                ];
                                $colors = ['#dc3545', '#fd7e14', '#ffc107', '#198754'];
                            @endphp

                            @foreach($questions as $key => $question)
                                @php
                                    $avg = $statistics['rata_rata_per_pertanyaan'][$key] ?? 0;
                                    $percentage = ($avg / 4) * 100;
                                @endphp
                                <div class="col-lg-6 mb-4">
                                    <div class="p-3 border rounded-3">
                                        <h6 class="fw-bold mb-3">{{ $loop->iteration }}. {{ $question }}</h6>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Rating:</span>
                                            <span class="fw-bold text-primary">{{ number_format($avg, 1) }}/4.0</span>
                                        </div>
                                        <div class="rating-bar bg-light">
                                            <div class="rating-progress bg-primary"
                                                 style="width: {{ $percentage }}%;
                                                        background: linear-gradient(135deg,
                                                        {{ $percentage >= 75 ? '#198754' : ($percentage >= 50 ? '#ffc107' : '#fd7e14') }},
                                                        {{ $percentage >= 75 ? '#20c997' : ($percentage >= 50 ? '#ffca2c' : '#fd7e14') }});">
                                                <div class="rating-text">{{ round($percentage) }}%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demographics -->
        <div class="row mb-5 animate-on-scroll">
            <div class="col-lg-6 mb-4">
                <div class="chart-card">
                    <div class="card-header-gradient">
                        <h5 class="mb-0"><i class="fas fa-venus-mars me-2"></i> Distribusi Jenis Kelamin</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="genderChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="chart-card">
                    <div class="card-header-gradient">
                        <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i> Distribusi Pendidikan</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="educationChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mb-5 animate-on-scroll">
            <div class="col-12 text-center">
                <a href="{{ route('survey.index') }}" class="btn-kemenag me-3">
                    <i class="fas fa-plus me-2"></i> Isi Survey
                </a>
                <a href="{{ url('/') }}" class="btn btn-outline-primary btn-lg px-4">
                    <i class="fas fa-home me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>

        @else
        <!-- No Data -->
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="chart-card p-5">
                    <i class="fas fa-chart-bar fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Belum Ada Data Survey</h3>
                    <p class="text-muted mb-4">
                        Belum ada responden yang mengisi survey. Jadilah yang pertama untuk memberikan penilaian terhadap pelayanan PPID kami.
                    </p>
                    <a href="{{ route('survey.index') }}" class="btn-kemenag">
                        <i class="fas fa-plus me-2"></i> Isi Survey Sekarang
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if($statistics['total_responden'] > 0)
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const primaryColor = '#1e5631';
        const secondaryColor = '#2d8f47';
        const accentColor = '#ffd700';

        // Rating Distribution Chart
        const ratingCtx = document.getElementById('ratingChart').getContext('2d');
        new Chart(ratingCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tidak Puas (1)', 'Kurang Puas (2)', 'Puas (3)', 'Sangat Puas (4)'],
                datasets: [{
                    data: [
                        {{ $statistics['distribusi_rating'][1] }},
                        {{ $statistics['distribusi_rating'][2] }},
                        {{ $statistics['distribusi_rating'][3] }},
                        {{ $statistics['distribusi_rating'][4] }}
                    ],
                    backgroundColor: ['#dc3545', '#fd7e14', '#ffc107', '#198754'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        // Average Ratings Chart
        const averageCtx = document.getElementById('averageChart').getContext('2d');
        new Chart(averageCtx, {
            type: 'bar',
            data: {
                labels: ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7'],
                datasets: [{
                    label: 'Rata-rata Rating',
                    data: [
                        {{ $statistics['rata_rata_per_pertanyaan']['kemudahan_akses_informasi'] ?? 0 }},
                        {{ $statistics['rata_rata_per_pertanyaan']['kualitas_informasi'] ?? 0 }},
                        {{ $statistics['rata_rata_per_pertanyaan']['kemudahan_permintaan'] ?? 0 }},
                        {{ $statistics['rata_rata_per_pertanyaan']['ketepatan_waktu_jawab'] ?? 0 }},
                        {{ $statistics['rata_rata_per_pertanyaan']['kelengkapan_informasi'] ?? 0 }},
                        {{ $statistics['rata_rata_per_pertanyaan']['ketepatan_tanggap'] ?? 0 }},
                        {{ $statistics['rata_rata_per_pertanyaan']['pelayanan_petugas'] ?? 0 }}
                    ],
                    backgroundColor: `linear-gradient(135deg, ${primaryColor}, ${secondaryColor})`,
                    borderColor: primaryColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 4,
                        ticks: {
                            stepSize: 0.5
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Gender Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [
                        {{ $statistics['distribusi_gender']['Laki-laki'] ?? 0 }},
                        {{ $statistics['distribusi_gender']['Perempuan'] ?? 0 }}
                    ],
                    backgroundColor: [primaryColor, secondaryColor],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20
                        }
                    }
                }
            }
        });

        // Education Chart
        const educationCtx = document.getElementById('educationChart').getContext('2d');
        new Chart(educationCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($statistics['distribusi_pendidikan'])) !!},
                datasets: [{
                    label: 'Jumlah Responden',
                    data: {!! json_encode(array_values($statistics['distribusi_pendidikan'])) !!},
                    backgroundColor: secondaryColor,
                    borderColor: primaryColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Animate progress bars
        setTimeout(() => {
            document.querySelectorAll('.rating-progress').forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        }, 500);

        // Scroll animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-on-scroll').forEach(element => {
            observer.observe(element);
        });
    });
    </script>
    @endif
</body>
</html>

<style>
.fw-bold {
    font-weight: 600 !important;
}

.progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    transition: width 0.6s ease;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.d-grid {
    display: grid !important;
}

.gap-2 {
    gap: 0.5rem !important;
}
</style>
</body>
</html>
