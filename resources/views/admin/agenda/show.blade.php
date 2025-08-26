@extends('admin.layouts.app')

@section('title', 'Detail Agenda')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Agenda</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.agenda.index') }}">Agenda</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                {{ $agenda->judul }}
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong><i class="fas fa-calendar-event mr-2"></i>Tanggal Mulai</strong>
                                    <p class="mb-0">{{ $agenda->tanggal_mulai->format('d F Y, H:i') }} WIB</p>
                                </div>
                                <div class="col-md-6">
                                    <strong><i class="fas fa-calendar-check mr-2"></i>Tanggal Selesai</strong>
                                    <p class="mb-0">{{ $agenda->tanggal_selesai->format('d F Y, H:i') }} WIB</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong><i class="fas fa-map-marker-alt mr-2"></i>Tempat</strong>
                                    <p class="mb-0">{{ $agenda->tempat }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong><i class="fas fa-users mr-2"></i>Penyelenggara</strong>
                                    <p class="mb-0">{{ $agenda->penyelenggara }}</p>
                                </div>
                            </div>

                            @if($agenda->deskripsi)
                                <div class="mb-3">
                                    <strong><i class="fas fa-file-text mr-2"></i>Deskripsi</strong>
                                    <p class="text-justify">{{ $agenda->deskripsi }}</p>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <strong><i class="fas fa-info-circle mr-2"></i>Status</strong>
                                    <p class="mb-0">
                                        @if($agenda->status == 'published')
                                            <span class="badge badge-success">Published</span>
                                        @else
                                            <span class="badge badge-warning">Draft</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <strong><i class="fas fa-sort-numeric-up mr-2"></i>Urutan</strong>
                                    <p class="mb-0">{{ $agenda->urutan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Status Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Status Agenda</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                @if($agenda->tanggal_mulai->isFuture())
                                    <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                                    <h5 class="text-primary">Akan Datang</h5>
                                    <p class="text-muted">{{ $agenda->tanggal_mulai->diffForHumans() }}</p>
                                @elseif($agenda->tanggal_selesai->isPast())
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <h5 class="text-success">Selesai</h5>
                                    <p class="text-muted">{{ $agenda->tanggal_selesai->diffForHumans() }}</p>
                                @else
                                    <i class="fas fa-play-circle fa-3x text-warning mb-3"></i>
                                    <h5 class="text-warning">Sedang Berlangsung</h5>
                                    <p class="text-muted">Hingga {{ $agenda->tanggal_selesai->diffForHumans() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Aksi</h3>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('admin.agenda.edit', $agenda) }}" class="btn btn-warning btn-block mb-2">
                                <i class="fas fa-edit mr-1"></i>
                                Edit Agenda
                            </a>

                            @if($agenda->status == 'published')
                                <a href="{{ route('agenda.show', $agenda) }}" target="_blank" class="btn btn-info btn-block mb-2">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    Lihat di Website
                                </a>
                            @endif

                            <button type="button" class="btn btn-danger btn-block" onclick="confirmDelete()">
                                <i class="fas fa-trash mr-1"></i>
                                Hapus Agenda
                            </button>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi</h3>
                        </div>
                        <div class="card-body">
                            <small class="text-muted">
                                <strong>Dibuat:</strong><br>
                                {{ $agenda->created_at->format('d M Y H:i') }}<br><br>
                                <strong>Terakhir Diubah:</strong><br>
                                {{ $agenda->updated_at->format('d M Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus agenda <strong>"{{ $agenda->judul }}"</strong>?</p>
                <p class="text-danger">
                    <small><i class="fas fa-exclamation-triangle"></i> Tindakan ini tidak dapat dibatalkan.</small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('admin.agenda.destroy', $agenda) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    $('#deleteModal').modal('show');
}
</script>
@endpush
