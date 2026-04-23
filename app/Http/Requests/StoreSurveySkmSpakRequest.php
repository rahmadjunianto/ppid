<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveySkmSpakRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Demographic Data
            'jenis_kelamin' => 'required|string|in:Laki - Laki,Perempuan',
            'usia' => 'required|string|in:Kurang dari 20 Tahun,21 - 30 Tahun,31 - 40 Tahun,41 - 50 Tahun,51 - 60 Tahun,Lebih dari 61 Tahun',
            'pendidikan_terakhir' => 'required|string',
            'pekerjaan' => 'required|string',
            'kategori_responden' => 'required|string|in:Internal - Pegawai Kemenag,Eksternal - Masyarakat Umum',
            'unit_kerja' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'jenis_pelayanan' => 'required|string',

            // SKM Unsur (scale 1-4)
            'u1_persyaratan' => 'required|integer|between:1,4',
            'u2_prosedur' => 'required|integer|between:1,4',
            'u3_waktu_pelayanan' => 'required|integer|between:1,4',
            'u4_biaya_tarif' => 'required|integer|between:1,4',
            'u5_hasil_pelayanan' => 'required|integer|between:1,4',
            'u6_kompetensi_petugas' => 'required|integer|between:1,4',
            'u7_perilaku_petugas' => 'required|integer|between:1,4',
            'u8_pengaduan' => 'required|integer|between:1,4',
            'u9_sarana_prasarana' => 'required|integer|between:1,4',

            // SPAK Unsur (scale 1-4)
            'i1_tidak_diskriminatif' => 'required|integer|between:1,4',
            'i2_tidak_curang' => 'required|integer|between:1,4',
            'i3_tidak_imbalan' => 'required|integer|between:1,4',
            'i4_tidak_percaloan' => 'required|integer|between:1,4',
            'i5_tidak_pungli' => 'required|integer|between:1,4',

            // Feedback
            'kritik_saran' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid',

            'usia.required' => 'Usia harus dipilih',
            'usia.in' => 'Pilihan usia tidak valid',

            'pendidikan_terakhir.required' => 'Pendidikan terakhir harus dipilih',

            'pekerjaan.required' => 'Pekerjaan harus dipilih',

            'kategori_responden.required' => 'Kategori responden harus dipilih',
            'kategori_responden.in' => 'Kategori responden tidak valid',

            'unit_kerja.required' => 'Unit kerja harus diisi',
            'unit_kerja.max' => 'Unit kerja maksimal 255 karakter',

            'jabatan.required' => 'Jabatan harus diisi',
            'jabatan.max' => 'Jabatan maksimal 255 karakter',

            'jenis_pelayanan.required' => 'Jenis pelayanan harus dipilih',

            // SKM messages
            'u1_persyaratan.required' => 'Pertanyaan 1 harus dijawab',
            'u1_persyaratan.between' => 'Jawaban harus antara 1-4',
            'u2_prosedur.required' => 'Pertanyaan 2 harus dijawab',
            'u2_prosedur.between' => 'Jawaban harus antara 1-4',
            'u3_waktu_pelayanan.required' => 'Pertanyaan 3 harus dijawab',
            'u3_waktu_pelayanan.between' => 'Jawaban harus antara 1-4',
            'u4_biaya_tarif.required' => 'Pertanyaan 4 harus dijawab',
            'u4_biaya_tarif.between' => 'Jawaban harus antara 1-4',
            'u5_hasil_pelayanan.required' => 'Pertanyaan 5 harus dijawab',
            'u5_hasil_pelayanan.between' => 'Jawaban harus antara 1-4',
            'u6_kompetensi_petugas.required' => 'Pertanyaan 6 harus dijawab',
            'u6_kompetensi_petugas.between' => 'Jawaban harus antara 1-4',
            'u7_perilaku_petugas.required' => 'Pertanyaan 7 harus dijawab',
            'u7_perilaku_petugas.between' => 'Jawaban harus antara 1-4',
            'u8_pengaduan.required' => 'Pertanyaan 8 harus dijawab',
            'u8_pengaduan.between' => 'Jawaban harus antara 1-4',
            'u9_sarana_prasarana.required' => 'Pertanyaan 9 harus dijawab',
            'u9_sarana_prasarana.between' => 'Jawaban harus antara 1-4',

            // SPAK messages
            'i1_tidak_diskriminatif.required' => 'Pertanyaan 1 harus dijawab',
            'i1_tidak_diskriminatif.between' => 'Jawaban harus antara 1-4',
            'i2_tidak_curang.required' => 'Pertanyaan 2 harus dijawab',
            'i2_tidak_curang.between' => 'Jawaban harus antara 1-4',
            'i3_tidak_imbalan.required' => 'Pertanyaan 3 harus dijawab',
            'i3_tidak_imbalan.between' => 'Jawaban harus antara 1-4',
            'i4_tidak_percaloan.required' => 'Pertanyaan 4 harus dijawab',
            'i4_tidak_percaloan.between' => 'Jawaban harus antara 1-4',
            'i5_tidak_pungli.required' => 'Pertanyaan 5 harus dijawab',
            'i5_tidak_pungli.between' => 'Jawaban harus antara 1-4',

            'kritik_saran.max' => 'Kritik/Saran maksimal 1000 karakter',
        ];
    }
}
