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
                    <li class="breadcrumb-item"><a href="{{ route('admin.surveys-skm-spak.reports') }}">Laporan Triwulanan</a></li>
                    <li class="breadcrumb-item active">Detail Laporan</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt me-2"></i> Detail Laporan
                    </h3>
                    <div>
                        <a href="{{ route('admin.surveys-skm-spak.reports', ['year' => $report->year]) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                        <a href="{{ route('admin.surveys-skm-spak.reports.edit', $report->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        @if($report->file_path)
                            <a href="{{ route('admin.surveys-skm-spak.reports.download', $report->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-download mr-2"></i> Download
                            </a>
                        @endif
                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash mr-2"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Details -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i> Informasi Laporan
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="200"><strong>Judul</strong></td>
                            <td>: {{ $report->title }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tipe</strong></td>
                            <td>: 
                                <span class="badge badge-info">
                                    {{ App\Models\QuarterlyReport::getTypeLabel($report->type) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Periode</strong></td>
                            <td>: 
                                <span class="badge badge-primary">{{ $report->year }}</span>
                                <span class="badge badge-secondary">{{ $report->getQuarterShortLabel() }}</span>
                                <small class="text-muted ml-2">{{ $report->getPeriodLabel() }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: 
                                @if($report->is_published)
                                    <span class="badge badge-success"><i class="fas fa-check"></i> Published</span>
                                @else
                                    <span class="badge badge-secondary">Draft</span>
                                @endif
                            </td>
                        </tr>
                        @if($report->description)
                        <tr>
                            <td><strong>Deskripsi</strong></td>
                            <td>: {!! nl2br(e($report->description)) !!}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-file mr-2"></i> File Laporan
                    </h3>
                </div>
                <div class="card-body text-center">
                    @if($report->file_path)
                        <i class="fas {{ $report->getFileIcon() }} fa-5x mb-3"></i>
                        <p class="mb-2"><strong>{{ $report->file_name }}</strong></p>
                        <p class="text-muted mb-3">({{ strtoupper($report->file_type) }})</p>
                        <a href="{{ route('admin.surveys-skm-spak.reports.download', $report->id) }}" class="btn btn-primary btn-block">
                            <i class="fas fa-download mr-2"></i> Download File
                        </a>
                    @else
                        <i class="fas fa-file fa-5x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada file yang dilampirkan</p>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i> Metadata
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Dibuat</strong></td>
                            <td>{{ $report->created_at->locale('id')->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui</strong></td>
                            <td>{{ $report->updated_at->locale('id')->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>ID</strong></td>
                            <td>#{{ $report->id }}</td>
                        </tr>
                    </table>
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
                <p>Apakah Anda yakin ingin menghapus laporan "{{ $report->title }}"?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('admin.surveys-skm-spak.reports.destroy', $report->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-2"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete() {
        $('#deleteModal').modal('show');
    }
</script>
@endpush
