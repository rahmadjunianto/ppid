<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - PPID Kemenag Nganjuk</title>
    <meta name="description" content="Artikel kategori {{ $category->name }} dari PPID Kementerian Agama Kabupaten Nganjuk">

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
            padding: 3rem 0;
            margin-bottom: 3rem;
            border-radius: 0 0 30px 30px;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 1rem;
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

        .content-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .article-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
            overflow: hidden;
            height: 100%;
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .article-image {
            height: 200px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .article-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.8rem;
            line-height: 1.4;
        }

        .article-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .article-title a:hover {
            color: var(--primary-color);
        }

        .article-excerpt {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .badge-type {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 15px;
            font-weight: 500;
        }

        .badge-news { background: var(--primary-color); color: white; }
        .badge-announcement { background: #f39c12; color: white; }
        .badge-info { background: #3498db; color: white; }

        .btn-read-more {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-read-more:hover {
            background: var(--secondary-color);
            transform: translateY(-1px);
        }

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

        .category-info {
            background: linear-gradient(135deg, {{ $category->color ?? '#2c5f2d' }}, {{ $category->color ?? '#97bc62' }});
            color: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .filter-item {
            display: block;
            padding: 0.8rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .filter-item:hover {
            background: var(--bg-light);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .filter-item.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .stats-counter {
            background: var(--accent-color);
            color: var(--text-dark);
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: auto;
        }

        .pagination {
            justify-content: center;
            margin-top: 3rem;
        }

        .pagination .page-link {
            border: none;
            color: var(--primary-color);
            margin: 0 0.2rem;
            border-radius: 8px;
            padding: 0.6rem 1rem;
        }

        .pagination .page-link:hover {
            background: var(--primary-color);
            color: white;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .footer {
            background: var(--text-dark);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .content-section {
                padding: 1.5rem;
            }

            .article-card {
                margin-bottom: 1.5rem;
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
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </nav>

            <div class="d-flex align-items-center">
                <div class="me-4">
                    @if($category->icon)
                        <i class="{{ $category->icon }} fa-3x"></i>
                    @else
                        <i class="fas fa-folder fa-3x"></i>
                    @endif
                </div>
                <div>
                    <h1 class="page-title">{{ $category->name }}</h1>
                    @if($category->description)
                        <p class="page-subtitle">{{ $category->description }}</p>
                    @endif
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-alt me-2"></i>
                        <span>{{ $articles->total() }} artikel ditemukan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container main-content">
        <div class="row">
            <!-- Content Area -->
            <div class="col-lg-8">
                <div class="content-section">
                    @if($articles->count() > 0)
                        <div class="row">
                            @foreach($articles as $article)
                            <div class="col-md-6 mb-4">
                                <article class="article-card">
                                    @if($article->featured_image)
                                    <div class="position-relative">
                                        <img src="{{ $article->featured_image_url }}" class="article-image w-100" alt="{{ $article->title }}">
                                        @if($article->is_featured)
                                        <span class="badge badge-danger position-absolute" style="top: 10px; left: 10px;">
                                            <i class="fas fa-star me-1"></i>Unggulan
                                        </span>
                                        @endif
                                    </div>
                                    @endif

                                    <div class="card-body p-3">
                                        <!-- Article Meta -->
                                        <div class="article-meta">
                                            <span class="badge badge-type badge-{{ $article->type }}">
                                                @if($article->type === 'news')
                                                    <i class="fas fa-newspaper me-1"></i>Berita
                                                @elseif($article->type === 'announcement')
                                                    <i class="fas fa-bullhorn me-1"></i>Pengumuman
                                                @else
                                                    <i class="fas fa-info-circle me-1"></i>Informasi
                                                @endif
                                            </span>
                                            <span><i class="fas fa-calendar me-1"></i>{{ $article->published_at->format('d M Y') }}</span>
                                        </div>

                                        <!-- Title -->
                                        <h5 class="article-title">
                                            <a href="{{ route('articles.show', $article->slug) }}">
                                                {{ $article->title }}
                                            </a>
                                        </h5>

                                        <!-- Excerpt -->
                                        <p class="article-excerpt">
                                            {{ Str::limit($article->excerpt ?: strip_tags($article->content), 120) }}
                                        </p>

                                        <!-- Footer -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i>{{ $article->admin->name }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-eye me-1"></i>{{ number_format($article->views) }}
                                            </small>
                                            <a href="{{ route('articles.show', $article->slug) }}"
                                               class="btn btn-read-more">
                                                Baca Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $articles->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <h4>Belum ada artikel</h4>
                            <p>Kategori {{ $category->name }} belum memiliki artikel.</p>
                            <a href="{{ route('articles.index') }}" class="btn btn-read-more">
                                <i class="fas fa-arrow-left me-2"></i>Lihat Semua Artikel
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Category Info -->
                <div class="category-info">
                    @if($category->icon)
                        <i class="{{ $category->icon }} category-icon"></i>
                    @endif
                    <h4>{{ $category->name }}</h4>
                    @if($category->description)
                        <p>{{ $category->description }}</p>
                    @endif
                    <div class="mt-3">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-file-alt me-1"></i>{{ $articles->total() }} artikel
                        </span>
                    </div>
                </div>

                <!-- Other Categories -->
                <div class="sidebar-widget">
                    <div class="widget-header bg-secondary">
                        <i class="fas fa-tags me-2"></i>Kategori Lainnya
                    </div>
                    <div class="widget-body">
                        @php
                            $otherCategories = App\Models\Category::active()
                                                                ->where('id', '!=', $category->id)
                                                                ->withCount('articles')
                                                                ->ordered()
                                                                ->get();
                        @endphp
                        @foreach($otherCategories as $otherCategory)
                        <a href="{{ route('articles.category', $otherCategory->slug) }}"
                           class="filter-item d-flex align-items-center">
                            @if($otherCategory->icon)
                                <i class="{{ $otherCategory->icon }} me-2" style="color: {{ $otherCategory->color }}"></i>
                            @endif
                            <span>{{ $otherCategory->name }}</span>
                            <span class="stats-counter">{{ $otherCategory->articles_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Latest Articles -->
                <div class="sidebar-widget">
                    <div class="widget-header" style="background: #3498db;">
                        <i class="fas fa-clock me-2"></i>Artikel Terbaru
                    </div>
                    <div class="widget-body">
                        @php
                            $latestArticles = App\Models\Article::published()
                                                              ->latest('published_at')
                                                              ->take(5)
                                                              ->get();
                        @endphp
                        @foreach($latestArticles as $latest)
                        <div class="media mb-3 pb-3 border-bottom">
                            @if($latest->featured_image)
                            <img src="{{ $latest->featured_image_url }}" class="me-3 rounded"
                                 style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $latest->title }}">
                            @endif
                            <div class="media-body">
                                <h6 class="mt-0 mb-1">
                                    <a href="{{ route('articles.show', $latest->slug) }}"
                                       class="text-decoration-none text-dark">
                                        {{ Str::limit($latest->title, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted d-block">
                                    <span class="badge badge-type badge-{{ $latest->type }} me-1">
                                        {{ $latest->type === 'news' ? 'Berita' : ($latest->type === 'announcement' ? 'Pengumuman' : 'Informasi') }}
                                    </span>
                                    {{ $latest->published_at->format('d M Y') }}
                                </small>
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
                                                                ->orderBy('views', 'desc')
                                                                ->take(5)
                                                                ->get();
                        @endphp
                        @foreach($popularArticles as $popular)
                        <div class="media mb-3 pb-3 border-bottom">
                            @if($popular->featured_image)
                            <img src="{{ $popular->featured_image_url }}" class="me-3 rounded"
                                 style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $popular->title }}">
                            @endif
                            <div class="media-body">
                                <h6 class="mt-0 mb-1">
                                    <a href="{{ route('articles.show', $popular->slug) }}"
                                       class="text-decoration-none text-dark">
                                        {{ Str::limit($popular->title, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted d-block">
                                    <i class="fas fa-eye me-1"></i>{{ number_format($popular->views) }} views
                                    <span class="mx-2">•</span>
                                    {{ $popular->published_at->format('d M Y') }}
                                </small>
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
