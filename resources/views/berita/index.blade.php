@extends('layouts.app')

@section('title', 'Berita Terbaru')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Berita Terbaru</h2>

                <!-- Search Form -->
                <form method="GET" action="{{ route('berita.index') }}" class="d-flex">
                    <input type="text" name="q" class="form-control me-2" placeholder="Cari berita..." value="{{ request('q') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>

            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('berita.index') }}" class="row g-3 align-items-end">
                        <!-- Keep search query -->
                        @if(request('q'))
                            <input type="hidden" name="q" value="{{ request('q') }}">
                        @endif

                        <div class="col-md-3">
                            <label for="kategori" class="form-label">Filter Kategori</label>
                            <select name="kategori" id="kategori" class="form-select">
                                <option value="">Semua Kategori</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id_kategori }}"
                                                {{ request('kategori') == $category->id_kategori ? 'selected' : '' }}>
                                            {{ $category->nama_kategori }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="user" class="form-label">Filter User</label>
                            <select name="user" id="user" class="form-select">
                                <option value="">Semua User</option>
                                @if(isset($authors))
                                    @foreach($authors as $author)
                                        <option value="{{ $author }}"
                                                {{ request('user') == $author ? 'selected' : '' }}>
                                            {{ $author }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times me-1"></i>Reset
                            </a>
                        </div>

                        @if(request()->hasAny(['kategori', 'user', 'q']))
                            <div class="col-md-2">
                                <div class="text-muted small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Filter aktif
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            @if(isset($berita) && $berita->count() > 0)
                <div class="row">
                    @foreach($berita as $item)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                @if($item->image_url)
                                    <img src="{{ $item->image_url }}"
                                         class="card-img-top"
                                         alt="{{ $item->judul }}"
                                         style="height: 200px; object-fit: cover;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ Str::limit($item->judul, 60) }}</h5>
                                    <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($item->konten), 120) }}</p>

                                    <div class="mt-auto">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center text-muted mb-2" style="font-size: 0.85rem;">
                                            <small>
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                @if($item->tanggal_publish)
                                                    {{ $item->tanggal_publish->format('d M Y') }}
                                                @else
                                                    Tanggal tidak tersedia
                                                @endif
                                            </small>
                                            @if($item->username)
                                                <small>
                                                    <i class="fas fa-user me-1"></i>{{ $item->username }}
                                                </small>
                                            @endif
                                            @if($item->kategori)
                                                <small>
                                                    <i class="fas fa-folder me-1"></i>{{ $item->kategori->nama_kategori }}
                                                </small>
                                            @endif
                                            @if($item->dibaca)
                                                <small>
                                                    <i class="fas fa-eye me-1"></i>{{ number_format($item->dibaca) }} dibaca
                                                </small>
                                            @endif
                                        </div>
                                      <div class="mt-auto">
                                        <a href="{{ route('berita.show', $item->judul_seo) }}" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if(method_exists($berita, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $berita->links('custom-pagination') }}
                    </div>
                @endif
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h4>Tidak ada berita yang ditemukan</h4>
                    @if(request('q'))
                        <p>Tidak ada hasil untuk pencarian "{{ request('q') }}"</p>
                        <a href="{{ route('berita.index') }}" class="btn btn-primary">Lihat Semua Berita</a>
                    @else
                        <p>Belum ada berita yang tersedia saat ini.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush
