@extends('admin.layouts.app')

@section('title', 'Kelola Kolom')
@section('page-title', 'Kelola Kolom')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.lists.index') }}">Daftar Dinamis</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.lists.show', $dynamicList) }}">{{ $dynamicList->title }}</a></li>
    <li class="breadcrumb-item active">Kelola Kolom</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-columns me-2"></i>Kolom: {{ $dynamicList->title }}</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.lists.items.index', $dynamicList) }}" class="btn btn-light btn-sm">
                    <i class="fas fa-table me-1"></i> Kelola Data
                </a>
                <a href="{{ route('admin.lists.columns.create', $dynamicList) }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Kolom
                </a>
            </div>
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

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Label</th>
                        <th>Key</th>
                        <th>Tipe</th>
                        <th>Jenis Aksi</th>
                        <th class="text-center">Required</th>
                        <th class="text-center">Multi</th>
                        <th width="110" class="text-center">Lebar</th>
                        <th width="160" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($columns as $index => $column)
                        <tr>
                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                            <td><strong>{{ $column->label }}</strong></td>
                            <td><code>{{ $column->key }}</code></td>
                            <td>{{ $column->typeLabel() }}</td>
                            <td>{{ $column->actionTypeLabel() ?? '-' }}</td>
                            <td class="text-center">
                                @if($column->is_required)
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Ya</span>
                                @else
                                    <span class="badge bg-light text-dark border">Tidak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($column->is_multiple)
                                    <span class="badge bg-info">Ya</span>
                                @else
                                    <span class="badge bg-light text-dark border">Tidak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($column->hasWidth())
                                    <span class="badge bg-success">{{ $column->width }} px</span>
                                @else
                                    <span class="badge bg-light text-dark border">Otomatis</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.lists.columns.edit', [$dynamicList, $column]) }}" class="btn btn-outline-success btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.lists.columns.destroy', [$dynamicList, $column]) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus kolom ini beserta seluruh nilainya?')">
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
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-columns fa-2x mb-2"></i>
                                <p class="mb-0">Belum ada kolom. Tambahkan kolom untuk membentuk struktur data.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('admin.lists.show', $dynamicList) }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Detail Daftar
        </a>
    </div>
</div>
@endsection
