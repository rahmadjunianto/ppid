@extends('admin.layouts.app')

@section('title', 'Kelola Agenda')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-he                    <!-- Pagination -->
                    @if($agendas->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <small class="text-muted">
                                    Menampilkan {{ $agendas->firstItem() }} - {{ $agendas->lastItem() }} 
                                    dari {{ $agendas->total() }} agenda
                                </small>
                            </div>
                            <div>
                                {{ $agendas->appends(request()->query())->links('admin-pagination') }}
                            </div>
                        </div>
                    @endif <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kelola Agenda</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Agenda</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="card-title">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Daftar Agenda
                            </h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-1"></i>
                                Tambah Agenda
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filter & Search -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('admin.agenda.index') }}" class="form-inline">
                                <div class="input-group mr-3">
                                    <input type="text" class="form-control" name="search"
                                           value="{{ request('search') }}"
                                           placeholder="Cari agenda..." style="width: 300px;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <select class="form-control mr-2" name="status" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>

                                @if(request()->hasAny(['search', 'status']))
                                    <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Reset
                                    </a>
                                @endif
                            </form>
                        </div>
                        <div class="col-md-4 text-right">
                            <small class="text-muted">
                                Total: {{ $agendas->total() }} agenda
                            </small>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="5%">Urutan</th>
                                    <th width="25%">Judul</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="15%">Tempat</th>
                                    <th width="15%">Penyelenggara</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agendas as $index => $agenda)
                                    <tr>
                                        <td>{{ $agendas->firstItem() + $index }}</td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $agenda->urutan }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $agenda->judul }}</strong>
                                            @if($agenda->deskripsi)
                                                <br>
                                                <small class="text-muted">
                                                    {{ Str::limit($agenda->deskripsi, 80) }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                <strong>Mulai:</strong><br>
                                                {{ $agenda->tanggal_mulai->format('d/m/Y H:i') }}<br>
                                                <strong>Selesai:</strong><br>
                                                {{ $agenda->tanggal_selesai->format('d/m/Y H:i') }}
                                            </small>
                                        </td>
                                        <td>{{ $agenda->tempat }}</td>
                                        <td>{{ $agenda->penyelenggara }}</td>
                                        <td>
                                            @if($agenda->status == 'published')
                                                <span class="badge badge-success">Published</span>
                                            @else
                                                <span class="badge badge-warning">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.agenda.show', $agenda) }}"
                                                   class="btn btn-info btn-sm" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.agenda.edit', $agenda) }}"
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete({{ $agenda->id }})" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Tidak ada agenda ditemukan</h5>
                                            @if(request()->hasAny(['search', 'status']))
                                                <p class="text-muted">Coba ubah filter pencarian</p>
                                            @else
                                                <p class="text-muted">Belum ada agenda yang ditambahkan</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($agendas->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <small class="text-muted">
                                    Menampilkan {{ $agendas->firstItem() }} - {{ $agendas->lastItem() }}
                                    dari {{ $agendas->total() }} agenda
                                </small>
                            </div>
                            <div>
                                {{ $agendas->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif
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
                <p>Apakah Anda yakin ingin menghapus agenda ini?</p>
                <p class="text-danger">
                    <small><i class="fas fa-exclamation-triangle"></i> Tindakan ini tidak dapat dibatalkan.</small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
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
function confirmDelete(agendaId) {
    const form = document.getElementById('deleteForm');
    form.action = `{{ route('admin.agenda.index') }}/${agendaId}`;
    $('#deleteModal').modal('show');
}

// Auto close alerts
$(document).ready(function() {
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endpush
