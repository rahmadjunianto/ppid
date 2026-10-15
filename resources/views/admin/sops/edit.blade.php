@extends('admin.layouts.app')
@section('title', 'Edit SOP')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.sops.index') }}">Kelola SOP</a></li>
<li class="breadcrumb-item active">Edit SOP</li>
@endsection
@section('content')
<div class="row">
<div class="col-12">
<div class="card card-success">
<div class="card-header">
<h3 class="card-title"><i class="fas fa-edit mr-2"></i>Edit Dokumen SOP: {{ $sop->nama_dokumen }}</h3>
<div class="card-tools">
<a href="{{ route('admin.sops.show', $sop) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat</a>
<a href="{{ route('admin.sops.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
</div>
<form action="{{ route('admin.sops.update', $sop) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="card-body">
@if($errors->any())
<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label for="nama_dokumen">Nama Dokumen <span class="text-danger">*</span></label>
<input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror" id="nama_dokumen" name="nama_dokumen" value="{{ old('nama_dokumen', $sop->nama_dokumen) }}" required>
@error('nama_dokumen')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="nomor">Nomor SOP</label>
<input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor" value="{{ old('nomor', $sop->nomor) }}" placeholder="Contoh: SOP No. 01/PPID/2026">
@error('nomor')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="grup">Grup <span class="text-danger">*</span></label>
<select class="form-control @error('grup') is-invalid @enderror" id="grup" name="grup" required>
@foreach($grupOptions as $key => $label)
<option value="{{ $key }}" {{ old('grup', $sop->grup) == $key ? 'selected' : '' }}>{{ $label }}</option>
@endforeach
</select>
@error('grup')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="tahun">Tahun</label>
<input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', $sop->tahun) }}" min="1900" max="{{ date('Y') + 1 }}">
@error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="col-md-12">
<div class="form-group">
<label for="file">File SOP</label>
@if($sop->file)
<div class="alert alert-info"><i class="fas fa-info-circle"></i> File saat ini: <a href="{{ asset('storage/' . $sop->file) }}" target="_blank">{{ basename($sop->file) }}</a><br><small>Upload file baru untuk mengganti file yang ada</small></div>
@endif
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx">
<label class="custom-file-label" for="file">Pilih file...</label>
</div>
</div>
<small class="text-muted">Format: PDF, DOC, DOCX, XLS, XLSX. Maksimal: 10MB</small>
@error('file')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="status">Status <span class="text-danger">*</span></label>
<select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
<option value="published" {{ old('status', $sop->status) == 'published' ? 'selected' : '' }}>Published</option>
<option value="draft" {{ old('status', $sop->status) == 'draft' ? 'selected' : '' }}>Draft</option>
</select>
@error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="sort_order">Sort Order</label>
<input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $sop->sort_order ?? 0) }}" min="0">
<small class="text-muted">Urutan tampilan (semakin kecil semakin awal)</small>
@error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
</div>
</div>
<div class="card-footer">
<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Perubahan</button>
<a href="{{ route('admin.sops.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
</div>
</form>
</div>
</div>
</div>
@endsection