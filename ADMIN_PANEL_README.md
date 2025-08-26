# Admin Panel AdminLTE - PPID Kemenag Nganjuk

## Overview
Telah berhasil dibuat admin panel menggunakan AdminLTE v3.2 untuk mengelola sistem survey PPID Kemenag Nganjuk.

## Features Yang Tersedia

### 1. Dashboard Admin
- **URL**: `/admin/dashboard`
- **Fitur**:
  - Statistik total survey, survey hari ini, minggu ini, dan rating rata-rata
  - Grafik survey 7 hari terakhir (line chart)
  - Grafik demografi responden (doughnut chart) 
  - Tabel survey terbaru (10 data terakhir)
  - Analisis rating per kategori (bar chart)

### 2. Survey Management
- **URL**: `/admin/surveys`
- **Fitur**:
  - Daftar semua data survey dengan pagination
  - Filter berdasarkan jenis kelamin, pendidikan, dan tanggal
  - Export data ke CSV/Excel
  - Detail view untuk masing-masing survey
  - Hapus data survey
  - Statistik lengkap dengan berbagai chart

### 3. Layout & Components
- **Navbar**: 
  - Notifikasi survey terbaru
  - User menu dengan profile dan logout
  - Link ke website publik
- **Sidebar**:
  - Dashboard menu
  - Survey management dengan submenu
  - Search functionality
  - User profile section
- **Footer**: 
  - Copyright dan informasi versi
  - Total survey counter

## Login Admin
- **URL**: `http://127.0.0.1:8001/login` (atau port yang aktif)
- **Email**: `admin@ppid.test`
- **Password**: `password`
- **Login Page**: Menggunakan AdminLTE design dengan branding Kemenag
- **Features**: Auto-focus, remember me, forgot password link, demo credentials hint

## Color Scheme
Menggunakan warna Kemenag:
- **Primary**: #1e5631 (hijau tua Kemenag)
- **Secondary**: #2d8f47 (hijau sedang)
- **Accent**: #ffd700 (kuning/emas)

## Technology Stack
- **Backend**: Laravel 7.4.33
- **Frontend**: AdminLTE 3.2
- **CSS Framework**: Bootstrap 4.6
- **Charts**: Chart.js 3.9.1
- **Tables**: DataTables 1.13.6
- **Icons**: Font Awesome 6.0, Ionicons
- **Notifications**: SweetAlert2
- **Database**: MySQL

## File Structure
```
resources/views/admin/
├── layouts/
│   ├── app.blade.php        # Main layout template
│   ├── navbar.blade.php     # Top navigation bar
│   ├── sidebar.blade.php    # Left sidebar menu
│   └── footer.blade.php     # Footer component
├── dashboard.blade.php      # Admin dashboard
└── surveys/
    ├── index.blade.php      # Survey list/management
    ├── show.blade.php       # Survey detail view
    └── statistics.blade.php # Survey statistics
```

## Routes
```php
// Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::prefix('surveys')->name('surveys.')->group(function () {
        Route::get('/', [AdminSurveyController::class, 'index'])->name('index');
        Route::get('/statistics', [AdminSurveyController::class, 'statistics'])->name('statistics');
        Route::get('/export', [AdminSurveyController::class, 'export'])->name('export');
        Route::get('/{survey}', [AdminSurveyController::class, 'show'])->name('show');
        Route::delete('/{survey}', [AdminSurveyController::class, 'destroy'])->name('destroy');
    });
});
```

## Key Features
1. **Responsive Design** - Mobile-friendly AdminLTE interface
2. **Real-time Statistics** - Dashboard dengan data live dari database
3. **Interactive Charts** - Grafik interaktif untuk analisis data
4. **Export Functionality** - Export data survey ke CSV
5. **Advanced Filtering** - Filter data berdasarkan berbagai kriteria
6. **User Authentication** - Sistem login yang aman
7. **Notifications** - SweetAlert2 untuk notifikasi yang menarik
8. **DataTables** - Tabel dengan search, sort, dan pagination
9. **Consistent Styling** - Menggunakan warna dan tema Kemenag
10. **Collapsible Components** - Sidebar dan card yang dapat di-collapse

## Development Notes
- Server development berjalan di port 8001 (karena 8000 sudah digunakan)
- Database sudah terisi dengan sample data survey
- Authentication menggunakan Laravel default auth
- Admin panel terintegrasi penuh dengan sistem survey publik
- CSS custom menggunakan variabel CSS untuk konsistensi warna

## Troubleshooting

### Error: "Target class [App\Http\Controllers\Auth\LoginController] does not exist"
**Solusi**: Jalankan command berikut untuk membuat authentication scaffolding:
```bash
php artisan ui:auth
```

### Server sudah berjalan di port 8000
Laravel akan otomatis menggunakan port 8001 jika 8000 sudah digunakan.

### Admin user belum ada
Jalankan seeder untuk membuat admin user:
```bash
php artisan db:seed --class=AdminUserSeeder
```

### Database connection error
Pastikan konfigurasi database di `.env` sudah benar dan database MySQL sudah berjalan.

## Next Steps (Opsional)
1. User management (tambah/edit/hapus admin users)
2. Advanced reporting dengan lebih banyak chart
3. Email notifications untuk survey baru
4. Backup/restore database functionality
5. System settings management
6. Audit logs untuk tracking aktivitas admin

Admin panel AdminLTE telah berhasil dibuat dan siap digunakan untuk mengelola sistem survey PPID Kemenag Nganjuk.
