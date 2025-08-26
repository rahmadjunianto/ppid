@extends('admin.layouts.app')

@section('title', 'Edit Pegawai')
@section('page-title', 'Edit Pegawai')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pegawai.index') }}">Data Pegawai</a></li>
    <li class="breadcrumb-item active">Edit Pegawai</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit mr-2"></i>
                        Edit Data Pegawai
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.pegawai.update', $pegawai) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('nama') is-invalid @enderror"
                                           id="nama"
                                           name="nama"
                                           value="{{ old('nama', $pegawai->nama) }}"
                                           required>
                                    @error('nama')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('jabatan') is-invalid @enderror"
                                           id="jabatan"
                                           name="jabatan"
                                           value="{{ old('jabatan', $pegawai->jabatan) }}"
                                           required>
                                    @error('jabatan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="golongan">Golongan</label>
                                    <input type="text"
                                           class="form-control @error('golongan') is-invalid @enderror"
                                           id="golongan"
                                           name="golongan"
                                           value="{{ old('golongan', $pegawai->golongan) }}"
                                           placeholder="Contoh: III/c">
                                    @error('golongan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="unit_kerja">Unit Kerja <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('unit_kerja') is-invalid @enderror"
                                           id="unit_kerja"
                                           name="unit_kerja"
                                           value="{{ old('unit_kerja', $pegawai->unit_kerja) }}"
                                           required>
                                    @error('unit_kerja')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="urutan">Urutan Tampil</label>
                                    <input type="number"
                                           class="form-control @error('urutan') is-invalid @enderror"
                                           id="urutan"
                                           name="urutan"
                                           value="{{ old('urutan', $pegawai->urutan) }}"
                                           min="0">
                                    <small class="form-text text-muted">Urutan tampil di halaman publik (0 = paling atas).</small>
                                    @error('urutan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
