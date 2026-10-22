{{--
    Satu baris form untuk multiple form (Tambah banyak SOP sekaligus).

    Variabel:
    - $idx     : indeks baris (angka, atau string "__INDEX__" untuk template JS)
    - $grupOptions : daftar grup
--}}
@php
    $errPrefix = 'items.' . $idx . '.';
@endphp
<div class="card sop-item-row mb-3" data-row-index="{{ $idx }}">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <strong class="sop-item-title">
            <i class="fas fa-file-alt mr-1"></i> Dokumen <span class="sop-item-number">{{ is_numeric($idx) ? $idx + 1 : '' }}</span>
        </strong>
        <button type="button" class="btn btn-danger btn-sm btn-remove-row">
            <i class="fas fa-trash"></i> Hapus Baris
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Dokumen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error($errPrefix . 'nama_dokumen') is-invalid @enderror"
                           name="items[{{ $idx }}][nama_dokumen]"
                           value="{{ old($errPrefix . 'nama_dokumen') }}"
                           placeholder="Contoh: SOP Permohonan Informasi PPID">
                    @error($errPrefix . 'nama_dokumen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nomor SOP</label>
                    <input type="text" class="form-control @error($errPrefix . 'nomor') is-invalid @enderror"
                           name="items[{{ $idx }}][nomor]"
                           value="{{ old($errPrefix . 'nomor') }}"
                           placeholder="Contoh: SOP No. 01/PPID/2026">
                    @error($errPrefix . 'nomor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Grup <span class="text-danger">*</span></label>
                    <select class="form-control @error($errPrefix . 'grup') is-invalid @enderror"
                            name="items[{{ $idx }}][grup]">
                        <option value="">-- Pilih Grup --</option>
                        @foreach($grupOptions as $key => $label)
                            <option value="{{ $key }}" {{ old($errPrefix . 'grup') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error($errPrefix . 'grup')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tahun</label>
                    <input type="number" class="form-control @error($errPrefix . 'tahun') is-invalid @enderror"
                           name="items[{{ $idx }}][tahun]"
                           value="{{ old($errPrefix . 'tahun', date('Y')) }}"
                           min="1900" max="{{ date('Y') + 1 }}">
                    @error($errPrefix . 'tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>File SOP <span class="text-danger">*</span></label>
                    <input type="file" class="form-control-file @error($errPrefix . 'file') is-invalid @enderror"
                           name="items[{{ $idx }}][file]"
                           accept=".pdf,.doc,.docx,.xls,.xlsx">
                    <small class="text-muted d-block sop-file-name">Format: PDF, DOC, DOCX, XLS, XLSX. Maksimal: 10MB</small>
                    @error($errPrefix . 'file')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <select class="form-control @error($errPrefix . 'status') is-invalid @enderror"
                            name="items[{{ $idx }}][status]" required>
                        <option value="published" {{ old($errPrefix . 'status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old($errPrefix . 'status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    @error($errPrefix . 'status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" class="form-control @error($errPrefix . 'sort_order') is-invalid @enderror"
                           name="items[{{ $idx }}][sort_order]"
                           value="{{ old($errPrefix . 'sort_order', 0) }}" min="0">
                    <small class="text-muted">Urutan tampilan (semakin kecil semakin awal)</small>
                    @error($errPrefix . 'sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
