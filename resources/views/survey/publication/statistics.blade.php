@extends('layouts.app')

@section('title', 'Statistik IKM & SPAK - ' . config('app.name'))

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">📊 Statistik IKM & SPAK</h2>
        <p class="text-muted">Data Survei Indeks Kepuasan Masyarakat dan Survei Penilaian Anti Korupsi</p>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Rata-rata Nilai IKM</h6>
                    <h2 class="fw-bold text-primary">{{ number_format($avgIkm, 2) }}</h2>
                    @php
                        $avgIkmCat = $avgIkm >= 88.31 ? 'A' : ($avgIkm >= 76.61 ? 'B' : ($avgIkm >= 65 ? 'C' : 'D'));
                        $avgIkmLabel = $avgIkm >= 88.31 ? 'Sangat Baik (A)' : ($avgIkm >= 76.61 ? 'Baik (B)' : ($avgIkm >= 65 ? 'Cukup (C)' : 'Buruk (D)'));
                        $avgIkmBadge = $avgIkm >= 88.31 ? 'success' : ($avgIkm >= 76.61 ? 'info' : ($avgIkm >= 65 ? 'warning' : 'danger'));
                    @endphp
                    <span class="badge bg-{{ $avgIkmBadge }}">{{ $avgIkm > 0 ? $avgIkmLabel : '-' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Rata-rata Nilai SPAK</h6>
                    <h2 class="fw-bold text-success">{{ number_format($avgSpak, 2) }}</h2>
                    @php
                        $avgSpakCat = $avgSpak >= 88.31 ? 'A' : ($avgSpak >= 76.61 ? 'B' : ($avgSpak >= 65 ? 'C' : 'D'));
                        $avgSpakLabel = $avgSpak >= 88.31 ? 'Sangat Baik (A)' : ($avgSpak >= 76.61 ? 'Baik (B)' : ($avgSpak >= 65 ? 'Cukup (C)' : 'Buruk (D)'));
                        $avgSpakBadge = $avgSpak >= 88.31 ? 'success' : ($avgSpak >= 76.61 ? 'info' : ($avgSpak >= 65 ? 'warning' : 'danger'));
                    @endphp
                    <span class="badge bg-{{ $avgSpakBadge }}">{{ $avgSpak > 0 ? $avgSpakLabel : '-' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Survei</h6>
                    <h2 class="fw-bold text-info">{{ $totalSurveys ?? 0 }}</h2>
                    <small class="text-muted">Periode Dipublikasikan</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Total Responden</h6>
                    <h2 class="fw-bold text-warning">{{ number_format($totalRespondents ?? 0) }}</h2>
                    <small class="text-muted">Masyarakat Terlibat</small>
                </div>
            </div>
        </div>
    </div>

    <!-- All Published Data -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-database me-2"></i> Semua Data Publikasi</h5>
        </div>
        <div class="card-body">
            @if($allPublishedData->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Periode</th>
                                <th class="text-center">Total Responden</th>
                                <th class="text-center">Nilai IKM</th>
                                <th class="text-center">Kategori IKM</th>
                                <th class="text-center">Nilai SPAK</th>
                                <th class="text-center">Kategori SPAK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allPublishedData as $data)
                            @php
                                $ikmCat = $data->getIkmCategoryWithFallback();
                                $ikmLabel = $data->getIkmCategoryLabelWithFallback();
                                $spakCat = $data->getSpakCategoryWithFallback();
                                $spakLabel = $data->getSpakCategoryLabelWithFallback();
                                
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
                                <td><strong>{{ $data->getPeriodLabel() }}</strong></td>
                                <td class="text-center">{{ $data->total_respondents ?? '-' }} orang</td>
                                <td class="text-center">
                                    <span class="fw-bold">{{ $data->ikm_value ? number_format($data->ikm_value, 2) : '-' }}</span>
                                </td>
                                <td class="text-center">
                                    @if($data->ikm_value && $ikmCat !== '-')
                                        <span class="badge bg-{{ $ikmBadge }}">{{ $ikmLabel }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold">{{ $data->spak_value ? number_format($data->spak_value, 2) : '-' }}</span>
                                </td>
                                <td class="text-center">
                                    @if($data->spak_value && $spakCat !== '-')
                                        <span class="badge bg-{{ $spakBadge }}">{{ $spakLabel }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Belum ada data yang dipublikasikan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Data by Year -->
    @if($yearlyData->count() > 0)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Ringkasan per Tahun</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($yearlyData as $year => $data)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="border rounded p-3">
                        <h6 class="mb-2">{{ $year }}</h6>
                        <div class="row text-center small">
                            <div class="col-6">
                                <div class="text-muted">IKM Rata-rata</div>
                                <strong class="text-primary">{{ number_format($data->avg('ikm_value'), 2) }}</strong>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">SPAK Rata-rata</div>
                                <strong class="text-success">{{ number_format($data->avg('spak_value'), 2) }}</strong>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <small class="text-muted">{{ $data->count() }} periode</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Back Link -->
    <div class="text-center">
        <a href="{{ route('ikm-spak.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Halaman Utama
        </a>
    </div>
</div>
@endsection
