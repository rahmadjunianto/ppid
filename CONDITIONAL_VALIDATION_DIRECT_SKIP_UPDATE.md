# Update: Direct Skip dari Step 5 ke Step 8 (Eksternal Users)

## 📋 Perubahan

Untuk memberikan pengalaman terbaik bagi **eksternal users**, sistem sekarang melakukan **direct jump dari Step 5 langsung ke Step 8** tanpa perlu melihat Steps 6 & 7.

---

## 🔄 Navigation Flow Update

### SEBELUM (Old Flow)
```
Internal User:  5 → 6 → 7 → 8 → ...
Eksternal User: 5 → 6 (skip) → 7 (skip) → 8 → ...
                (masih harus lihat step 6 & 7 dengan info "skip")
```

### SESUDAH (New Flow - Optimized)
```
Internal User:  5 → 6 → 7 → 8 → ...
Eksternal User: 5 ────────────→ 8 → ...
                (langsung ke Jenis Pelayanan, tidak perlu lihat 6 & 7)
```

---

## 🛠️ Perubahan Teknis

### 1. Updated `nextStep()` Function

**Logika baru:**

```javascript
function nextStep() {
    if (currentStep < totalSteps - 1) {
        // SPECIAL CASE: From Step 5 (Kategori), check which path to take
        if (currentStep === 5) {
            if (dynamicFields[currentStep]) {
                if (!validateStep(currentStep)) {
                    return; // Validation gagal, tetap di step 5
                }
            }
            
            // Setelah validasi, check kategori selection
            if (!areOptionalFieldsRequired()) {
                // EKSTERNAL: Jump langsung ke Step 8
                // Skip Steps 6 & 7 sama sekali
                currentStep = 8;
            } else {
                // INTERNAL: Normal flow ke Step 6
                currentStep = 6;
            }
            
            showStep(currentStep);
        }
        // Logika untuk steps lainnya tetap sama...
    }
}
```

**Key Points:**
- ✅ Setelah kategori dipilih, validasi berjalan normal
- ✅ Jika eksternal: `currentStep = 8` (jump)
- ✅ Jika internal: `currentStep = 6` (normal)

---

### 2. Updated `previousStep()` Function

**Logika baru:**

```javascript
function previousStep() {
    if (currentStep > 0) {
        // Jika eksternal user klik back dari step 8,
        // kembali ke step 5 (kategori) karena 6 & 7 di-skip
        if (currentStep === 8 && !areOptionalFieldsRequired()) {
            currentStep = 5; // Kembali ke kategori
        } else {
            currentStep--; // Normal back navigation
        }
        
        showStep(currentStep);
    }
}
```

**Key Points:**
- ✅ Eksternal user dari step 8 → back to step 5
- ✅ Internal user dari step 8 → back to step 7 (normal)
- ✅ User dapat re-select kategori jika diperlukan

---

## 📊 Test Cases

### Test Case 1: Internal User (Normal Flow)

```
1. Start → Step 5
2. Pilih "Internal - Pegawai Kemenag"
3. Klik "Selanjutnya" 
   → nextStep() check currentStep === 5
   → areOptionalFieldsRequired() = true (internal)
   → currentStep = 6 ✅
   → showStep(6) - Step Unit Kerja tampil
4. Isi Unit Kerja
5. Klik "Selanjutnya" 
   → currentStep = 7 ✅
6. Klik "Selanjutnya"
   → currentStep = 8 ✅
```

### Test Case 2: Eksternal User (Direct Jump)

```
1. Start → Step 5
2. Pilih "Eksternal - Masyarakat Umum"
3. Klik "Selanjutnya"
   → nextStep() check currentStep === 5
   → areOptionalFieldsRequired() = false (eksternal)
   → currentStep = 8 ✅
   → showStep(8) - Step Jenis Pelayanan tampil LANGSUNG
   ✅ SKIP Steps 6 & 7 sama sekali
```

### Test Case 3: Eksternal User - Navigate Back

```
1. Eksternal user di Step 8 (Jenis Pelayanan)
2. Klik "Sebelumnya"
   → previousStep() check currentStep === 8 && eksternal
   → currentStep = 5 ✅
   → showStep(5) - Kembali ke Kategori
3. Dapat re-select kategori jika berubah pikiran
4. Klik "Selanjutnya"
   → Jump ke step 8 lagi ✅
```

### Test Case 4: Eksternal User - Change Mind (Internal)

```
1. Eksternal user di Step 8
2. Klik "Sebelumnya" → Back ke Step 5
3. Ubah pilihan ke "Internal - Pegawai Kemenag"
4. Klik "Selanjutnya"
   → nextStep() deteksi areOptionalFieldsRequired() = true (internal)
   → currentStep = 6 ✅
5. Sekarang mengisi Step 6 (Unit Kerja) & Step 7 (Jabatan)
```

---

## 🎯 User Experience Improvement

| Aspek | Sebelum | Sesudah | Benefit |
|-------|---------|---------|---------|
| Navigation | 5→6→7→8 | 5→8 | Faster, less clicks |
| Optional Fields | Terlihat (dengan "skip" info) | Hidden | Cleaner UI |
| Mental Model | "Saya bisa skip ini" | "Ini tidak perlu untuk saya" | Clear intent |
| Total Steps | 24 (sama untuk semua) | 24 (logically 22 untuk eksternal) | Better perceived experience |

---

## 🔐 Data Integrity

**Backend validation tetap sama:**

```php
// FormRequest tetap validasi conditional
if ($kategori === 'Internal - Pegawai Kemenag') {
    $rules['unit_kerja'] = 'required|string|max:255';
    $rules['jabatan'] = 'required|string|max:255';
} else {
    $rules['unit_kerja'] = 'nullable|string|max:255';
    $rules['jabatan'] = 'nullable|string|max:255';
}
```

**Database:**
- Internal users: `unit_kerja`, `jabatan` - FILLED
- Eksternal users: `unit_kerja`, `jabatan` - NULL (atau optional)

---

## 📝 Progress Bar Behavior

### Visual Progress untuk Eksternal User:
```
Step 5: Progress = 5/24 = 21%
Step 8: Progress = 8/24 = 33%

(Jump dari 21% ke 33%, skipping visual representation of steps 6-7)
```

### Progress Indicator Text:
- Step 5: "5 dari 24"
- Step 8 (eksternal): "8 dari 24" (tetap akurat)

**Note**: Progress bar tetap menampilkan absolute step count (24), meskipun eksternal users tidak melihat steps 6-7. Ini memastikan konsistensi dan akurasi data.

---

## ✅ Implementation Summary

**Files Updated:**
- ✅ `resources/views/survey/skm-spak/index.blade.php`
  - `nextStep()` function: Added Step 5 special case logic
  - `previousStep()` function: Added eksternal back-navigation logic

**Key Changes:**
1. From Step 5, check kategori selection
2. Eksternal → Jump to Step 8 directly
3. Internal → Normal flow to Step 6
4. Eksternal back from Step 8 → Go to Step 5
5. Internal back from Step 8 → Go to Step 7

**No Breaking Changes:**
- ✅ Internal users workflow unchanged
- ✅ Backend validation unchanged
- ✅ Database schema unchanged
- ✅ All existing data remains valid

---

## 🚀 Result

**Eksternal users sekarang mendapatkan:**
- ✅ Faster navigation (skip 2 unnecessary steps)
- ✅ Cleaner UI (tidak lihat optional field steps)
- ✅ Better clarity (langsung fokus pada Jenis Pelayanan)
- ✅ Same validation rigor (backend tetap strict)

---

**Update Date**: 24 April 2026
**Status**: ✅ Implemented & Ready
