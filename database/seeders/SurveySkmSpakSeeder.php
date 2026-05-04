<?php

namespace Database\Seeders;

use App\Models\SurveySkmSpak;
use Illuminate\Database\Seeder;

class SurveySkmSpakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = ['Eksternal - Masyarakat Umum', 'Eksternal - Jasa Pengiriman', 'Internal - Pegawai'];
        $jenisPelayanans = [
            'Pelayanan Informasi Publik',
            'Pelayanan Permohonan Kekayaan Daerah',
            'Pelayanan Pemberian Dalton/Badan',
            'Pelayanan Penyaluran Dana',
        ];
        $units = ['Bagian Umum', 'Bagian Hukum', 'Bagian Keuangan', 'Bagian Program'];
        $jabatan = ['Staff', 'Kabag', 'Kasubag', 'Sekretaris'];
        $jenisKelamin = ['Laki-laki', 'Perempuan'];
        $usias = ['17-25', '26-35', '36-45', '46-55', '>55'];
        $pendidikans = ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3'];
        $pekerjaans = ['PNS', 'TNI/Polri', 'Pegawai Swasta', 'Wiraswasta', 'Petani', 'Nelayan', 'Guru/Dosen', 'Dokter', 'Lainnya'];

        for ($i = 0; $i < 50; $i++) {
            $kategori = $kategoris[array_rand($kategoris)];
            $createdDate = now()->subDays(rand(1, 60));
            
            SurveySkmSpak::create([
                'jenis_kelamin' => $jenisKelamin[array_rand($jenisKelamin)],
                'usia' => $usias[array_rand($usias)],
                'pendidikan_terakhir' => $pendidikans[array_rand($pendidikans)],
                'pekerjaan' => $pekerjaans[array_rand($pekerjaans)],
                'kategori_responden' => $kategori,
                'unit_kerja' => $units[array_rand($units)],
                'jabatan' => $jabatan[array_rand($jabatan)],
                'jenis_pelayanan' => $jenisPelayanans[array_rand($jenisPelayanans)],
                'u1_persyaratan' => rand(1, 4),
                'u2_prosedur' => rand(1, 4),
                'u3_waktu_pelayanan' => rand(1, 4),
                'u4_biaya_tarif' => rand(1, 4),
                'u5_hasil_pelayanan' => rand(1, 4),
                'u6_kompetensi_petugas' => rand(1, 4),
                'u7_perilaku_petugas' => rand(1, 4),
                'u8_pengaduan' => rand(1, 4),
                'u9_sarana_prasarana' => rand(1, 4),
                'i1_tidak_diskriminatif' => rand(1, 4),
                'i2_tidak_curang' => rand(1, 4),
                'i3_tidak_imbalan' => rand(1, 4),
                'i4_tidak_percaloan' => rand(1, 4),
                'i5_tidak_pungli' => rand(1, 4),
                'kritik_saran' => $i % 3 == 0 ? 'Pelayanan sudah baik, tetap dipertahankan.' : null,
                'ip_address' => '192.168.1.' . rand(1, 255),
                'user_agent' => 'Seeder/1.0',
                'created_at' => $createdDate,
                'updated_at' => $createdDate,
            ]);
        }
    }
}
