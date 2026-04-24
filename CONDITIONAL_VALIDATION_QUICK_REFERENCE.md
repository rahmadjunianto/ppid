# Quick Reference: Conditional Validation Functions

## 🚀 Fungsi Utama untuk Validasi Kondisional

### 1. Get Selected Kategori
```javascript
/**
 * Mendapatkan nilai kategori responden yang dipilih
 * @returns {string|null} - "Internal - Pegawai Kemenag" atau "Eksternal - Masyarakat Umum"
 */
function getSelectedKategori() {
    const kategoriInput = document.querySelector('input[name="kategori_responden"]:checked');
    return kategoriInput ? kategoriInput.value : null;
}

// Usage
const kategori = getSelectedKategori();
console.log(kategori); // Output: "Internal - Pegawai Kemenag" atau null
```

---

### 2. Cek Apakah Fields Required
```javascript
/**
 * Menentukan apakah unit_kerja dan jabatan wajib berdasarkan kategori
 * @returns {boolean} - true jika Internal (required), false jika Eksternal (optional)
 */
function areOptionalFieldsRequired() {
    const kategori = getSelectedKategori();
    return kategori === 'Internal - Pegawai Kemenag';
}

// Usage
if (areOptionalFieldsRequired()) {
    console.log("Field wajib untuk internal user");
} else {
    console.log("Field optional untuk eksternal user");
}
```

---

### 3. Cek Apakah Step Bisa Di-Skip
```javascript
/**
 * Menentukan apakah step tertentu bisa dilewatkan
 * Step 6 (unit_kerja) dan step 7 (jabatan) bisa skip jika eksternal
 * @param {number} step - Nomor step (0-23)
 * @returns {boolean} - true jika bisa skip, false jika harus isi
 */
function canSkipStep(step) {
    const isOptionalFieldsRequired = areOptionalFieldsRequired();
    
    if ((step === 6 || step === 7) && !isOptionalFieldsRequired) {
        return true;
    }
    return false;
}

// Usage
if (canSkipStep(6)) {
    console.log("Step 6 (Unit Kerja) bisa dilewatkan");
} else {
    console.log("Step 6 (Unit Kerja) harus diisi");
}
```

---

### 4. Update UI Untuk Fields Optional
```javascript
/**
 * Update visual indicator untuk unit_kerja dan jabatan berdasarkan kategori
 * - Ubah badge dari "Wajib" ke "Opsional"
 * - Tampilkan/sembunyikan pesan info
 * - Set required attribute secara dinamis
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
        // INTERNAL - Fields wajib
        unitKerjaBadge.textContent = 'Wajib';
        unitKerjaBadge.className = 'badge bg-danger';
        jabatanBadge.textContent = 'Wajib';
        jabatanBadge.className = 'badge bg-danger';
        unitKerjaInfo.style.display = 'none';
        jabatanInfo.style.display = 'none';
        unitKerjaInput.required = true;
        jabatanInput.required = true;
    } else {
        // EKSTERNAL - Fields optional
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
    }
}

// Usage
updateOptionalFieldsUI(); // Call ini ketika kategori berubah
```

---

## 🔄 Flow Control

### Update Next Button Text
```javascript
/**
 * Update button "Selanjutnya" untuk menunjukkan "Lewati" ketika di optional step
 */
function updateNextButtonText() {
    const btnNext = document.getElementById('btnNext');
    
    if (canSkipStep(currentStep)) {
        btnNext.innerHTML = 'Lewati <i class="fas fa-forward ms-2"></i>';
    } else {
        btnNext.innerHTML = 'Selanjutnya <i class="fas fa-chevron-right ms-2"></i>';
    }
}
```

---

### Handle Next Step dengan Skip Logic
```javascript
/**
 * Navigasi ke step berikutnya dengan support untuk skip
 */
function nextStep() {
    if (currentStep < totalSteps - 1) {
        if (dynamicFields[currentStep]) {
            // Jika eksternal user pada optional field, skip tanpa validasi
            if (canSkipStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            } else if (!validateStep(currentStep)) {
                // Validasi normal untuk field yang wajib
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

## 🎯 Event Listeners

### Listen Untuk Perubahan Kategori
```javascript
/**
 * Update UI ketika user mengubah pilihan kategori
 */
document.querySelectorAll('input[name="kategori_responden"]').forEach(input => {
    input.addEventListener('change', function() {
        updateOptionalFieldsUI(); // Trigger update
    });
});
```

---

## 📦 Backend FormRequest - Conditional Rules

```php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveySkmSpakRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validasi rules dengan kondisional unit_kerja & jabatan
     */
    public function rules(): array
    {
        $rules = [
            'kategori_responden' => 'required|string|in:Internal - Pegawai Kemenag,Eksternal - Masyarakat Umum',
            'jenis_pelayanan' => 'required|string',
            // ... field lainnya ...
        ];

        // Validasi kondisional untuk unit_kerja dan jabatan
        $kategori = $this->input('kategori_responden');
        
        if ($kategori === 'Internal - Pegawai Kemenag') {
            $rules['unit_kerja'] = 'required|string|max:255';
            $rules['jabatan'] = 'required|string|max:255';
        } else {
            $rules['unit_kerja'] = 'nullable|string|max:255';
            $rules['jabatan'] = 'nullable|string|max:255';
        }

        return $rules;
    }

    /**
     * Custom pesan error
     */
    public function messages(): array
    {
        return [
            'unit_kerja.required' => 'Unit kerja harus diisi untuk kategori Internal - Pegawai Kemenag',
            'jabatan.required' => 'Jabatan harus diisi untuk kategori Internal - Pegawai Kemenag',
        ];
    }
}
```

---

## 🧪 Testing Checklist

### Test Case: Internal User

```javascript
// 1. Pilih "Internal - Pegawai Kemenag"
document.querySelector('input[value="Internal - Pegawai Kemenag"]').click();

// 2. Verify UI changes
console.assert(
    document.getElementById('unit_kerja_badge').textContent === 'Wajib',
    'Badge harus "Wajib"'
);

console.assert(
    document.getElementById('unit_kerja').required === true,
    'Field harus required'
);

// 3. Try skip - should fail
const isEmpty = document.getElementById('unit_kerja').value === '';
nextStep();
// → Should show error if empty
```

---

### Test Case: Eksternal User

```javascript
// 1. Pilih "Eksternal - Masyarakat Umum"
document.querySelector('input[value="Eksternal - Masyarakat Umum"]').click();

// 2. Verify UI changes
console.assert(
    document.getElementById('unit_kerja_badge').textContent === 'Opsional',
    'Badge harus "Opsional"'
);

console.assert(
    document.getElementById('unit_kerja').required === false,
    'Field harus NOT required'
);

console.assert(
    document.getElementById('unitKerjaStatusInfo').style.display !== 'none',
    'Info alert harus ditampilkan'
);

// 3. Try skip - should succeed
nextStep();
// → Should move to next step without validation
```

---

## 💾 Form Data Storage

### Database Column Definition
```sql
-- Kolom nullable untuk eksternal user
ALTER TABLE surveys_skm_spak
MODIFY unit_kerja VARCHAR(255) NULL,
MODIFY jabatan VARCHAR(255) NULL;
```

### Model Declaration
```php
protected $fillable = [
    // ... fields lainnya ...
    'unit_kerja',     // nullable untuk eksternal
    'jabatan',        // nullable untuk eksternal
];

protected $casts = [
    'unit_kerja' => 'string',
    'jabatan' => 'string',
];
```

---

## 📊 State Diagram

```
┌─────────────────────────────────────────┐
│  Step 5: Pilih Kategori Responden       │
└─────────────────┬───────────────────────┘
                  │
        ┌─────────┴──────────┐
        │                    │
        ▼                    ▼
┌──────────────┐      ┌──────────────┐
│   INTERNAL   │      │  EKSTERNAL   │
│ - Pegawai    │      │ - Masyarakat │
│   Kemenag    │      │   Umum       │
└──┬───────────┘      └────┬─────────┘
   │                       │
   ▼                       ▼
Step 6: Unit Kerja    Step 6: Unit Kerja
├─ Badge: Wajib       ├─ Badge: Opsional
├─ Required: true     ├─ Required: false
├─ Alert: hidden      ├─ Alert: shown
└─ Btn: Selanjutnya   └─ Btn: Lewati

   │                       │
   ├──────► Isi ◄──────────┤
   │                       │
   ▼                   ▼
Step 7: Jabatan    [Skip]
├─ Badge: Wajib        │
├─ Required: true      │
└─ Alert: hidden       │
                       │
   │                   │
   └───► Isi ◄─────────┤
                       │
        ▼              ▼
    Step 8: Jenis Pelayanan
```

---

## 🎓 Pembelajaran Kunci

1. **Conditional Validation**: Menggunakan nilai input lain untuk menentukan validation rules
2. **Dynamic UI**: Mengubah tampilan berdasarkan state aplikasi (kategori dipilih)
3. **User Experience**: Memberikan clear indication kepada user tentang field yang optional
4. **Data Integrity**: Validasi di client dan server untuk memastikan data consistency
5. **Accessibility**: Alert dan badge membantu user memahami requirement dengan jelas

---

**Dokumentasi ini dibuat**: 24 April 2026
**Versi**: 1.0 - Production Ready
