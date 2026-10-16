@extends("layouts.app")
@section("title", "Lihat Dokumen")
@section("breadcrumb")
    <li class="breadcrumb-item"><a href="{{ url("/") }}">Beranda</a></li>
    <li class="breadcrumb-item"><a href="{{ url("/informasi-berkala") }}">Informasi Berkala</a></li>
    <li class="breadcrumb-item active">Dokumen</li>
@endsection
@section("content")
<div class="container my-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>{{ $item->judul }}</h5>
            <div>
                <a href="{{ url('/informasi-berkala/download/' . $item->id) }}" class="btn btn-success btn-sm">
                    <i class="bi bi-download me-1"></i>Unduh
                </a>
                <a href="{{ url('/informasi-berkala') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <iframe src="{{ $pdfUrl }}" style="width:100%; height:70vh; border:none;"></iframe>
        </div>
    </div>
</div>
@endsection