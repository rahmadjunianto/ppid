@extends('layouts.app')

@section('title', 'Tren IKM & SPAK - ' . config('app.name'))

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">📈 Tren Capaian IKM & SPAK</h2>
        <p class="text-muted">Visualisasi Perkembangan Survei dari Periode ke Periode</p>
    </div>

    <!-- Target Info -->
    <div class="alert alert-info text-center mb-4">
        <i class="fas fa-bullseye me-2"></i>
        <strong>Target Capaian:</strong> IKM ≥ {{ number_format($ikmTarget, 2) }} | SPAK ≥ {{ number_format($spakTarget, 2) }} (Kategori A)
    </div>

    @if($trendData->count() > 0)
        <!-- Chart Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i> Grafik Tren</h5>
            </div>
            <div class="card-body">
                <canvas id="trendChart" height="100"></canvas>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-table me-2"></i> Tabel Data Tren</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Periode</th>
                                <th class="text-center">Nilai IKM</th>
                                <th class="text-center">Kategori IKM</th>
                                <th class="text-center">Nilai SPAK</th>
                                <th class="text-center">Kategori SPAK</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trendData as $index => $data)
                            @php
                                $ikmCat = $data->getIkmCategoryWithFallback();
                                $ikmCatLabel = $data->getIkmCategoryLabelWithFallback();
                                $spakCat = $data->getSpakCategoryWithFallback();
                                $spakCatLabel = $data->getSpakCategoryLabelWithFallback();
                                
                                $ikmBadge = match($ikmCat) {
                                    'A' => 'success',
                                    'B' => 'info',
                                    'C' => 'warning',
                                    'D' => 'danger',
                                    default => 'secondary'
                                };
                                
                                $spakBadge = match($spakCat) {
                                    'A' => 'success',
                                    'B' => 'info',
                                    'C' => 'warning',
                                    'D' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><strong>{{ $data->getPeriodLabel() }}</strong></td>
                                <td class="text-center">
                                    @if($data->ikm_value)
                                        <span class="fw-bold {{ $data->ikm_value >= $ikmTarget ? 'text-success' : 'text-warning' }}">
                                            {{ number_format($data->ikm_value, 2) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($data->ikm_value && $ikmCat !== '-')
                                        <span class="badge bg-{{ $ikmBadge }}">{{ $ikmCatLabel }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($data->spak_value)
                                        <span class="fw-bold {{ $data->spak_value >= $spakTarget ? 'text-success' : 'text-warning' }}">
                                            {{ number_format($data->spak_value, 2) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($data->spak_value && $spakCat !== '-')
                                        <span class="badge bg-{{ $spakBadge }}">{{ $spakCatLabel }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('ikm-spak.show', ['year' => $data->year, 'quarter' => $data->quarter]) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Chart.js Script -->
        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('trendChart').getContext('2d');
                
                // Reverse data so oldest is on the left, newest on the right
                const labels = {!! json_encode(array_reverse($trendData->map(function($item) { 
                    return $item->getPeriodLabel(); 
                })->toArray())) !!};
                
                const ikmData = {!! json_encode(array_reverse($trendData->pluck('ikm_value')->toArray())) !!};
                const spakData = {!! json_encode(array_reverse($trendData->pluck('spak_value')->toArray())) !!};
                
                const ikmTarget = {{ $ikmTarget }};
                const spakTarget = {{ $spakTarget }};
                
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
                                borderWidth: 3,
                                fill: true,
                                tension: 0.3,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                pointBackgroundColor: '#0d6efd'
                            },
                            {
                                label: 'SPAK',
                                data: spakData,
                                borderColor: '#198754',
                                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.3,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                pointBackgroundColor: '#198754'
                            },
                            {
                                label: 'Target IKM',
                                data: Array(labels.length).fill(ikmTarget),
                                borderColor: '#0d6efd',
                                borderDash: [5, 5],
                                borderWidth: 2,
                                pointRadius: 0,
                                fill: false
                            },
                            {
                                label: 'Target SPAK',
                                data: Array(labels.length).fill(spakTarget),
                                borderColor: '#198754',
                                borderDash: [5, 5],
                                borderWidth: 2,
                                pointRadius: 0,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: { mode: 'index', intersect: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: 70,
                                max: 100,
                                title: { display: true, text: 'Nilai' }
                            }
                        }
                    }
                });
            });
        </script>
        @endpush
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-chart-line fa-4x mb-3 opacity-25"></i>
                <h4>Belum Ada Data Tren</h4>
                <p>Data survei IKM dan SPAK belum tersedia untuk ditampilkan</p>
            </div>
        </div>
    @endif

    <!-- Navigation -->
    <div class="text-center mt-4">
        <a href="{{ route('ikm-spak.index') }}" class="btn btn-outline-primary me-2">
            <i class="fas fa-arrow-left me-2"></i> Halaman Utama
        </a>
        <a href="{{ route('ikm-spak.statistics') }}" class="btn btn-outline-success">
            <i class="fas fa-chart-bar me-2"></i> Statistik
        </a>
    </div>
</div>
@endsection
