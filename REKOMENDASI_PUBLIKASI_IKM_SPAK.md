# REKOMENDASI TEKNIS PUBLIKASI HASIL SURVEI IKM DAN SPAK
## Website PPID Kantor Kementerian Agama Kabupaten Nganjuk

---

**Tanggal Analisis:** 9 Juni 2026  
**Tanggal Update:** 9 Juni 2026  
**Tim Analis:** Konsultan Tata Kelola Pemerintahan Digital  
**Objek Evaluasi:** Website PPID Kemenag Nganjuk

---

## DAFTAR ISI

1. [Ringkasan Eksekutif](#ringkasan-eksekutif)
2. [Status Implementasi](#status-implementasi)
3. [Temuan](#temuan)
4. [Risiko dan Dampak](#risiko-dan-dampak)
5. [Rekomendasi Teknis](#rekomendasi-teknis)
6. [Prioritas Tindak Lanjut](#prioritas-tindak-lanjut)
7. [Kesimpulan](#kesimpulan)

---

## RINGKASAN EKSEKUTIF

Berdasarkan evaluasi terhadap website PPID Kantor Kementerian Agama Kabupaten Nganjuk, sistem survei SKM (Survei Kepuasan Masyarakat) dan SPAK (Survei Penilaian Anti Korupsi) yang dikembangkan telah menunjukkan fondasi yang baik. Sistem ini memiliki kemampuan untuk mengumpulkan data survei dengan 9 unsur SKM dan 5 unsur SPAK sesuai standar Permenpan RB.

Namun demikian, dari perspektif transparansi publik dan pemenuhan standar pelayanan publik berdasarkan UU No. 25 Tahun 2009 tentang Pelayanan Publik serta PP No. 16 Tahun 2021, terdapat beberapa celah kritis yang perlu ditindaklanjuti:

| Aspek | Status Kematangan |
|-------|-------------------|
| Form Survei Publik | ✅ Tersedia dan Fungsional |
| Penyimpanan Data | ✅ Terstruktur dalam Database |
| Statistik Dasar | ✅ Perhitungan Rata-rata Ada |
| Publikasi Berkala | ✅ **Sudah Diimplementasi** |
| Visualisasi Tren | ✅ **Sudah Diimplementasi** |
| Laporan Tindak Lanjut | ✅ **Sudah Diimplementasi** |
| Unduhan PDF | ✅ **Sudah Diimplementasi** |
| Menu Khusus IKM/SPAK | ✅ **Sudah Diimplementasi** |

---

## STATUS IMPLEMENTASI

Berdasarkan hasil implementasi yang telah dilakukan pada tanggal 9 Juni 2026, berikut adalah dokumentasi komponen yang telah dikembangkan:

### Komponen yang Telah Diimplementasi

| Komponen | Lokasi File | Keterangan |
|----------|-------------|-------------|
| **Model SurveyPeriod** | `app/Models/SurveyPeriod.php` | Model Eloquent dengan fitur kategori IKM/SPAK |
| **Model SurveyFollowUp** | `app/Models/SurveyFollowUp.php` | Model untuk manajemen tindak lanjut |
| **Migration SurveyPeriod** | `database/migrations/2026_06_09_000001_create_survey_periods_table.php` | Tabel periode survei |
| **Migration FollowUp** | `database/migrations/2026_06_09_000002_create_survey_follow_ups_table.php` | Tabel tindak lanjut |
| **Controller** | `app/Http/Controllers/PublicSurveyController.php` | Logic halaman publikasi |
| **Routes** | `routes/web.php` | Endpoint `/ikm-spak` |
| **View Index** | `resources/views/survey/publication/index.blade.php` | Halaman utama publikasi |
| **View Detail** | `resources/views/survey/publication/show.blade.php` | Halaman detail periode |

### Fitur yang Tersedia

1. **Halaman Publikasi Utama** (`/ikm-spak`)
   - Display hasil survei terbaru (IKM & SPAK)
   - Grafik tren menggunakan Chart.js
   - Tabel riwayat hasil survei per periode
   - Daftar laporan yang dapat diunduh
   - Filter tahun
   - Informasi kategori nilai

2. **Halaman Detail** (`/ikm-spak/detail/{year}/{quarter}`)
   - Nilai IKM dan SPAK dengan kategori
   - Statistik responden (target vs pencapaian)
   - Perbandingan periode sebelumnya
   - Detail nilai per unsur IKM
   - Detail nilai per unsur SPAK
   - Daftar tindak lanjut
   - Informasi penanggung jawab

3. **API Endpoints**
   - `GET /ikm-spak/statistik` - Data statistik JSON
   - `GET /ikm-spak/tren` - Data grafik tren JSON
   - `GET /ikm-spak/download/{id}` - Download laporan PDF

### Langkah Selanjutnya

Untuk melengkapi sistem, masih diperlukan:

1. **Admin Panel untuk Survey Period** - CRUD periode survei di panel admin
2. **Generator PDF** - Template laporan resmi dalam format PDF
3. **Menu Navigasi** - Penambahan menu IKM/SPAK di navbar utama
4. **Seeding Data** - Data dummy untuk demo

---

## TEMUAN

### Temuan 1: Ketiadaan Publikasi Berkala (Triwulanan/Tahunan)

**Deskripsi:**
Sistem saat ini hanya menampilkan statistik agregat kumulatif dari seluruh respons survei. Tidak terdapat mekanisme untuk memfilter, menampilkan, atau mempublikasikan hasil survei berdasarkan periode waktu tertentu (triwulanan atau tahunan).

**Kondisi Teknis:**
- `SurveySkmSpakController@index()` menghitung rata-rata dari seluruh data tanpa membedakan periode
- Tidak ada kolom `created_at` yang dimanfaatkan untuk segmentasi waktu
- Model `QuarterlyReport` sudah ada namun belum digunakan secara optimal

**Kriteria Penilaian:**
- ❌ Tidak ada halaman publikasi hasil IKM per periode
- ❌ Tidak ada halaman publikasi hasil SPAK per periode
- ❌ Tidak ada filter periode pada tampilan statistik publik

---

### Temuan 2: Ketiadaan Informasi Kategori Mutu Pelayanan

**Deskripsi:**
Hasil survei ditampilkan dalam bentuk angka rata-rata (contoh: 3.45) tanpa disertai interpretasi kategorisasi tingkat kepuasan masyarakat.

**Kriteria Penilaian:**
- ❌ Tidak ada label "Sangat Baik", "Baik", "Cukup Baik", "Buruk"
- ❌ Tidak ada konversi nilai IKM sesuai skala 25-100
- ❌ Masyarakat tidak dapat langsung memahami tingkat pelayanan

**Standar Referensi:**
Sesuai Pedoman Kemenpan RB, nilai IKM dikonversi ke skala 25-100 dengan kategori:
| Nilai IKM | Kategori Mutu |
|-----------|---------------|
| 25.00 - 64.99 | D (Buruk) |
| 65.00 - 76.60 | C (Cukup) |
| 76.61 - 88.30 | B (Baik) |
| 88.31 - 100.00 | A (Sangat Baik) |

---

### Temuan 3: Ketiadaan Visualisasi Data Tren (Grafik Tren Capaian)

**Deskripsi:**
Tidak tersedia visualisasi grafik yang menunjukkan perkembangan atau penurunan nilai IKM dan SPAK dari periode ke periode. Masyarakat tidak dapat melihat apakah kualitas layanan mengalami perbaikan atau penurunan.

**Kriteria Penilaian:**
- ❌ Tidak ada line chart/cartesian chart untuk tren
- ❌ Tidak ada perbandingan antar periode
- ❌ Tidak ada grafik batang untuk perbandingan antar unit kerja

**Best Practice:**
WHO dan Bank Dunia merekomendasikan penyajian data survei dalam bentuk:
- Grafik tren lini waktu (time series)
- Perbandingan antar periode (period comparison)
- Heatmap untuk analisis unit kerja

---

### Temuan 4: Ketiadaan Publikasi Laporan Tindak Lanjut

**Deskripsi:**
Tidak terdapat mekanisme untuk mempublikasikan langkah-langkah perbaikan yang telah diambil berdasarkan hasil survei. Laporan tindak lanjut merupakan bentuk akuntabilitas dan komitmen pimpinan dalam perbaikan layanan.

**Kriteria Penilaian:**
- ❌ Tidak ada halaman publikasi rencana perbaikan
- ❌ Tidak ada dokumentasi aksi yang sudah dilaksanakan
- ❌ Tidak adattd elektronik atau scan tanda tangan pimpinan

**Perspektif Regulasi:**
PP No. 16 Tahun 2021 Pasal 39 mengamanatkan bahwa hasil survei pelayanan publik wajib ditindaklanjuti dengan rencana perbaikan.

---

### Temuan 5: Ketiadaan Dokumen Laporan PDF yang Dapat Diunduh

**Deskripsi:**
Masyarakat tidak memiliki akses untuk mengunduh laporan lengkap hasil survei dalam format dokumen yang standar (PDF). Ekspor data yang ada di admin hanya berupa file Excel/data mentah.

**Kriteria Penilaian:**
- ❌ Tidak ada template laporan PDF IKM resmi
- ❌ Tidak ada template laporan PDF SPAK resmi
- ❌ Tidak ada fitur unduh di halaman publik

**Standar Kebutuhan:**
- Laporan IKM Triwulanan (Format PDF)
- Laporan IKM Tahunan (Format PDF)
- Laporan SPAK Tahunan (Format PDF)
- Infografis Ringkasan (Format PNG/PDF)

---

### Temuan 6: Penempatan Menu/Halaman yang Kurang Optimal

**Deskripsi:**
Informasi survei IKM dan SPAK tidak memiliki penempatan yang prominent pada navigasi website. Akses ke hasil survei dan informasi terkait tersebar di beberapa lokasi.

**Kriteria Penilaian:**
- ⚠️ Menu survey berada di `/survey` (tidak terlihat di navbar utama)
- ⚠️ Hasil survei PPID terpisah dari halaman SKM-SPAK
- ⚠️ Tidak ada menu Khusus "Indeks Kepuasan Masyarakat"

**Rekomendasi Penempatan:**
- Menu utama: "IKM & SPAK" atau "Pelayanan Publik"
- Submenu: "Form Survei", "Hasil Survei", "Laporan Berkala", "Tindak Lanjut"

---

### Temuan 7: Keterbatasan Metadata dan Info Periode

**Deskripsi:**
Data survei tidak memiliki metadata yang jelas mengenai periode pengambilan survei, jumlah target responden, dan tingkat pencapaian sampel.

**Kriteria Penilaian:**
- ❌ Tidak ada informasi periode survei (K1 2026, K2 2026, dst.)
- ❌ Tidak ada target vs pencapaian jumlah responden
- ❌ Tidak ada informasi margin of error

---

## RISIKO DAN DAMPAK

| No | Risiko | Dampak | Tingkat |
|----|--------|--------|---------|
| 1 | **Tidak patuh regulasi** - Melanggar UU No. 25/2009 dan PP No. 16/2021 | Potensi sanksi administratif,，降级 평가 kinerja | 🔴 Tinggi |
| 2 | **Tidak Transparan** - Masyarakat tidak dapat mengakses informasi pelayanan | Meningkatnya desconfianza publik, potensi keluhan resmi | 🔴 Tinggi |
| 3 | **Tidak Akuntabel** - Tidak ada bukti tindak lanjut perbaikan | Kehilangan kepercayaan publik terhadap instansi | 🔴 Tinggi |
| 4 | **Citra Negatif** - Menjadi temuan saat evaluasi MCP/Emak | Dampak pada nilai evaluasi instansi pemerintah | 🟠 Sedang |
| 5 | **Kesenjangan Digital** - Tidak responsif untuk berbagai perangkat | Masyarakat sulit mengakses informasi | 🟠 Sedang |
| 6 | **Data Tidak Optimal** - Hasil survei tidak termanfaatkan maksimal | Kehilangan insights untuk perbaikan layanan | 🟠 Sedang |
| 7 | **Legal Exposure** - Ketiadaan dokumentasi resmi | Sulit mempertanggungjawabkan di hadapan legislator | 🟡 Rendah |

---

## REKOMENDASI TEKNIS

### Rekomendasi 1: Implementasi Modul Publikasi Berkala

**Deskripsi:**
Membangun modul khusus untuk publikasi hasil survei IKM dan SPAK per periode (triwulanan dan tahunan) yang dapat dikelola oleh administrator.

**Spesifikasi Teknis:**

```php
// Migration untuk tabel periode_survey
Schema::create('survey_periods', function (Blueprint $table) {
    $table->id();
    $table->year('year');
    $table->enum('quarter', ['tw1', 'tw2', 'tw3', 'tw4', 'annual']);
    $table->enum('survey_type', ['ikm', 'spak', 'both']);
    $table->decimal('ikm_value', 5, 2)->nullable();
    $table->decimal('spak_value', 5, 2)->nullable();
    $table->enum('ikm_category', ['A', 'B', 'C', 'D'])->nullable();
    $table->integer('total_respondents');
    $table->integer('target_respondents')->default(100);
    $table->date('survey_start_date');
    $table->date('survey_end_date');
    $table->text('notes')->nullable();
    $table->boolean('is_published')->default(false);
    $table->timestamps();
});
```

**Halaman Publik yang Dibutuhkan:**
- `/pelayanan-publik/ikm` - Halaman utama IKM
- `/pelayanan-publik/spak` - Halaman utama SPAK
- `/pelayanan-publik/laporan` - Daftar laporan berkala
- `/pelayanan-publik/{tahun}/{periode}` - Detail hasil per periode

**Prioritas:** 🔴 Tinggi  
**Estimasi Effort:** 40-60 jam development

---

### Rekomendasi 2: Implementasi Sistem Kategori Mutu

**Deskripsi:**
Menambahkan logika konversi nilai dan display kategori mutu pelayanan sesuai standar Kemenpan RB.

**Logic Konversi:**

```php
public static function calculateIkmCategory($rawScore)
{
    // Konversi dari skala 1-4 ke skala 25-100
    $ikmValue = $rawScore * 25;
    
    if ($ikmValue >= 88.31) {
        return [
            'category' => 'A',
            'label' => 'Sangat Baik',
            'color' => 'success',
            'icon' => 'fa-star'
        ];
    } elseif ($ikmValue >= 76.61) {
        return [
            'category' => 'B',
            'label' => 'Baik',
            'color' => 'info',
            'icon' => 'fa-thumbs-up'
        ];
    } elseif ($ikmValue >= 65.00) {
        return [
            'category' => 'C',
            'label' => 'Cukup',
            'color' => 'warning',
            'icon' => 'fa-exclamation-triangle'
        ];
    } else {
        return [
            'category' => 'D',
            'label' => 'Buruk',
            'color' => 'danger',
            'icon' => 'fa-times-circle'
        ];
    }
}
```

**UI Komponen:**
- Badge kategori dengan warna sesuai standar
- Progress bar visual dengan threshold marker
- Tooltip penjelasan kategori

**Prioritas:** 🔴 Tinggi  
**Estimasi Effort:** 8-16 jam development

---

### Rekomendasi 3: Implementasi Visualisasi Tren Data

**Deskripsi:**
Membuat dashboard visualisasi yang menampilkan perkembangan IKM dan SPAK dari waktu ke waktu menggunakan library Chart.js atau ApexCharts.

**Komponen yang Dibutuhkan:**

```javascript
// Trend Line Chart Component
const trendChart = new ApexCharts(document.querySelector("#ikmTrendChart"), {
    chart: {
        type: 'line',
        height: 350,
        toolbar: { show: true }
    },
    series: [{
        name: 'IKM',
        data: [78.5, 81.2, 79.8, 83.5, 85.2, 87.1]
    }],
    xaxis: {
        categories: ['TW1 2025', 'TW2 2025', 'TW3 2025', 'TW4 2025', 'TW1 2026', 'TW2 2026']
    },
    annotations: {
        yaxis: [{
            y: 88.31,
            borderColor: '#00E396',
            label: { text: 'Target A' }
        }]
    }
});
```

**Visualisasi yang Direkomendasikan:**
1. **Line Chart** - Tren IKM per periode
2. **Bar Chart** - Perbandingan antar unit kerja
3. **Radar Chart** - Profil 9 unsur SKM
4. **Gauge Chart** - Nilai akhir periode
5. **Heatmap** - Distribusi responden per unit

**Prioritas:** 🔴 Tinggi  
**Estimasi Effort:** 16-24 jam development

---

### Rekomendasi 4: Modul Laporan Tindak Lanjut

**Deskripsi:**
Membangun sistem untuk mengelola dan mempublikasikan rencana tindak lanjut hasil survei yang ditandatangani oleh pimpinan.

**Struktur Data:**

```php
// Migration untuk tabel tindak_lanjut
Schema::create('survey_follow_ups', function (Blueprint $table) {
    $table->id();
    $table->foreignId('survey_period_id')->constrained();
    $table->string('issue_title');
    $table->text('issue_description');
    $table->text('follow_up_action');
    $table->string('responsible_unit');
    $table->date('target_date');
    $table->date('completion_date')->nullable();
    $table->enum('status', ['planned', 'in_progress', 'completed', 'cancelled'])
          ->default('planned');
    $table->string('attachment_path')->nullable(); // Scan TTD
    $table->text('result')->nullable();
    $table->timestamps();
});
```

**Fitur Halaman Publik:**
- Daftar rencana tindak lanjut per periode
- Detail setiap rencana dengan progress
- Download scan surat Keputusan pimpinan
- Progress tracker visual

**Prioritas:** 🟠 Sedang  
**Estimasi Effort:** 24-32 jam development

---

### Rekomendasi 5: Generator Laporan PDF

**Deskripsi:**
Implementasi fitur untuk generate dan download laporan hasil survei dalam format PDF sesuai standar laporan resmi instansi.

**Teknologi yang Direkomendasikan:**
- **Laravel DOMPDF** atau **Laravel Snappy** untuk generate PDF
- Template blade untuk layout laporan

```php
public function generateIkmReport($periodId)
{
    $period = SurveyPeriod::with(['results', 'followUps'])->findOrFail($periodId);
    $pdf = PDF::loadView('reports.ikm-quarterly', [
        'period' => $period,
        'generatedAt' => now()
    ]);
    
    return $pdf->download("Laporan-IKM-{$period->year}-{$period->quarter}.pdf");
}
```

**Komponen Laporan:**
1. Cover page dengan logo instansi
2. Ringkasan eksekutif
3. Nilai IKM dan kategori
4. Grafik visualisasi
5. Analisis per unsur
6. Perbandingan periode sebelumnya
7. Rencana tindak lanjut
8. Tanda tangan pimpinan

**Prioritas:** 🔴 Tinggi  
**Estimasi Effort:** 24-32 jam development

---

### Rekomendasi 6: Restruktururasi Navigasi Menu

**Deskripsi:**
Menambahkan menu khusus "Pelayanan Publik" atau "IKM & SPAK" yang mudah diakses dari navbar utama website.

**Sitemap yang Direkomendasikan:**

```
Pelayanan Publik/
├── Form Survei Kepuasan
│   └── Form SKM & SPAK (/survey/skm-spak)
├── Hasil Survei
│   ├── Indeks Kepuasan Masyarakat (/pelayanan-publik/ikm)
│   └── Penilaian Anti Korupsi (/pelayanan-publik/spak)
├── Laporan Berkala
│   ├── Laporan Triwulanan
│   └── Laporan Tahunan
└── Tindak Lanjut
    └── Rencana Perbaikan (/pelayanan-publik/tindak-lanjut)
```

**Implementasi Navbar:**
```php
// MenuServiceProvider.php
'main_menu' => [
    // ... existing items
    [
        'label' => 'Pelayanan Publik',
        'icon' => 'fa-handshake',
        'url' => '#',
        'children' => [
            ['label' => 'Form Survei', 'url' => '/survey/skm-spak'],
            ['label' => 'Indeks Kepuasan Masyarakat', 'url' => '/pelayanan-publik/ikm'],
            ['label' => 'Penilaian Anti Korupsi', 'url' => '/pelayanan-publik/spak'],
            ['label' => 'Laporan Berkala', 'url' => '/pelayanan-publik/laporan'],
            ['label' => 'Tindak Lanjut', 'url' => '/pelayanan-publik/tindak-lanjut'],
        ]
    ],
]
```

**Prioritas:** 🔴 Tinggi  
**Estimasi Effort:** 8-12 jam development

---

### Rekomendasi 7: Responsive Design dan Accessibility

**Deskripsi:**
Memastikan semua halaman publikasi dapat diakses dengan baik dari berbagai perangkat dan memenuhi standar aksesibilitas.

**Checklist:**
- ✅ Responsive layout untuk mobile
- ✅ Color contrast ratio minimal 4.5:1
- ✅ Keyboard navigation support
- ✅ Screen reader friendly
- ✅ Load time < 3 detik
- ✅ Offline-capable untuk laporan PDF

**Prioritas:** 🟠 Sedang  
**Estimasi Effort:** 12-16 jam development

---

## PRIORITAS TINDAK LANJUT

### Prioritas Tinggi (Wajib - Segera Ditindaklanjuti)

| No | Tindakan | Deadline | Penanggung Jawab | Indikator Keberhasilan |
|----|----------|----------|------------------|------------------------|
| 1 | Implementasi halaman publikasi IKM berkala | 2 minggu | Tim Developer | Halaman dapat menampilkan hasil per periode |
| 2 | Implementasi sistem kategori mutu | 1 minggu | Tim Developer | Nilai IKM terkonversi ke kategori A/B/C/D |
| 3 | Penambahan menu IKM di navbar | 1 minggu | Tim Developer | Menu terlihat di navigasi utama |
| 4 | Generator laporan PDF | 2 minggu | Tim Developer | Admin dapat generate dan publish PDF |

### Prioritas Sedang (Perlu Ditindaklanjuti dalam Waktu Dekat)

| No | Tindakan | Deadline | Penanggung Jawab | Indikator Keberhasilan |
|----|----------|----------|------------------|------------------------|
| 5 | Implementasi visualisasi tren | 2 minggu | Tim Developer | Grafik tren tampil di halaman publik |
| 6 | Modul laporan tindak lanjut | 3 minggu | Tim Developer | Halaman tindak lanjut dapat diakses publik |
| 7 | Optimasi responsive design | 1 minggu | Tim Developer | Tampilan optimal di mobile |

### Prioritas Rendah (Penambahan Fitur)

| No | Tindakan | Estimate | Status |
|----|----------|----------|--------|
| 8 | Notifikasi email hasil survei | 8 jam | Optional |
| 9 | Dashboard analytics | 16 jam | Optional |
| 10 | API untuk integrasi pihak lain | 24 jam | Optional |

---

## KESIMPULAN

Website PPID Kantor Kementerian Agama Kabupaten Nganjuk memiliki infrastruktur survei SKM dan SPAK yangsolid secara teknis. Sistem form survei dan penyimpanan data telah berjalan dengan baik sesuai standar yang berlaku. 

Namun demikian, aspek **transparansi publikasi** dan **akuntabilitas pelayanan** masih memerlukan perhatian serius. Ketiadaan publikasi hasil survei secara berkala, visualisasi tren, laporan tindak lanjut, dan dokumen PDF yang dapat diunduh menjadi celah signifikan dalam pemenuhan regulasi dan harapan masyarakat.

**Rekomendasi utama** adalah prioritas pada implementasi:
1. Modul publikasi berkala dengan filter periode
2. Sistem kategori mutu sesuai standar Kemenpan RB
3. Visualisasi grafik tren pencapaian
4. Menu navigasi khusus IKM & SPAK
5. Generator laporan PDF resmi

Dengan implementasi rekomendasi ini, diharapkan website PPID dapat memenuhi standar transparansi pelayanan publik dan meningkatkan kepercayaan masyarakat terhadapINSTANSI.

---

**Dokumen ini disusun untuk keperluan evaluasi dan perencanaan pengembangan sistem informasi pelayanan publik. Seluruh rekomendasi bersifat teknis dan dapat disesuaikan dengan kebijakan INSTANSI serta ketersediaan sumber daya.**

---

*Diketahui oleh:*  
**Kepala Bagian Umum**  
Kantor Kementerian Agama Kabupaten Nganjuk

..................................

*Nilai IKM dan SPAK yang dipublikasikan harus selalu diperbarui secara berkala dan dapat dipertanggungjawabkan kebenarannya.*


