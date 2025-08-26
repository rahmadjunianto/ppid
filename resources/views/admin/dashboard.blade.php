@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    @php
        $totalSurveys = \App\Models\Survey::count();
        $todaySurveys = \App\Models\Survey::whereDate('created_at', today())->count();
        $thisWeekSurveys = \App\Models\Survey::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $thisMonthSurveys = \App\Models\Survey::whereMonth('created_at', now()->month)->count();

        $statistics = \App\Models\Survey::getStatistics();
        $avgRating = isset($statistics['rata_rata_kepuasan']) ? number_format($statistics['rata_rata_kepuasan'], 2) : '0.00';

        // Chart data
        $last7Days = collect();
        for($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = \App\Models\Survey::whereDate('created_at', $date)->count();
            $last7Days->push([
                'date' => $date->format('d/m'),
                'count' => $count
            ]);
        }
    @endphp

    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-poll"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Survey</span>
                    <span class="info-box-number">{{ number_format($totalSurveys) }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-day"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Hari Ini</span>
                    <span class="info-box-number">{{ $todaySurveys }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-week"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Minggu Ini</span>
                    <span class="info-box-number">{{ $thisWeekSurveys }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-star"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Rating Rata-rata</span>
                    <span class="info-box-number">{{ $avgRating }}/4</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts row -->
    <div class="row">
        <div class="col-md-8">
            <!-- Survey Chart -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Survey 7 Hari Terakhir
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="surveyChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Demographics Chart -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Demografi Responden
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="genderChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Surveys -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-1"></i>
                        Survey Terbaru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.surveys.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-eye"></i> Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Umur</th>
                                <th>Pendidikan</th>
                                <th>Rating Rata-rata</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $recentSurveys = \App\Models\Survey::latest()->take(10)->get();
                            @endphp
                            @forelse($recentSurveys as $survey)
                            <tr>
                                <td>{{ $survey->nama }}</td>
                                <td>
                                    <span class="badge badge-{{ $survey->jenis_kelamin == 'Laki-laki' ? 'primary' : 'danger' }}">
                                        {{ $survey->jenis_kelamin }}
                                    </span>
                                </td>
                                <td>{{ $survey->umur }} tahun</td>
                                <td>{{ $survey->pendidikan }}</td>
                                <td>
                                    @php
                                        $avgSurveyRating = collect([
                                            $survey->kepuasan_layanan,
                                            $survey->kemudahan_akses,
                                            $survey->kecepatan_respon,
                                            $survey->kejelasan_informasi,
                                            $survey->keramahan_petugas,
                                            $survey->fasilitas_layanan,
                                            $survey->kepuasan_keseluruhan
                                        ])->avg();
                                    @endphp
                                    <span class="badge badge-success">{{ number_format($avgSurveyRating, 1) }}/4</span>
                                </td>
                                <td>{{ $survey->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.surveys.show', $survey->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data survey</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Analysis -->
    <div class="row">
        <div class="col-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Analisis Rating per Kategori
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="ratingChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
$(document).ready(function() {
    // Survey 7 Days Chart
    var ctx1 = document.getElementById('surveyChart').getContext('2d');
    var surveyChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: {!! json_encode($last7Days->pluck('date')) !!},
            datasets: [{
                label: 'Survey per Hari',
                data: {!! json_encode($last7Days->pluck('count')) !!},
                borderColor: '#1e5631',
                backgroundColor: 'rgba(30, 86, 49, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gender Chart
    var ctx2 = document.getElementById('genderChart').getContext('2d');
    var genderChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [
                    {{ $statistics['distribusi_gender']['Laki-laki'] ?? 0 }},
                    {{ $statistics['distribusi_gender']['Perempuan'] ?? 0 }}
                ],
                backgroundColor: ['#007bff', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Rating Chart
    var ctx3 = document.getElementById('ratingChart').getContext('2d');
    var ratingChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: [
                'Kemudahan Akses Informasi',
                'Kualitas Informasi',
                'Kemudahan Permintaan',
                'Ketepatan Waktu Jawab',
                'Kelengkapan Informasi',
                'Ketepatan Tanggap',
                'Pelayanan Petugas'
            ],
            datasets: [{
                label: 'Rating Rata-rata',
                data: [
                    {{ $statistics['rata_rata_per_pertanyaan']['kemudahan_akses_informasi'] ?? 0 }},
                    {{ $statistics['rata_rata_per_pertanyaan']['kualitas_informasi'] ?? 0 }},
                    {{ $statistics['rata_rata_per_pertanyaan']['kemudahan_permintaan'] ?? 0 }},
                    {{ $statistics['rata_rata_per_pertanyaan']['ketepatan_waktu_jawab'] ?? 0 }},
                    {{ $statistics['rata_rata_per_pertanyaan']['kelengkapan_informasi'] ?? 0 }},
                    {{ $statistics['rata_rata_per_pertanyaan']['ketepatan_tanggap'] ?? 0 }},
                    {{ $statistics['rata_rata_per_pertanyaan']['pelayanan_petugas'] ?? 0 }}
                ],
                backgroundColor: [
                    '#1e5631', '#2d8f47', '#28a745', '#20c997',
                    '#17a2b8', '#007bff', '#6f42c1'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 4,
                    ticks: {
                        stepSize: 0.5
                    }
                }
            }
        }
    });
});
</script>
@endpush

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Survey Hari Ini</span>
                            <span class="info-box-number">
                                @php
                                    $todaySurveys = \App\Models\Survey::whereDate('created_at', today())->count();
                                @endphp
                                {{ $todaySurveys }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main row -->
            <div class="row">
                <!-- Quick Actions -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('admin.surveys.index') }}" class="btn btn-primary btn-block">
                                        <i class="fas fa-list"></i> Lihat Data Survey
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <a href="{{ route('survey.index') }}" target="_blank" class="btn btn-warning btn-block">
                                        <i class="fas fa-external-link-alt"></i> Lihat Survey
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Surveys -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Survey Terbaru</h3>
                        </div>
                        <div class="card-body">
                            @php
                                $recentSurveys = \App\Models\Survey::latest()->take(5)->get();
                            @endphp

                            @if($recentSurveys->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Rating</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentSurveys as $survey)
                                        <tr>
                                            <td>{{ Str::limit($survey->nama, 20) }}</td>
                                            <td>
                                                <span class="badge badge-{{ $survey->getAverageRating() >= 3 ? 'success' : 'warning' }}">
                                                    {{ number_format($survey->getAverageRating(), 1) }}
                                                </span>
                                            </td>
                                            <td>{{ $survey->created_at->format('d/m H:i') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <p class="text-muted text-center">Belum ada survey.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Selamat Datang</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Informasi!</h5>
                                Selamat datang di panel admin PPID Kemenag Nganjuk. Gunakan menu di sebelah kiri untuk mengelola data survey.
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Fitur yang Tersedia:</h6>
                                    <ul>
                                        <li>Kelola data survey responden</li>
                                        <li>Lihat statistik dan analisis</li>
                                        <li>Export data ke format CSV</li>
                                        <li>Monitor tingkat kepuasan</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Link Berguna:</h6>
                                    <ul>
                                        <li><a href="{{ route('survey.index') }}" target="_blank">Form Survey Public</a></li>
                                        <li><a href="{{ route('survey.results') }}" target="_blank">Hasil Survey Public</a></li>
                                        <li><a href="{{ url('/') }}" target="_blank">Website Utama</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
