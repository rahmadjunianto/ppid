<nav class="main-header navbar navbar-expand navbar-success navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('survey.index') }}" class="nav-link" target="_blank">
                <i class="fas fa-poll"></i> Survey Publik
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Fullscreen Toggle -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <!-- Notifications -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{ \App\Models\Survey::whereDate('created_at', today())->count() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item-text">{{ \App\Models\Survey::whereDate('created_at', today())->count() }} Survey Hari Ini</span>
                <div class="dropdown-divider"></div>
                @php
                    $recentSurveys = \App\Models\Survey::latest()->take(3)->get();
                @endphp
                @foreach($recentSurveys as $survey)
                <a href="{{ route('admin.surveys.show', $survey->id) }}" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> {{ $survey->nama }}
                    <span class="float-right text-muted text-sm">{{ $survey->created_at->diffForHumans() }}</span>
                </a>
                <div class="dropdown-divider"></div>
                @endforeach
                <a href="{{ route('admin.surveys.index') }}" class="dropdown-item dropdown-footer">Lihat Semua Survey</a>
            </div>
        </li>

        <!-- User Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=1e5631&color=fff&size=32"
                     class="img-circle" alt="User Image" style="width: 32px; height: 32px;">
                <span class="d-none d-md-inline ml-1">{{ auth()->user()->name ?? 'Admin' }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-header">
                    <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
                    <br>
                    <small class="text-muted">{{ auth()->user()->email ?? 'admin@example.com' }}</small>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ url('/') }}" class="dropdown-item" target="_blank">
                    <i class="fas fa-external-link-alt mr-2"></i> Lihat Website
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
