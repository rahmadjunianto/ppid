{{--
    Satu baris form untuk multiple form (Tambah banyak dokumen sekaligus).

    Variabel:
    - $idx          : indeks baris (angka, atau string "__INDEX__" untuk template JS)
    - $grupDokumens : daftar grup dokumen
--}}
@php
    $errPrefix = 'items.' . $idx . '.';
    $rowId    = is_numeric($idx) ? (int) $idx : $idx;
@endphp
<div class="card pustaka-item-row mb-3" data-row-index="{{ $rowId }}">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <strong class="pustaka-item-title">
            <i class="fas fa-file-alt mr-1"></i> Dokumen <span class="pustaka-item-number">{{ is_numeric($idx) ? $idx + 1 : '' }}</span>
        </strong>
        <button type="button" class="btn btn-danger btn-sm btn-remove-row">
            <i class="fas fa-trash"></i> Hapus Baris
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kategori Dokumen <span class="text-danger">*</span></label>
                    <select class="form-control @error($errPrefix . 'grup_dokumen_id') is-invalid @enderror"
                            name="items[{{ $idx }}][grup_dokumen_id]">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($grupDokumens as $grup)
                            <option value="{{ $grup->id }}" {{ (string) old($errPrefix . 'grup_dokumen_id') === (string) $grup->id ? 'selected' : '' }}>
                                {{ $grup->nama_grup }}
                            </option>
                        @endforeach
                    </select>
                    @error($errPrefix . 'grup_dokumen_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Dokumen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error($errPrefix . 'nama_dokumen') is-invalid @enderror"
                           name="items[{{ $idx }}][nama_dokumen]"
                           value="{{ old($errPrefix . 'nama_dokumen') }}"
                           placeholder="Contoh: Dokumen Keterbukaan Informasi">
                    @error($errPrefix . 'nama_dokumen')
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
                           placeholder="Contoh: 001/INFO/2026">
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
                           min="2000" max="2100">
                    @error($errPrefix . 'tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea class="form-control @error($errPrefix . 'deskripsi') is-invalid @enderror"
                              name="items[{{ $idx }}][deskripsi]"
                              rows="2"
                              placeholder="Deskripsi singkat (opsional)">{{ old($errPrefix . 'deskripsi') }}</textarea>
                    @error($errPrefix . 'deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tipe Dokumen <span class="text-danger">*</span></label>
                    <div class="border rounded p-3 pustaka-file-option">
                        <label class="form-check-label fw-bold mb-0">
                            <input class="form-check-input pustaka-link-type" type="radio"
                                   name="items[{{ $idx }}][link_type]" value="file"
                                   {{ old($errPrefix . 'link_type', 'file') == 'file' ? 'checked' : '' }}>
                            <i class="fas fa-upload me-1"></i> Upload File
                        </label>
                        <div class="mt-2 pustaka-file-section">
                            <input type="file" class="form-control @error($errPrefix . 'file') is-invalid @enderror"
                                   name="items[{{ $idx }}][file]"
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg">
                            <small class="text-muted d-block pustaka-file-name">Format: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG (Max: 10MB)</small>
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
                    <div class="border rounded p-3 pustaka-link-option">
                        <label class="form-check-label fw-bold mb-0">
                            <input class="form-check-input pustaka-link-type" type="radio"
                                   name="items[{{ $idx }}][link_type]" value="link"
                                   {{ old($errPrefix . 'link_type') == 'link' ? 'checked' : '' }}>
                            <i class="fas fa-link me-1"></i> Input Link
                        </label>
                        <div class="mt-2 pustaka-link-section">
                            <input type="url" class="form-control @error($errPrefix . 'link_url') is-invalid @enderror"
                                   name="items[{{ $idx }}][link_url]"
                                   value="{{ old($errPrefix . 'link_url') }}"
                                   placeholder="https://example.com/dokumen.pdf">
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

