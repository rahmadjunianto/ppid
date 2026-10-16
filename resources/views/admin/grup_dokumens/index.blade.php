@extends('admin.layouts.app')

@section('title', 'Master Grup Dokumen')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-folder-open me-2"></i>Master Grup Dokumen</h5>
            <a href="{{ route('admin.grup-dokumens.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Tambah Grup
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

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Nama Grup</th>
                        <th>Slug</th>
                        <th>Deskripsi</th>
                        <th width="80" class="text-center">Sort</th>
                        <th width="80" class="text-center">Status</th>
                        <th width="120" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grupDokumens as $index => $grup)
                    <tr>
                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                        <td><strong>{{ $grup->nama_grup }}</strong></td>
                        <td><code>{{ $grup->slug }}</code></td>
                        <td class="text-muted">{{ Str::limit($grup->deskripsi, 50) }}</td>
                        <td class="text-center text-muted">{{ $grup->sort_order }}</td>
                        <td class="text-center">
                            @if($grup->is_active)
                                <span class="badge" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.grup-dokumens.edit', $grup->id) }}" 
                               class="btn btn-outline-success btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.grup-dokumens.destroy', $grup->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus grup ini? Dokumen terkait juga akan ikut terhapus.')">
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
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada grup dokumen.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
