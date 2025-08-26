@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-poll"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Survey</span>
                            <span class="info-box-number">
                                @php
                                    $totalSurveys = \App\Models\Survey::count();
                                @endphp
                                {{ $totalSurveys }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-star"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Rata-rata Rating</span>
                            <span class="info-box-number">
                                @php
                                    $stats = \App\Models\Survey::getStatistics();
                                @endphp
                                {{ number_format($stats['rata_rata_kepuasan'], 1) }}/4
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-percentage"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tingkat Kepuasan</span>
                            <span class="info-box-number">
                                {{ round(($stats['rata_rata_kepuasan'] / 4) * 100) }}%
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Survey Hari Ini</span>
                            <span class="info-box-number">
                                @php
                                    $todaySurveys = \App\Models\Survey::whereDate('created_at', today())->count();
                                @endphp
                                {{ $todaySurveys }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main row -->
            <div class="row">
                <!-- Quick Actions -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('admin.surveys.index') }}" class="btn btn-primary btn-block">
                                        <i class="fas fa-list"></i> Lihat Data Survey
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('admin.surveys.statistics') }}" class="btn btn-info btn-block">
                                        <i class="fas fa-chart-bar"></i> Lihat Statistik
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <a href="{{ route('admin.surveys.export') }}" class="btn btn-success btn-block">
                                        <i class="fas fa-download"></i> Export Data
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('survey.index') }}" target="_blank" class="btn btn-warning btn-block">
                                        <i class="fas fa-external-link-alt"></i> Lihat Survey
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Surveys -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Survey Terbaru</h3>
                        </div>
                        <div class="card-body">
                            @php
                                $recentSurveys = \App\Models\Survey::latest()->take(5)->get();
                            @endphp
                            
                            @if($recentSurveys->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Rating</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentSurveys as $survey)
                                        <tr>
                                            <td>{{ Str::limit($survey->nama, 20) }}</td>
                                            <td>
                                                <span class="badge badge-{{ $survey->getAverageRating() >= 3 ? 'success' : 'warning' }}">
                                                    {{ number_format($survey->getAverageRating(), 1) }}
                                                </span>
                                            </td>
                                            <td>{{ $survey->created_at->format('d/m H:i') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <p class="text-muted text-center">Belum ada survey.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Selamat Datang</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Informasi!</h5>
                                Selamat datang di panel admin PPID Kemenag Nganjuk. Gunakan menu di sebelah kiri untuk mengelola data survey.
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Fitur yang Tersedia:</h6>
                                    <ul>
                                        <li>Kelola data survey responden</li>
                                        <li>Lihat statistik dan analisis</li>
                                        <li>Export data ke format CSV</li>
                                        <li>Monitor tingkat kepuasan</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Link Berguna:</h6>
                                    <ul>
                                        <li><a href="{{ route('survey.index') }}" target="_blank">Form Survey Public</a></li>
                                        <li><a href="{{ route('survey.results') }}" target="_blank">Hasil Survey Public</a></li>
                                        <li><a href="{{ url('/') }}" target="_blank">Website Utama</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
