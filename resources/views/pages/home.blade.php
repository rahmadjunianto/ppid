@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: $page->excerpt)
@section('meta_keywords', $page->meta_keywords)

@section('content')
<!-- Hero Section -->
@if($page->featured_image || $page->excerpt)
<section class="hero-section py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold">{{ $page->title }}</h1>
                @if($page->excerpt)
                    <p class="lead">{{ $page->excerpt }}</p>
                @endif

                @if($page->children->where('status', 'published')->count() > 0)
                    <div class="mt-4">
                        <a href="#main-content" class="btn btn-light btn-lg">
                            Jelajahi Konten
                        </a>
                    </div>
                @endif
            </div>

            @if($page->featured_image)
                <div class="col-lg-4">
                    <img src="{{ asset('storage/' . $page->featured_image) }}"
                         alt="{{ $page->title }}"
                         class="img-fluid rounded shadow-lg">
                </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Main Content -->
<section id="main-content" class="py-5">
    <div class="container">
        @if($page->content)
            <div class="row">
                <div class="col-12">
                    <div class="content-section">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        @endif

        <!-- Featured Pages/Services -->
        @if($page->children->where('status', 'published')->count() > 0)
            <div class="featured-pages mt-5">
                <div class="text-center mb-5">
                    <h2 class="display-5">Layanan & Informasi</h2>
                    <p class="lead text-muted">Temukan berbagai layanan dan informasi yang tersedia</p>
                </div>

                <div class="row">
                    @foreach($page->children->where('status', 'published')->take(6) as $child)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                @if($child->featured_image)
                                    <img src="{{ asset('storage/' . $child->featured_image) }}"
                                         class="card-img-top" alt="{{ $child->title }}"
                                         style="height: 250px; object-fit: cover;">
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $child->title }}</h5>

                                    @if($child->excerpt)
                                        <p class="card-text text-muted flex-grow-1">
                                            {{ Str::limit($child->excerpt, 120) }}
                                        </p>
                                    @endif

                                    <div class="mt-auto">
                                        <a href="{{ $child->getUrl() }}" class="btn btn-primary">
                                            Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($page->children->where('status', 'published')->count() > 6)
                    <div class="text-center mt-4">
                        <a href="#" class="btn btn-outline-primary btn-lg">
                            Lihat Semua Layanan
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>

<!-- Quick Stats or Highlights -->
@if($page->children->where('status', 'published')->count() >= 3)
<section class="stats-section py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="stat-item">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3>Layanan Publik</h3>
                    <p class="text-muted">Berbagai layanan untuk masyarakat</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-item">
                    <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                    <h3>Informasi Terkini</h3>
                    <p class="text-muted">Update informasi dan berita terbaru</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-item">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                    <h3>24/7 Akses</h3>
                    <p class="text-muted">Akses informasi kapan saja</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Latest Updates -->
@if($latestPages && $latestPages->count() > 0)
<section class="latest-updates py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5">Informasi Terbaru</h2>
            <p class="lead text-muted">Berita dan pengumuman terkini</p>
        </div>

        <div class="row">
            @foreach($latestPages as $latest)
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="row no-gutters">
                            @if($latest->featured_image)
                                <div class="col-4">
                                    <img src="{{ asset('storage/' . $latest->featured_image) }}"
                                         class="card-img h-100" alt="{{ $latest->title }}"
                                         style="object-fit: cover;">
                                </div>
                                <div class="col-8">
                            @else
                                <div class="col-12">
                            @endif
                                <div class="card-body">
                                    <small class="text-muted">
                                        {{ $latest->published_at ? $latest->published_at->format('d M Y') : $latest->created_at->format('d M Y') }}
                                    </small>
                                    <h6 class="card-title mt-1">{{ $latest->title }}</h6>
                                    @if($latest->excerpt)
                                        <p class="card-text small text-muted">
                                            {{ Str::limit($latest->excerpt, 80) }}
                                        </p>
                                    @endif
                                    <a href="{{ $latest->getUrl() }}" class="btn btn-sm btn-outline-primary">
                                        Baca
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="cta-section py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="display-5 mb-3">Butuh Bantuan?</h2>
        <p class="lead mb-4">Tim kami siap membantu Anda dengan layanan terbaik</p>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="tel:+6221xxxxxxx" class="btn btn-light btn-lg btn-block">
                            <i class="fas fa-phone"></i> Telepon
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="mailto:info@ppid.go.id" class="btn btn-light btn-lg btn-block">
                            <i class="fas fa-envelope"></i> Email
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="/kontak" class="btn btn-light btn-lg btn-block">
                            <i class="fas fa-map-marker-alt"></i> Lokasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.1);
    z-index: 1;
}

.hero-section .container {
    position: relative;
    z-index: 2;
}

.content-section {
    font-size: 1.1rem;
    line-height: 1.7;
}

.content-section h1,
.content-section h2,
.content-section h3,
.content-section h4,
.content-section h5,
.content-section h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.content-section p {
    margin-bottom: 1.5rem;
    text-align: justify;
}

.featured-pages .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.featured-pages .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.stat-item {
    padding: 2rem 1rem;
}

.stat-item i {
    transition: transform 0.3s ease;
}

.stat-item:hover i {
    transform: scale(1.1);
}

.latest-updates .card {
    transition: transform 0.3s ease;
}

.latest-updates .card:hover {
    transform: translateY(-3px);
}

.cta-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.btn-block {
    display: block;
    width: 100%;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-section {
        text-align: center;
    }

    .hero-section .display-4 {
        font-size: 2rem;
    }

    .featured-pages .card-body {
        padding: 1rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endsection
