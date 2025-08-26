@extends('admin.layouts.app')

@section('title', 'Edit Agenda')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Agenda</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.agenda.index') }}">Agenda</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        <i class="fas fa-edit mr-2"></i>
                        Form Edit Agenda
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.agenda.update', $agenda) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                                           id="judul" name="judul" value="{{ old('judul', $agenda->judul) }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                              id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $agenda->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                                   id="tanggal_mulai" name="tanggal_mulai" 
                                                   value="{{ old('tanggal_mulai', $agenda->tanggal_mulai->format('Y-m-d\TH:i')) }}" required>
                                            @error('tanggal_mulai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                                   id="tanggal_selesai" name="tanggal_selesai" 
                                                   value="{{ old('tanggal_selesai', $agenda->tanggal_selesai->format('Y-m-d\TH:i')) }}" required>
                                            @error('tanggal_selesai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tempat">Tempat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tempat') is-invalid @enderror" 
                                           id="tempat" name="tempat" value="{{ old('tempat', $agenda->tempat) }}" required>
                                    @error('tempat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="penyelenggara">Penyelenggara <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('penyelenggara') is-invalid @enderror" 
                                           id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara', $agenda->penyelenggara) }}" required>
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
                                                <option value="draft" {{ old('status', $agenda->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', $agenda->status) == 'published' ? 'selected' : '' }}>Published</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="urutan">Urutan</label>
                                            <input type="number" class="form-control @error('urutan') is-invalid @enderror" 
                                                   id="urutan" name="urutan" value="{{ old('urutan', $agenda->urutan) }}" min="1">
                                            <small class="text-muted">Kosongkan untuk otomatis</small>
                                            @error('urutan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Informasi</label>
                                            <div class="bg-light p-2 rounded">
                                                <small class="text-muted">
                                                    <strong>Dibuat:</strong><br>
                                                    {{ $agenda->created_at->format('d M Y H:i') }}<br>
                                                    <strong>Diubah:</strong><br>
                                                    {{ $agenda->updated_at->format('d M Y H:i') }}
                                                </small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <a href="{{ route('agenda.show', $agenda) }}" target="_blank" class="btn btn-info btn-sm btn-block">
                                                <i class="fas fa-eye mr-1"></i>
                                                Lihat di Website
                                            </a>
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
                                    Update Agenda
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
// Auto-fill tanggal selesai when tanggal mulai changes
document.getElementById('tanggal_mulai').addEventListener('change', function() {
    const tanggalMulai = this.value;
    const tanggalSelesaiField = document.getElementById('tanggal_selesai');
    
    // Only auto-fill if tanggal_selesai is empty or earlier than tanggal_mulai
    if (tanggalMulai && (!tanggalSelesaiField.value || tanggalSelesaiField.value < tanggalMulai)) {
        tanggalSelesaiField.value = tanggalMulai;
    }
});
</script>
@endpush
