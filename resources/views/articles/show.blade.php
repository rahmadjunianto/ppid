<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} - PPID Kemenag Nganjuk</title>
    <meta name="description" content="{{ Str::limit($article->excerpt ?: strip_tags($article->content), 160) }}">

    <!-- SEO Meta Tags -->
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ Str::limit($article->excerpt ?: strip_tags($article->content), 160) }}">
    <meta property="og:image" content="{{ $article->featured_image_url }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:description" content="{{ Str::limit($article->excerpt ?: strip_tags($article->content), 160) }}">
    <meta name="twitter:image" content="{{ $article->featured_image_url }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2c5f2d;
            --secondary-color: #97bc62;
            --accent-color: #ffd700;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --bg-light: #f8f9fa;
            --border-color: #e9ecef;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: #ffffff;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: white !important;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .navbar-nav .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--accent-color) !important;
        }

        .main-content {
            margin-top: 2rem;
            margin-bottom: 4rem;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem 0;
            margin-bottom: 3rem;
            border-radius: 0 0 30px 30px;
        }

        .breadcrumb-custom {
            background: rgba(255,255,255,0.1);
            border-radius: 25px;
            padding: 0.5rem 1rem;
            backdrop-filter: blur(10px);
        }

        .breadcrumb-custom .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }

        .breadcrumb-custom .breadcrumb-item.active {
            color: white;
        }

        .article-content {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .article-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        .article-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: center;
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .badge-type {
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-weight: 500;
        }

        .badge-news { background: var(--primary-color); color: white; }
        .badge-announcement { background: #f39c12; color: white; }
        .badge-info { background: #3498db; color: white; }

        .featured-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .article-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-dark);
        }

        .article-body h1, .article-body h2, .article-body h3,
        .article-body h4, .article-body h5, .article-body h6 {
            color: var(--primary-color);
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .article-body p {
            margin-bottom: 1.5rem;
            text-align: justify;
        }

        .article-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        .social-share {
            background: var(--bg-light);
            border-radius: 12px;
            padding: 1.5rem;
            margin: 2rem 0;
        }

        .share-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .share-buttons {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
        }

        .share-btn {
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .share-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .share-facebook { background: #1877f2; color: white; }
        .share-twitter { background: #1da1f2; color: white; }
        .share-whatsapp { background: #25d366; color: white; }
        .share-linkedin { background: #0077b5; color: white; }

        .sidebar-widget {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .widget-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .widget-body {
            padding: 1.5rem;
        }

        .related-article {
            display: flex;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .related-article:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .related-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .related-content h6 {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .related-content h6 a {
            color: var(--text-dark);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .related-content h6 a:hover {
            color: var(--primary-color);
        }

        .related-meta {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .author-info {
            background: var(--bg-light);
            border-radius: 12px;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: center;
        }

        .author-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }

        .navigation-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-back {
            background: var(--text-muted);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-back:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .footer {
            background: var(--text-dark);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        @media (max-width: 768px) {
            .article-title {
                font-size: 1.8rem;
            }

            .article-content {
                padding: 1.5rem;
            }

            .article-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.8rem;
            }

            .share-buttons {
                justify-content: center;
            }

            .related-article {
                flex-direction: column;
                text-align: center;
            }

            .related-image {
                margin: 0 auto 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-landmark me-2"></i>
                PPID Kemenag Nganjuk
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/profil') }}">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('articles.index') }}">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Layanan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header" style="margin-top: 76px;">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Artikel</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('articles.category', $article->category->slug) }}">{{ $article->category->name }}</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($article->title, 50) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container main-content">
        <div class="row">
            <!-- Article Content -->
            <div class="col-lg-8">
                <article class="article-content">
                    <!-- Article Header -->
                    <header class="article-header">
                        <h1 class="article-title">{{ $article->title }}</h1>

                        <div class="article-meta">
                            <div class="meta-item">
                                <span class="badge badge-type badge-{{ $article->type }}">
                                    @if($article->type === 'news')
                                        <i class="fas fa-newspaper me-1"></i>Berita
                                    @elseif($article->type === 'announcement')
                                        <i class="fas fa-bullhorn me-1"></i>Pengumuman
                                    @else
                                        <i class="fas fa-info-circle me-1"></i>Informasi
                                    @endif
                                </span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $article->published_at->format('d F Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-user"></i>
                                <span>{{ $article->admin->name }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-tag"></i>
                                <a href="{{ route('articles.category', $article->category->slug) }}" class="text-decoration-none">
                                    {{ $article->category->name }}
                                </a>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-eye"></i>
                                <span>{{ number_format($article->views) }} views</span>
                            </div>
                        </div>

                        @if($article->is_featured)
                        <div class="mb-3">
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star me-1"></i>Artikel Unggulan
                            </span>
                        </div>
                        @endif
                    </header>

                    <!-- Featured Image -->
                    @if($article->featured_image)
                    <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="featured-image">
                    @endif

                    <!-- Article Excerpt -->
                    @if($article->excerpt)
                    <div class="alert alert-light border-start border-4 border-primary mb-4">
                        <strong>Ringkasan:</strong> {{ $article->excerpt }}
                    </div>
                    @endif

                    <!-- Article Body -->
                    <div class="article-body">
                        {!! $article->content !!}
                    </div>

                    <!-- Social Share -->
                    <div class="social-share">
                        <h5 class="share-title">
                            <i class="fas fa-share-alt me-2"></i>Bagikan Artikel
                        </h5>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                               target="_blank" class="share-btn share-facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $article->title }}"
                               target="_blank" class="share-btn share-twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ $article->title }} {{ url()->current() }}"
                               target="_blank" class="share-btn share-whatsapp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}"
                               target="_blank" class="share-btn share-linkedin">
                                <i class="fab fa-linkedin-in"></i> LinkedIn
                            </a>
                        </div>
                    </div>

                    <!-- Author Info -->
                    <div class="author-info">
                        <div class="author-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <h6>Ditulis oleh</h6>
                        <h5>{{ $article->admin->name }}</h5>
                        <p class="text-muted mb-0">Admin PPID Kemenag Nganjuk</p>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="navigation-buttons">
                        <a href="{{ route('articles.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Kembali ke Artikel
                        </a>
                        <a href="{{ route('articles.category', $article->category->slug) }}" class="btn-back">
                            <i class="fas fa-list"></i> {{ $article->category->name }}
                        </a>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Related Articles -->
                @if($relatedArticles->count() > 0)
                <div class="sidebar-widget">
                    <div class="widget-header">
                        <i class="fas fa-newspaper me-2"></i>Artikel Terkait
                    </div>
                    <div class="widget-body">
                        @foreach($relatedArticles as $related)
                        <div class="related-article">
                            @if($related->featured_image)
                            <img src="{{ $related->featured_image_url }}" alt="{{ $related->title }}" class="related-image">
                            @endif
                            <div class="related-content">
                                <h6>
                                    <a href="{{ route('articles.show', $related->slug) }}">
                                        {{ Str::limit($related->title, 60) }}
                                    </a>
                                </h6>
                                <div class="related-meta">
                                    <span class="badge badge-type badge-{{ $related->type }}">
                                        {{ $related->type === 'news' ? 'Berita' : ($related->type === 'announcement' ? 'Pengumuman' : 'Informasi') }}
                                    </span>
                                    <br>
                                    <i class="fas fa-calendar me-1"></i>{{ $related->published_at->format('d M Y') }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-eye me-1"></i>{{ number_format($related->views) }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Latest Articles -->
                <div class="sidebar-widget">
                    <div class="widget-header" style="background: #3498db;">
                        <i class="fas fa-clock me-2"></i>Artikel Terbaru
                    </div>
                    <div class="widget-body">
                        @php
                            $latestArticles = App\Models\Article::published()
                                                              ->where('id', '!=', $article->id)
                                                              ->latest('published_at')
                                                              ->take(5)
                                                              ->get();
                        @endphp
                        @foreach($latestArticles as $latest)
                        <div class="related-article">
                            @if($latest->featured_image)
                            <img src="{{ $latest->featured_image_url }}" alt="{{ $latest->title }}" class="related-image">
                            @endif
                            <div class="related-content">
                                <h6>
                                    <a href="{{ route('articles.show', $latest->slug) }}">
                                        {{ Str::limit($latest->title, 60) }}
                                    </a>
                                </h6>
                                <div class="related-meta">
                                    <span class="badge badge-type badge-{{ $latest->type }}">
                                        {{ $latest->type === 'news' ? 'Berita' : ($latest->type === 'announcement' ? 'Pengumuman' : 'Informasi') }}
                                    </span>
                                    <br>
                                    <i class="fas fa-calendar me-1"></i>{{ $latest->published_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Popular Articles -->
                <div class="sidebar-widget">
                    <div class="widget-header" style="background: #e74c3c;">
                        <i class="fas fa-fire me-2"></i>Artikel Populer
                    </div>
                    <div class="widget-body">
                        @php
                            $popularArticles = App\Models\Article::published()
                                                                ->where('id', '!=', $article->id)
                                                                ->orderBy('views', 'desc')
                                                                ->take(5)
                                                                ->get();
                        @endphp
                        @foreach($popularArticles as $popular)
                        <div class="related-article">
                            @if($popular->featured_image)
                            <img src="{{ $popular->featured_image_url }}" alt="{{ $popular->title }}" class="related-image">
                            @endif
                            <div class="related-content">
                                <h6>
                                    <a href="{{ route('articles.show', $popular->slug) }}">
                                        {{ Str::limit($popular->title, 60) }}
                                    </a>
                                </h6>
                                <div class="related-meta">
                                    <i class="fas fa-eye me-1"></i>{{ number_format($popular->views) }} views
                                    <br>
                                    <i class="fas fa-calendar me-1"></i>{{ $popular->published_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-landmark me-2"></i>PPID Kemenag Nganjuk</h5>
                    <p>Pejabat Pengelola Informasi dan Dokumentasi Kementerian Agama Kabupaten Nganjuk berkomitmen memberikan layanan informasi publik yang terbaik.</p>
                </div>
                <div class="col-md-6">
                    <h6>Kontak Kami</h6>
                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i>Jl. Raya Surabaya-Madiun KM. 45, Nganjuk</p>
                    <p class="mb-1"><i class="fas fa-phone me-2"></i>(0358) 321175</p>
                    <p><i class="fas fa-envelope me-2"></i>ppid@kemenagnganjuk.id</p>
                </div>
            </div>
            <hr class="my-3">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 PPID Kemenag Kabupaten Nganjuk. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
