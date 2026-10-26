<?php

namespace Database\Seeders;

use App\Models\Regulasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegulasiSeeder extends Seeder
{

public function run(): void
    {
        $regulasi = [
            [
                'nama_regulasi' => 'Peraturan Presiden tentang Kementerian Agama',
                'nomor' => '152 Tahun 2024',
                'tahun' => 2024,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751335676_4b62f2460537114fed12.pdf',
            ],
            [
                'nama_regulasi' => 'Peraturan Menteri Agama tentang Organisasi dan Tata Kerja Kementerian Agama',
                'nomor' => '33 Tahun 2024',
                'tahun' => 2024,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751352801_4e6f9d18b46b970ac673.pdf',
            ],
            [
                'nama_regulasi' => 'Undang-Undang tentang Kementerian Negara',
                'nomor' => '39 Tahun 2008',
                'tahun' => 2008,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751352916_bc55b9f6ff9e9782bae6.pdf',
            ],
            [
                'nama_regulasi' => 'Undang-Undang tentang Perubahan atas UU Nomor 39 Tahun 2008 tentang Kementerian Negara',
                'nomor' => '61 Tahun 2024',
                'tahun' => 2024,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751352977_084068a3162b356c8ea6.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Sistem Kerja',
                'nomor' => '1179 Tahun 2022',
                'tahun' => 2022,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751353031_3645967984d9bf954e2e.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Peta Proses Bisnis Kementerian Agama',
                'nomor' => '1364 Tahun 2021',
                'tahun' => 2021,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751353077_ee37881342a6f065b67a.pdf',
            ],
            [
                'nama_regulasi' => 'Undang-Undang tentang Kitab Undang-Undang Hukum Pidana',
                'nomor' => '1 Tahun 2023',
                'tahun' => 2023,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751353265_e0b38e5b1108337f7ce7.pdf',
            ],
            [
                'nama_regulasi' => 'Peraturan Presiden tentang Satuan Tugas Sapu Bersih Pungutan Liar',
                'nomor' => '87 Tahun 2016',
                'tahun' => 2016,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751353293_7c629f3817aea88d0d2f.pdf',
            ],
            [
                'nama_regulasi' => 'Undang-Undang tentang Ombudsman Republik Indonesia',
                'nomor' => '37 Tahun 2008',
                'tahun' => 2008,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751353349_b818d68089dfdcb571b2.pdf',
            ],
            [
                'nama_regulasi' => 'Undang-Undang tentang Pelayanan Publik',
                'nomor' => '25 Tahun 2009',
                'tahun' => 2009,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751353476_bc35c7b502a0b6a6369d.pdf',
            ],
            [
                'nama_regulasi' => 'Undang-Undang tentang Perubahan Kedua atas UU Nomor 30 Tahun 2002 tentang Komisi Pemberantasan Tindak Pidana Korupsi',
                'nomor' => '19 Tahun 2019',
                'tahun' => 2019,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751353517_e9a7e5b59a97dfb02a5d.pdf',
            ],
            [
                'nama_regulasi' => 'Penjelasan Undang-Undang Nomor 19 Tahun 2019 tentang Perubahan Kedua atas UU Nomor 30 Tahun 2002 tentang KPK',
                'nomor' => '19 Tahun 2019',
                'tahun' => 2019,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751353627_eaa4e1f3bad1dda839ac.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Inspektur Jenderal tentang Petunjuk Pelaksanaan Pemberantasan Pungutan Liar pada Kementerian Agama',
                'nomor' => '75 Tahun 2020',
                'tahun' => 2020,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751353677_3d521a7bb5b0e0039058.pdf',
            ],
            [
                'nama_regulasi' => 'Undang-Undang tentang Aparatur Sipil Negara',
                'nomor' => '20 Tahun 2023',
                'tahun' => 2023,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1751353769_dc2a49d14a1182afbe8e.pdf',
            ],
            [
                'nama_regulasi' => 'Peraturan Menteri Agama tentang Rencana Strategis Kementerian Agama 2025-2029',
                'nomor' => '17 Tahun 2025',
                'tahun' => 2025,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788648721_b5df458b99dd6d3c4648.pdf',
            ],
            [
                'nama_regulasi' => 'Peraturan Menteri Agama tentang Tata Naskah Dinas pada Kementerian Agama',
                'nomor' => '12 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788648788_8cdb667692349ab3fc9a.pdf',
            ],
            [
                'nama_regulasi' => 'Peraturan Menteri Agama tentang Pengendalian Gratifikasi pada Kementerian Agama',
                'nomor' => '14 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649091_618b47d4ab13b3cb970f.pdf',
            ],
            [
                'nama_regulasi' => 'Peraturan Menteri Agama tentang Perubahan atas PMA Nomor 33 Tahun 2024 tentang Organisasi dan Tata Kerja Kementerian Agama',
                'nomor' => '16 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649113_a2eb6750fac2b597cc2e.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Direktur Jenderal Hindu tentang Petunjuk Teknis Pedoman Pengelolaan Blangko Ijazah pada Satuan Pendidikan Widyalaya',
                'nomor' => '91 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649225_029bb87fe1ebe78b0cc7.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Direktur Jenderal Bimbingan Masyarakat Islam tentang Jenis Layanan pada KUA',
                'nomor' => '980 Tahun 2025',
                'tahun' => 2025,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649335_5ce6c6b9cae67bdc6037.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Sekretaris Jenderal tentang Petunjuk Teknis Pelaksanaan Kontrak Penyuluh Agama, Guru Pendidikan Agama dan Guru Pendidikan Keagamaan Khonghucu Non-ASN',
                'nomor' => '16 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649358_3e2f054c13687879c1f3.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Sekretaris Jenderal tentang Standar Kompetensi Lulusan dan Capaian Pembelajaran Program Studi Jenjang Sarjana pada Perguruan Tinggi Keagamaan Khonghucu',
                'nomor' => '89 Tahun 2025',
                'tahun' => 2025,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649375_37c13d8506013736c2fe.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Sekretaris Jenderal tentang Petunjuk Teknis PIP pada Satuan Pendidikan Jenjang Pendidikan Dasar dan Menengah',
                'nomor' => '119 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649392_776805ee4a33706f7a1c.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Sekretaris Jenderal tentang Petunjuk Teknis Sensus BMN pada Kementerian Agama',
                'nomor' => '274 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649407_263d224854ce72297fd2.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Pengembangan Kompetensi Pegawai ASN Kementerian Agama',
                'nomor' => '605 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649509_53d6c1aff16ca0b5179d.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Pedoman Pemenuhan Beban Kerja Guru Madrasah yang Bersertifikat Pendidik',
                'nomor' => '736 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649536_c1bcc5cdce9ef7636801.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Pedoman Pelaksanaan Sensus BMN pada Kementerian Agama',
                'nomor' => '765 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649561_a583dafbe0d7988977f0.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Pedoman Penyelenggaraan Rekognisi Pembelajaran Lampau pada Mahad Aly',
                'nomor' => '863 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649591_b71343c2ca58510d9b51.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Pedoman Penggunaan Data Tunggal Sosial dan Ekonomi Nasional dalam Pendistribusian dan Pendayagunaan ZIS dan Dana Sosial Keagamaan Lainnya',
                'nomor' => '885 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649619_d3971faf6db3268aa296.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Penyelenggara Satu Data Kementerian Agama',
                'nomor' => '933 Tahun 2026',
                'tahun' => 2026,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649644_00b67fa29edf8fd5cd82.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Kedudukan dan Uraian Tugas Jabatan Fungsional dan Jabatan Pelaksana pada Peta Jabatan',
                'nomor' => '1150 Tahun 2025',
                'tahun' => 2025,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649666_25e4ba6a2a216c295338.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Pengelola Informasi dan Dokumentasi',
                'nomor' => '1518 Tahun 2025',
                'tahun' => 2025,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649687_986532c9541b27f57ec2.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Pedoman Penyelenggaraan Taman Seminarium',
                'nomor' => '1533 Tahun 2025',
                'tahun' => 2025,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649705_3971fa19dd84ec1f0082.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Kewajiban Penyampaian Laporan Harta Kekayaan Aparatur Negara pada Kementerian Agama',
                'nomor' => '1599 Tahun 2025',
                'tahun' => 2025,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649723_db605c2c6c8f3a326eb4.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Kepala Kantor Urusan Agama',
                'nomor' => '1644 Tahun 2025',
                'tahun' => 2025,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649781_a0fcc56167976456a8b0.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Dana Abadi Pendidikan Berbasis Wakaf',
                'nomor' => '1683 Tahun 2025',
                'tahun' => 2025,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649804_685402d7ac8f451b35b8.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Pedoman Penyelenggaraan Unit Layanan Disabilitas Pendidikan Islam pada Kementerian Agama',
                'nomor' => '1751 Tahun 2025',
                'tahun' => 2025,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1788649819_42e5a38122188c10c079.pdf',
            ],
            [
                'nama_regulasi' => 'Keputusan Menteri Agama tentang Pedoman Pengelolaan Pengaduan Masyarakat dan Whistleblowing pada Kementerian Agama',
                'nomor' => '765 Tahun 2018',
                'tahun' => 2018,
                'url' => 'https://ppidjatim.kemenag.go.id/public/unduh/produkhukum/1789889253_5fd451fe0fc9a616e8e9.pdf',
            ],
        ];

        foreach ($regulasi as $index => $item) {
            DB::table('regulasi')->updateOrInsert(
                ['link_url' => $item['url']],
                [
                    'nama_regulasi' => $item['nama_regulasi'],
                    'nomor' => $item['nomor'],
                    'tingkat' => 'pusat',
                    'tahun' => $item['tahun'],
                    'link_type' => 'link',
                    'file' => null,
                    'link_url' => $item['url'],
                    'ukuran' => null,
                    'status' => 'published',
                    'sort_order' => $index + 1,
                    'view_count' => 0,
                    'admin_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
