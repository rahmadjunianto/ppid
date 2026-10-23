
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
        }

        .navbar-kemenag {
            background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
            box-shadow: 0 2px 20px rgba(30, 86, 49, 0.1);
        }

        .navbar-brand img {
            height: 40px;
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

        .pagination-navigation .pagination {
            margin: 0;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-item a {
            color: var(--kemenag-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--kemenag-secondary);
        }

        .breadcrumb-item.active {
            color: var(--kemenag-primary);
            font-weight: 600;
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

    </style>
</head>
<body>
    <!-- Include Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Pegawai</li>
                </ol>
            </nav>

            <div class="row mb-3 align-items-center g-3">
                <div class="col-lg-5">
                    <h4 class="fw-bold text-success mb-1"><i class="bi bi-people-fill me-2"></i>Data Pegawai</h4>
                    <p class="text-muted mb-0 small">Informasi lengkap pegawai Kementerian Agama Kabupaten Nganjuk</p>
                </div>
                <div class="col-lg-7">
                    <form method="GET" action="{{ route('pegawai.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari pegawai..." aria-label="Pencarian" value="{{ request('search') }}">
                            <select name="unit_kerja" class="form-select" style="max-width: 220px;" aria-label="Filter unit kerja" onchange="this.form.submit()">
                                <option value="">Semua Unit Kerja</option>
                                @foreach($unitKerja as $unit)
                                    <option value="{{ $unit }}" {{ request('unit_kerja') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-success" type="submit" title="Cari"><i class="bi bi-search"></i></button>
                            @if(request()->anyFilled(['search', 'unit_kerja']))
                                <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary" title="Hapus filter"><i class="bi bi-x"></i></a>
                            @endif
                        </div>
                    </form>
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
                <div class="d-flex justify-content-center mt-4">
                    {{ $pegawai->appends(request()->query())->links('custom-pagination') }}
                </div>
            @endif
            <p class="text-muted small text-center mt-3 mb-0">
                Menampilkan {{ $pegawai->firstItem() ?? 0 }} - {{ $pegawai->lastItem() ?? 0 }} dari {{ $pegawai->total() }} pegawai
            </p>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
