@extends('admin.layouts.app')

@section('title', 'Pustaka Dokumen')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-book me-2"></i>Pustaka Dokumen</h5>
            <a href="{{ route('admin.pustaka-dokumens.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Tambah Dokumen
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filter Form -->
        <form method="GET" class="row g-3 mb-3">
            <div class="col-md-4">
                <select name="grup" class="form-select">
                    <option value="">Semua Grup</option>
                    @foreach($grupDokumens as $grup)
                        <option value="{{ $grup->id }}" {{ request('grup') == $grup->id ? 'selected' : '' }}>
                            {{ $grup->nama_grup }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" 
                       placeholder="Cari nama dokumen..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn text-white me-1" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%);">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('admin.pustaka-dokumens.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Nama Dokumen</th>
                        <th>Deskripsi</th>
                        <th>Grup</th>
                        <th>Nomor</th>
                        <th>Tahun</th>
                        <th>Tipe</th>
                        <th width="140" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pustakaDokumens as $index => $dok)
                    <tr>
                        <td class="text-center text-muted">{{ $pustakaDokumens->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $dok->nama_dokumen }}</strong>
                            @if($dok->link_type === 'file' && $dok->file)
                                <span class="badge bg-secondary ms-1">{{ strtoupper(pathinfo($dok->file, PATHINFO_EXTENSION)) }}</span>
                            @endif
                            @if($dok->link_type === 'link' && $dok->link_url)
                                <br><small class="text-muted">{{ Str::limit($dok->link_url, 40) }}</small>
                            @endif
                        </td>
                        <td class="text-muted small">{{ Str::limit($dok->deskripsi, 60) ?? '-' }}</td>
                        <td>
                            <span class="badge" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">{{ $dok->grupDokumen->nama_grup ?? '-' }}</span>
                        </td>
                        <td class="text-muted">{{ $dok->nomor ?? '-' }}</td>
                        <td class="text-muted">{{ $dok->tahun ?? '-' }}</td>
                        <td>
                            @if($dok->link_type === 'file')
                                <span class="badge" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;"><i class="fas fa-file"></i> File</span>
                            @else
                                <span class="badge bg-info"><i class="fas fa-link"></i> Link</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.pustaka-dokumens.edit', $dok->id) }}" 
                               class="btn btn-outline-success btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.pustaka-dokumens.destroy', $dok->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus dokumen ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-file-alt fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada dokumen.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $pustakaDokumens->links() }}
        </div>
    </div>
</div>
@endsection
