@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light p-3 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.surveys-skm-spak.index') }}">Survey SKM & SPAK</a></li>
                    <li class="breadcrumb-item active">Laporan Triwulanan</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar me-2"></i> Laporan Triwulanan SKM & SPAK
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.surveys-skm-spak.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Survey
            </a>
        </div>
    </div>

    <!-- Filter Year and Quarter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.surveys-skm-spak.reports') }}" class="form-inline">
                        <div class="row w-100">
                            <div class="col-md-3">
                                <label for="year" class="mr-2 font-weight-bold">Tahun:</label>
                                <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                                    @foreach($availableYears as $yr)
                                        <option value="{{ $yr }}" {{ $year == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="quarter" class="mr-2 font-weight-bold">Triwulan:</label>
                                <select name="quarter" id="quarter" class="form-control" onchange="this.form.submit()">
                                    <option value="">-- Semua Triwulan --</option>
                                    <option value="1" {{ $quarter == 1 ? 'selected' : '' }}>Triwulan I (Jan-Mar)</option>
                                    <option value="2" {{ $quarter == 2 ? 'selected' : '' }}>Triwulan II (Apr-Jun)</option>
                                    <option value="3" {{ $quarter == 3 ? 'selected' : '' }}>Triwulan III (Jul-Sep)</option>
                                    <option value="4" {{ $quarter == 4 ? 'selected' : '' }}>Triwulan IV (Okt-Des)</option>
                                </select>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('admin.surveys-skm-spak.reports.create', ['year' => $year, 'quarter' => $quarter ?? 1, 'type' => 'publication']) }}" class="btn btn-success">
                                    <i class="fas fa-plus mr-2"></i> Tambah Laporan
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Summary -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Responden</span>
                    <span class="info-box-number">{{ $statistics['total_responden'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Rata-rata SKM</span>
                    <span class="info-box-number">{{ $statistics['skm_average'] ?? 'N/A' }}/4.0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-shield-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Rata-rata SPAK</span>
                    <span class="info-box-number">{{ $statistics['spak_average'] ?? 'N/A' }}/4.0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-star"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Rata-rata Keseluruhan</span>
                    <span class="info-box-number">{{ $statistics['total_average'] ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Trend Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line me-2"></i> Grafik Tren SKM & SPAK Tahun {{ $year }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <canvas id="trendChart" height="100"></canvas>
                        </div>
                        <div class="col-md-4">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Triwulan</th>
                                            <th>SKM</th>
                                            <th>SPAK</th>
                                            <th>Responden</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($trendData['quarters'] as $q)
                                            <tr>
                                                <td><strong>TW {{ $q }}</strong></td>
                                                <td>{{ $trendData['skm'][$q] }}</td>
                                                <td>{{ $trendData['spak'][$q] }}</td>
                                                <td>{{ $trendData['respondents'][$q] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs for Report Categories -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="reportTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="publication-tab" data-toggle="tab" href="#publication" role="tab">
                                <i class="fas fa-upload me-1"></i> Bukti Publikasi
                                @if($publications->count() > 0)
                                    <span class="badge badge-primary ml-1">{{ $publications->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="trend-tab" data-toggle="tab" href="#trend" role="tab">
                                <i class="fas fa-chart-bar me-1"></i> Grafik Tren
                                @if($trendCharts->count() > 0)
                                    <span class="badge badge-primary ml-1">{{ $trendCharts->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="followup-tab" data-toggle="tab" href="#followup" role="tab">
                                <i class="fas fa-clipboard-check me-1"></i> Laporan Tindak Lanjut
                                @if($followUps->count() > 0)
                                    <span class="badge badge-primary ml-1">{{ $followUps->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="summary-tab" data-toggle="tab" href="#summary" role="tab">
                                <i class="fas fa-file-alt me-1"></i> Ringkasan Laporan
                                @if($summaries->count() > 0)
                                    <span class="badge badge-primary ml-1">{{ $summaries->count() }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="reportTabsContent">
                        <!-- Publication Tab -->
                        <div class="tab-pane fade show active" id="publication" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="fas fa-upload text-primary me-2"></i>Bukti Publikasi Hasil Survei</h5>
                                <a href="{{ route('admin.surveys-skm-spak.reports.create', ['year' => $year, 'type' => 'publication']) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Tambah
                                </a>
                            </div>
                            @if($publications->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Periode</th>
                                                <th>File</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($publications as $index => $report)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $report->title }}</td>
                                                    <td>
                                                        <span class="badge badge-info">{{ $report->year }}</span>
                                                        <span class="badge badge-secondary">{{ $report->getQuarterShortLabel() }}</span>
                                                    </td>
                                                    <td>
                                                        @if($report->file_path)
                                                            <i class="fas {{ $report->getFileIcon() }}"></i>
                                                            <small>{{ $report->file_name }}</small>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($report->is_published)
                                                            <span class="badge badge-success"><i class="fas fa-check"></i> Published</span>
                                                        @else
                                                            <span class="badge badge-secondary">Draft</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            @if($report->file_path)
                                                                <a href="{{ route('admin.surveys-skm-spak.reports.download', $report->id) }}" class="btn btn-info" title="Download">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                                            @endif
                                                            <a href="{{ route('admin.surveys-skm-spak.reports.show', $report->id) }}" class="btn btn-primary" title="Lihat">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.surveys-skm-spak.reports.edit', $report->id) }}" class="btn btn-warning" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('admin.surveys-skm-spak.reports.destroy', $report->id) }}')" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada bukti publikasi untuk periode ini</p>
                                    <a href="{{ route('admin.surveys-skm-spak.reports.create', ['year' => $year, 'type' => 'publication']) }}" class="btn btn-primary">
                                        <i class="fas fa-plus mr-2"></i>Tambah Bukti Publikasi
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Trend Tab -->
                        <div class="tab-pane fade" id="trend" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="fas fa-chart-bar text-primary me-2"></i>Grafik Tren Hasil Survei</h5>
                                <a href="{{ route('admin.surveys-skm-spak.reports.create', ['year' => $year, 'type' => 'trend']) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Tambah
                                </a>
                            </div>
                            @if($trendCharts->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Periode</th>
                                                <th>File</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($trendCharts as $index => $report)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $report->title }}</td>
                                                    <td>
                                                        <span class="badge badge-info">{{ $report->year }}</span>
                                                        <span class="badge badge-secondary">{{ $report->getQuarterShortLabel() }}</span>
                                                    </td>
                                                    <td>
                                                        @if($report->file_path)
                                                            <i class="fas {{ $report->getFileIcon() }}"></i>
                                                            <small>{{ $report->file_name }}</small>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($report->is_published)
                                                            <span class="badge badge-success"><i class="fas fa-check"></i> Published</span>
                                                        @else
                                                            <span class="badge badge-secondary">Draft</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            @if($report->file_path)
                                                                <a href="{{ route('admin.surveys-skm-spak.reports.download', $report->id) }}" class="btn btn-info" title="Download">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                                            @endif
                                                            <a href="{{ route('admin.surveys-skm-spak.reports.show', $report->id) }}" class="btn btn-primary" title="Lihat">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.surveys-skm-spak.reports.edit', $report->id) }}" class="btn btn-warning" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('admin.surveys-skm-spak.reports.destroy', $report->id) }}')" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada grafik tren untuk periode ini</p>
                                    <a href="{{ route('admin.surveys-skm-spak.reports.create', ['year' => $year, 'type' => 'trend']) }}" class="btn btn-primary">
                                        <i class="fas fa-plus mr-2"></i>Tambah Grafik Tren
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Follow Up Tab -->
                        <div class="tab-pane fade" id="followup" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="fas fa-clipboard-check text-primary me-2"></i>Laporan Tindak Lanjut Resmi</h5>
                                <a href="{{ route('admin.surveys-skm-spak.reports.create', ['year' => $year, 'type' => 'follow_up']) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Tambah
                                </a>
                            </div>
                            @if($followUps->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Periode</th>
                                                <th>File</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($followUps as $index => $report)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $report->title }}</td>
                                                    <td>
                                                        <span class="badge badge-info">{{ $report->year }}</span>
                                                        <span class="badge badge-secondary">{{ $report->getQuarterShortLabel() }}</span>
                                                    </td>
                                                    <td>
                                                        @if($report->file_path)
                                                            <i class="fas {{ $report->getFileIcon() }}"></i>
                                                            <small>{{ $report->file_name }}</small>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($report->is_published)
                                                            <span class="badge badge-success"><i class="fas fa-check"></i> Published</span>
                                                        @else
                                                            <span class="badge badge-secondary">Draft</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            @if($report->file_path)
                                                                <a href="{{ route('admin.surveys-skm-spak.reports.download', $report->id) }}" class="btn btn-info" title="Download">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                                            @endif
                                                            <a href="{{ route('admin.surveys-skm-spak.reports.show', $report->id) }}" class="btn btn-primary" title="Lihat">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.surveys-skm-spak.reports.edit', $report->id) }}" class="btn btn-warning" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('admin.surveys-skm-spak.reports.destroy', $report->id) }}')" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada laporan tindak lanjut untuk periode ini</p>
                                    <a href="{{ route('admin.surveys-skm-spak.reports.create', ['year' => $year, 'type' => 'follow_up']) }}" class="btn btn-primary">
                                        <i class="fas fa-plus mr-2"></i>Tambah Laporan Tindak Lanjut
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Summary Tab -->
                        <div class="tab-pane fade" id="summary" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="fas fa-file-alt text-primary me-2"></i>Ringkasan Laporan</h5>
                                <a href="{{ route('admin.surveys-skm-spak.reports.create', ['year' => $year, 'type' => 'summary']) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Tambah
                                </a>
                            </div>
                            @if($summaries->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Periode</th>
                                                <th>File</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($summaries as $index => $report)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $report->title }}</td>
                                                    <td>
                                                        <span class="badge badge-info">{{ $report->year }}</span>
                                                        <span class="badge badge-secondary">{{ $report->getQuarterShortLabel() }}</span>
                                                    </td>
                                                    <td>
                                                        @if($report->file_path)
                                                            <i class="fas {{ $report->getFileIcon() }}"></i>
                                                            <small>{{ $report->file_name }}</small>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($report->is_published)
                                                            <span class="badge badge-success"><i class="fas fa-check"></i> Published</span>
                                                        @else
                                                            <span class="badge badge-secondary">Draft</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            @if($report->file_path)
                                                                <a href="{{ route('admin.surveys-skm-spak.reports.download', $report->id) }}" class="btn btn-info" title="Download">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                                            @endif
                                                            <a href="{{ route('admin.surveys-skm-spak.reports.show', $report->id) }}" class="btn btn-primary" title="Lihat">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.surveys-skm-spak.reports.edit', $report->id) }}" class="btn btn-warning" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('admin.surveys-skm-spak.reports.destroy', $report->id) }}')" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-file fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada ringkasan laporan untuk periode ini</p>
                                    <a href="{{ route('admin.surveys-skm-spak.reports.create', ['year' => $year, 'type' => 'summary']) }}" class="btn btn-primary">
                                        <i class="fas fa-plus mr-2"></i>Tambah Ringkasan Laporan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-trash mr-2"></i> Hapus Laporan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus laporan ini?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="deleteLink" class="btn btn-danger">
                    <i class="fas fa-trash mr-2"></i> Hapus
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Trend Chart
    const ctx = document.getElementById('trendChart').getContext('2d');
    const trendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_map(function($q) { return "TW $q"; }, $trendData['quarters'])) !!},
            datasets: [
                {
                    label: 'SKM',
                    data: {!! json_encode(array_values($trendData['skm'])) !!},
                    borderColor: 'rgba(40, 167, 69, 1)',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.3,
                    fill: true,
                },
                {
                    label: 'SPAK',
                    data: {!! json_encode(array_values($trendData['spak'])) !!},
                    borderColor: 'rgba(255, 193, 7, 1)',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    tension: 0.3,
                    fill: true,
                },
                {
                    label: 'Total',
                    data: {!! json_encode(array_values($trendData['total'])) !!},
                    borderColor: 'rgba(0, 123, 255, 1)',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.3,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 4,
                    title: {
                        display: true,
                        text: 'Skor (0-4)'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    // Delete confirmation
    function confirmDelete(url) {
        document.getElementById('deleteLink').href = url;
        $('#deleteModal').modal('show');
    }
</script>
@endpush
