<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Admin PPID Kemenag Nganjuk</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- AdminLTE Theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --kemenag-primary: #1e5631;
            --kemenag-secondary: #2d8f47;
            --kemenag-accent: #ffd700;
        }

        .navbar-success {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary)) !important;
        }

        .main-sidebar .sidebar {
            background: #343a40;
        }

        .nav-sidebar .nav-item > .nav-link.active {
            background: var(--kemenag-primary);
            color: white;
        }

        .nav-sidebar .nav-item > .nav-link:hover {
            background: rgba(30, 86, 49, 0.2);
            color: var(--kemenag-accent);
        }

        .brand-link {
            background: var(--kemenag-primary) !important;
            color: white !important;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .brand-link:hover {
            color: var(--kemenag-accent) !important;
        }

        .content-wrapper {
            background: #f4f6f9;
        }

        .card-success .card-header {
            background: var(--kemenag-primary);
            border-color: var(--kemenag-primary);
        }

        .btn-success {
            background: var(--kemenag-primary);
            border-color: var(--kemenag-primary);
        }

        .btn-success:hover {
            background: var(--kemenag-secondary);
            border-color: var(--kemenag-secondary);
        }

        .info-box-icon.bg-success {
            background: var(--kemenag-primary) !important;
        }

        .small-box.bg-success {
            background: linear-gradient(135deg, var(--kemenag-primary), var(--kemenag-secondary)) !important;
        }

        .small-box.bg-info {
            background: linear-gradient(135deg, #17a2b8, #20c997) !important;
        }

        .small-box.bg-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14) !important;
        }

        .small-box.bg-danger {
            background: linear-gradient(135deg, #dc3545, #e83e8c) !important;
        }

        .elevation-2 {
            box-shadow: 0 2px 4px rgba(0,0,0,.1), 0 8px 16px rgba(0,0,0,.1);
        }

        .table th {
            background: var(--kemenag-primary);
            color: white;
            border: none;
        }

        .table td {
            border-color: rgba(0,0,0,0.05);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--kemenag-primary) !important;
            border-color: var(--kemenag-primary) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--kemenag-secondary) !important;
            border-color: var(--kemenag-secondary) !important;
            color: white !important;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .text-success {
            color: var(--kemenag-primary) !important;
        }
    </style>

    @stack('styles')
</head>
<<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Emblem_of_Ministry_of_Religious_Affairs_of_Indonesia.svg/200px-Emblem_of_Ministry_of_Religious_Affairs_of_Indonesia.svg.png" alt="Logo Kemenag" height="60" width="60">
    </div>

    <!-- Navbar -->
    @include('admin.layouts.navbar')

    <!-- Main Sidebar Container -->
    @include('admin.layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumb')
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    @include('admin.layouts.footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables
    $('.data-table').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        }
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // CSRF token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Delete confirmation with SweetAlert
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();

        var form = $(this).closest('form');
        var title = $(this).data('title') || 'Apakah Anda yakin?';
        var text = $(this).data('text') || 'Data yang dihapus tidak dapat dikembalikan!';

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@stack('scripts')
</body>
</html>
