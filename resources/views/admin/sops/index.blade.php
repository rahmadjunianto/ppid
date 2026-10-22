@extends('admin.layouts.app')

@section('title', 'Kelola SOP')
@section('page-title', 'Kelola SOP')

@section('breadcrumb')
    <li class="breadcrumb-item active">Kelola SOP</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt mr-2"></i>
                        Daftar Dokumen SOP
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sops.create', ['jumlah' => 5]) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-layer-group"></i> Tambah Banyak
                        </a>
                        <a href="{{ route('admin.sops.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah SOP
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

                    @if(session('failed_items'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Dokumen berikut gagal disimpan:</strong>
                            <ul class="mb-0">
                                @foreach(session('failed_items') as $failed)
                                    <li>{{ $failed }}</li>
                                @endforeach
                            </ul>
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
                            <form method="GET" action="{{ route('admin.sops.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text"
                                               name="search"
                                               class="form-control"
                                               placeholder="Cari dokumen SOP..."
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="grup" class="form-control">
                                            <option value="">Semua Grup</option>
                                            @foreach($grupOptions as $key => $label)
                                                <option value="{{ $key }}" {{ request('grup') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status" class="form-control">
                                            <option value="">Semua Status</option>
                                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="tahun" class="form-control">
                                            <option value="">Semua Tahun</option>
                                            @foreach($tahunOptions as $thn)
                                                <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>
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
                                        <a href="{{ route('admin.sops.index') }}" class="btn btn-secondary btn-block">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    @if($sops->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Nama Dokumen</th>
                                        <th width="15%">Grup</th>
                                        <th width="15%">Nomor</th>
                                        <th width="8%">Tahun</th>
                                        <th width="8%">Ukuran</th>
                                        <th width="8%">Dilihat</th>
                                        <th width="8%">Status</th>
                                        <th width="16%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sops as $index => $sop)
                                        <tr>
                                            <td class="text-center">{{ $sops->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $sop->nama_dokumen }}</strong>
                                                @if($sop->file)
                                                    <br><small class="text-muted">
                                                        <i class="fas fa-paperclip"></i> {{ pathinfo($sop->file, PATHINFO_EXTENSION) }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $sop->grup == 'SOP PPID' ? 'info' : 'warning' }}">
                                                    {{ $sop->grup_label }}
                                                </span>
                                            </td>
                                            <td>{{ $sop->nomor ?: '-' }}</td>
                                            <td class="text-center">{{ $sop->tahun ?: '-' }}</td>
                                            <td class="text-center">{{ $sop->ukuran_formatted }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-light">
                                                    <i class="fas fa-eye mr-1"></i>{{ $sop->view_count ?? 0 }}
                                                </span>
                                            </td>
                                            <td class="text-center">{!! $sop->status_badge !!}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.sops.show', $sop) }}"
                                                       class="btn btn-info btn-sm" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.sops.edit', $sop) }}"
                                                       class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.sops.destroy', $sop) }}"
                                                          method="POST"
                                                          style="display: inline-block;"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus SOP ini?')">
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
                        @if($sops->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <small class="text-muted">
                                        Menampilkan {{ $sops->firstItem() }} - {{ $sops->lastItem() }}
                                        dari {{ $sops->total() }} SOP
                                    </small>
                                </div>
                                <div>
                                    {{ $sops->appends(request()->query())->links('admin-pagination') }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data SOP</p>
                            <a href="{{ route('admin.sops.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah SOP Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
