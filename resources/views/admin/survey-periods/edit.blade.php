{{-- Admin: Edit Survey Period --}}
@extends('admin.layouts.app')

@section('title', 'Edit Periode Survei IKM/SPAK - ' . $surveyPeriod->getPeriodLabel())

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Periode Survei: {{ $surveyPeriod->getPeriodLabel() }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.survey-periods.index') }}">Periode Survei</a></li>
        <li class="breadcrumb-item active">{{ $surveyPeriod->getPeriodLabel() }}</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        {{-- Main Form --}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div><i class="fas fa-edit me-1"></i> Data Survei</div>
                    <div>
                        <span class="badge bg-{{ $surveyPeriod->is_published ? 'success' : 'secondary' }}">
                            {{ $surveyPeriod->is_published ? 'Dipublikasi' : 'Draft' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.survey-periods.update', $surveyPeriod->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="year" class="form-label">Tahun <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                           id="year" name="year" value="{{ old('year', $surveyPeriod->year) }}" required min="2020" max="2099">
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quarter" class="form-label">Periode <span class="text-danger">*</span></label>
                                    <select class="form-select @error('quarter') is-invalid @enderror" id="quarter" name="quarter" required>
                                        <option value="tw1" {{ $surveyPeriod->quarter == 'tw1' ? 'selected' : '' }}>Triwulan I</option>
                                        <option value="tw2" {{ $surveyPeriod->quarter == 'tw2' ? 'selected' : '' }}>Triwulan II</option>
                                        <option value="tw3" {{ $surveyPeriod->quarter == 'tw3' ? 'selected' : '' }}>Triwulan III</option>
                                        <option value="tw4" {{ $surveyPeriod->quarter == 'tw4' ? 'selected' : '' }}>Triwulan IV</option>
                                        <option value="annual" {{ $surveyPeriod->quarter == 'annual' ? 'selected' : '' }}>Tahunan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ikm_value" class="form-label">Nilai IKM</label>
                                    <input type="number" step="0.01" class="form-control" 
                                           id="ikm_value" name="ikm_value" value="{{ old('ikm_value', $surveyPeriod->ikm_value) }}" min="25" max="100">
                                    @if($surveyPeriod->ikm_category_label)
                                        <small class="text-{{ $surveyPeriod->getIkmCategoryInfo()['color'] }}">
                                            Kategori: <strong>{{ $surveyPeriod->ikm_category_label }}</strong>
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="spak_value" class="form-label">Nilai SPAK</label>
                                    <input type="number" step="0.01" class="form-control" 
                                           id="spak_value" name="spak_value" value="{{ old('spak_value', $surveyPeriod->spak_value) }}" min="25" max="100">
                                    @if($surveyPeriod->spak_category_label)
                                        <small class="text-{{ $surveyPeriod->getSpakCategoryInfo()['color'] }}">
                                            Kategori: <strong>{{ $surveyPeriod->spak_category_label }}</strong>
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total_respondents" class="form-label">Total Responden</label>
                                    <input type="number" class="form-control" 
                                           id="total_respondents" name="total_respondents" value="{{ old('total_respondents', $surveyPeriod->total_respondents) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="target_respondents" class="form-label">Target Responden</label>
                                    <input type="number" class="form-control" 
                                           id="target_respondents" name="target_respondents" value="{{ old('target_respondents', $surveyPeriod->target_respondents) }}" min="1">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Tingkat Respons</label>
                                    <input type="text" class="form-control" value="{{ number_format($surveyPeriod->response_rate ?? 0, 1) }}%" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="survey_start_date" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" 
                                           id="survey_start_date" name="survey_start_date" value="{{ old('survey_start_date', $surveyPeriod->survey_start_date?->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="survey_end_date" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" 
                                           id="survey_end_date" name="survey_end_date" value="{{ old('survey_end_date', $surveyPeriod->survey_end_date?->format('Y-m-d')) }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $surveyPeriod->notes) }}</textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Signatory Section --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-signature me-1"></i> Penanggung Jawab Publikasi
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.survey-periods.update', $surveyPeriod->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="year" value="{{ $surveyPeriod->year }}">
                        <input type="hidden" name="quarter" value="{{ $surveyPeriod->quarter }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="signatory_name" class="form-label">Nama Pejabat</label>
                                    <input type="text" class="form-control" 
                                           id="signatory_name" name="signatory_name" value="{{ old('signatory_name', $surveyPeriod->signatory_name) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="signatory_position" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" 
                                           id="signatory_position" name="signatory_position" value="{{ old('signatory_position', $surveyPeriod->signatory_position) }}">
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Simpan Info Pejabat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Status Card --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-cog me-1"></i> Pengaturan
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.survey-periods.toggle-publish', $surveyPeriod->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-{{ $surveyPeriod->is_published ? 'warning' : 'success' }} w-100">
                                <i class="fas fa-{{ $surveyPeriod->is_published ? 'eye-slash' : 'eye' }} me-1"></i>
                                {{ $surveyPeriod->is_published ? 'Batalkan Publikasi' : 'Publikasi Sekarang' }}
                            </button>
                        </form>
                        <a href="{{ route('ikm-spak.show', ['year' => $surveyPeriod->year, 'quarter' => $surveyPeriod->quarter]) }}" 
                           class="btn btn-outline-primary w-100" target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i> Lihat di Website
                        </a>
                        <a href="{{ route('ikm-spak.export', ['year' => $surveyPeriod->year, 'quarter' => $surveyPeriod->quarter]) }}" 
                           class="btn btn-outline-success w-100">
                            <i class="fas fa-file-excel me-1"></i> Export Excel
                        </a>
                    </div>
                </div>
            </div>

            {{-- Follow-ups Card --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div><i class="fas fa-tasks me-1"></i> Tindak Lanjut</div>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addFollowUpModal">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="card-body p-0">
                    @if($followUps->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($followUps as $followUp)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $followUp->title }}</h6>
                                        <small class="text-muted">{{ $followUp->description }}</small>
                                    </div>
                                    <span class="badge bg-{{ $followUp->status_color ?? 'secondary' }}">
                                        {{ $followUp->status_label }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada tindak lanjut
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Follow-up Modal --}}
<div class="modal fade" id="addFollowUpModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.survey-periods.add-follow-up', $surveyPeriod->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tindak Lanjut</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pending">Pending</option>
                            <option value="in_progress">Sedang Dikerjakan</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="target_date" class="form-label">Target Penyelesaian</label>
                        <input type="date" class="form-control" id="target_date" name="target_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
