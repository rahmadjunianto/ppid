# 📖 Step-by-Step Integration Guide

Panduan lengkap untuk memahami dan mengintegrasikan sistem validasi kondisional ke form wizard survey SKM & SPAK.

---

## 📋 Prerequisites

Sebelum memulai, pastikan Anda sudah memiliki:

- ✅ Laravel 8+ (framework)
- ✅ PHP 7.x+ (untuk production)
- ✅ Form wizard SKM & SPAK yang sudah ada
- ✅ Bootstrap 5 (untuk styling)
- ✅ Database migration dengan kolom `unit_kerja` dan `jabatan` yang nullable

---

## 🚀 Step 1: Update Database Schema

### Jika belum ada kolom nullable untuk unit_kerja dan jabatan:

**File**: `database/migrations/2026_04_23_100000_create_surveys_skm_spak_table.php`

```php
Schema::create('surveys_skm_spak', function (Blueprint $table) {
    $table->id();
    
    // ... fields lainnya ...
    
    // UBAH INI dari required menjadi nullable
    $table->string('unit_kerja')->nullable(); // Bisa NULL untuk eksternal
    $table->string('jabatan')->nullable();    // Bisa NULL untuk eksternal
    
    // ... fields lainnya ...
    
    $table->timestamps();
});
```

### Jika sudah ada kolom (existing table):

```php
// Create migration untuk modify column
php artisan make:migration modify_surveys_skm_spak_to_nullable

// Dalam migration file:
public function up()
{
    Schema::table('surveys_skm_spak', function (Blueprint $table) {
        $table->string('unit_kerja')->nullable()->change();
        $table->string('jabatan')->nullable()->change();
    });
}

// Run migration
php artisan migrate
```

---

## 🎨 Step 2: Update Form View - Step Kategori

**File**: `resources/views/survey/skm-spak/index.blade.php`

### Cari Step 5 (Kategori Responden) dan verifikasi struktur:

```html
<!-- Step 5: Kategori Responden -->
<div class="form-tab" data-step="5">
    <div class="tab-title">
        <i class="fas fa-user-tag"></i> Kategori Responden
    </div>
    <div class="form-group-skm">
        <label class="form-label">Kategori <span class="badge bg-danger">Wajib</span></label>
        <div class="radio-group">
            <div class="radio-option">
                <input type="radio" id="kat1" name="kategori_responden" 
                       value="Internal - Pegawai Kemenag" required>
                <label for="kat1">Internal - Pegawai Kemenag</label>
            </div>
            <div class="radio-option">
                <input type="radio" id="kat2" name="kategori_responden" 
                       value="Eksternal - Masyarakat Umum">
                <label for="kat2">Eksternal - Masyarakat Umum</label>
            </div>
        </div>
        <div class="error-message" id="err_kategori_responden"></div>
    </div>
</div>
```

---

## 📝 Step 3: Update Form View - Step Unit Kerja

**File**: `resources/views/survey/skm-spak/index.blade.php`

### Ganti Step 6 (Unit Kerja) dengan versi yang conditional:

```html
<!-- Step 6: Unit Kerja -->
<div class="form-tab" data-step="6">
    <div class="tab-title">
        <i class="fas fa-building"></i> Unit Kerja
    </div>
    
    <!-- Alert dipilih untuk Eksternal users -->
    <div id="unitKerjaStatusInfo" class="alert alert-info" style="display: none;">
        <i class="fas fa-info-circle me-2"></i>
        <span id="unitKerjaInfoText"></span>
    </div>
    
    <div class="form-group-skm">
        <!-- Label dengan Badge Dinamis -->
        <label for="unit_kerja" class="form-label">
            Unit Kerja 
            <span id="unit_kerja_badge" class="badge bg-danger">Wajib</span>
        </label>
        
        <!-- Input field -->
        <input type="text" class="form-control" id="unit_kerja" 
               name="unit_kerja" placeholder="Contoh: MAN 1 Nganjuk" 
               value="{{ old('unit_kerja') }}" required>
        
        <!-- Error message -->
        <div class="error-message" id="err_unit_kerja"></div>
    </div>
</div>
```

---

## 📝 Step 4: Update Form View - Step Jabatan

**File**: `resources/views/survey/skm-spak/index.blade.php`

### Ganti Step 7 (Jabatan) dengan versi yang conditional:

```html
<!-- Step 7: Jabatan -->
<div class="form-tab" data-step="7">
    <div class="tab-title">
        <i class="fas fa-id-badge"></i> Jabatan
    </div>
    
    <!-- Alert untuk eksternal users -->
    <div id="jabatanStatusInfo" class="alert alert-info" style="display: none;">
        <i class="fas fa-info-circle me-2"></i>
        <span id="jabatanInfoText"></span>
    </div>
    
    <div class="form-group-skm">
        <!-- Label dengan Badge Dinamis -->
        <label for="jabatan" class="form-label">
            Jabatan 
            <span id="jabatan_badge" class="badge bg-danger">Wajib</span>
        </label>
        
        <!-- Input field -->
        <input type="text" class="form-control" id="jabatan" 
               name="jabatan" placeholder="Contoh: Penyuluh" 
               value="{{ old('jabatan') }}" required>
        
        <!-- Error message -->
        <div class="error-message" id="err_jabatan"></div>
    </div>
</div>
```

---

## 🔧 Step 5: Tambahkan JavaScript Functions

**File**: `resources/views/survey/skm-spak/index.blade.php` (dalam tag `<script>`)

### Tambahkan ke atas section JavaScript (sebelum `dynamicFields` object):

```javascript
/**
 * HELPER FUNCTIONS UNTUK CONDITIONAL VALIDATION
 */

/**
 * Get the currently selected kategori responden
 */
function getSelectedKategori() {
    const kategoriInput = document.querySelector('input[name="kategori_responden"]:checked');
    return kategoriInput ? kategoriInput.value : null;
}

/**
 * Determine if unit_kerja and jabatan are required based on kategori
 * True = Internal (required) | False = Eksternal (optional)
 */
function areOptionalFieldsRequired() {
    const kategori = getSelectedKategori();
    return kategori === 'Internal - Pegawai Kemenag';
}

/**
 * Check if current step can be skipped
 */
function canSkipStep(step) {
    const isOptionalFieldsRequired = areOptionalFieldsRequired();
    
    // Step 6 (unit_kerja) and step 7 (jabatan) can be skipped if eksternal
    if ((step === 6 || step === 7) && !isOptionalFieldsRequired) {
        return true;
    }
    return false;
}

/**
 * Update visual indicators for unit_kerja and jabatan fields
 */
function updateOptionalFieldsUI() {
    const isRequired = areOptionalFieldsRequired();
    const unitKerjaBadge = document.getElementById('unit_kerja_badge');
    const jabatanBadge = document.getElementById('jabatan_badge');
    const unitKerjaInfo = document.getElementById('unitKerjaStatusInfo');
    const jabatanInfo = document.getElementById('jabatanStatusInfo');
    const unitKerjaInput = document.getElementById('unit_kerja');
    const jabatanInput = document.getElementById('jabatan');

    if (isRequired) {
        // Internal - fields wajib
        unitKerjaBadge.textContent = 'Wajib';
        unitKerjaBadge.className = 'badge bg-danger';
        jabatanBadge.textContent = 'Wajib';
        jabatanBadge.className = 'badge bg-danger';
        unitKerjaInfo.style.display = 'none';
        jabatanInfo.style.display = 'none';
        unitKerjaInput.required = true;
        jabatanInput.required = true;
        unitKerjaInput.classList.remove('is-invalid');
        jabatanInput.classList.remove('is-invalid');
    } else {
        // Eksternal - fields optional
        unitKerjaBadge.textContent = 'Opsional';
        unitKerjaBadge.className = 'badge bg-secondary';
        jabatanBadge.textContent = 'Opsional';
        jabatanBadge.className = 'badge bg-secondary';
        unitKerjaInfo.style.display = 'block';
        jabatanInfo.style.display = 'block';
        document.getElementById('unitKerjaInfoText').textContent = 
            'Field ini bersifat opsional untuk kategori eksternal. Anda dapat melewati step ini.';
        document.getElementById('jabatanInfoText').textContent = 
            'Field ini bersifat opsional untuk kategori eksternal. Anda dapat melewati step ini.';
        unitKerjaInput.required = false;
        jabatanInput.required = false;
        unitKerjaInput.classList.remove('is-invalid');
        jabatanInput.classList.remove('is-invalid');
    }
}
```

---

## 🔄 Step 6: Update JavaScript nextStep Function

**File**: `resources/views/survey/skm-spak/index.blade.php`

### Ganti seluruh function `nextStep()`:

```javascript
function nextStep() {
    if (currentStep < totalSteps - 1) {
        // Check if current step requires validation
        if (dynamicFields[currentStep]) {
            // If eksternal user on optional fields step, allow skip without validation
            if (canSkipStep(currentStep)) {
                // Just move to next step without validation
                currentStep++;
                showStep(currentStep);
            } else if (!validateStep(currentStep)) {
                // Otherwise validate normally
                return;
            } else {
                currentStep++;
                showStep(currentStep);
            }
        } else {
            currentStep++;
            showStep(currentStep);
        }
    }
}
```

---

## 🎨 Step 7: Update JavaScript showStep Function

**File**: `resources/views/survey/skm-spak/index.blade.php`

### Tambahkan logic untuk update UI ketika step ditampilkan:

```javascript
function showStep(step) {
    // Hide all tabs
    document.querySelectorAll('.form-tab').forEach(tab => {
        tab.classList.remove('active');
    });

    // Show current tab
    document.querySelectorAll('.form-tab')[step].classList.add('active');

    // 🔥 TAMBAHAN: Update UI untuk optional fields jika di step 5, 6, atau 7
    if (step === 5 || step === 6 || step === 7) {
        updateOptionalFieldsUI();
    }

    // Update progress bar
    updateProgress();

    // Update buttons
    updateButtons();

    // Update step indicator
    document.getElementById('currentStep').textContent = step;
    document.getElementById('totalSteps').textContent = totalSteps;
}
```

---

## 🔘 Step 8: Update JavaScript updateButtons Function

**File**: `resources/views/survey/skm-spak/index.blade.php`

### Ubah button text menjadi "Lewati" untuk optional steps:

```javascript
function updateButtons() {
    const btnPrevious = document.getElementById('btnPrevious');
    const btnNext = document.getElementById('btnNext');
    const btnFinish = document.getElementById('btnFinish');

    if (currentStep === 0) {
        btnPrevious.style.display = 'none';
        btnNext.style.display = 'block';
        btnNext.textContent = 'Mulai';
        btnFinish.style.display = 'none';
    } else if (currentStep === totalSteps - 1) {
        btnPrevious.style.display = 'block';
        btnNext.style.display = 'none';
        btnFinish.style.display = 'block';
    } else {
        btnPrevious.style.display = 'block';
        btnNext.style.display = 'block';
        
        // 🔥 TAMBAHAN: Update button text untuk skip
        if (canSkipStep(currentStep)) {
            btnNext.innerHTML = 'Lewati <i class="fas fa-forward ms-2"></i>';
        } else {
            btnNext.innerHTML = 'Selanjutnya <i class="fas fa-chevron-right ms-2"></i>';
        }
        
        btnFinish.style.display = 'none';
    }
}
```

---

## 📌 Step 9: Add Event Listener untuk Kategori Change

**File**: `resources/views/survey/skm-spak/index.blade.php`

### Tambahkan sebelum `// Initialize`:

```javascript
// Listen untuk kategori responden changes dan update UI
document.querySelectorAll('input[name="kategori_responden"]').forEach(input => {
    input.addEventListener('change', function() {
        updateOptionalFieldsUI();
    });
});
```

---

## 🔐 Step 10: Update Backend FormRequest

**File**: `app/Http/Requests/StoreSurveySkmSpakRequest.php`

### Update method `rules()`:

```php
public function rules(): array
{
    $rules = [
        // Demographic Data - tetap sama
        'jenis_kelamin' => 'required|string|in:Laki - Laki,Perempuan',
        'usia' => 'required|string|in:Kurang dari 20 Tahun,21 - 30 Tahun,31 - 40 Tahun,41 - 50 Tahun,51 - 60 Tahun,Lebih dari 61 Tahun',
        'pendidikan_terakhir' => 'required|string',
        'pekerjaan' => 'required|string',
        'kategori_responden' => 'required|string|in:Internal - Pegawai Kemenag,Eksternal - Masyarakat Umum',
        'jenis_pelayanan' => 'required|string',

        // SKM & SPAK Unsur - tetap sama
        'u1_persyaratan' => 'required|integer|between:1,4',
        'u2_prosedur' => 'required|integer|between:1,4',
        'u3_waktu_pelayanan' => 'required|integer|between:1,4',
        'u4_biaya_tarif' => 'required|integer|between:1,4',
        'u5_hasil_pelayanan' => 'required|integer|between:1,4',
        'u6_kompetensi_petugas' => 'required|integer|between:1,4',
        'u7_perilaku_petugas' => 'required|integer|between:1,4',
        'u8_pengaduan' => 'required|integer|between:1,4',
        'u9_sarana_prasarana' => 'required|integer|between:1,4',

        // SPAK Unsur - tetap sama
        'i1_tidak_diskriminatif' => 'required|integer|between:1,4',
        'i2_tidak_curang' => 'required|integer|between:1,4',
        'i3_tidak_imbalan' => 'required|integer|between:1,4',
        'i4_tidak_percaloan' => 'required|integer|between:1,4',
        'i5_tidak_pungli' => 'required|integer|between:1,4',

        // Feedback - tetap sama
        'kritik_saran' => 'nullable|string|max:1000',
    ];

    // 🔥 TAMBAHAN: Validasi kondisional untuk unit_kerja dan jabatan
    $kategori = $this->input('kategori_responden');
    
    if ($kategori === 'Internal - Pegawai Kemenag') {
        // INTERNAL - Wajib diisi
        $rules['unit_kerja'] = 'required|string|max:255';
        $rules['jabatan'] = 'required|string|max:255';
    } else {
        // EKSTERNAL - Optional (nullable)
        $rules['unit_kerja'] = 'nullable|string|max:255';
        $rules['jabatan'] = 'nullable|string|max:255';
    }

    return $rules;
}
```

---

## 📬 Step 11: Update Custom Messages

**File**: `app/Http/Requests/StoreSurveySkmSpakRequest.php`

### Update method `messages()`:

```php
public function messages(): array
{
    return [
        // ... pesan lain tetap sama ...

        // 🔥 UBAH INI
        'unit_kerja.required' => 'Unit kerja harus diisi untuk kategori Internal - Pegawai Kemenag',
        'unit_kerja.max' => 'Unit kerja maksimal 255 karakter',

        'jabatan.required' => 'Jabatan harus diisi untuk kategori Internal - Pegawai Kemenag',
        'jabatan.max' => 'Jabatan maksimal 255 karakter',

        // ... pesan lain tetap sama ...
    ];
}
```

---

## ✅ Step 12: Test Implementation

### Test di Browser:

```
1. Buka form survey (http://localhost/survey/skm-spak)
2. Lanjutkan ke Step 5 (Kategori Responden)
3. TEST CASE A: Pilih "Internal - Pegawai Kemenag"
   ✅ Step 6: Badge "Wajib" merah, alert tersembunyi
   ✅ Kosongkan unit_kerja → error muncul
   ✅ Isi unit_kerja & jabatan → lanjut ke step berikutnya
4. TEST CASE B: Pilih "Eksternal - Masyarakat Umum"
   ✅ Step 6: Badge "Opsional" abu-abu, alert ditampilkan
   ✅ Tombol berubah ke "Lewati"
   ✅ Klik "Lewati" → skip ke step 8
5. TEST POST SUBMIT:
   ✅ Internal: Verifikasi bahwa unit_kerja dan jabatan terisi di database
   ✅ Eksternal (skip): Verifikasi bahwa unit_kerja dan jabatan NULL di database
   ✅ Eksternal (isi): Verifikasi bahwa unit_kerja dan jabatan terisi di database
```

---

## 🐛 Troubleshooting

### Problem: Fields tidak berubah ketika kategori dipilih

**Solution**:
```javascript
// Pastikan event listener sudah ditambahkan
document.querySelectorAll('input[name="kategori_responden"]').forEach(input => {
    input.addEventListener('change', function() {
        updateOptionalFieldsUI();
    });
});

// Test di console
getSelectedKategori() // Should return kategori value
```

### Problem: Skip button tidak berfungsi

**Solution**:
```javascript
// Check apakah canSkipStep() mengembalikan true
console.log('canSkipStep(6):', canSkipStep(6));
console.log('getSelectedKategori():', getSelectedKategori());
```

### Problem: Backend validation error

**Solution**:
```php
// Check apakah rules() method sudah diupdate
// Di Tinker atau DumpDie:
$request = new StoreSurveySkmSpakRequest([
    'kategori_responden' => 'Eksternal - Masyarakat Umum'
]);
dd($request->rules()); // Should show unit_kerja nullable

```

---

## 📊 Verification Checklist

- [ ] Database migration sudah run (unit_kerja & jabatan nullable)
- [ ] Form HTML sudah update (Step 6 & 7 dengan conditional elements)
- [ ] JavaScript functions sudah ditambahkan (getSelectedKategori, areOptionalFieldsRequired, dll)
- [ ] nextStep() sudah update dengan canSkipStep logic
- [ ] showStep() sudah update dengan updateOptionalFieldsUI call
- [ ] updateButtons() sudah update dengan conditional button text
- [ ] Event listener untuk kategori change sudah ditambahkan
- [ ] FormRequest rules() sudah update dengan conditional validation
- [ ] FormRequest messages() sudah update
- [ ] Test case sudah dijalankan dan passed

---

## 🎓 Kesimpulan

Dengan mengikuti 12 langkah di atas, Anda telah berhasil mengimplementasikan:

✅ Frontend conditional validation dengan JavaScript
✅ Dynamic UI indicators (badge, alert, button text)
✅ Skip functionality untuk eksternal users
✅ Backend conditional validation dengan Laravel FormRequest
✅ Proper error messages
✅ Clean code structure yang maintainable

---

**Dibuat**: 24 April 2026
**Versi**: 1.0 - Complete Integration Guide
