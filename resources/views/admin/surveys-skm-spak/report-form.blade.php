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
                    <li class="breadcrumb-item active">{{ isset($report) ? 'Edit' : 'Tambah' }} Laporan</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-{{ isset($report) ? 'edit' : 'plus' }} me-2"></i> 
                        {{ isset($report) ? 'Edit' : 'Tambah' }} {{ App\Models\QuarterlyReport::getTypeLabel($type ?? 'publication') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($report) ? route('admin.surveys-skm-spak.reports.update', $report->id) : route('admin.surveys-skm-spak.reports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($report))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="year">Tahun <span class="text-danger">*</span></label>
                                    <select name="year" id="year" class="form-control @error('year') is-invalid @enderror" required>
                                        @foreach($availableYears as $yr)
                                            <option value="{{ $yr }}" {{ (old('year', isset($report) ? $report->year : $year) == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                                        @endforeach
                                    </select>
                                    @error('year')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quarter">Triwulan <span class="text-danger">*</span></label>
                                    <select name="quarter" id="quarter" class="form-control @error('quarter') is-invalid @enderror" required>
                                        <option value="1" {{ (old('quarter', isset($report) ? $report->quarter : ($quarter ?? 1)) == 1 ? 'selected' : '') }}>Triwulan I (Januari - Maret)</option>
                                        <option value="2" {{ (old('quarter', isset($report) ? $report->quarter : ($quarter ?? 1)) == 2 ? 'selected' : '') }}>Triwulan II (April - Juni)</option>
                                        <option value="3" {{ (old('quarter', isset($report) ? $report->quarter : ($quarter ?? 1)) == 3 ? 'selected' : '') }}>Triwulan III (Juli - September)</option>
                                        <option value="4" {{ (old('quarter', isset($report) ? $report->quarter : ($quarter ?? 1)) == 4 ? 'selected' : '') }}>Triwulan IV (Oktober - Desember)</option>
                                    </select>
                                    @error('quarter')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Tipe Laporan <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                        <option value="publication" {{ (old('type', isset($report) ? $report->type : ($type ?? 'publication')) == 'publication' ? 'selected' : '') }}>Bukti Publikasi</option>
                                        <option value="trend" {{ (old('type', isset($report) ? $report->type : ($type ?? 'publication')) == 'trend' ? 'selected' : '') }}>Grafik Tren</option>
                                        <option value="follow_up" {{ (old('type', isset($report) ? $report->type : ($type ?? 'publication')) == 'follow_up' ? 'selected' : '') }}>Laporan Tindak Lanjut</option>
                                        <option value="summary" {{ (old('type', isset($report) ? $report->type : ($type ?? 'publication')) == 'summary' ? 'selected' : '') }}>Ringkasan Laporan</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_published">Status</label>
                                    <div class="custom-control custom-switch mt-2">
                                        <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1" {{ old('is_published', isset($report) ? $report->is_published : true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_published">Publikasi / Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Judul Laporan <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', isset($report) ? $report->title : '') }}" required placeholder="Contoh: Publikasi Hasil Survei SKM Triwulan I 2026">
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Deskripsi atau ringkasan laporan...">{{ old('description', isset($report) ? $report->description : '') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="file">File Laporan</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf,.xlsx,.xls,.doc,.docx">
                                    <label class="custom-file-label" for="file">Pilih file...</label>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                Format yang diizinkan: PDF, Excel (.xlsx, .xls), Word (.doc, .docx). Maksimal ukuran: 10MB.
                            </small>
                            @error('file')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            
                            @if(isset($report) && $report->file_path)
                                <div class="mt-2">
                                    <div class="alert alert-info py-2">
                                        <i class="fas {{ $report->getFileIcon() }} mr-2"></i>
                                        File saat ini: <strong>{{ $report->file_name }}</strong>
                                        <span class="text-muted">({{ strtoupper($report->file_type) }})</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.surveys-skm-spak.reports', ['year' => old('year', isset($report) ? $report->year : $year)]) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i> 
                                {{ isset($report) ? 'Perbarui' : 'Simpan' }} Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Show filename when file is selected
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0]?.name || 'Pilih file...';
        e.target.nextElementSibling.textContent = fileName;
    });
</script>
@endpush
