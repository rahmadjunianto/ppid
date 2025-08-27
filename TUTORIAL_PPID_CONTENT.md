# Tutorial: Membuat Konten Seperti PPID Jatim dengan CKEditor 5

## Overview
Sistem CMS dengan CKEditor 5 yang telah kita implementasikan **sangat bisa** membuat konten seperti halaman https://ppidjatim.kemenag.go.id/page/informasi-tersedia-setiap-saat

## Analisis Struktur Halaman PPID Jatim

### Komponen Utama:
1. **Judul Halaman**: "Informasi Tersedia Setiap Saat"
2. **Metadata**: Author, tanggal publikasi, jumlah pembaca
3. **Tabel Informasi**: Daftar nama informasi publik dengan link
4. **Formatting**: Table styling, links, typography

## Cara Membuat dengan CKEditor 5

### 1. **Akses Admin Panel**
```
URL: http://127.0.0.1:8000/admin/pages/create
Login: admin@ppid.com / admin123
```

### 2. **Fitur CKEditor 5 yang Digunakan**

#### **A. Tabel (Table)**
```html
<!-- Contoh tabel informasi publik -->
<table border="1" style="width: 100%; border-collapse: collapse;">
<thead>
<tr>
<th style="background-color: #f8f9fa; padding: 12px;">Nama Informasi Publik</th>
<th style="background-color: #f8f9fa; padding: 12px;">Aksi</th>
</tr>
</thead>
<tbody>
<tr>
<td style="padding: 10px;">Daftar Informasi Publik</td>
<td style="padding: 10px;"><a href="#">Lihat Detail</a></td>
</tr>
<!-- ... baris lainnya ... -->
</tbody>
</table>
```

**Cara membuat di CKEditor 5:**
1. Klik toolbar **"Insert Table"**
2. Pilih ukuran tabel (misalnya 2x5)
3. Isi header dan data
4. Gunakan **Table Tools** untuk styling

#### **B. Heading dan Typography**
```html
<h2>Informasi Tersedia Setiap Saat</h2>
<h3>Informasi Tambahan</h3>
```

**Cara membuat:**
1. Pilih **"Heading"** di toolbar
2. Pilih level heading (H1, H2, H3, etc.)

#### **C. Lists (Daftar)**
```html
<ul>
<li><strong>Program Moderasi Beragama</strong> - Dokumen panduan</li>
<li><strong>Layanan Disabilitas</strong> - Informasi layanan khusus</li>
</ul>
```

**Cara membuat:**
1. Klik **"Bulleted List"** atau **"Numbered List"**
2. Gunakan **Bold** untuk emphasis

#### **D. Links**
```html
<a href="/download/dokumen.pdf">Download PDF</a>
<a href="/page/detail-info">Lihat Detail</a>
```

**Cara membuat:**
1. Select text yang ingin dijadikan link
2. Klik **"Link"** di toolbar
3. Masukkan URL tujuan

#### **E. Blockquotes (Kutipan)**
```html
<blockquote>
<p><strong>Catatan:</strong> Semua informasi dapat diakses setiap saat.</p>
</blockquote>
```

**Cara membuat:**
1. Pilih text
2. Klik **"Block Quote"** di toolbar

## Template Konten PPID

### Template 1: Daftar Informasi Publik
```html
<h2>Informasi Tersedia Setiap Saat</h2>
<p>Berikut daftar informasi publik yang tersedia:</p>

<table border="1" style="width: 100%; border-collapse: collapse;">
<thead>
<tr>
<th style="background-color: #f8f9fa; padding: 12px;">Nama Informasi</th>
<th style="background-color: #f8f9fa; padding: 12px;">Keterangan</th>
<th style="background-color: #f8f9fa; padding: 12px;">Aksi</th>
</tr>
</thead>
<tbody>
<tr>
<td style="padding: 10px;">Daftar Informasi Publik</td>
<td style="padding: 10px;">Seluruh informasi yang dapat diakses publik</td>
<td style="padding: 10px;"><a href="#">Download</a></td>
</tr>
</tbody>
</table>
```

### Template 2: Layanan Informasi
```html
<h2>Layanan Informasi PPID</h2>

<h3>Layanan Online</h3>
<ul>
<li><strong>Permohonan Informasi</strong> - Ajukan permohonan informasi online</li>
<li><strong>Tracking Status</strong> - Lacak status permohonan Anda</li>
<li><strong>Download Dokumen</strong> - Unduh dokumen yang tersedia</li>
</ul>

<h3>Layanan Offline</h3>
<ol>
<li>Datang langsung ke kantor PPID</li>
<li>Isi formulir permohonan</li>
<li>Tunggu proses verifikasi</li>
<li>Terima informasi yang diminta</li>
</ol>
```

### Template 3: Regulasi dan Dokumen
```html
<h2>Daftar Regulasi</h2>

<blockquote>
<p><strong>Informasi:</strong> Dokumen dapat diunduh dalam format PDF.</p>
</blockquote>

<table border="1" style="width: 100%;">
<thead>
<tr>
<th>No.</th>
<th>Nama Regulasi</th>
<th>Tahun</th>
<th>Download</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik</td>
<td>2008</td>
<td><a href="#">PDF</a></td>
</tr>
</tbody>
</table>
```

## Langkah-langkah Praktis

### Step 1: Buat Halaman Baru
1. Login ke admin: `http://127.0.0.1:8000/login`
2. Goto: `http://127.0.0.1:8000/admin/pages/create`
3. Isi title: "Informasi Tersedia Setiap Saat"
4. Slug auto-generated: "informasi-tersedia-setiap-saat"

### Step 2: Gunakan CKEditor 5
1. **Heading**: Buat judul dengan H2
2. **Paragraph**: Tulis deskripsi singkat
3. **Table**: Insert tabel untuk daftar informasi
4. **Styling**: Gunakan inline styles untuk tabel
5. **Links**: Tambahkan link ke dokumen/halaman lain

### Step 3: Advanced Features

#### **Table Styling yang Cantik**
```css
/* Styling yang bisa ditambahkan via Source Editing */
<table style="
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
">
<thead>
<tr style="background: linear-gradient(135deg, #1e5631, #2d8f47);">
<th style="color: white; padding: 15px; text-align: left;">Nama Informasi</th>
<th style="color: white; padding: 15px; text-align: center;">Status</th>
</tr>
</thead>
<tbody>
<tr style="background-color: #f8f9fa;">
<td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Informasi A</td>
<td style="padding: 12px; text-align: center; border-bottom: 1px solid #dee2e6;">
    <span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Tersedia</span>
</td>
</tr>
</tbody>
</table>
```

#### **Call-to-Action Boxes**
```html
<div style="
    background: #e7f3ff;
    border: 1px solid #b8daff;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
">
<h4 style="color: #004085; margin-top: 0;">📋 Cara Mengajukan Permohonan</h4>
<ol>
<li>Isi formulir online di website</li>
<li>Upload dokumen pendukung</li>
<li>Tunggu konfirmasi dalam 3 hari kerja</li>
</ol>
<p><a href="/permohonan" style="
    background: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    text-decoration: none;
">Ajukan Sekarang</a></p>
</div>
```

## Tips dan Trik

### 1. **Source Editing untuk Advanced Styling**
- Gunakan **"Source Editing"** di toolbar untuk HTML custom
- Copy-paste template HTML yang sudah jadi
- Modifikasi sesuai kebutuhan

### 2. **Konsistensi Design**
- Gunakan color scheme yang sama: #1e5631 (hijau Kemenag)
- Padding dan margin yang konsisten
- Font weight untuk emphasis

### 3. **Responsive Table**
```html
<div style="overflow-x: auto;">
<table style="min-width: 600px; width: 100%;">
<!-- table content -->
</table>
</div>
```

### 4. **SEO Friendly**
- Isi Meta Title, Description, Keywords
- Gunakan heading structure yang benar (H1 → H2 → H3)
- Alt text untuk gambar

## Hasil Akhir

Dengan menggunakan CKEditor 5, Anda bisa membuat halaman yang **persis seperti PPID Jatim** dengan fitur:

✅ **Tabel informasi yang rapi dan responsive**
✅ **Typography yang konsisten dengan heading hierarchy**
✅ **Links ke dokumen dan halaman lain**
✅ **Blockquotes untuk catatan penting**
✅ **Lists untuk informasi terstruktur**
✅ **Custom styling via Source Editing**
✅ **SEO optimization dengan meta tags**

**CKEditor 5 memberikan fleksibilitas penuh untuk membuat konten PPID yang profesional dan user-friendly!** 🎉

## URL Testing
- **Create Page**: http://127.0.0.1:8000/admin/pages/create
- **Admin Dashboard**: http://127.0.0.1:8000/admin/pages
- **Test View**: http://127.0.0.1:8000/test-ckeditor-admin
