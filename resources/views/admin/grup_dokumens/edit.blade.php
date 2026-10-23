@extends('admin.layouts.app')

@section('title', 'Edit Kategori Dokumen')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Kategori Dokumen</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.grup-dokumens.update', $grupDokumen->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nama_grup" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('nama_grup') is-invalid @enderror" 
                       id="nama_grup" 
                       name="nama_grup" 
                       value="{{ old('nama_grup', $grupDokumen->nama_grup) }}"
                       required>
                @error('nama_grup')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" 
                          name="deskripsi" 
                          rows="3">{{ old('deskripsi', $grupDokumen->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sort_order" class="form-label fw-semibold">Urutan</label>
                        <input type="number" 
                               class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $grupDokumen->sort_order) }}"
                               min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="is_active" class="form-label fw-semibold">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $grupDokumen->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.grup-dokumens.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
