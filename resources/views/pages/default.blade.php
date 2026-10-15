@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: $page->excerpt)
@section('meta_keywords', $page->meta_keywords)

@section('breadcrumb')
    @foreach($page->getBreadcrumbs() as $breadcrumb)
        @if($loop->last)
            <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
        @else
            <li class="breadcrumb-item">
                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
            </li>
        @endif
    @endforeach
@endsection

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="page-header mb-4">
                <h1 class="display-4">{{ $page->title }}</h1>

                @if($page->excerpt)
                    <p class="lead text-muted">{{ $page->excerpt }}</p>
                @endif

                <!-- Page Meta Info -->
                <div class="page-meta mt-3">
                    @if($page->admin)
                        <span class="meta-author">
                            <i class="fas fa-user-edit"></i> {{ $page->admin->name }}
                        </span>
                        <span class="meta-separator">|</span>
                    @endif
                    @if($page->published_at)
                        <span class="meta-date">
                            <i class="fas fa-calendar-alt"></i> {{ $page->published_at->locale('id')->translatedFormat('d F Y') }}
                        </span>
                        <span class="meta-separator">|</span>
                    @endif
                    <span class="meta-views">
                        <i class="fas fa-eye"></i> Dibaca {{ number_format($page->view_count) }} kali
                    </span>
                </div>

                @if($page->featured_image)
                    <div class="featured-image my-4">
                        <img src="{{ asset('storage/' . $page->featured_image) }}"
                             alt="{{ $page->title }}"
                             class="img-fluid rounded shadow">
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <div class="page-content" id="pageContent">
                @if($page->content)
                    <div class="content-body">
                        {!! $page->content !!}
                    </div>
                @endif
            </div>
            
            <!-- Script untuk responsive images -->
            @push('scripts')
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                function resizeImages() {
                    if (window.innerWidth <= 768) {
                        var container = document.getElementById('pageContent');
                        if (container) {
                            var containerWidth = container.offsetWidth;
                            var images = container.querySelectorAll('img');
                            images.forEach(function(img) {
                                img.style.maxWidth = containerWidth + 'px';
                                img.style.width = containerWidth + 'px';
                                img.style.height = 'auto';
                            });
                            
                            var figures = container.querySelectorAll('figure');
                            figures.forEach(function(figure) {
                                figure.style.maxWidth = containerWidth + 'px';
                                figure.style.width = containerWidth + 'px';
                            });
                        }
                    } else {
                        var container = document.getElementById('pageContent');
                        if (container) {
                            var images = container.querySelectorAll('img');
                            images.forEach(function(img) {
                                img.style.maxWidth = '';
                                img.style.width = '';
                            });
                            
                            var figures = container.querySelectorAll('figure');
                            figures.forEach(function(figure) {
                                figure.style.maxWidth = '';
                                figure.style.width = '';
                            });
                        }
                    }
                }
                
                resizeImages();
                window.addEventListener('resize', resizeImages);
            });
            </script>
            @endpush

            <!-- Child Pages -->
            @if($page->children->where('status', 'published')->count() > 0)
                <div class="child-pages mt-5">
                    <h3>Sub Halaman</h3>
                    <div class="row">
                        @foreach($page->children->where('status', 'published') as $child)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    @if($child->featured_image)
                                        <img src="{{ asset('storage/' . $child->featured_image) }}"
                                             class="card-img-top" alt="{{ $child->title }}"
                                             style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $child->title }}</h5>
                                        @if($child->excerpt)
                                            <p class="card-text">{{ Str::limit($child->excerpt, 100) }}</p>
                                        @endif
                                        <a href="{{ $child->getUrl() }}" class="btn btn-primary">
                                            Baca Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Related Pages -->
            @if($relatedPages && $relatedPages->count() > 0)
                <div class="related-pages mt-5">
                    <h3>Halaman Terkait</h3>
                    <div class="row">
                        @foreach($relatedPages as $related)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    @if($related->featured_image)
                                        <img src="{{ asset('storage/' . $related->featured_image) }}"
                                             class="card-img-top" alt="{{ $related->title }}"
                                             style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $related->title }}</h5>
                                        @if($related->excerpt)
                                            <p class="card-text">{{ Str::limit($related->excerpt, 100) }}</p>
                                        @endif
                                        <a href="{{ $related->getUrl() }}" class="btn btn-outline-primary">
                                            Lihat Halaman
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Page Navigation -->
            @if($page->parent || $page->children->where('status', 'published')->count() > 0)
                <div class="page-navigation mt-5 pt-4 border-top">
                    <div class="row">
                        @if($page->parent)
                            <div class="col-md-6">
                                <a href="{{ $page->parent->getUrl() }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ $page->parent->title }}
                                </a>
                            </div>
                        @endif

                        @if($page->children->where('status', 'published')->count() > 0)
                            <div class="col-md-6 text-md-right">
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                            data-toggle="dropdown">
                                        Sub Halaman
                                    </button>
                                    <div class="dropdown-menu">
                                        @foreach($page->children->where('status', 'published') as $child)
                                            <a class="dropdown-item" href="{{ $child->getUrl() }}">
                                                {{ $child->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.page-header {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 1rem;
}

.page-meta {
    font-size: 0.9rem;
    color: #6c757d;
}

.page-meta .meta-author,
.page-meta .meta-date,
.page-meta .meta-views {
    display: inline-block;
}

.page-meta .meta-separator {
    margin: 0 0.5rem;
    color: #dee2e6;
}

.page-meta i {
    margin-right: 0.25rem;
    color: #007bff;
}

.content-body {
    font-size: 1.1rem;
    line-height: 1.7;
}

.content-body h1,
.content-body h2,
.content-body h3,
.content-body h4,
.content-body h5,
.content-body h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.content-body p {
    margin-bottom: 1.5rem;
    text-align: justify;
}

.content-body img {
    max-width: 100%;
    height: auto;
    border-radius: 0.25rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin: 1rem 0;
    display: block;
}

/* Featured Image - Responsive */
.featured-image {
    text-align: center;
    width: 100%;
    margin: 1.5rem 0;
}

.featured-image img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    width: 100%;
    object-fit: cover;
}

/* Mobile - Gambar fit dalam layar */
@media (max-width: 768px) {
    .page-content {
        overflow-x: hidden !important;
        width: 100% !important;
        max-width: 100vw !important;
        position: relative;
    }

    .content-body {
        font-size: 1rem;
        overflow-x: hidden !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    /* RESET semua inline styles pada gambar */
    .page-content img,
    .content-body img {
        max-width: 100% !important;
        width: 100% !important;
        min-width: 100% !important;
        height: auto !important;
        display: block !important;
        margin: 1rem auto !important;
        padding: 0 !important;
        border-radius: 8px !important;
        object-fit: contain !important;
        box-sizing: border-box !important;
        /* Override inline styles dari CKEditor */
        left: auto !important;
        right: auto !important;
    }

    /* Gambar dalam figure - constrain */
    .page-content figure,
    .content-body figure,
    figure.image {
        margin: 1rem 0 !important;
        padding: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 100% !important;
        background: transparent !important;
        box-sizing: border-box !important;
        overflow: hidden !important;
        border: none !important;
        box-shadow: none !important;
        float: none !important;
        clear: both !important;
    }

    .page-content figure img,
    .content-body figure img,
    figure.image img {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 100% !important;
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        border-radius: 8px !important;
        object-fit: contain !important;
        display: block !important;
        box-sizing: border-box !important;
        position: relative !important;
    }

    /* Override style figcaption */
    .page-content figcaption,
    .content-body figcaption,
    figure.image figcaption {
        width: 100% !important;
        text-align: center !important;
        margin: 0.5rem 0 !important;
    }

    .featured-image {
        margin: 1rem 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        overflow: hidden !important;
    }

    .featured-image img {
        width: 100% !important;
        max-width: 100% !important;
        height: auto !important;
        border-radius: 8px !important;
        object-fit: contain !important;
    }

    /* Override inline width/height dari CKEditor */
    [style*="width"] {
        width: 100% !important;
    }
    
    img[style] {
        max-width: 100% !important;
        width: 100% !important;
    }
}

/* Small Mobile */
@media (max-width: 480px) {
    .content-body img,
    .content-body figure img,
    .featured-image img {
        max-width: 100% !important;
        width: 100% !important;
        height: auto !important;
        margin: 0.75rem 0 !important;
        border-radius: 6px !important;
    }

    .content-body figure {
        margin: 0.75rem 0 !important;
    }
}

/* Lightbox effect on click */
.content-body img,
.featured-image img {
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.content-body img:hover,
.featured-image img:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 12px rgba(0,0,0,0.2);
}

.content-body blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.25rem;
}

.content-body ul,
.content-body ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.content-body li {
    margin-bottom: 0.5rem;
}

.featured-image {
    text-align: center;
}

.child-pages h3,
.related-pages h3 {
    border-bottom: 2px solid #007bff;
    padding-bottom: 0.5rem;
    margin-bottom: 1.5rem;
}

.page-navigation {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.25rem;
}
</style>
@endsection
