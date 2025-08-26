<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - PPID Kemenag Nganjuk</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        :root {
            --kemenag-primary: #1e5631;
            --kemenag-secondary: #2d8f47;
            --kemenag-accent: #ffd700;
        }

        body {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary));
            min-height: 100vh;
        }

        .login-card-body {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .btn-primary {
            background: var(--kemenag-primary);
            border-color: var(--kemenag-primary);
        }

        .btn-primary:hover {
            background: var(--kemenag-secondary);
            border-color: var(--kemenag-secondary);
        }

        .input-group-text {
            background: var(--kemenag-primary);
            border-color: var(--kemenag-primary);
            color: white;
        }

        .form-control:focus {
            border-color: var(--kemenag-primary);
            box-shadow: 0 0 0 0.2rem rgba(30, 86, 49, 0.25);
        }

        .icheck-primary > input:checked + label::before {
            background-color: var(--kemenag-primary);
            border-color: var(--kemenag-primary);
        }

        .login-logo a {
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .login-logo img {
            filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));
        }
    </style>
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <!-- Login logo -->
    <div class="login-logo">
        <img src="{{ asset('logo-kemenag.png') }}"
             alt="Logo Kemenag" class="mb-3" style="height: 80px;">
        <br>
        <a href="{{ url('/') }}"><b>Admin</b> PPID<br><small>Kemenag Nganjuk</small></a>
    </div>
    <!-- /.login-logo -->

    <div class="card elevation-4">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Masuk untuk mengakses panel admin</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password" required autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                Ingat saya
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mb-1">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Lupa password?</a>
                @endif
            </p>

            <p class="mb-0">
                <a href="{{ url('/') }}" class="text-center">
                    <i class="fas fa-arrow-left"></i> Kembali ke Website
                </a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function() {
    // Auto focus on email field
    $('#email').focus();

    // Show demo credentials hint
    setTimeout(function() {
        if (!$('#email').val()) {
            $('#email').attr('placeholder', 'Email: admin@ppid.test');
            $('#password').attr('placeholder', 'Password: password');
        }
    }, 2000);
});
</script>

</body>
</html>
