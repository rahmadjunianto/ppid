@extends('admin.layouts.app')

@section('title', 'Tambah Agenda')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Agenda</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.agenda.index') }}">Agenda</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus mr-2"></i>
                        Form Tambah Agenda
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.agenda.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="judul">Judul Agenda <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                           id="judul" name="judul" value="{{ old('judul') }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                              id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                                   id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                            @error('tanggal_mulai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                                   id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                            @error('tanggal_selesai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tempat">Tempat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tempat') is-invalid @enderror"
                                           id="tempat" name="tempat" value="{{ old('tempat') }}" required>
                                    @error('tempat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="penyelenggara">Penyelenggara <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('penyelenggara') is-invalid @enderror"
                                           id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara') }}" required>
                                    @error('penyelenggara')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Pengaturan</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                    id="status" name="status" required>
                                                <option value="">Pilih Status</option>
                                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="urutan">Urutan</label>
                                            <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                                   id="urutan" name="urutan" value="{{ old('urutan') }}" min="1">
                                            <small class="text-muted">Kosongkan untuk otomatis</small>
                                            @error('urutan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="preview" onclick="previewAgenda()">
                                                <label class="custom-control-label" for="preview">Preview Data</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>
                                    Simpan Agenda
                                </button>
                                <button type="reset" class="btn btn-secondary ml-2">
                                    <i class="fas fa-undo mr-1"></i>
                                    Reset
                                </button>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('admin.agenda.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times mr-1"></i>
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
function previewAgenda() {
    const checkbox = document.getElementById('preview');
    if (checkbox.checked) {
        // Collect form data
        const judul = document.getElementById('judul').value;
        const deskripsi = document.getElementById('deskripsi').value;
        const tanggal_mulai = document.getElementById('tanggal_mulai').value;
        const tanggal_selesai = document.getElementById('tanggal_selesai').value;
        const tempat = document.getElementById('tempat').value;
        const penyelenggara = document.getElementById('penyelenggara').value;
        const status = document.getElementById('status').value;

        let preview = `
            <strong>Preview Agenda:</strong><br>
            <strong>Judul:</strong> ${judul || 'Belum diisi'}<br>
            <strong>Deskripsi:</strong> ${deskripsi || 'Belum diisi'}<br>
            <strong>Tanggal Mulai:</strong> ${tanggal_mulai || 'Belum diisi'}<br>
            <strong>Tanggal Selesai:</strong> ${tanggal_selesai || 'Belum diisi'}<br>
            <strong>Tempat:</strong> ${tempat || 'Belum diisi'}<br>
            <strong>Penyelenggara:</strong> ${penyelenggara || 'Belum diisi'}<br>
            <strong>Status:</strong> ${status || 'Belum diisi'}
        `;

        Swal.fire({
            title: 'Preview Agenda',
            html: preview,
            icon: 'info',
            confirmButtonText: 'OK'
        });

        checkbox.checked = false;
    }
}

// Auto-fill tanggal selesai when tanggal mulai changes
document.getElementById('tanggal_mulai').addEventListener('change', function() {
    const tanggalMulai = this.value;
    const tanggalSelesaiField = document.getElementById('tanggal_selesai');

    if (tanggalMulai && !tanggalSelesaiField.value) {
        tanggalSelesaiField.value = tanggalMulai;
    }
});
</script>
@endpush
