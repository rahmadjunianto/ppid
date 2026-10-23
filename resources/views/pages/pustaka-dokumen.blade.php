@extends('layouts.app')
@section('title', $selectedGrup === 'Semua Kategori' ? 'Daftar Informasi Publik' : $selectedGrup)
@section('content')
<div class="container my-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-page">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            @if($selectedGrup !== 'Semua Kategori')
            <li class="breadcrumb-item"><a href="{{ route('pustaka-dokumen.index') }}">Informasi Publik</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $selectedGrup }}</li>
            @else
            <li class="breadcrumb-item active" aria-current="page">Informasi Publik</li>
            @endif
        </ol>
    </nav>

    <div class="row mb-3 align-items-center g-3">
        <div class="col-lg-7">
            <h4 class="fw-bold text-success mb-1"><i class="bi bi-book me-2"></i>{{ $selectedGrup === 'Semua Kategori' ? 'Daftar Informasi Publik' : $selectedGrup }}</h4>
            <p class="text-muted mb-0 small">@if($selectedGrup === 'Semua Kategori')Unduh dokumen resmi: SOP, laporan, regulasi, dan lainnya.@else{{ $grupDokumens->where('nama_grup', $selectedGrup)->first()->deskripsi ?? 'Kumpulan dokumen ' . $selectedGrup }}@endif</p>
        </div>
        <div class="col-lg-5">
            <form method="GET" action="{{ route('pustaka-dokumen.index') }}">
                <div class="input-group">
                    <select name="grup" class="form-select" style="max-width: 230px;" aria-label="Filter Kategori" onchange="this.form.submit()">
                        <option value="">Semua Kategori ({{ $counts['semua'] }})</option>
                        @foreach($grupDokumens as $grup)
                            <option value="{{ $grup->slug }}" {{ $grupAktif == $grup->slug ? 'selected' : '' }}>{{ $grup->nama_grup }} ({{ $counts[$grup->slug] ?? 0 }})</option>
                        @endforeach
                    </select>
                    <input type="text" name="search" class="form-control" placeholder="Cari dokumen..." value="{{ $search ?? '' }}">
                    <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button>
                    @if($search || $grupAktif)
                        <a href="{{ route('pustaka-dokumen.index') }}" class="btn btn-outline-secondary" title="Hapus filter"><i class="fas fa-times"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama Dokumen</th>
                            <th width="140">Kategori</th>
                            <th width="80">Tahun</th>
                            <th width="90" class="text-center">Dilihat</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokumens as $index => $dok)
                        <tr>
                            <td class="text-center text-muted">{{ $dokumens->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $dok->nama_dokumen }}</strong>
                                @if($dok->link_type === 'file' && $dok->file)
                                    <span class="badge bg-secondary ms-2">{{ strtoupper(pathinfo($dok->file, PATHINFO_EXTENSION)) }}</span>
                                @endif
                                @if($dok->deskripsi)
                                    <br><small class="text-muted">{{ Str::limit($dok->deskripsi, 100) }}</small>
                                @endif
                            </td>
                            <td><span class="badge" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white; font-size: 0.75rem;">{{ $dok->grupDokumen->nama_grup ?? '-' }}</span></td>
                            <td class="text-muted">{{ $dok->tahun ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border"><i class="fas fa-eye me-1"></i>{{ $dok->view_count ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                @if($dok->link_type === 'file')
                                    @if($dok->file_url)
                                        <a href="{{ route('pustaka-dokumen.view', $dok->slug) }}" target="_blank" class="btn btn-outline-success btn-sm" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('pustaka-dokumen.download', $dok->slug) }}" class="btn btn-success btn-sm" title="Unduh" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @else
                                        <span class="text-muted small">File tidak ada</span>
                                    @endif
                                @else
                                    @if($dok->link_url)
                                        <a href="{{ route('pustaka-dokumen.link', $dok->slug) }}" target="_blank" class="btn btn-sm text-white" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;">
                                            <i class="fas fa-external-link-alt me-1"></i> Kunjungi
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-folder2-open text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2 mb-0">Tidak ada dokumen ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($dokumens->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $dokumens->links('custom-pagination') }}
        </div>
    @endif
    <p class="text-muted small text-center mt-3 mb-0">
        Menampilkan {{ $dokumens->firstItem() ?? 0 }} - {{ $dokumens->lastItem() ?? 0 }} dari {{ $dokumens->total() }} dokumen
    </p>
</div>
@endsection
