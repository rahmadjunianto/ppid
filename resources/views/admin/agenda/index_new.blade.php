@extends('admin.layouts.app')

@section('title', 'Kelola Agenda')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
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
                    @if($agendas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Judul</th>
                                        <th width="120">Tanggal</th>
                                        <th width="150">Tempat</th>
                                        <th width="100">Status</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agendas as $index => $agenda)
                                        <tr>
                                            <td class="text-center">{{ $agendas->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $agenda->judul }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{ Str::limit($agenda->deskripsi, 80) }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <small>
                                                    {{ $agenda->tanggal_mulai->format('d/m/Y') }}
                                                    <br>
                                                    {{ $agenda->tanggal_mulai->format('H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <small>{{ Str::limit($agenda->tempat, 30) }}</small>
                                            </td>
                                            <td class="text-center">
                                                @if($agenda->status == 'published')
                                                    <span class="badge badge-success">Published</span>
                                                @else
                                                    <span class="badge badge-secondary">Draft</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
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

                                                <form id="delete-form-{{ $agenda->id }}"
                                                      action="{{ route('admin.agenda.destroy', $agenda) }}"
                                                      method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
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
                                    {{ $agendas->appends(request()->query())->links('admin-pagination') }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada agenda ditemukan</h5>
                            <p class="text-muted">
                                @if(request()->hasAny(['search', 'status']))
                                    Coba ubah filter pencarian atau
                                    <a href="{{ route('admin.agenda.index') }}">reset filter</a>
                                @else
                                    Mulai dengan <a href="{{ route('admin.agenda.create') }}">menambah agenda baru</a>
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data agenda akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
@endsection
