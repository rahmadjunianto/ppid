@extends('admin.layouts.app')
@section('title', 'Edit Dokumen')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Dokumen</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.pustaka-dokumens.update', $pustakaDokumen->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="grup_dokumen_id" class="form-label fw-semibold">Kategori Dokumen <span class="text-danger">*</span></label>
                <select class="form-select" id="grup_dokumen_id" name="grup_dokumen_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($grupDokumens as $grup)
                        <option value="{{ $grup->id }}" {{ old('grup_dokumen_id', $pustakaDokumen->grup_dokumen_id) == $grup->id ? 'selected' : '' }}>{{ $grup->nama_grup }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="nama_dokumen" class="form-label fw-semibold">Nama Dokumen <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen" value="{{ old('nama_dokumen', $pustakaDokumen->nama_dokumen) }}" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2">{{ old('deskripsi', $pustakaDokumen->deskripsi) }}</textarea>
                <small class="text-muted">Deskripsi singkat tentang dokumen (opsional)</small>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3"><label for="nomor" class="form-label fw-semibold">Nomor</label>
                        <input type="text" class="form-control" id="nomor" name="nomor" value="{{ old('nomor', $pustakaDokumen->nomor) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3"><label for="tahun" class="form-label fw-semibold">Tahun</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" value="{{ old('tahun', $pustakaDokumen->tahun) }}" min="2000" max="2100">
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Tipe Dokumen</label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check border rounded p-3" id="file-option">
                            <input class="form-check-input" type="radio" name="link_type" id="type_file" value="file" {{ old('link_type', $pustakaDokumen->link_type) == 'file' ? 'checked' : '' }} onclick="toggleLinkType('file')">
                            <label class="form-check-label fw-bold" for="type_file"><i class="fas fa-upload me-1"></i> Upload File</label>
                            <div id="file-input-section" class="mt-2">
                                @if($pustakaDokumen->file)
                                    <div class="alert alert-info py-2 mb-2">
                                        <i class="fas fa-file-pdf me-1"></i> 
                                        <strong>{{ $pustakaDokumen->nama_dokumen }}</strong>.{{ pathinfo($pustakaDokumen->file, PATHINFO_EXTENSION) }}
                                        <span class="text-muted">({{ $pustakaDokumen->ukuran ?? '-' }})</span>
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg">
                                <small class="text-muted">Kosongkan jika tidak diganti</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check border rounded p-3" id="link-option">
                            <input class="form-check-input" type="radio" name="link_type" id="type_link" value="link" {{ old('link_type', $pustakaDokumen->link_type) == 'link' ? 'checked' : '' }} onclick="toggleLinkType('link')">
                            <label class="form-check-label fw-bold" for="type_link"><i class="fas fa-link me-1"></i> Input Link</label>
                            <div id="link-input-section" class="mt-2 {{ old('link_type', $pustakaDokumen->link_type) == 'link' ? '' : 'd-none' }}">
                                <input type="url" class="form-control" id="link_url" name="link_url" value="{{ old('link_url', $pustakaDokumen->link_url) }}" placeholder="https://example.com/dokumen.pdf">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('admin.pustaka-dokumens.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
function toggleLinkType(type) {
    document.getElementById('file-input-section').classList.toggle('d-none', type !== 'file');
    document.getElementById('link-input-section').classList.toggle('d-none', type !== 'link');
    document.getElementById('file-option').classList.toggle('border-success', type === 'file');
    document.getElementById('file-option').classList.toggle('bg-success bg-opacity-10', type === 'file');
    document.getElementById('link-option').classList.toggle('border-success', type === 'link');
    document.getElementById('link-option').classList.toggle('bg-success bg-opacity-10', type === 'link');
}
document.addEventListener('DOMContentLoaded', function() { toggleLinkType('{{ old('link_type', $pustakaDokumen->link_type) }}'); });
</script>
@endsection
