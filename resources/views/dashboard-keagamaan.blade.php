<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Keagamaan- Kementerian Agama Kabupaten Nganjuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
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

        /* Header */
        .navbar {
            background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: white !important;
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--kemenag-accent) !important;
            transform: translateY(-1px);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .dropdown-item:hover {
            background-color: var(--kemenag-light);
            color: var(--kemenag-primary);
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
            color: white;
            padding: 4rem 0 2rem;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .breadcrumb {
            background: none;
            padding: 0;
        }

        .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--kemenag-accent);
        }

        /* Content Sections */
        .content-section {
            margin-bottom: 3rem;
        }

        .section-title {
            color: var(--kemenag-primary);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--kemenag-accent);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            margin-bottom: 2rem;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            padding: 1rem 1.5rem;
        }

        .list-group-item {
            border: none;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .highlight-box {
            background: linear-gradient(135deg, var(--kemenag-light) 0%, #fff 100%);
            border-left: 4px solid var(--kemenag-accent);
            padding: 1.5rem;
            border-radius: 0 10px 10px 0;
            margin: 1.5rem 0;
        }

        .regulation-item {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--kemenag-secondary);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .badge-kemenag {
            background: var(--kemenag-accent);
            color: var(--kemenag-primary);
            font-weight: 600;
        }

        /* Structure Section */
        .structure-item {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            border-top: 3px solid var(--kemenag-secondary);
        }

        .structure-item h5 {
            color: var(--kemenag-primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .structure-list {
            list-style: none;
            padding-left: 0;
        }

        .structure-list li {
            padding: 0.25rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .structure-list li:last-child {
            border-bottom: none;
        }

        /* Footer */
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
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .card-header {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    @include('partials.navbar')


    <!-- Main Content -->
    <div class="container">

        <!-- Dasar Hukum -->
        <div class="content-section">
            <div class="row">
                <div class="card">
                    <div class="card-body" style="padding: 2rem;">
                        <div class="ratio ratio-16x9 mb-4">
                            <iframe
                                src="https://www.appsheet.com/start/deaf9e73-f3ff-417f-b30e-c6a573315fdb"
                                title="AppSheet - PPID"
                                loading="lazy"
                                style="border:0;"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <p class="small text-muted mb-0">
                            Jika tampilan tidak muncul atau ingin melihat di layar penuh, buka aplikasi di tab baru:
                            <a href="https://www.appsheet.com/start/deaf9e73-f3ff-417f-b30e-c6a573315fdb" target="_blank" rel="noopener">Buka AppSheet</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Footer -->
@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</html>
