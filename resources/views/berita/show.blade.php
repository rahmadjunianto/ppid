@extends('layouts.app')

@section('title', $berita->title ?? 'Detail Berita')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($berita->title, 50) }}</li>
                </ol>
            </nav>

            <article class="card">
                @if($berita->image_url)
                    <img src="{{ $berita->image_url }}"
                         class="card-img-top"
                         alt="{{ $berita->title }}"
                         style="max-height: 400px; object-fit: cover;"
                         onerror="this.onerror=null; this.src='{{ $berita->image_url_asli }}'; this.onerror=function(){ this.style.display='none'; };">
                @endif

                <div class="card-body">
                    <h1 class="card-title h2 mb-3">{{ $berita->title }}</h1>

                    <div class="d-flex flex-wrap gap-3 mb-4 text-muted">
                        @if($berita->published_at)
                            <small>
                                <i class="fas fa-calendar-alt"></i>
                                {{ $berita->published_at->format('d F Y, H:i') }} WIB
                            </small>
                        @endif

                        @if($berita->author)
                            <small>
                                <i class="fas fa-user"></i>
                                {{ $berita->author }}
                            </small>
                        @endif

                        @if($berita->kategori)
                            <small>
                                <i class="fas fa-folder"></i>
                                {{ $berita->kategori->name }}
                            </small>
                        @elseif($berita->category_id)
                            <small>
                                <i class="fas fa-folder"></i>
                                Kategori ID: {{ $berita->category_id }}
                            </small>
                        @endif

                        @if($berita->views)
                            <small>
                                <i class="fas fa-eye"></i>
                                {{ $berita->views }} kali dibaca
                            </small>
                        @endif
                    </div>

                    {{-- Tags Section --}}
                    @if($berita->tags->isNotEmpty())
                        <div class="mb-3">
                            @foreach($berita->tags as $tag)
                                <span class="badge bg-secondary me-1">
                                    <i class="fas fa-tag"></i> {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="content">
                        {!! $berita->content !!}
                    </div>
                </div>
            </article>

            <!-- Navigation to other news -->
            <div class="mt-4">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Berita
                        </a>
                    </div>
                    <div class="col-6 text-end">
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Berita Terbaru Lainnya</h5>
                </div>
                <div class="card-body">
                    <div id="latest-news">
                        <div class="text-center">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Memuat berita terbaru...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Share buttons -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Bagikan Berita</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                           target="_blank" class="btn btn-primary btn-sm">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($berita->title) }}"
                           target="_blank" class="btn btn-info btn-sm">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($berita->title . ' ' . request()->fullUrl()) }}"
                           target="_blank" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .content img {
        max-width: 100%;
        height: auto;
    }

    .content {
        line-height: 1.6;
    }

    @media print {
        .btn, nav, .card:not(:first-child) {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load latest news for sidebar
    fetch('{{ route("berita.latest", 5) }}')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('latest-news');

            if (data.status === 'success' && data.data.length > 0) {
                let html = '';
                data.data.forEach(item => {
                    if (item.id != {{ $berita->id }}) {
                        html += `
                            <div class="mb-3 pb-3 border-bottom">
                                <h6><a href="{{ url('berita') }}/${item.slug}" class="text-decoration-none">${item.title}</a></h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt"></i>
                                    ${new Date(item.published_at).toLocaleDateString('id-ID')}
                                </small>
                            </div>
                        `;
                    }
                });

                if (html) {
                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<p class="text-muted">Tidak ada berita lain tersedia.</p>';
                }
            } else {
                container.innerHTML = '<p class="text-muted">Gagal memuat berita terbaru.</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('latest-news').innerHTML = '<p class="text-muted">Gagal memuat berita terbaru.</p>';
        });
});
</script>
@endpush
