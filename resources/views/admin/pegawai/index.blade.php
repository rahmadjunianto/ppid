@extends('admin.layouts.app')

@section('title', 'Data Pegawai')
@section('page-title', 'Data Pegawai')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Pegawai</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-2"></i>
                        Daftar Pegawai
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pegawai.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Pegawai
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filter -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('admin.pegawai.index') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" 
                                               name="search" 
                                               class="form-control" 
                                               placeholder="Cari nama, jabatan, golongan..."
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <select name="unit_kerja" class="form-control">
                                            <option value="">Semua Unit Kerja</option>
                                            @foreach($unitKerja as $unit)
                                                <option value="{{ $unit }}" {{ request('unit_kerja') == $unit ? 'selected' : '' }}>
                                                    {{ $unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                        <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Results Count -->
                    <p class="text-muted">
                        Menampilkan {{ $pegawai->firstItem() ?? 0 }} - {{ $pegawai->lastItem() ?? 0 }} 
                        dari {{ $pegawai->total() }} pegawai
                    </p>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="60">No</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Golongan</th>
                                    <th>Unit Kerja</th>
                                    <th width="60">Urutan</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pegawai as $index => $p)
                                    <tr>
                                        <td>{{ $pegawai->firstItem() + $index }}</td>
                                        <td><strong>{{ $p->nama }}</strong></td>
                                        <td>{{ $p->jabatan }}</td>
                                        <td>{{ $p->golongan ?: '-' }}</td>
                                        <td>{{ $p->unit_kerja }}</td>
                                        <td class="text-center">{{ $p->urutan }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.pegawai.show', $p) }}" 
                                                   class="btn btn-info btn-sm" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.pegawai.edit', $p) }}" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.pegawai.destroy', $p) }}" 
                                                      method="POST" 
                                                      style="display: inline-block;"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Tidak ada data pegawai</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($pegawai->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $pegawai->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
