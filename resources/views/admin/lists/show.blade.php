@extends('admin.layouts.app')

@section('title', 'Detail '.$dynamicList->title)
@section('page-title', 'Detail Daftar Dinamis')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.lists.index') }}">Daftar Dinamis</a></li>
    <li class="breadcrumb-item active">{{ $dynamicList->title }}</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>{{ $dynamicList->title }}</h5>
            <div class="d-flex gap-2">
                <a href="{{ $dynamicList->public_url }}" target="_blank" class="btn btn-light btn-sm">
                    <i class="fas fa-external-link-alt me-1"></i> Lihat Publik
                </a>
                <a href="{{ route('admin.lists.items.index', $dynamicList) }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-table me-1"></i> Kelola Data
                </a>
                <a href="{{ route('admin.lists.columns.index', $dynamicList) }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-columns me-1"></i> Kelola Kolom
                </a>
                <a href="{{ route('admin.lists.edit', $dynamicList) }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-edit me-1"></i> Edit
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

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header py-2"><strong>Informasi Daftar</strong></div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Judul:</strong> {{ $dynamicList->title }}</p>
                        <p class="mb-2"><strong>Slug:</strong> <code>{{ $dynamicList->slug }}</code></p>
                        <p class="mb-2"><strong>URL Publik:</strong>
                            <a href="{{ $dynamicList->public_url }}" target="_blank">{{ $dynamicList->public_url }}</a>
                        </p>
                        <p class="mb-2">
                            <strong>Status:</strong>
                            @if($dynamicList->status === 'published')
                                <span class="badge bg-success">Published</span>
                            @elseif($dynamicList->status === 'draft')
                                <span class="badge bg-secondary">Draft</span>
                            @else
                                <span class="badge bg-warning">Archived</span>
                            @endif
                        </p>
                        <p class="mb-2"><strong>Tampilkan Judul Publik:</strong> {{ $dynamicList->show_title ? 'Ya' : 'Tidak' }}</p>
                        <p class="mb-0"><strong>Deskripsi:</strong><br>{{ $dynamicList->description ?: '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center">
                        <strong>Struktur Kolom ({{ $dynamicList->columns->count() }})</strong>
                        <a href="{{ route('admin.lists.columns.create', $dynamicList) }}" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-plus me-1"></i> Tambah Kolom
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <thead style="background: #f1f3f5;">
                                    <tr>
                                        <th width="50" class="text-center">No</th>
                                        <th>Label</th>
                                        <th>Key</th>
                                        <th>Tipe</th>
                                        <th>Jenis Aksi</th>
                                        <th width="100" class="text-center">Lebar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dynamicList->columns as $index => $column)
                                        <tr>
                                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                                            <td>{{ $column->label }}</td>
                                            <td><code>{{ $column->key }}</code></td>
                                            <td>{{ $column->typeLabel() }}</td>
                                            <td>{{ $column->actionTypeLabel() ?? '-' }}</td>
                                            <td class="text-center">{{ $column->widthLabel() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">
                                                Belum ada kolom. Tambahkan kolom terlebih dahulu.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <form action="{{ route('admin.lists.toggle-status', $dynamicList) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-{{ $dynamicList->status === 'published' ? 'warning' : 'success' }}">
                <i class="fas fa-{{ $dynamicList->status === 'published' ? 'undo' : 'check' }} me-1"></i>
                {{ $dynamicList->status === 'published' ? 'Ubah ke Draft' : 'Terbitkan' }}
            </button>
        </form>
        <a href="{{ route('admin.lists.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>
@endsection
