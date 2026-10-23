@extends('layouts.app')

@section('title', 'Informasi Berkala')
@section('meta_description', 'Daftar informasi berkala Kementerian Agama Kabupaten Nganjuk yang wajib tersedia setiap saat bagi masyarakat sesuai ketentuan Undang-Undang Keterbukaan Informasi Publik.')

@section('content')
<div class="container my-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-page">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/pustaka-dokumen') }}">Informasi Publik</a></li>
            <li class="breadcrumb-item active" aria-current="page">Informasi Berkala</li>
        </ol>
    </nav>

    {{-- Page Header, Filter & Search --}}
    <div class="row mb-3 align-items-center g-3">
        <div class="col-lg-7">
            <h4 class="fw-bold text-success mb-1"><i class="bi bi-calendar-week me-2"></i>Informasi Berkala</h4>
            <p class="text-muted mb-0 small">Informasi yang wajib tersedia setiap saat bagi masyarakat sesuai ketentuan Undang-Undang Keterbukaan Informasi Publik.</p>
        </div>
        <div class="col-lg-5">
            <form method="GET" action="{{ url('/informasi-berkala') }}">
                <div class="input-group">
                    <select name="kategori" class="form-select" style="max-width: 230px;" aria-label="Filter kategori" onchange="this.form.submit()">
                        <option value="">Semua Kategori ({{ $counts['semua'] }})</option>
                        @foreach($kategoriOptions as $key => $label)
                            @php $plainLabel = preg_replace('/^[A-Z]\.\s*/', '', $label); @endphp
                            <option value="{{ $key }}" {{ $kategori === $key ? 'selected' : '' }}>{{ $plainLabel }} ({{ $counts[$key] ?? 0 }})</option>
                        @endforeach
                    </select>
                    <input type="text" name="search" class="form-control" placeholder="Cari informasi berkala..." value="{{ $search ?? '' }}">
                    <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button>
                    @if($search || $kategori)
                        <a href="{{ url('/informasi-berkala') }}" class="btn btn-outline-secondary" title="Hapus filter"><i class="fas fa-times"></i></a>
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
                @php $colors = ['A'=>'primary','B'=>'success','C'=>'info','D'=>'warning','E'=>'secondary']; @endphp
                @foreach($itemsByKategori as $kode => $groupItems)
                    <tr class="table-{{ $colors[$kode] ?? 'secondary' }}">
                        <td class="text-center fw-bold">{{ $kode }}</td>
                        <td class="fw-bold">{{ preg_replace('/^[A-Z]\.\s*/', '', $kategoriOptions[$kode] ?? '') }}</td>
                    </tr>
                    @foreach($groupItems as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td><a href="{{ $item->link }}" target="_blank">{{ $item->judul }}</a></td>
                    </tr>
                    @endforeach
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1"></i>
            <p class="mt-2">{{ ($search || $kategori) ? 'Tidak ada informasi berkala yang ditemukan.' : 'Belum ada informasi berkala' }}</p>
        </div>
    @endif

    <p class="text-muted small text-center mt-3 mb-0">
        Menampilkan {{ $items->count() }} dari {{ $counts['semua'] }} informasi berkala
    </p>
</div>
@endsection