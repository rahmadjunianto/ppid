@extends('layouts.app')
@section('title', 'Pustaka Dokumen')
@section('content')
<section class="py-4" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item active text-white">Pustaka Dokumen</li>
            </ol>
        </nav>
    </div>
</section>
<section class="py-4">
    <div class="container">
        <div class="row mb-4 align-items-center">
            <div class="col-lg-8">
                <h4 class="fw-bold text-success mb-1"><i class="bi bi-book me-2"></i>Pustaka Dokumen</h4>
                <p class="text-muted mb-0 small">Unduh dokumen resmi: SOP, laporan, regulasi, dan lainnya.</p>
            </div>
            <div class="col-lg-4">
                <form method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari dokumen..." value="{{ $search ?? '' }}">
                        @if($grupAktif)<input type="hidden" name="grup" value="{{ $grupAktif }}">@endif
                        <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Filter Buttons -->
        <div class="mb-3">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('pustaka-dokumen.index') }}" class="btn btn-sm {{ !$grupAktif ? 'text-white' : 'btn-outline-success' }}" style="{{ !$grupAktif ? 'background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;' : '' }}">
                    <i class="bi bi-list-ul me-1"></i> Semua
                </a>
                @foreach($grupDokumens as $grup)
                    <a href="{{ route('pustaka-dokumen.index', ['grup' => $grup->slug]) }}" 
                       class="btn btn-sm {{ $grupAktif == $grup->slug ? 'text-white' : 'btn-outline-success' }}"
                       style="{{ $grupAktif == $grup->slug ? 'background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;' : '' }}">
                        {{ $grup->nama_grup }}
                    </a>
                @endforeach
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
                                <th width="150">Grup</th>
                                <th width="120">Nomor</th>
                                <th width="80">Tahun</th>
                                <th width="80">Ukuran</th>
                                <th width="120" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dokumens as $index => $dok)
                            <tr>
                                <td class="text-center text-muted">{{ $dokumens->firstItem() + $index }}</td>
                                <td><strong>{{ $dok->nama_dokumen }}</strong></td>
                                <td><span class="badge" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white; font-size: 0.75rem;">{{ $dok->grupDokumen->nama_grup ?? '-' }}</span></td>
                                <td class="text-muted">{{ $dok->nomor ?? '-' }}</td>
                                <td class="text-muted">{{ $dok->tahun ?? '-' }}</td>
                                <td class="text-muted">{{ $dok->ukuran ?? '-' }}</td>
                                <td class="text-center">
                                    @if($dok->link_type === 'file')
                                        @if($dok->file_url)
                                            <a href="{{ route('pustaka-dokumen.view', $dok->id) }}" target="_blank" class="btn btn-outline-success btn-sm" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pustaka-dokumen.download', $dok->id) }}" class="btn btn-success btn-sm" title="Unduh" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted small">File tidak ada</span>
                                        @endif
                                    @else
                                        @if($dok->link_url)
                                            <a href="{{ $dok->link_url }}" target="_blank" class="btn btn-sm text-white" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;">
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
                {{ $dokumens->links() }}
            </div>
        @endif
        <p class="text-muted small text-center mt-3 mb-0">
            Menampilkan {{ $dokumens->count() }} dari {{ $dokumens->total() }} dokumen
        </p>
    </div>
</section>
@endsection
