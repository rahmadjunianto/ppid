@extends('admin.layouts.app')

@section('title', 'Statistik Survey')
@section('page-title', 'Statistik Survey Detail')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.surveys.index') }}">Data Survey</a></li>
    <li class="breadcrumb-item active">Statistik</li>
@endsection

@section('content')>

            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('admin.surveys.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Overview Statistics -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $statistics['total_responden'] }}</h3>
                            <p>Total Responden</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($statistics['rata_rata_kepuasan'], 1) }}/4</h3>
                            <p>Rata-rata Kepuasan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ round(($statistics['rata_rata_kepuasan'] / 4) * 100) }}%</h3>
                            <p>Tingkat Kepuasan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $statistics['distribusi_rating'][3] + $statistics['distribusi_rating'][4] }}</h3>
                            <p>Responden Puas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-thumbs-up"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Rating Distribution Chart -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie"></i> Distribusi Rating</h3>
                        </div>
                        <div class="card-body">
                            @if($statistics['total_responden'] > 0)
                            <canvas id="ratingChart" width="400" height="400"></canvas>
                            @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-chart-pie fa-3x mb-3"></i>
                                <p>Belum ada data untuk ditampilkan</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Monthly Survey Data -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-line"></i> Survey per Bulan ({{ date('Y') }})</h3>
                        </div>
                        <div class="card-body">
                            @if(array_sum($monthlyStats) > 0)
                            <canvas id="monthlyChart" width="400" height="400"></canvas>
                            @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-chart-line fa-3x mb-3"></i>
                                <p>Belum ada data bulanan</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Rating Analysis -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Analisis Rating Detail</h3>
                        </div>
                        <div class="card-body">
                            @if($statistics['total_responden'] > 0)
                            @php
                                $maxCount = max($statistics['distribusi_rating']);
                                $ratingLabels = [
                                    1 => ['label' => 'Tidak Puas', 'color' => 'danger'],
                                    2 => ['label' => 'Kurang Puas', 'color' => 'warning'],
                                    3 => ['label' => 'Puas', 'color' => 'info'],
                                    4 => ['label' => 'Sangat Puas', 'color' => 'success']
                                ];
                            @endphp

                            @foreach($statistics['distribusi_rating'] as $rating => $count)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">
                                        <span class="badge badge-{{ $ratingLabels[$rating]['color'] }}">
                                            {{ $rating }}/4
                                        </span>
                                        {{ $ratingLabels[$rating]['label'] }}
                                    </h5>
                                    <span class="text-muted">
                                        {{ $count }} responden
                                        ({{ $statistics['total_responden'] > 0 ? round(($count / $statistics['total_responden']) * 100, 1) : 0 }}%)
                                    </span>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-{{ $ratingLabels[$rating]['color'] }}"
                                         style="width: {{ $maxCount > 0 ? ($count / $maxCount) * 100 : 0 }}%">
                                        {{ $count }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-chart-bar fa-3x mb-3"></i>
                                <p>Belum ada data rating untuk dianalisis</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Satisfaction Summary -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-info-circle"></i> Ringkasan Kepuasan</h3>
                        </div>
                        <div class="card-body">
                            @if($statistics['total_responden'] > 0)
                            @php
                                $positiveResponse = $statistics['distribusi_rating'][3] + $statistics['distribusi_rating'][4];
                                $negativeResponse = $statistics['distribusi_rating'][1] + $statistics['distribusi_rating'][2];
                                $positivePercentage = round(($positiveResponse / $statistics['total_responden']) * 100, 1);
                                $negativePercentage = round(($negativeResponse / $statistics['total_responden']) * 100, 1);
                            @endphp

                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="info-box bg-success">
                                        <span class="info-box-icon"><i class="fas fa-smile"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Respons Positif</span>
                                            <span class="info-box-number">{{ $positiveResponse }}</span>
                                            <span class="progress-description">{{ $positivePercentage }}% dari total</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="info-box bg-danger">
                                        <span class="info-box-icon"><i class="fas fa-frown"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Respons Negatif</span>
                                            <span class="info-box-number">{{ $negativeResponse }}</span>
                                            <span class="progress-description">{{ $negativePercentage }}% dari total</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="info-box bg-info">
                                        <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Status Kepuasan</span>
                                            <span class="info-box-number">
                                                @if($positivePercentage >= 80)
                                                    Excellent
                                                @elseif($positivePercentage >= 60)
                                                    Good
                                                @else
                                                    Perlu Perbaikan
                                                @endif
                                            </span>
                                            <span class="progress-description">Berdasarkan analisis</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-info-circle fa-3x mb-3"></i>
                                <p>Belum ada data untuk membuat ringkasan kepuasan</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if($statistics['total_responden'] > 0)
// Rating Distribution Pie Chart
const ratingCtx = document.getElementById('ratingChart').getContext('2d');
new Chart(ratingCtx, {
    type: 'pie',
    data: {
        labels: ['Tidak Puas (1)', 'Kurang Puas (2)', 'Puas (3)', 'Sangat Puas (4)'],
        datasets: [{
            data: [
                {{ $statistics['distribusi_rating'][1] }},
                {{ $statistics['distribusi_rating'][2] }},
                {{ $statistics['distribusi_rating'][3] }},
                {{ $statistics['distribusi_rating'][4] }}
            ],
            backgroundColor: [
                '#dc3545', // danger
                '#ffc107', // warning
                '#17a2b8', // info
                '#28a745'  // success
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
@endif

@if(array_sum($monthlyStats) > 0)
// Monthly Survey Line Chart
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
            label: 'Jumlah Survey',
            data: [
                @foreach($monthlyStats as $month => $count)
                {{ $count }},
                @endforeach
            ],
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
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
@endif
</script>
@endpush
@endsection
