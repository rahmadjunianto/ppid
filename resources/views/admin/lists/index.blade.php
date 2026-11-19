@extends('admin.layouts.app')

@section('title', 'Daftar Dinamis')
@section('page-title', 'Daftar Dinamis')

@section('breadcrumb')
    <li class="breadcrumb-item active">Daftar Dinamis</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Dinamis</h5>
            <a href="{{ route('admin.lists.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Daftar
            </a>
        </div>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="GET" class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari judul atau slug..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach(['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'] as $value => $text)
                        <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $text }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <a href="{{ route('admin.lists.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Judul</th>
                        <th>Slug</th>
                        <th class="text-center">Kolom</th>
                        <th class="text-center">Baris</th>
                        <th class="text-center">Status</th>
                        <th width="230" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lists as $index => $list)
                        <tr>
                            <td class="text-center text-muted">{{ $lists->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $list->title }}</strong>
                                @if($list->description)
                                    <br><small class="text-muted">{{ Str::limit($list->description, 70) }}</small>
                                @endif
                            </td>
                            <td><code>{{ $list->slug }}</code></td>
                            <td class="text-center">{{ $list->columns_count }}</td>
                            <td class="text-center">{{ $list->items_count }}</td>
                            <td class="text-center">
                                @if($list->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @elseif($list->status === 'draft')
                                    <span class="badge bg-secondary">Draft</span>
                                @else
                                    <span class="badge bg-warning">Archived</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.lists.show', $list) }}" class="btn btn-outline-success btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.lists.columns.index', $list) }}" class="btn btn-outline-primary btn-sm" title="Kelola Kolom">
                                    <i class="fas fa-columns"></i>
                                </a>
                                <a href="{{ route('admin.lists.items.index', $list) }}" class="btn btn-outline-info btn-sm" title="Kelola Data">
                                    <i class="fas fa-table"></i>
                                </a>
                                <a href="{{ route('admin.lists.edit', $list) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.lists.duplicate', $list) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-secondary btn-sm" title="Duplikasi">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.lists.destroy', $list) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus daftar ini beserta kolom, data, dan file?')">
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
                                <i class="fas fa-list fa-2x mb-2"></i>
                                <p class="mb-0">Belum ada daftar dinamis.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lists->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    Menampilkan {{ $lists->firstItem() }} - {{ $lists->lastItem() }} dari {{ $lists->total() }} daftar
                </small>
                <div>{{ $lists->appends(request()->query())->links('admin-pagination') }}</div>
            </div>
        @endif
    </div>
</div>
@endsection
