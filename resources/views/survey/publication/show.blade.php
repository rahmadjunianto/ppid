{{-- Halaman Detail Publikasi IKM dan SPAK --}}
@extends('layouts.app')

@section('title', 'Detail Hasil Survei - ' . $period->getPeriodLabel())

@section('content')
<div class="container py-4">
    {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/ikm-spak') }}">IKM & SPAK</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $period->getPeriodLabel() }}</li>
            </ol>
        </nav>

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="page-title">Hasil Survei {{ $period->getPeriodLabel() }}</h1>
            <p class="text-muted mb-0">
                <i class="fas fa-calendar-alt me-1"></i>
                {{ \Carbon\Carbon::parse($period->survey_start_date)->format('d M Y') }} - 
                {{ \Carbon\Carbon::parse($period->survey_end_date)->format('d M Y') }}
            </p>
        </div>
        <div class="btn-group">
            <a href="{{ route('ikm-spak.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            @if($period->approval_document_path)
            <a href="{{ route('ikm-spak.download', $period->id) }}" class="btn btn-primary">
                <i class="fas fa-file-pdf me-1"></i> Unduh PDF
            </a>
            @endif
            <a href="{{ route('ikm-spak.export', ['year' => $period->year, 'quarter' => $period->quarter]) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i> Unduh Excel
            </a>
        </div>
    </div>

    {{-- Main Results Cards --}}
    <div class="row g-4 mb-4">
        {{-- IKM Result --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-smile me-2"></i>Indeks Kepuasan Masyarakat (IKM)</h5>
                </div>
                <div class="card-body text-center">
                    <div class="display-1 fw-bold text-{{ $period->getIkmCategoryInfo()['color'] }}">
                        {{ $period->ikm_value ?? 'N/A' }}
                    </div>
                    <div class="badge bg-{{ $period->getIkmCategoryInfo()['color'] }} fs-5 px-4 py-2 mt-2">
                        <i class="fas {{ $period->getIkmCategoryInfo()['icon'] }} me-2"></i>
                        {{ $period->ikm_category_label ?? 'N/A' }}
                    </div>
                    <p class="mt-3 text-muted">
                        {{ $period->getIkmCategoryInfo()['description'] }}
                    </p>
                </div>
            </div>
        </div>

        {{-- SPAK Result --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Survei Penilaian Anti Korupsi (SPAK)</h5>
                </div>
                <div class="card-body text-center">
                    <div class="display-1 fw-bold text-{{ $period->getSpakCategoryInfo()['color'] }}">
                        {{ $period->spak_value ?? 'N/A' }}
                    </div>
                    <div class="badge bg-{{ $period->getSpakCategoryInfo()['color'] }} fs-5 px-4 py-2 mt-2">
                        <i class="fas {{ $period->getSpakCategoryInfo()['icon'] }} me-2"></i>
                        {{ $period->spak_category_label ?? 'N/A' }}
                    </div>
                    <p class="mt-3 text-muted">
                        {{ $period->getSpakCategoryInfo()['description'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Respondent Statistics --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>Statistik Responden</h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded">
                        <div class="h2 mb-0 text-primary">{{ $period->total_respondents }}</div>
                        <small class="text-muted">Total Responden</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded">
                        <div class="h2 mb-0 text-info">{{ $period->target_respondents }}</div>
                        <small class="text-muted">Target Responden</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded">
                        <div class="h2 mb-0 text-success">{{ $period->response_rate ?? 'N/A' }}%</div>
                        <small class="text-muted">Tingkat Respons</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Comparison with Previous Period --}}
    @if($previousPeriod || $nextPeriod)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-exchange-alt me-2 text-primary"></i>Perbandingan Periode</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @if($previousPeriod)
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <small class="text-muted d-block mb-2">
                            <i class="fas fa-arrow-left me-1"></i>Periode Sebelumnya
                        </small>
                        <a href="{{ route('ikm-spak.show', ['year' => $previousPeriod->year, 'quarter' => $previousPeriod->quarter]) }}" 
                           class="text-decoration-none">
                            <strong>{{ $previousPeriod->getPeriodLabel() }}</strong>
                        </a>
                        <div class="row mt-2">
                            <div class="col-6">
                                <span class="badge bg-light text-dark">IKM: {{ $previousPeriod->ikm_value ?? '-' }}</span>
                            </div>
                            <div class="col-6">
                                <span class="badge bg-light text-dark">SPAK: {{ $previousPeriod->spak_value ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($nextPeriod)
                <div class="col-md-6">
                    <div class="border rounded p-3">
                        <small class="text-muted d-block mb-2">
                            <i class="fas fa-arrow-right me-1"></i>Periode Berikutnya
                        </small>
                        <a href="{{ route('ikm-spak.show', ['year' => $nextPeriod->year, 'quarter' => $nextPeriod->quarter]) }}" 
                           class="text-decoration-none">
                            <strong>{{ $nextPeriod->getPeriodLabel() }}</strong>
                        </a>
                        <div class="row mt-2">
                            <div class="col-6">
                                <span class="badge bg-light text-dark">IKM: {{ $nextPeriod->ikm_value ?? '-' }}</span>
                            </div>
                            <div class="col-6">
                                <span class="badge bg-light text-dark">SPAK: {{ $nextPeriod->spak_value ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- IKM Unsur Details --}}
    @if($period->ikm_unsur_details)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-list-ul me-2"></i>Detail Nilai Per Unsur IKM</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Unsur Pelayanan</th>
                            <th class="text-center">Nilai</th>
                            <th class="text-center">Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($period->ikm_unsur_details as $index => $unsur)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $unsur['name'] ?? 'Unsur ' . ($index + 1) }}</td>
                            <td class="text-center">{{ $unsur['value'] ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $unsur['category_color'] ?? 'secondary' }}">
                                    {{ $unsur['category'] ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- SPAK Unsur Details --}}
    @if($period->spak_unsur_details)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-list-ul me-2"></i>Detail Nilai Per Unsur SPAK</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Unsur Penilaian</th>
                            <th class="text-center">Nilai</th>
                            <th class="text-center">Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($period->spak_unsur_details as $index => $unsur)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $unsur['name'] ?? 'Unsur ' . ($index + 1) }}</td>
                            <td class="text-center">{{ $unsur['value'] ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $unsur['category_color'] ?? 'secondary' }}">
                                    {{ $unsur['category'] ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Follow-ups Section --}}
    @if($followUps->count() > 0)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Tindak Lanjut Hasil Survei</h5>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @foreach($followUps as $followUp)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $followUp->title }}</h6>
                            <p class="mb-1 text-muted small">{{ $followUp->description }}</p>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $followUp->created_at->format('d M Y') }}
                            </small>
                        </div>
                        <span class="badge bg-{{ $followUp->status_color ?? 'secondary' }}">
                            {{ $followUp->status ?? 'Pending' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Signatory Section --}}
    @if($period->signatory_name)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-file-signature me-2 text-primary"></i>Persetujuan Laporan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width: 150px;">Nama</td>
                            <td class="fw-bold">{{ $period->signatory_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jabatan</td>
                            <td>{{ $period->signatory_position ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Publikasi</td>
                            <td>{{ $period->published_at ? $period->published_at->format('d M Y') : 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 text-end">
                    @if($period->approval_document_path)
                    <a href="{{ route('ikm-spak.download', $period->id) }}" class="btn btn-primary">
                        <i class="fas fa-file-pdf me-2"></i>Unduh Dokumen Persetujuan
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Notes --}}
    @if($period->notes)
    <div class="card border-0 shadow-sm bg-light">
        <div class="card-body">
            <h6 class="text-muted"><i class="fas fa-sticky-note me-2"></i>Catatan</h6>
            <p class="mb-0">{{ $period->notes }}</p>
        </div>
    </div>
    @endif

    {{-- Navigation --}}
    <div class="mt-4 d-flex justify-content-between">
        @if($previousPeriod)
        <a href="{{ route('ikm-spak.show', ['year' => $previousPeriod->year, 'quarter' => $previousPeriod->quarter]) }}" 
           class="btn btn-outline-secondary">
            <i class="fas fa-chevron-left me-2"></i>{{ $previousPeriod->getPeriodLabel() }}
        </a>
        @else
        <div></div>
        @endif
        
        @if($nextPeriod)
        <a href="{{ route('ikm-spak.show', ['year' => $nextPeriod->year, 'quarter' => $nextPeriod->quarter]) }}" 
           class="btn btn-outline-secondary">
            {{ $nextPeriod->getPeriodLabel() }}<i class="fas fa-chevron-right ms-2"></i>
        </a>
        @else
        <div></div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
}
</style>
@endpush
