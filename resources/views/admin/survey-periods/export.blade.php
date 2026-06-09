@extends('admin.layouts.app')

@section('title', 'Export Laporan IKM & SPAK')
@section('page-title', 'Export Laporan IKM & SPAK')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.survey-periods.index') }}">IKM & SPAK</a></li>
    <li class="breadcrumb-item active">Export Laporan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-export mr-2"></i>
                        Export Laporan IKM & SPAK
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Petunjuk Export</h5>
                        <ul class="mb-0">
                            <li>Klik tombol <strong>"Generate PDF"</strong> untuk membuat laporan dalam format PDF</li>
                            <li>Laporan PDF berisi data lengkap meliputi nilai IKM, SPAK, kategori, dan tindak lanjut</li>
                            <li>Laporan dapat langsung diunduh atau dicetak</li>
                        </ul>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="bg-primary">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Periode</th>
                                    <th>Tipe</th>
                                    <th>Nilai IKM</th>
                                    <th>Nilai SPAK</th>
                                    <th>Status</th>
                                    <th width="200">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($periods as $period)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $period->year }} {{ $period->getQuarterLabel() }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $period->survey_start_date->format('d/m/Y') }} - {{ $period->survey_end_date->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($period->survey_type == 'ikm')
                                                <span class="badge badge-info">IKM</span>
                                            @elseif($period->survey_type == 'spak')
                                                <span class="badge badge-warning">SPAK</span>
                                            @else
                                                <span class="badge badge-success">IKM & SPAK</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($period->ikm_value)
                                                <span class="badge badge-{{ $period->ikm_category == 'A' ? 'success' : ($period->ikm_category == 'B' ? 'info' : 'warning') }}">
                                                    {{ number_format($period->ikm_value, 2) }}
                                                </span>
                                                <br>
                                                <small class="text-muted">{{ $period->ikm_category_label }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($period->spak_value)
                                                <span class="badge badge-{{ $period->spak_category == 'A' ? 'success' : ($period->spak_category == 'B' ? 'info' : 'warning') }}">
                                                    {{ number_format($period->spak_value, 2) }}
                                                </span>
                                                <br>
                                                <small class="text-muted">{{ $period->spak_category_label }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($period->is_published)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Published
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-clock"></i> Draft
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($period->is_published)
                                                <a href="{{ route('admin.survey-export.generate', $period->id) }}" 
                                                   class="btn btn-success btn-sm" 
                                                   title="Generate & Download PDF">
                                                    <i class="fas fa-file-pdf"></i> PDF
                                                </a>
                                                <a href="{{ route('ikm-spak.export', ['year' => $period->year, 'quarter' => $period->quarter]) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Export Excel"
                                                   target="_blank">
                                                    <i class="fas fa-file-excel"></i> Excel
                                                </a>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-lock"></i> Publish terlebih dahulu
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p class="mb-0">Belum ada data periode survei</p>
                                            <a href="{{ route('admin.survey-periods.create') }}" class="btn btn-primary btn-sm mt-2">
                                                <i class="fas fa-plus"></i> Tambah Periode
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('admin.survey-periods.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <div class="col-md-6 text-right">
                            @if($periods->count() > 0)
                                <a href="{{ route('admin.survey-export.generate', $periods->first()->id) }}" 
                                   class="btn btn-success">
                                    <i class="fas fa-file-pdf"></i> Download Laporan Terbaru
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Periode</span>
                    <span class="info-box-number">{{ $periods->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Sudah Publish</span>
                    <span class="info-box-number">{{ $periods->where('is_published', true)->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Draft</span>
                    <span class="info-box-number">{{ $periods->where('is_published', false)->count() }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
