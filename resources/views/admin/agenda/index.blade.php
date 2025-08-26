@extends('admin.layouts.app')

@section('title', 'Data Agenda')
@section('page-title', 'Data Agenda')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Agenda</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Daftar Agenda
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Agenda
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Filter -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('admin.agenda.index') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text"
                                               name="search"
                                               class="form-control"
                                               placeholder="Cari agenda..."
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <select name="status" class="form-control">
                                            <option value="">Semua Status</option>
                                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                        <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Results Count -->
                    <p class="text-muted">
                        Menampilkan {{ $agendas->firstItem() ?? 0 }} - {{ $agendas->lastItem() ?? 0 }}
                        dari {{ $agendas->total() }} agenda
                    </p>

                    <!-- Table -->
                    @if($agendas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="60">No</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Tempat</th>
                                        <th width="100">Status</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agendas as $index => $agenda)
                                        <tr>
                                            <td>{{ $agendas->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $agenda->judul }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{ Str::limit($agenda->deskripsi, 80) }}
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    {{ $agenda->tanggal_mulai->format('d/m/Y') }}
                                                    <br>
                                                    {{ $agenda->tanggal_mulai->format('H:i') }}
                                                </small>
                                            </td>
                                            <td>{{ Str::limit($agenda->tempat, 30) }}</td>
                                            <td class="text-center">
                                                @if($agenda->status == 'published')
                                                    <span class="badge badge-success">Published</span>
                                                @else
                                                    <span class="badge badge-secondary">Draft</span>
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
                                                    <form action="{{ route('admin.agenda.destroy', $agenda) }}"
                                                          method="POST"
                                                          style="display: inline-block;"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data agenda</p>
                        </div>
                    @endif
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
                </div>
            </div>
        </div>
    </div>
@endsection
