<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'PPID Kementerian Agama Kabupaten Nganjuk - Layanan Informasi Publik Terpercaya')">
    <meta name="keywords" content="@yield('meta_keywords', 'PPID, Kemenag, Nganjuk, Informasi Publik, Layanan')">

    <title>@yield('title', 'PPID Kemenag Nganjuk')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --kemenag-primary: #1e5631;
            --kemenag-secondary: #2d8f47;
            --kemenag-accent: #ffd700;
            --kemenag-light: #f8f9fa;
            --kemenag-dark: #0d2818;
            --gradient-primary: linear-gradient(135deg, var(--kemenag-primary) 0%, var(--kemenag-secondary) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            background: var(--kemenag-light);
            padding-top: 80px;
        }

        .navbar-kemenag {
            background: var(--gradient-primary);
            box-shadow: 0 2px 20px rgba(30, 86, 49, 0.1);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: white !important;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--kemenag-accent) !important;
            transform: scale(1.02);
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .dropdown-menu {
            border: none;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            padding: 15px 0;
            min-width: 280px;
            background: white;
            margin-top: 10px;
        }

        .dropdown-item {
            padding: 12px 25px;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 3px 15px;
            color: #333;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: var(--gradient-primary);
            color: white !important;
            transform: translateX(8px);
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 12px 18px;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 3px;
            color: white !important;
        }

        .navbar-nav .nav-link:hover {
            color: var(--kemenag-accent) !important;
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link.active {
            color: var(--kemenag-accent) !important;
            background: rgba(255,255,255,0.15);
            font-weight: 600;
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--kemenag-primary);
            margin-bottom: 25px;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .section-subtitle {
            color: #6c757d;
            font-size: 1.2rem;
            margin-bottom: 50px;
            font-weight: 400;
        }

        .btn-kemenag {
            background: var(--gradient-primary);
            border: none;
            border-radius: 25px;
            padding: 14px 35px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .btn-kemenag::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-kemenag:hover::before {
            left: 100%;
        }

        .btn-kemenag:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(30, 86, 49, 0.3);
            color: white;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.12);
        }

        .card-header-gradient {
            background: var(--gradient-primary);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 25px;
            border: none;
        }

        .footer-kemenag {
            background: var(--kemenag-dark);
            color: white;
            padding: 80px 0 40px;
            margin-top: 80px;
        }

        .footer-logo {
            height: 80px;
            margin-bottom: 25px;
        }

        .footer-link {
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 5px 0;
            display: inline-block;
        }

        .footer-link:hover {
            color: var(--kemenag-accent);
            transform: translateX(5px);
        }

        .social-icon {
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
        }

        .social-icon:hover {
            background: var(--kemenag-accent);
            color: var(--kemenag-primary);
            transform: translateY(-3px);
        }

        .breadcrumb {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 15px 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
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

        .alert {
            border: none;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(25, 135, 84, 0.1), rgba(32, 201, 151, 0.1));
            border-left: 4px solid #198754;
            color: #155724;
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(13, 202, 240, 0.1), rgba(111, 66, 193, 0.1));
            border-left: 4px solid #0dcaf0;
            color: #055160;
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 202, 44, 0.1));
            border-left: 4px solid #ffc107;
            color: #664d03;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(253, 126, 20, 0.1));
            border-left: 4px solid #dc3545;
            color: #721c24;
        }

        /* Smooth Animations */
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }

            .section-title {
                font-size: 2.2rem;
            }

            .navbar-nav {
                background: rgba(255,255,255,0.1);
                border-radius: 15px;
                padding: 15px;
                margin-top: 15px;
            }

            .dropdown-menu {
                position: static !important;
                transform: none !important;
                box-shadow: none;
                border: none;
                background: rgba(255,255,255,0.1);
                margin-top: 8px;
                margin-left: 20px;
            }

            .dropdown-item {
                color: white !important;
                margin: 2px 8px;
            }

            .dropdown-item:hover {
                background: rgba(255,255,255,0.2);
                transform: none;
            }

            .card {
                margin-bottom: 25px;
            }

            .btn-kemenag {
                width: 100%;
                text-align: center;
                margin-bottom: 15px;
            }
        }

        /* Print Styles */
        @media print {
            .navbar, .footer-kemenag, .breadcrumb {
                display: none !important;
            }

            body {
                padding-top: 0;
                background: white;
            }

            .card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Include Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="animate-fadeIn">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scrolling to all anchor links
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

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-slideUp');
                }
            });
        }, observerOptions);

        // Observe all cards and sections
        document.querySelectorAll('.card, .section, .stats-card').forEach(element => {
            observer.observe(element);
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert:not(.alert-permanent)').forEach(alert => {
                if (alert.classList.contains('alert-dismissible')) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);

        // Add loading animation to forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                }
            });
        });

        // Enhanced navbar scroll effect
        let lastScrollTop = 0;
        const navbar = document.querySelector('.navbar');
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                navbar.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        });
    });
    </script>
</body>
</html>
