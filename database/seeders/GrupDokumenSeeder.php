<?php

namespace Database\Seeders;

use App\Models\GrupDokumen;
use Illuminate\Database\Seeder;

class GrupDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['nama_grup' => 'Dokumen PPID', 'slug' => 'dokumen-ppid', 'deskripsi' => 'Dokumen resmi Pengelolaan Informasi dan Dokumentasi', 'sort_order' => 1],
            ['nama_grup' => 'Rencana Strategis', 'slug' => 'rencana-strategis', 'deskripsi' => 'Rencana Strategis Organisasi', 'sort_order' => 2],
            ['nama_grup' => 'Rencana Kerja & Anggaran', 'slug' => 'rencana-kerja', 'deskripsi' => 'Rencana Kerja dan Anggaran', 'sort_order' => 3],
            ['nama_grup' => 'Laporan', 'slug' => 'laporan', 'deskripsi' => 'Laporan kinerja dan keuangan', 'sort_order' => 4],
            ['nama_grup' => 'LPJ Kegiatan', 'slug' => 'lpj-kegiatan', 'deskripsi' => 'Laporan Pertanggungjawaban Kegiatan', 'sort_order' => 5],
            ['nama_grup' => 'Regulasi', 'slug' => 'regulasi', 'deskripsi' => 'Peraturan dan regulasi', 'sort_order' => 6],
            ['nama_grup' => 'Standar Layanan', 'slug' => 'standar-layanan', 'deskripsi' => 'Standar pelayanan publik', 'sort_order' => 7],
            ['nama_grup' => 'Statistik', 'slug' => 'statistik', 'deskripsi' => 'Data statistik pelayanan', 'sort_order' => 8],
        ];

        foreach ($groups as $group) {
            GrupDokumen::firstOrCreate(['slug' => $group['slug']], $group);
        }
    }
}
