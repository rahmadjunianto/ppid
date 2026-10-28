@extends('layouts.app')

@section('title', 'Informasi Setiap Saat')
@section('meta_description', 'Daftar informasi setiap saat Kementerian Agama Kabupaten Nganjuk yang wajib tersedia dan dapat diakses oleh publik kapan saja tanpa harus menunggu permintaan khusus.')

@section('content')
<div class="container my-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-page">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/pustaka-dokumen') }}">Informasi Publik</a></li>
            <li class="breadcrumb-item active" aria-current="page">Informasi Setiap Saat</li>
        </ol>
    </nav>

    {{-- Page Header, Filter & Search --}}
    <div class="row mb-3 align-items-center g-3">
        <div class="col-lg-7">
            <h4 class="fw-bold text-success mb-1"><i class="bi bi-hourglass-split me-2"></i>Informasi Setiap Saat</h4>
            <p class="text-muted mb-0 small">Informasi yang wajib tersedia dan dapat diakses oleh publik kapan saja tanpa harus menunggu permintaan khusus.</p>
        </div>
        <div class="col-lg-5">
            <form method="GET" action="{{ url('/informasi-setiap-saat') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari informasi setiap saat..." value="{{ $search ?? '' }}">
                    <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button>
                    @if($search)
                        <a href="{{ url('/informasi-setiap-saat') }}" class="btn btn-outline-secondary" title="Hapus filter"><i class="fas fa-times"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    @if($items->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th width="60" class="text-center">No</th>
                    <th>Daftar Informasi Publik</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                        @if($item->public_url)
                            <a href="{{ $item->public_url }}" target="_blank" rel="noopener">{{ $item->judul }}</a>
                        @else
                            {{ $item->judul }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1"></i>
            <p class="mt-2">{{ $search ? 'Tidak ada informasi setiap saat yang ditemukan.' : 'Belum ada informasi setiap saat' }}</p>
        </div>
    @endif

    <p class="text-muted small text-center mt-3 mb-0">
        Menampilkan {{ $items->count() }} dari {{ $total }} informasi setiap saat
    </p>
</div>
@endsection
