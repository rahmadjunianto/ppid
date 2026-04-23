@extends('layouts.app')

@section('content')
<style>
    :root {
        --kemenag-primary: #1e5631;
        --kemenag-secondary: #2d8f47;
        --kemenag-accent: #ffd700;
    }

    .success-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 60vh;
        padding: 2rem;
    }

    .success-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        padding: 3rem 2rem;
        text-align: center;
        max-width: 600px;
        overflow: hidden;
    }

    .success-icon {
        font-size: 5rem;
        color: var(--kemenag-primary);
        margin-bottom: 1.5rem;
        animation: bounceIn 0.6s ease-out;
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .success-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--kemenag-primary);
        margin-bottom: 1rem;
    }

    .success-message {
        font-size: 1.1rem;
        color: #555;
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    .success-description {
        background: rgba(30, 86, 49, 0.05);
        border-left: 4px solid var(--kemenag-primary);
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        text-align: left;
        font-size: 0.95rem;
    }

    .success-description p {
        margin-bottom: 0.75rem;
    }

    .success-description p:last-child {
        margin-bottom: 0;
    }

    .btn-success-action {
        background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin: 0.5rem;
    }

    .btn-success-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 86, 49, 0.3);
        color: white;
    }

    .btn-secondary-action {
        background: white;
        color: var(--kemenag-primary);
        border: 2px solid var(--kemenag-primary);
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin: 0.5rem;
    }

    .btn-secondary-action:hover {
        background: rgba(30, 86, 49, 0.05);
        border-color: var(--kemenag-secondary);
        color: var(--kemenag-secondary);
    }

    .checkmark {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        animation: slideDown 0.6s ease-out;
    }

    .checkmark svg {
        width: 50px;
        height: 50px;
        stroke: white;
        stroke-width: 3;
        stroke-linecap: round;
        fill: none;
        animation: checkmark 0.6s ease-out 0.3s forwards;
    }

    .checkmark svg polyline {
        stroke-dasharray: 50;
        stroke-dashoffset: 50;
        animation: checkmark 0.6s ease-out 0.3s forwards;
    }

    @keyframes slideDown {
        0% {
            transform: translateY(-50px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes checkmark {
        to {
            stroke-dashoffset: 0;
        }
    }

    .success-meta {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e9ecef;
    }

    @media (max-width: 768px) {
        .success-card {
            padding: 2rem 1.5rem;
        }

        .success-title {
            font-size: 1.5rem;
        }

        .success-message {
            font-size: 1rem;
        }

        .checkmark {
            width: 60px;
            height: 60px;
        }

        .checkmark svg {
            width: 40px;
            height: 40px;
        }
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('survey.skm-spak.index') }}">Survey SKM & SPAK</a></li>
                <li class="breadcrumb-item active">Terima Kasih</li>
            </ol>
        </nav>
        <h1><i class="fas fa-check-circle me-3"></i>Survey Berhasil Dikirim</h1>
    </div>
</div>

<!-- Success Content -->
<div class="container my-5">
    <div class="success-container">
        <div class="success-card">
            <div class="checkmark">
                <svg viewBox="0 0 52 52">
                    <polyline points="17.7,26.7 24.8,33.8 35.2,22.4" />
                </svg>
            </div>

            <h2 class="success-title">Terima Kasih!</h2>

            <p class="success-message">
                Respons survey Anda telah berhasil kami terima dengan baik.
            </p>

            <div class="success-description">
                <p><strong>Apa selanjutnya?</strong></p>
                <p>Data yang Anda berikan sangat berharga bagi kami untuk meningkatkan kualitas dan integritas layanan publik di Kantor Kementerian Agama Kabupaten Nganjuk.</p>
                <p>Kami akan menganalisis semua respons dan menggunakannya untuk evaluasi serta perbaikan berkelanjutan terhadap sistem dan pelayanan kami.</p>
            </div>

            <div class="success-meta">
                <p><i class="fas fa-info-circle me-2"></i>Waktu Pengiriman: <strong>{{ now()->locale('id')->format('d F Y H:i') }}</strong></p>
            </div>

            <div style="margin-top: 2rem;">
                <a href="{{ url('/') }}" class="btn-success-action">
                    <i class="fas fa-home me-2"></i>Kembali ke Beranda
                </a>
                <a href="{{ route('survey.skm-spak.index') }}" class="btn-secondary-action">
                    <i class="fas fa-poll me-2"></i>Isi Survey Lagi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
