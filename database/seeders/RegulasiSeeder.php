<?php

namespace Database\Seeders;

use App\Models\Regulasi;
use Illuminate\Database\Seeder;

class RegulasiSeeder extends Seeder
{
    /**
     * Seed data regulasi & peraturan (peraturan perundang-undangan, keputusan, dan edaran).
     *
     * Data di bawah ditampilkan pada halaman /regulasi. Dokumen Pusat diunjuk
     * melalui tautan eksternal (link_type = link), sedangkan dokumen Kankemenag
     * dapat diunggah melalui dashboard admin (link_type = file).
     */
    public function run(): void
    {
        $regulasi = [
            [
                'nama_regulasi' => 'UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik',
                'nomor'         => 'UU No. 14/2008',
                'tingkat'       => 'pusat',
                'tahun'         => 2008,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/39',
                'sort_order'    => 1,
            ],
            [
                'nama_regulasi' => 'UU No. 25 Tahun 2009 tentang Pelayanan Publik',
                'nomor'         => 'UU No. 25/2009',
                'tingkat'       => 'pusat',
                'tahun'         => 2009,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/40',
                'sort_order'    => 2,
            ],
            [
                'nama_regulasi' => 'PP No. 61 Tahun 2010 tentang Penyelenggaraan Informasi Publik',
                'nomor'         => 'PP No. 61/2010',
                'tingkat'       => 'pusat',
                'tahun'         => 2010,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/41',
                'sort_order'    => 3,
            ],
            [
                'nama_regulasi' => 'Perpres No. 61 Tahun 2010 tentang Badan Publik',
                'nomor'         => 'Perpres No. 61/2010',
                'tingkat'       => 'pusat',
                'tahun'         => 2010,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/42',
                'sort_order'    => 4,
            ],
            [
                'nama_regulasi' => 'KMA tentang Pedoman Pengelolaan Informasi Publik di Lingkungan Kementerian Agama',
                'nomor'         => 'KMA',
                'tingkat'       => 'pusat',
                'tahun'         => null,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/43',
                'sort_order'    => 5,
            ],
            [
                'nama_regulasi' => 'PMA tentang Standar Layanan Pelayanan Terpadu Satu Pintu',
                'nomor'         => 'PMA',
                'tingkat'       => 'pusat',
                'tahun'         => null,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/44',
                'sort_order'    => 6,
            ],
            [
                'nama_regulasi' => 'Edaran Menteri Agama RI tentang Penguatan Pelayanan Publik',
                'nomor'         => 'Edaran Menag',
                'tingkat'       => 'pusat',
                'tahun'         => null,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/45',
                'sort_order'    => 7,
            ],
            [
                'nama_regulasi' => 'Edaran Direktur Jenderal Pendidikan Islam tentang Data Pendidikan',
                'nomor'         => 'Edaran Dirjen Pendidikan Islam',
                'tingkat'       => 'pusat',
                'tahun'         => null,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/46',
                'sort_order'    => 8,
            ],
            [
                'nama_regulasi' => 'SK Kepala Kankemenag Kabupaten Nganjuk No. 12 Tahun 2026 tentang Penetapan Pengelola PPID',
                'nomor'         => 'SK No. 12/2026',
                'tingkat'       => 'kankemenag',
                'tahun'         => 2026,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/47',
                'sort_order'    => 9,
            ],
            [
                'nama_regulasi' => 'SK Kepala Kankemenag Kabupaten Nganjuk No. 13 Tahun 2026 tentang Penetapan Pengelola PTSP',
                'nomor'         => 'SK No. 13/2026',
                'tingkat'       => 'kankemenag',
                'tahun'         => 2026,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/48',
                'sort_order'    => 10,
            ],
            [
                'nama_regulasi' => 'Edaran Kepala Kankemenag Kabupaten Nganjuk tentang Pemutakhiran Daftar Informasi Publik',
                'nomor'         => 'Edaran Kepala Kankemenag',
                'tingkat'       => 'kankemenag',
                'tahun'         => null,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/49',
                'sort_order'    => 11,
            ],
            [
                'nama_regulasi' => 'Keputusan Kepala Kankemenag Kabupaten Nganjuk tentang Pedoman Pelaksanaan Tugas Kepala Kankemenag',
                'nomor'         => 'Kep. Kepala Kankemenag',
                'tingkat'       => 'kankemenag',
                'tahun'         => null,
                'link_url'      => 'https://ppid.ptspkotamalang.net/unduh/dokumen/50',
                'sort_order'    => 12,
            ],
        ];

        foreach ($regulasi as $item) {
            Regulasi::updateOrCreate(
                ['nama_regulasi' => $item['nama_regulasi']],
                array_merge($item, [
                    'link_type' => 'link',
                    'status'    => 'published',
                ])
            );
        }
    }
}
