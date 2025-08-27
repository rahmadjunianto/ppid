<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Survey;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sampleSurveys = [
            [
                'nama' => 'Ahmad Santoso',
                'umur' => 45,
                'jenis_kelamin' => 'Laki-laki',
                'no_hp' => '081244567890',
                'pendidikan' => 'S1',
                'pekerjaan' => 'PNS',
                'kemudahan_akses_informasi' => 4,
                'kualitas_informasi' => 4,
                'kemudahan_permintaan' => 4,
                'ketepatan_waktu_jawab' => 4,
                'kelengkapan_informasi' => 4,
                'ketepatan_tanggap' => 4,
                'pelayanan_petugas' => 4,
                'saran_masukan' => 'Pelayanan PPID sudah baik, namun perlu ditingkatkan lagi responsnya.',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Test Browser'
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'umur' => 28,
                'jenis_kelamin' => 'Perempuan',
                'no_hp' => '082445678901',
                'pendidikan' => 'S2',
                'pekerjaan' => 'Dosen',
                'kemudahan_akses_informasi' => 4,
                'kualitas_informasi' => 4,
                'kemudahan_permintaan' => 4,
                'ketepatan_waktu_jawab' => 4,
                'kelengkapan_informasi' => 4,
                'ketepatan_tanggap' => 4,
                'pelayanan_petugas' => 4,
                'saran_masukan' => 'Website PPID mudah digunakan dan informasinya lengkap.',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Test Browser'
            ],
            [
                'nama' => 'Budi Wijaya',
                'umur' => 42,
                'jenis_kelamin' => 'Laki-laki',
                'no_hp' => '084456789012',
                'pendidikan' => 'SMA/SMK',
                'pekerjaan' => 'Wiraswasta',
                'kemudahan_akses_informasi' => 2,
                'kualitas_informasi' => 4,
                'kemudahan_permintaan' => 2,
                'ketepatan_waktu_jawab' => 4,
                'kelengkapan_informasi' => 2,
                'ketepatan_tanggap' => 4,
                'pelayanan_petugas' => 4,
                'saran_masukan' => 'Perlu perbaikan pada proses permintaan informasi, agak rumit.',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Test Browser'
            ],
            [
                'nama' => 'Rina Wati',
                'umur' => 41,
                'jenis_kelamin' => 'Perempuan',
                'no_hp' => '084567890124',
                'pendidikan' => 'S1',
                'pekerjaan' => 'Karyawan Swasta',
                'kemudahan_akses_informasi' => 4,
                'kualitas_informasi' => 4,
                'kemudahan_permintaan' => 4,
                'ketepatan_waktu_jawab' => 4,
                'kelengkapan_informasi' => 4,
                'ketepatan_tanggap' => 4,
                'pelayanan_petugas' => 4,
                'saran_masukan' => 'Sangat puas dengan pelayanan PPID! Terus tingkatkan.',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Test Browser'
            ],
            [
                'nama' => 'Andi Pratama',
                'umur' => 24,
                'jenis_kelamin' => 'Laki-laki',
                'no_hp' => '085678901244',
                'pendidikan' => 'S1',
                'pekerjaan' => 'Mahasiswa',
                'kemudahan_akses_informasi' => 4,
                'kualitas_informasi' => 4,
                'kemudahan_permintaan' => 4,
                'ketepatan_waktu_jawab' => 2,
                'kelengkapan_informasi' => 4,
                'ketepatan_tanggap' => 2,
                'pelayanan_petugas' => 4,
                'saran_masukan' => 'Sebagai mahasiswa, saya membutuhkan informasi yang lebih cepat.',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Test Browser'
            ]
        ];

        foreach ($sampleSurveys as $survey) {
            Survey::create($survey);
        }
    }
}
