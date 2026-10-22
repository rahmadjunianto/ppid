{{--
    Formulir bersama untuk tambah / edit regulasi.

    Variabel:
    - $regulasi      : model Regulasi (null pada mode tambah)
    - $tingkatOptions : daftar tingkat regulasi
--}}
@php
    $isEdit       = isset($regulasi) && $regulasi;
    $currentType  = old('link_type', $isEdit ? $regulasi->link_type : 'file');
    $currentUrl   = old('link_url', $isEdit ? $regulasi->link_url : null);
    $currentFile  = $isEdit ? $regulasi->file : null;
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="nama_regulasi">Nama Regulasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama_regulasi') is-invalid @enderror" id="nama_regulasi" name="nama_regulasi" value="{{ old('nama_regulasi', $isEdit ? $regulasi->nama_regulasi : '') }}" required>
            @error('nama_regulasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nomor">Nomor</label>
            <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor" name="nomor" value="{{ old('nomor', $isEdit ? $regulasi->nomor : '') }}" placeholder="Contoh: UU No. 14/2008">
            @error('nomor')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tahun">Tahun</label>
            <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', $isEdit ? $regulasi->tahun : '') }}" min="1900" max="{{ date('Y') + 1 }}">
            @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tingkat">Tingkat <span class="text-danger">*</span></label>
            <select class="form-control @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat" required>
                @foreach($tingkatOptions as $key => $label)
                    <option value="{{ $key }}" {{ old('tingkat', $isEdit ? $regulasi->tingkat : 'pusat') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('tingkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="link_type">Sumber Dokumen <span class="text-danger">*</span></label>
            <select class="form-control @error('link_type') is-invalid @enderror" id="link_type" name="link_type" required>
                <option value="file" {{ $currentType == 'file' ? 'selected' : '' }}>Upload File</option>
                <option value="link" {{ $currentType == 'link' ? 'selected' : '' }}>Tautan Eksternal</option>
            </select>
            @error('link_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>


    <div class="col-md-12">
        <div class="form-group" id="field-file">
            <label for="file">File Dokumen {!! $isEdit ? '' : '<span class="text-danger">*</span>' !!}</label>
            @if($currentFile)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> File saat ini: <a href="{{ asset('storage/' . $currentFile) }}" target="_blank">{{ basename($currentFile) }}</a><br>
                    <small>Upload file baru untuk mengganti file yang ada</small>
                </div>
            @endif
            <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx">
            <small class="text-muted d-block">Format: PDF, DOC, DOCX, XLS, XLSX. Maksimal: 10MB</small>
            @error('file')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
        <div class="form-group d-none" id="field-link">
            <label for="link_url">URL Tautan {!! $isEdit ? '' : '<span class="text-danger">*</span>' !!}</label>
            <input type="url" class="form-control @error('link_url') is-invalid @enderror" id="link_url" name="link_url" value="{{ $currentUrl }}" placeholder="https://contoh.go.id/dokumen.pdf">
            <small class="text-muted d-block">Tautan dokumen eksternal, akan dibuka di tab baru.</small>
            @error('link_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="published" {{ old('status', $isEdit ? $regulasi->status : 'published') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ old('status', $isEdit ? $regulasi->status : 'published') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="sort_order">Sort Order</label>
            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $isEdit ? $regulasi->sort_order : 0) }}" min="0">
            <small class="text-muted">Urutan tampilan (semakin kecil semakin awal)</small>
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
