{{--
    Satu baris form untuk multiple form (Tambah banyak regulasi sekaligus).

    Variabel:
    - $idx            : indeks baris (angka, atau string "__INDEX__" untuk template JS)
    - $tingkatOptions : daftar tingkat regulasi
--}}
@php
    $errPrefix = 'items.' . $idx . '.';
    $rowId    = is_numeric($idx) ? (int) $idx : $idx;
    $oldType  = old($errPrefix . 'link_type', 'file');
@endphp
<div class="card regulasi-item-row mb-3" data-row-index="{{ $rowId }}">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <strong class="regulasi-item-title">
            <i class="fas fa-book mr-1"></i> Regulasi <span class="regulasi-item-number">{{ is_numeric($idx) ? $idx + 1 : '' }}</span>
        </strong>
        <button type="button" class="btn btn-danger btn-sm btn-remove-row">
            <i class="fas fa-trash"></i> Hapus Baris
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Nama Regulasi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error($errPrefix . 'nama_regulasi') is-invalid @enderror"
                           name="items[{{ $idx }}][nama_regulasi]"
                           value="{{ old($errPrefix . 'nama_regulasi') }}"
                           placeholder="Contoh: UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik">
                    @error($errPrefix . 'nama_regulasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nomor</label>
                    <input type="text" class="form-control @error($errPrefix . 'nomor') is-invalid @enderror"
                           name="items[{{ $idx }}][nomor]"
                           value="{{ old($errPrefix . 'nomor') }}"
                           placeholder="Contoh: UU No. 14/2008">
                    @error($errPrefix . 'nomor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tingkat <span class="text-danger">*</span></label>
                    <select class="form-control @error($errPrefix . 'tingkat') is-invalid @enderror"
                            name="items[{{ $idx }}][tingkat]">
                        @foreach($tingkatOptions as $key => $label)
                            <option value="{{ $key }}" {{ old($errPrefix . 'tingkat', 'pusat') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error($errPrefix . 'tingkat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <select class="form-control @error($errPrefix . 'status') is-invalid @enderror"
                            name="items[{{ $idx }}][status]">
                        <option value="published" {{ old($errPrefix . 'status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old($errPrefix . 'status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    @error($errPrefix . 'status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
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

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Sumber Dokumen <span class="text-danger">*</span></label>
                    <div class="border rounded p-3 regulasi-file-option">
                        <label class="form-check-label fw-bold mb-0">
                            <input class="form-check-input regulasi-link-type" type="radio"
                                   name="items[{{ $idx }}][link_type]" value="file"
                                   {{ $oldType == 'file' ? 'checked' : '' }}>
                            <i class="fas fa-upload me-1"></i> Upload File
                        </label>
                        <div class="mt-2 regulasi-file-section">
                            <input type="file" class="form-control @error($errPrefix . 'file') is-invalid @enderror"
                                   name="items[{{ $idx }}][file]"
                                   accept=".pdf,.doc,.docx,.xls,.xlsx">
                            <small class="text-muted d-block regulasi-file-name">Format: PDF, DOC, DOCX, XLS, XLSX (Maks: 10MB)</small>
                            @error($errPrefix . 'file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div class="border rounded p-3 regulasi-link-option">
                        <label class="form-check-label fw-bold mb-0">
                            <input class="form-check-input regulasi-link-type" type="radio"
                                   name="items[{{ $idx }}][link_type]" value="link"
                                   {{ $oldType == 'link' ? 'checked' : '' }}>
                            <i class="fas fa-link me-1"></i> Input Link
                        </label>
                        <div class="mt-2 regulasi-link-section">
                            <input type="url" class="form-control @error($errPrefix . 'link_url') is-invalid @enderror"
                                   name="items[{{ $idx }}][link_url]"
                                   value="{{ old($errPrefix . 'link_url') }}"
                                   placeholder="https://contoh.go.id/dokumen.pdf">
                            @error($errPrefix . 'link_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
