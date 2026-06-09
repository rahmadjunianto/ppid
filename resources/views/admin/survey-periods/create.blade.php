{{-- Admin: Create Survey Period --}}
@extends('admin.layouts.app')

@section('title', 'Tambah Periode Survei IKM/SPAK')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Periode Survei IKM/SPAK</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.survey-periods.index') }}">Periode Survei</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i> Form Tambah Periode Survei
        </div>
        <div class="card-body">
            <form action="{{ route('admin.survey-periods.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="year" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                   id="year" name="year" value="{{ old('year', date('Y')) }}" required min="2020" max="2099">
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quarter" class="form-label">Periode <span class="text-danger">*</span></label>
                            <select class="form-select @error('quarter') is-invalid @enderror" id="quarter" name="quarter" required>
                                <option value="">-- Pilih Periode --</option>
                                <option value="tw1" {{ old('quarter') == 'tw1' ? 'selected' : '' }}>Triwulan I (Januari - Maret)</option>
                                <option value="tw2" {{ old('quarter') == 'tw2' ? 'selected' : '' }}>Triwulan II (April - Juni)</option>
                                <option value="tw3" {{ old('quarter') == 'tw3' ? 'selected' : '' }}>Triwulan III (Juli - September)</option>
                                <option value="tw4" {{ old('quarter') == 'tw4' ? 'selected' : '' }}>Triwulan IV (Oktober - Desember)</option>
                                <option value="annual" {{ old('quarter') == 'annual' ? 'selected' : '' }}>Tahunan</option>
                            </select>
                            @error('quarter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="survey_type" class="form-label">Jenis Survei <span class="text-danger">*</span></label>
                    <select class="form-select @error('survey_type') is-invalid @enderror" id="survey_type" name="survey_type" required>
                        <option value="both" {{ old('survey_type') == 'both' ? 'selected' : '' }}>IKM dan SPAK</option>
                        <option value="ikm" {{ old('survey_type') == 'ikm' ? 'selected' : '' }}>Hanya IKM</option>
                        <option value="spak" {{ old('survey_type') == 'spak' ? 'selected' : '' }}>Hanya SPAK</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ikm_value" class="form-label">Nilai IKM</label>
                            <input type="number" step="0.01" class="form-control @error('ikm_value') is-invalid @enderror" 
                                   id="ikm_value" name="ikm_value" value="{{ old('ikm_value') }}" min="25" max="100" placeholder="Contoh: 85.50">
                            <small class="text-muted">Nilai skala 25 - 100</small>
                            @error('ikm_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="spak_value" class="form-label">Nilai SPAK</label>
                            <input type="number" step="0.01" class="form-control @error('spak_value') is-invalid @enderror" 
                                   id="spak_value" name="spak_value" value="{{ old('spak_value') }}" min="25" max="100" placeholder="Contoh: 87.25">
                            <small class="text-muted">Nilai skala 25 - 100</small>
                            @error('spak_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="total_respondents" class="form-label">Total Responden <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('total_respondents') is-invalid @enderror" 
                                   id="total_respondents" name="total_respondents" value="{{ old('total_respondents', 100) }}" required min="0">
                            @error('total_respondents')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="target_respondents" class="form-label">Target Responden <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('target_respondents') is-invalid @enderror" 
                                   id="target_respondents" name="target_respondents" value="{{ old('target_respondents', 100) }}" required min="1">
                            @error('target_respondents')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="survey_start_date" class="form-label">Tanggal Mulai Survei <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('survey_start_date') is-invalid @enderror" 
                                   id="survey_start_date" name="survey_start_date" value="{{ old('survey_start_date') }}" required>
                            @error('survey_start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="survey_end_date" class="form-label">Tanggal Selesai Survei <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('survey_end_date') is-invalid @enderror" 
                                   id="survey_end_date" name="survey_end_date" value="{{ old('survey_end_date') }}" required>
                            @error('survey_end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="is_published" class="form-label">Status Publikasi</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">Publikasi sekarang</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.survey-periods.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
