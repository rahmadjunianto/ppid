@extends('layouts.app')
@section('title', 'Lihat Dokumen - ' . ($dokumen->nama_dokumen ?? ''))
@section('content')
<section class="py-4" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pustaka-dokumen.index') }}" class="text-white text-decoration-none">Pustaka Dokumen</a></li>
                <li class="breadcrumb-item active text-white">{{ Str::limit($dokumen->nama_dokumen, 30) }}</li>
            </ol>
        </nav>
    </div>
</section>
<section class="py-4">
    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="card-header text-white" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0"><i class="fas fa-file-pdf me-2"></i>{{ $dokumen->nama_dokumen }}</h5>
                        @if($dokumen->nomor || $dokumen->tahun)
                            <small class="opacity-75">
                                @if($dokumen->nomor){{ $dokumen->nomor }}@endif
                                @if($dokumen->tahun) - Tahun {{ $dokumen->tahun }}@endif
                            </small>
                        @endif
                    </div>
                    <a href="{{ route('pustaka-dokumen.download', $dokumen->id) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-download me-1"></i> Unduh
                    </a>
                </div>
            </div>
            <div class="card-body p-0" style="height: 75vh; min-height: 500px;">
                <iframe src="{{ $fileUrl }}" width="100%" height="100%" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection
