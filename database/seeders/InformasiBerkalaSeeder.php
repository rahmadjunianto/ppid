<?php

namespace Database\Seeders;

use App\Models\InformasiBerkala;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InformasiBerkalaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Kategori A: Profil Kementerian Agama
            ["kategori" => "A", "judul" => "Alamat Kantor Lengkap", "link_type" => "link", "link" => "https://ppid.kemenagnganjuk.id/alamat-kantor"],
            ["kategori" => "A", "judul" => "Visi dan Misi", "link_type" => "link", "link" => "https://ppid.kemenagnganjuk.id/visi-misi"],
            ["kategori" => "A", "judul" => "Tugas dan Fungsi", "link_type" => "link", "link" => "https://ppid.kemenagnganjuk.id/tugas-fungsi"],
            ["kategori" => "A", "judul" => "Sejarah Kantor Kementerian Agama Kabupaten Nganjuk", "link_type" => "link", "link" => "https://ppid.kemenagnganjuk.id/sejarah-kantor-kementerian-agama-kabupaten-nganjuk"],
            ["kategori" => "A", "judul" => "Tujuan", "link_type" => "link", "link" => "https://ppid.kemenagnganjuk.id/tujuan"],
            ["kategori" => "A", "judul" => "Struktur Organisasi", "link_type" => "link", "link" => "https://ppid.kemenagnganjuk.id/struktur-organisasi"],
            ["kategori" => "A", "judul" => "Ruang Lingkup Satuan Kerja", "link_type" => "link", "link" => "https://ppid.kemenagnganjuk.id/ruang-lingkup-satuan-kerja"],
            ["kategori" => "A", "judul" => "Profil Kepala Kantor Kementerian Agama Kabupaten Nganjuk", "link_type" => "link", "link" => "https://ppid.kemenagnganjuk.id/profil-kepala-kantor-kementerian-agama-kabupaten-nganjuk"],
            ["kategori" => "A", "judul" => "Pejabat Kantor Kementerian Agama Kabupaten Nganjuk", "link_type" => "link", "link" => "https://ppid.kemenagnganjuk.id/pejabat-kantor-kementerian-agama-kabupaten-nganjuk"],
            ["kategori" => "A", "judul" => "Logo Kementerian Agama (KMA Nomor 717 Tahun 2006)", "link_type" => "link", "link" => "https://balitbangdiklat.kemenag.go.id/upload/files/LOGO%20KEMENAG%20PNG-1.png"],
            ["kategori" => "A", "judul" => "Laporan Harta Kekayaan Penyelenggara Negara (LHKPN)", "link_type" => "link", "link" => "https://ppid.kemenagnganjuk.id/lhkpn"],

            // Kategori B: Program dan/atau Kegiatan yang Sedang Dijalankan
            ["kategori" => "B", "judul" => "Rencana Kerja", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/13GFZbmE7Fjo9Zkgwszz2BqnCvYuvOso0?hl=id"],
            ["kategori" => "B", "judul" => "Rencana Strategis", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1sbS_2iiikId0RD2zOI3d6eSBnfD_Cr3J?hl=id"],
            ["kategori" => "D", "judul" => "Perjanjian Kinerja", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1GtPIMhAGagaowFaIU5g6HGWIY4-dXRXs?hl=id"],
            ["kategori" => "B", "judul" => "Daftar Isian Pelaksanaan Anggaran (DIPA)", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1EhEeygNxhutZvMAQVHLIPQP9mFTFzzrZ?hl=id"],
            ["kategori" => "B", "judul" => "Rekap RKAKL Kementerian Agama", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1tEp5LtcOvgQmKjgflyGpS1bf-mxCu7n2?hl=id"],
            ["kategori" => "B", "judul" => "Informasi Realisasi atau Penyerapan Penggunaan Keuangan", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1wnK8s9g6Oxp-fa35v0jZ13b6q5KIgDlj?hl=id"],

            // Kategori C: Program Strategis sesuai Tugas dan Fungsi
            ["kategori" => "C", "judul" => "Program/Kegiatan Lengkap dengan Pelaksana, Target, Jadwal dan Anggaran", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1f8GY0z5MhZogtjUK8llMxlJ3PScIbmSa?hl=id"],
            ["kategori" => "C", "judul" => "Program Prioritas Tahun 2025", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1BMyf4DvkTMFqjdn07rdAhqMIsQ-pZ_Wg?hl=id"],
            ["kategori" => "C", "judul" => "Ringkasan Kinerja dan Capaian Program/Kegiatan", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1WlRMZcE_njbct4h4RnT56sB7tQ_Lsf5Y?hl=id"],
            ["kategori" => "E", "judul" => "Peraturan, Keputusan, dan/atau Kebijakan Publik", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1bInvCzL7ZLeYe1s1R9BTBb4JzxSbbNK7?hl=id"],

            // Kategori D: Ringkasan Program/Kegiatan yang Telah Dijalankan
            ["kategori" => "D", "judul" => "Laporan Keuangan", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1lgJ0jJxH76bKA-w6MKJP1LbUKJMVvafI?hl=id"],
            ["kategori" => "D", "judul" => "Laporan Kinerja", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/10tZEc5v_SElfUMNkrkwv4dgYMc3oW8W9?hl=id"],
            ["kategori" => "D", "judul" => "Laporan Tahunan Pelayanan Publik", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1dOMcypvUDyhayQKa_9yGe2nWrGhcfQHi?hl=id"],
            ["kategori" => "D", "judul" => "Data Perbendaharaan atau Inventaris Barang Milik Negara", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1NvZpisgxUKb5YtmCbt8JA4O1MgiCAPNw?hl=id"],
            ["kategori" => "D", "judul" => "Pencatatan Nikah", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1r8y8Oio7aE4ww-2XiNcHIDoAjtiNz0NK?hl=id"],
            ["kategori" => "D", "judul" => "Layanan Informasi Haji dan Umrah", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1RPjrDB7zJ0v6jkwv1Kl9LPe4Ne1ep7aM?hl=id"],
            ["kategori" => "D", "judul" => "Layanan Pengaduan Masyarakat dan Whistleblowing", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1x_cWu0r2pQF7HwaQmXrqZJQuaQrA81cp?hl=id"],
            ["kategori" => "D", "judul" => "Program Bantuan Penelitian, Publikasi, dan Pengabdian Litapdimas", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1E6I2wUiHTC3B33beGXmCK_nwKfKNxheZ?hl=id"],
            ["kategori" => "D", "judul" => "Layanan Produk Halal", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1N2IbWuJRrkymGPMARCRgpThGdr-E7IFi?hl=id"],
            ["kategori" => "D", "judul" => "Informasi tentang Rekrutmen ASN Kementerian Agama", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1CPTvsZ3fu9ZpTlk2nJHx_JFHl1EitawG?hl=id"],
            ["kategori" => "D", "judul" => "Sistem Pendaftaran Online JPT Terbuka", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/182CftlUhiQO-EMztaeABs9_WGBda1frD?hl=id"],
            ["kategori" => "D", "judul" => "Agenda Kegiatan Badan Publik", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1uo0lSUnWCx3yybzEpqeGgTy8g96UeUz9?hl=id"],
            ["kategori" => "D", "judul" => "Dokumen Pengadaan Barang/Jasa yang Telah Selesai dan Diserahterimakan", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1HPF617dxJSwLGsPRd1YzuaT6VTAL9WF2?hl=id"],
            ["kategori" => "D", "judul" => "Informasi Publik yang Terbuka Berdasarkan Keberatan/Sengketa", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1DkV_rdr4U_ad2kpU5o9BxvGonbEBAdR7?hl=id"],

            // Kategori E: Informasi Pekerjaan Pengadaan Barang/Jasa
            ["kategori" => "E", "judul" => "Rencana Umum Pengadaan Barang/Jasa", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1Vzv0XWy6laNdIGyOAsqFm12Yf0RxbZLN?hl=id"],
            ["kategori" => "E", "judul" => "Pengumuman Pengadaan Barang dan Jasa", "link_type" => "link", "link" => "https://drive.google.com/drive/folders/1TJgyYW0ARhEsEwFOnNDupouG7Hfki6Sr?hl=id"],
        ];

        $order = 1;
        foreach ($data as $item) {
            InformasiBerkala::create([
                "judul" => $item["judul"],
                "slug" => Str::slug($item["judul"]),
                "kategori" => $item["kategori"],
                "link_type" => $item["link_type"],
                "file" => $item["file"] ?? null,
                "link" => $item["link"] ?? null,
                "status" => "published",
                "sort_order" => $order++,
            ]);
        }
    }
}

