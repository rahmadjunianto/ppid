{{-- Halaman Publikasi IKM dan SPAK --}}
@extends('layouts.app')

@section('title', 'Publikasi IKM & SPAK - Survei Indeks Kepuasan Masyarakat dan Survei Penilaian Anti Korupsi')

@section('content')
<div class="container py-4">
    {{-- Header Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#">Pelayanan Publik</a></li>
                    <li class="breadcrumb-item active" aria-current="page">IKM & SPAK</li>
                </ol>
            </nav>
            <h1 class="page-title">Publikasi Hasil Survei IKM & SPAK</h1>
            <p class="text-muted">
                Transparansi dan akuntabilitas kinerja pelayanan berdasarkan Survei Indeks Kepuasan Masyarakat (IKM) 
                dan Survei Penilaian Anti Korupsi (SPAK)
            </p>
        </div>
    </div>

    {{-- Info Box --}}
    <div class="alert alert-info border-0 shadow-sm mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-2x me-3 text-info"></i>
            <div>
                <h5 class="mb-1">Tentang Survei IKM & SPAK</h5>
                <p class="mb-0">
                    Survei IKM dilakukan untuk mengukur tingkat kepuasan masyarakat terhadap pelayanan publik, 
                    sedangkan Survei SPAK menilai persepsi anti korupsi di lingkungan instansi. 
                    Hasil survei ini menjadi dasar perbaikan layanan secara berkelanjutan.
                </p>
            </div>
        </div>
    </div>

    {{-- Latest Results Card --}}
    @if($latestPeriod)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Hasil Survei Terbaru</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    {{-- IKM Result --}}
                    <div class="border rounded-3 p-4 text-center bg-light">
                        <h6 class="text-muted mb-3">Indeks Kepuasan Masyarakat (IKM)</h6>
                        <div class="display-4 fw-bold text-{{ $latestPeriod->getIkmCategoryInfo()['color'] }}">
                            {{ $latestPeriod->ikm_value ?? 'N/A' }}
                        </div>
                        <span class="badge bg-{{ $latestPeriod->getIkmCategoryInfo()['color'] }} fs-6 mt-2">
                            <i class="fas {{ $latestPeriod->getIkmCategoryInfo()['icon'] }} me-1"></i>
                            {{ $latestPeriod->ikm_category_label ?? 'N/A' }}
                        </span>
                        <p class="text-muted mt-2 mb-0">{{ $latestPeriod->getPeriodLabel() }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    {{-- SPAK Result --}}
                    <div class="border rounded-3 p-4 text-center bg-light">
                        <h6 class="text-muted mb-3">Survei Penilaian Anti Korupsi (SPAK)</h6>
                        <div class="display-4 fw-bold text-{{ $latestPeriod->getSpakCategoryInfo()['color'] }}">
                            {{ $latestPeriod->spak_value ?? 'N/A' }}
                        </div>
                        <span class="badge bg-{{ $latestPeriod->getSpakCategoryInfo()['color'] }} fs-6 mt-2">
                            <i class="fas {{ $latestPeriod->getSpakCategoryInfo()['icon'] }} me-1"></i>
                            {{ $latestPeriod->spak_category_label ?? 'N/A' }}
                        </span>
                        <p class="text-muted mt-2 mb-0">{{ $latestPeriod->getPeriodLabel() }}</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('ikm-spak.show', ['year' => $latestPeriod->year, 'quarter' => $latestPeriod->quarter]) }}" 
                   class="btn btn-primary">
                    <i class="fas fa-eye me-2"></i>Lihat Detail Lengkap
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- Trend Chart Section --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-chart-bar me-2 text-primary"></i>Grafik Tren Capaian</h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height: 300px;">
                <canvas id="trendChart"></canvas>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2" style="width: 20px; height: 4px;"></span>
                        <small class="text-muted">IKM</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success me-2" style="width: 20px; height: 4px;"></span>
                        <small class="text-muted">SPAK</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Survey Periods Table --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-table me-2 text-primary"></i>Riwayat Hasil Survei</h5>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-1"></i> Filter Tahun
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('ikm-spak.index') }}">Semua Tahun</a></li>
                        @foreach($availableYears as $year)
                            <li><a class="dropdown-item" href="#">{{ $year }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-nowrap">Periode</th>
                            <th class="text-center">Total Responden</th>
                            <th class="text-center">Nilai IKM</th>
                            <th class="text-center">Kategori IKM</th>
                            <th class="text-center">Nilai SPAK</th>
                            <th class="text-center">Kategori SPAK</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($surveyPeriods as $period)
                        <tr>
                            <td class="text-nowrap">
                                <strong>{{ $period->getPeriodLabel() }}</strong>
                            </td>
                            <td class="text-center">{{ $period->total_respondents }} orang</td>
                            <td class="text-center">
                                <strong>{{ $period->ikm_value ?? '-' }}</strong>
                            </td>
                            <td class="text-center">
                                @if($period->ikm_category_label)
                                    <span class="badge bg-{{ $period->getIkmCategoryInfo()['color'] }}">
                                        {{ $period->ikm_category_label }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <strong>{{ $period->spak_value ?? '-' }}</strong>
                            </td>
                            <td class="text-center">
                                @if($period->spak_category_label)
                                    <span class="badge bg-{{ $period->getSpakCategoryInfo()['color'] }}">
                                        {{ $period->spak_category_label }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('ikm-spak.show', ['year' => $period->year, 'quarter' => $period->quarter]) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                Belum ada data hasil survei yang dipublikasikan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Downloadable Reports --}}
    @if($reports->count() > 0)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-file-pdf me-2 text-danger"></i>Laporan & Dokumen Unduh</h5>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @foreach($reports as $report)
                <a href="{{ route('ikm-spak.download', $report->id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="fas fa-file-{{ $report->file_type === 'pdf' ? 'pdf text-danger' : 'excel text-success' }} fa-2x me-3"></i>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">{{ $report->title }}</h6>
                        <small class="text-muted">
                            {{ $report->year }} - {{ App\Models\SurveyPeriod::getQuarterLabel($report->quarter) }} | 
                            {{ strtoupper($report->file_type ?? 'PDF') }}
                        </small>
                    </div>
                    <i class="fas fa-download text-muted"></i>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Information Section --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-info-circle text-primary me-2"></i>Kategori Nilai IKM</h5>
                    <p class="text-muted small">Indeks Kepuasan Masyarakat menggunakan kategori sebagai berikut:</p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><span class="badge bg-success me-2">A</span> Sangat Baik (88,31 - 100)</li>
                        <li class="mb-2"><span class="badge bg-info me-2">B</span> Baik (76,61 - 88,30)</li>
                        <li class="mb-2"><span class="badge bg-warning me-2">C</span> Cukup (65,00 - 76,60)</li>
                        <li class="mb-2"><span class="badge bg-danger me-2">D</span> Buruk (25,00 - 64,99)</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-shield-alt text-success me-2"></i>Kategori Nilai SPAK</h5>
                    <p class="text-muted small">Survei Penilaian Anti Korupsi menggunakan kategori yang sama dengan IKM:</p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><span class="badge bg-success me-2">A</span> Sangat Baik (88,31 - 100)</li>
                        <li class="mb-2"><span class="badge bg-info me-2">B</span> Baik (76,61 - 88,30)</li>
                        <li class="mb-2"><span class="badge bg-warning me-2">C</span> Cukup (65,00 - 76,60)</li>
                        <li class="mb-2"><span class="badge bg-danger me-2">D</span> Buruk (25,00 - 64,99)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Contact Section --}}
    <div class="card border-0 shadow-sm mt-4 bg-light">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">Butuh Informasi Lebih Lanjut?</h5>
                    <p class="mb-0 text-muted">
                        Untuk pertanyaan atau masukan terkait pelayanan kami, silakan hubungi kami melalui 
                        halaman <a href="{{ url('/') }}">Beranda</a> atau layangkan surat resmi ke alamat kami.
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ url('/survey/skm-spak') }}" class="btn btn-primary">
                        <i class="fas fa-poll me-2"></i>Ikuti Survei
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2c3e50;
}
.chart-container {
    background: #fafafa;
    border-radius: 8px;
    padding: 1rem;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch trend data from API
    fetch('{{ route("ikm-spak.trend-data") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.length > 0) {
                const ctx = document.getElementById('trendChart').getContext('2d');
                
                // Reverse data so oldest is on the left, newest on the right
                const labels = data.data.map(d => d.period).reverse();
                const ikmData = data.data.map(d => d.ikm_value).reverse();
                const spakData = data.data.map(d => d.spak_value).reverse();
                
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'IKM',
                                data: ikmData,
                                borderColor: '#0d6efd',
                                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                                fill: true,
                                tension: 0.3
                            },
                            {
                                label: 'SPAK',
                                data: spakData,
                                borderColor: '#198754',
                                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                                fill: true,
                                tension: 0.3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                min: 50,
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Nilai'
                                }
                            }
                        }
                    }
                });
            }
        })
        .catch(error => console.error('Error loading trend data:', error));
});
</script>
@endpush
