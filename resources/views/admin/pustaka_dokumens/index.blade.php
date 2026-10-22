@extends('admin.layouts.app')

@section('title', 'Daftar Informasi Publik')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-book me-2"></i>Daftar Informasi Publik</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.pustaka-dokumens.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Tambah Dokumen
                </a>
                <a href="{{ route('admin.pustaka-dokumens.create', ['jumlah' => 5]) }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-layer-group"></i> Tambah Banyak
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
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
                        <th>Grup</th>
                        <th>Nomor</th>
                        <th>Tahun</th>
                        <th width="90" class="text-center">Dilihat</th>
                        <th width="140" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pustakaDokumens as $index => $dok)
                    <tr>
                        <td class="text-center text-muted">{{ $pustakaDokumens->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $dok->nama_dokumen }}</strong>
                            @if($dok->deskripsi)
                                <br><small class="text-muted">{{ Str::limit($dok->deskripsi, 60) }}</small>
                            @endif
                            @if($dok->link_type === 'file' && $dok->file_url)
                                <br><a href="{{ $dok->file_url }}" target="_blank" class="btn btn-sm btn-outline-success mt-1">
                                    <i class="fas fa-eye me-1"></i> Lihat File
                                </a>
                            @elseif($dok->link_type === 'link' && $dok->link_url)
                                <br><a href="{{ $dok->link_url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                    <i class="fas fa-external-link-alt me-1"></i> Kunjungi Link
                                </a>
                            @endif
                        </td>
                        <td>
                            <span class="badge" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">{{ $dok->grupDokumen->nama_grup ?? '-' }}</span>
                        </td>
                        <td class="text-muted">{{ $dok->nomor ?? '-' }}</td>
                        <td class="text-muted">{{ $dok->tahun ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border"><i class="fas fa-eye me-1"></i>{{ $dok->view_count ?? 0 }}</span>
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
                        <td colspan="7" class="text-center text-muted py-4">
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
