
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Data Pegawai PPID Kementerian Agama Kabupaten Nganjuk">
    <meta name="keywords" content="Pegawai, PPID, Kemenag, Nganjuk, Data Pegawai">

    <title>Data Pegawai - PPID Kemenag Kabupaten Nganjuk</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --kemenag-primary: #1e5631;
            --kemenag-secondary: #2d8f47;
            --kemenag-accent: #ffd700;
            --kemenag-light: #f8f9fa;
            --kemenag-dark: #0d2818;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            padding-top: 80px;
            background-color: #f8f9fa;
        }

        .navbar-kemenag {
            background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
            box-shadow: 0 2px 20px rgba(30, 86, 49, 0.1);
        }

        .navbar-brand img {
            height: 40px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .pegawai-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: none;
        }

        .pegawai-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .pegawai-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--kemenag-light);
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .pegawai-initials {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0 auto 15px auto;
            border: 4px solid var(--kemenag-light);
            transition: all 0.3s ease;
        }        .pegawai-name {
            font-weight: 600;
            color: var(--kemenag-dark);
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .pegawai-jabatan {
            color: var(--kemenag-primary);
            font-weight: 500;
            margin-bottom: 5px;
        }

        .pegawai-unit {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .btn-kemenag {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-kemenag:hover {
            background: linear-gradient(135deg, var(--kemenag-secondary), var(--kemenag-primary));
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-kemenag {
            border: 2px solid var(--kemenag-primary);
            color: var(--kemenag-primary);
            background: transparent;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-kemenag:hover {
            background: var(--kemenag-primary);
            color: white;
        }

        .search-box {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            border-color: var(--kemenag-primary);
            box-shadow: 0 0 0 0.2rem rgba(30, 86, 49, 0.25);
        }

        .select-custom {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .select-custom:focus {
            border-color: var(--kemenag-primary);
            box-shadow: 0 0 0 0.2rem rgba(30, 86, 49, 0.25);
        }

        .pagination {
            justify-content: center;
            margin: 0;
            gap: 5px;
        }

        .page-link {
            color: var(--kemenag-primary);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
        }

        .page-link:hover {
            background: var(--kemenag-secondary);
            color: white;
            border-color: var(--kemenag-secondary);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(30, 86, 49, 0.2);
        }

        .page-item.active .page-link {
            background: var(--kemenag-primary);
            border-color: var(--kemenag-primary);
            color: white;
            box-shadow: 0 4px 12px rgba(30, 86, 49, 0.3);
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #f8f9fa;
            border-color: #dee2e6;
            cursor: not-allowed;
        }

        .page-item.disabled .page-link:hover {
            transform: none;
            box-shadow: none;
        }

        .pagination-info {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid var(--kemenag-primary);
        }

        .pagination-wrapper {
            margin: 30px 0;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }

        .pagination-nav {
            display: flex;
            justify-content: center;
        }

        .pagination-summary {
            text-align: center;
            padding: 8px 16px;
            background: #f8f9fa;
            border-radius: 20px;
            display: inline-block;
            color: #6c757d;
            font-size: 0.875rem;
        }

        .pagination-navigation .pagination {
            margin: 0;
        }
            color: white;
            border-color: var(--kemenag-primary);
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: white;
        }

        .breadcrumb-item.active {
            color: var(--kemenag-accent);
        }

        /* Footer Styles */
        .footer-kemenag {
            background: var(--kemenag-dark);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-logo {
            height: 60px;
            margin-bottom: 20px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: var(--kemenag-secondary);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: var(--kemenag-accent);
            color: var(--kemenag-dark);
            transform: translateY(-2px);
        }

        .contact-info .d-flex {
            margin-bottom: 10px;
        }

        .contact-info i {
            color: var(--kemenag-accent);
            margin-top: 2px;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 40px 0;
            }

            .page-header h1 {
                font-size: 1.8rem;
            }

            .filter-section {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    @include('partials.navbar')

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Data Pegawai</li>
                </ol>
            </nav>
            <h1>Data Pegawai</h1>
            <p>PPID Kementerian Agama Kabupaten Nganjuk</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="{{ route('pegawai.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Cari Pegawai</label>
                        <input type="text"
                               name="search"
                               class="form-control search-box"
                               placeholder="Nama, Jabatan, Golongan..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Unit Kerja</label>
                        <select name="unit_kerja" class="form-select select-custom">
                            <option value="">Semua Unit Kerja</option>
                            @foreach($unitKerja as $unit)
                                <option value="{{ $unit }}" {{ request('unit_kerja') == $unit ? 'selected' : '' }}>
                                    {{ $unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-kemenag me-2">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-outline-kemenag">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Count -->
        <div class="pagination-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 text-kemenag">
                        <i class="bi bi-people-fill me-2"></i>
                        Data Pegawai PPID Kemenag Nganjuk
                    </h5>
                    <p class="mb-0 text-muted">
                        Menampilkan {{ $pegawai->firstItem() ?? 0 }} - {{ $pegawai->lastItem() ?? 0 }}
                        dari {{ $pegawai->total() }} pegawai
                        @if(request('search') || request('unit_kerja'))
                            <span class="badge bg-secondary ms-2">Hasil Pencarian</span>
                        @endif
                    </p>
                </div>
                @if($pegawai->hasPages())
                    <div class="text-muted small">
                        Halaman {{ $pegawai->currentPage() }} dari {{ $pegawai->lastPage() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Pegawai Grid -->
        <div class="row">
            @forelse($pegawai as $p)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card pegawai-card">
                        <div class="card-body text-center">
                            @php
                                // Generate initials from name
                                $nameParts = explode(' ', $p->nama);
                                $initials = '';
                                foreach($nameParts as $part) {
                                    if(strlen($initials) < 2) {
                                        $initials .= strtoupper(substr($part, 0, 1));
                                    }
                                }
                                if(strlen($initials) < 2 && count($nameParts) > 0) {
                                    $initials = strtoupper(substr($nameParts[0], 0, 2));
                                }
                            @endphp

                            <div class="pegawai-initials">{{ $initials }}</div>

                            <h6 class="pegawai-name">{{ $p->nama }}</h6>

                            <div class="pegawai-jabatan">{{ $p->jabatan }}</div>

                            @if($p->golongan)
                                <div class="text-muted small mb-2">{{ $p->golongan }}</div>
                            @endif

                            <div class="pegawai-unit">{{ $p->unit_kerja }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-people display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">Tidak ada data pegawai</h4>
                        <p class="text-muted">Silakan coba dengan kata kunci lain atau reset filter.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($pegawai->hasPages())
            <div class="pagination-wrapper">
                <div class="pagination-summary mb-3 text-center">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Halaman {{ $pegawai->currentPage() }} dari {{ $pegawai->lastPage() }}
                        ({{ $pegawai->total() }} total data)
                    </small>
                </div>
                <div class="pagination-nav">
                    {{ $pegawai->appends(request()->query())->links('custom-pagination') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
