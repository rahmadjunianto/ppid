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

                @if($page->featured_image)
                    <div class="featured-image my-4">
                        <img src="{{ asset('storage/' . $page->featured_image) }}"
                             alt="{{ $page->title }}"
                             class="img-fluid rounded shadow">
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <div class="page-content">
                @if($page->content)
                    <div class="content-body">
                        {!! $page->content !!}
                    </div>
                @endif
            </div>

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
