@extends('admin.layouts.app')

@section('title', 'Kelola Regulasi')
@section('page-title', 'Kelola Regulasi')

@section('breadcrumb')
<li class="breadcrumb-item active">Kelola Regulasi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-book mr-2"></i>
                    Daftar Regulasi &amp; Peraturan
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.regulasi.create', ['jumlah' => 5]) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-layer-group"></i> Tambah Banyak
                    </a>
                    <a href="{{ route('admin.regulasi.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Regulasi
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

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <!-- Filter -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('admin.regulasi.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" placeholder="Cari regulasi..."
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="tingkat" class="form-control">
                                        <option value="">Semua Tingkat</option>
                                        @foreach($tingkatOptions as $key => $label)
                                        <option value="{{ $key }}" {{ request('tingkat')==$key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="draft" {{ request('status')=='draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="published" {{ request('status')=='published' ? 'selected' : ''
                                            }}>Published</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="tahun" class="form-control">
                                        <option value="">Semua Tahun</option>
                                        @foreach($tahunOptions as $thn)
                                        <option value="{{ $thn }}" {{ request('tahun')==$thn ? 'selected' : '' }}>
                                            {{ $thn }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ route('admin.regulasi.index') }}" class="btn btn-secondary btn-block">
                                        <i class="fas fa-sync"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                @if($regulasi->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Nama Regulasi</th>
                                <th width="15%">Nomor</th>
                                <th width="13%">Tingkat</th>
                                <th width="8%">Tahun</th>
                                <th width="8%">Sumber</th>
                                <th width="8%">Status</th>
                                <th width="13%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($regulasi as $index => $item)
                            <tr>
                                <td class="text-center">{{ $regulasi->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $item->nama_regulasi }}</strong>
                                </td>
                                <td>{{ $item->nomor ?: '-' }}</td>
                                <td class="text-center">{!! $item->tingkat_badge !!}</td>
                                <td class="text-center">{{ $item->tahun ?: '-' }}</td>
                                <td class="text-center">
                                    @if($item->link_type === 'file')
                                    <span class="badge badge-info">File</span>
                                    @else
                                    <span class="badge badge-secondary">Tautan</span>
                                    @endif
                                </td>
                                <td class="text-center">{!! $item->status_badge !!}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.regulasi.show', $item->id) }}"
                                            class="btn btn-info btn-sm" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.regulasi.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.regulasi.destroy', $item->id) }}" method="POST"
                                            style="display: inline-block;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus regulasi ini?')">
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

                <!-- Pagination -->
                @if($regulasi->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $regulasi->firstItem() }} - {{ $regulasi->lastItem() }}
                            dari {{ $regulasi->total() }} Regulasi
                        </small>
                    </div>
                    <div>
                        {{ $regulasi->appends(request()->query())->links('admin-pagination') }}
                    </div>
                </div>
                @endif
                @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data regulasi.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection