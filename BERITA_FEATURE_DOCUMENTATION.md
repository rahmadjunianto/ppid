# Dokumentasi Fitur Berita dari Database Portal Kemenag

## Overview
Fitur ini mena### **URL Akses:**
- **Daftar Berita**: `http://127.0.0.1:8000/berita`
- **Detail Berita**: `http://127.0.0.1:8000/berita/{id}`
- **Pencarian**: `http://127.0.0.1:8000/berita/search?q=keyword`
- **Test Page**: `http://127.0.0.1:8000/test-berita`

Server Laravel sudah berjalan di port 8000 dan siap digunakan! 🚀 berita dari tabel `berita` di database `portal_kemenag` sesuai dengan konfigurasi environment yang ada di file `.env`.

## Konfigurasi Database

### File: `config/database.php`
Ditambahkan koneksi database baru:
```php
'mysql_portal' => [
    'driver' => 'mysql',
    'host' => env('PORTAL_DB_HOST', '127.0.0.1'),
    'port' => env('PORTAL_DB_PORT', '3306'),
    'database' => env('PORTAL_DB_DATABASE', 'forge'),
    'username' => env('PORTAL_DB_USERNAME', 'forge'),
    'password' => env('PORTAL_DB_PASSWORD', ''),
    // ... konfigurasi lainnya
],
```

### File: `.env`
Konfigurasi koneksi database:
```
PORTAL_DB_HOST=127.0.0.1
PORTAL_DB_PORT=3306
PORTAL_DB_DATABASE=portal_kemenag
PORTAL_DB_USERNAME=root
PORTAL_DB_PASSWORD=1
```

## Model Berita

### File: `app/Models/Berita.php`
- Menggunakan koneksi `mysql_portal`
- Primary key: `id_berita`
- Tidak menggunakan timestamps Laravel (karena tabel existing)
- Accessor untuk mapping field:
  - `tanggal_publish` (gabungan dari `tanggal` + `jam`)
  - `konten` (dari field `isi_berita`)
  - `author` (dari field `username`)
  - `status` (konversi dari `aktif`: Y = published, N = draft)

### Scope Methods:
- `published()`: Filter berita dengan `aktif = 'Y'`
- `headline()`: Filter berita dengan `headline = 'Y'`
- `utama()`: Filter berita dengan `utama = 'Y'`

## Controller

### File: `app/Http/Controllers/BeritaController.php`
Methods yang tersedia:
1. `index()`: Menampilkan daftar berita (view + JSON API)
2. `show($id)`: Menampilkan detail berita
3. `latest($limit)`: API endpoint untuk berita terbaru
4. `search()`: Pencarian berita berdasarkan judul/konten

## Routes

### File: `routes/web.php`
```php
Route::prefix('berita')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/latest/{limit?}', [BeritaController::class, 'latest'])->name('berita.latest');
    Route::get('/search', [BeritaController::class, 'search'])->name('berita.search');
    Route::get('/{id}', [BeritaController::class, 'show'])->name('berita.show');
});
```

## Views

### File: `resources/views/berita/index.blade.php`
- Grid layout untuk daftar berita
- Fitur pencarian
- Pagination
- Responsive design

### File: `resources/views/berita/show.blade.php`
- Detail berita lengkap
- Sidebar dengan berita terbaru lainnya
- Social media share buttons
- Fitur print

## URL Endpoints

1. **Daftar Berita**: `http://localhost:8004/berita`
2. **Detail Berita**: `http://localhost:8004/berita/{id_berita}`
3. **Pencarian**: `http://localhost:8004/berita/search?q=keyword`
4. **API Berita Terbaru**: `http://localhost:8004/berita/latest/5`
5. **Test Page**: `http://localhost:8004/test-berita`

## Fitur

### Frontend Features:
- ✅ Responsive grid layout
- ✅ Search functionality
- ✅ Pagination
- ✅ Image placeholder untuk berita tanpa gambar
- ✅ Social media sharing
- ✅ Print functionality
- ✅ Related news sidebar

### API Features:
- ✅ JSON response support
- ✅ Error handling
- ✅ Pagination untuk API
- ✅ Search API

### Database Features:
- ✅ Multiple database connections
- ✅ Proper model mapping
- ✅ Query optimization
- ✅ Scope methods

## Struktur Tabel Berita

Berdasarkan analisis database, tabel `berita` memiliki struktur:
- `id_berita` (primary key)
- `judul` (title)
- `isi_berita` (content)
- `gambar` (image filename)
- `tanggal` (date)
- `jam` (time)
- `username` (author)
- `aktif` (Y/N - published status)
- `headline` (Y/N)
- `utama` (Y/N - featured)
- `dibaca` (view count)
- `id_kategori` (category ID)
- `judul_seo` (SEO slug)

## Testing

Database connection berhasil ditest dengan:
- Total berita: 1000+ records
- Koneksi ke `portal_kemenag` database: ✅
- Model mapping: ✅
- Controller functionality: ✅
- Routes: ✅
- Views rendering: ✅

### Bug Fixes:
- ✅ **Carbon Date Parsing Error**: Fixed `getTanggalPublishAttribute()` accessor to handle Carbon object casting properly
- ✅ **View Error Handling**: Added null checks for date fields in views
- ✅ **Route Parameters**: Updated views to use correct primary key `id_berita`

## Notes

1. Server development berjalan di port 8000: `http://127.0.0.1:8000`
2. Semua endpoint mendukung response HTML dan JSON
3. Fitur pencarian bekerja pada field `judul` dan `isi_berita`
4. Pagination default: 12 berita per halaman
5. Berita yang ditampilkan hanya yang memiliki status `aktif = 'Y'`
6. **Fixed**: Carbon date parsing issue dengan proper handling untuk field `tanggal` dan `jam`
7. **Fixed**: Pagination berantakan - sekarang menggunakan custom Bootstrap pagination
8. **Added**: Section Berita Terbaru di halaman beranda dengan 6 berita terbaru

## Status Update - August 29, 2025

### ✅ **Fitur yang Berfungsi:**
- **Halaman Beranda**: `http://127.0.0.1:8000/` dengan section Berita Terbaru
- **Halaman Daftar Berita**: `http://127.0.0.1:8000/berita` dengan pagination yang fixed
- **Detail Berita**: `http://127.0.0.1:8000/berita/{id}`
- **Pencarian**: `http://127.0.0.1:8000/berita/search?q=keyword`
- **API Endpoints**: JSON response support

### 📊 **Database Statistics:**
- Total berita published: 959 berita aktif
- 80 halaman pagination (12 berita per halaman)
- Koneksi database `portal_kemenag` stable

### 🎨 **UI/UX Features:**
- ✅ Responsive grid layout
- ✅ Bootstrap pagination dengan custom styling
- ✅ Badge system (Headline/Utama/Berita)
- ✅ Image placeholder untuk berita tanpa gambar
- ✅ Hover effects dan transitions
- ✅ Search functionality dengan real-time

## Cara Penggunaan

1. Pastikan koneksi database portal_kemenag sudah terkonfigurasi di `.env`
2. Jalankan `php artisan serve` (default port 8000)
3. Akses `http://127.0.0.1:8000/` untuk melihat beranda dengan berita terbaru
4. Akses `http://127.0.0.1:8000/berita` untuk melihat semua berita
5. Klik pada berita untuk melihat detail
6. Gunakan search box untuk mencari berita
7. API endpoints dapat diakses dengan header `Accept: application/json`
