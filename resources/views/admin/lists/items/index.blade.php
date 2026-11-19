@extends('admin.layouts.app')

@section('title', 'Kelola Data')
@section('page-title', 'Kelola Data')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.lists.index') }}">Daftar Dinamis</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.lists.show', $dynamicList) }}">{{ $dynamicList->title }}</a></li>
    <li class="breadcrumb-item active">Kelola Data</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i>Data: {{ $dynamicList->title }}</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.lists.columns.index', $dynamicList) }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-columns me-1"></i> Kolom
                </a>
                <a href="{{ route('admin.lists.items.create', $dynamicList) }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Data
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

        @if(session('failed_items'))
            <div class="alert alert-warning alert-dismissible fade show">
                <strong>Baris berikut gagal disimpan:</strong>
                <ul class="mb-0">
                    @foreach(session('failed_items') as $failed)
                        <li>{{ $failed }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($dynamicList->columns->isEmpty())
            <div class="alert alert-info">
                Daftar ini belum memiliki kolom. <a href="{{ route('admin.lists.columns.create', $dynamicList) }}">Tambahkan kolom</a> terlebih dahulu.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            @foreach($dynamicList->columns as $column)
                                <th>{{ $column->label }}</th>
                            @endforeach
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                            <tr>
                                <td class="text-center text-muted">{{ $index + 1 }}</td>
                                @foreach($dynamicList->columns as $column)
                                    <td>
                                        @include('admin.lists.items._cell', ['column' => $column, 'item' => $item])
                                    </td>
                                @endforeach
                                <td class="text-center">
                                    <a href="{{ route('admin.lists.items.edit', [$dynamicList, $item]) }}" class="btn btn-outline-success btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.lists.items.destroy', [$dynamicList, $item]) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus baris data ini beserta file nya?')">
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
                                <td colspan="{{ $dynamicList->columns->count() + 2 }}" class="text-center text-muted py-4">
                                    <i class="fas fa-table fa-2x mb-2"></i>
                                    <p class="mb-0">Belum ada data. Klik "Tambah Data" untuk mengisi baris pertama.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="card-footer">
        <a href="{{ route('admin.lists.show', $dynamicList) }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Detail Daftar
        </a>
    </div>
</div>
@endsection
