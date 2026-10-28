<?php

namespace Database\Seeders;

use App\Models\InformasiSetiapSaat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InformasiSetiapSaatSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ["judul" => "Daftar Informasi Publik yang Dikecualikan", "link" => "https://drive.google.com/file/d/1e4vpHWEzA8v7TpPEmPTjc7t2-3KCFsYt/view?usp=sharing"],
            ["judul" => "Dokumen Pendukung dalam Penyusunan Peraturan/Kebijakan/Keputusan yang Telah Ditetapkan", "link" => null],
            ["judul" => "Perjanjian dengan Pihak Ketiga", "link" => null],
            ["judul" => "Pedoman Pengelolaan Administrasi", "link" => null],
            ["judul" => "Pedoman Pengelolaan Organisasi", "link" => null],
            ["judul" => "Pedoman Pengelolaan Kepegawaian", "link" => null],
            ["judul" => "Prosedur Pengelolaan Keuangan", "link" => null],
            ["judul" => "Statistik Kepegawaian - berdasarkan Agama, Pendidikan, Jenis Kelamin, Pangkat, Golongan, Usia, Tipe Jabatan, Jabatan Struktural, dan JFT", "link" => "https://lookerstudio.google.com/s/gCf689Lhcpk"],
            ["judul" => "Statistik Kepegawaian - berdasarkan Sebaran PNS, Agama, Jenis Kelamin, Jenjang Pendidikan, Perkiraan Pensiun, Penerimaan PNS", "link" => "https://lookerstudio.google.com/s/gCf689Lhcpk"],
            ["judul" => "Program Moderasi Beragama", "link" => null],
            ["judul" => "Ensiklopedia Agama", "link" => null],
            ["judul" => "Pedoman Induk Penanggulangan Darurat Kebakaran dan Bencana Alam di Lingkungan Kantor Pusat", "link" => null],
            ["judul" => "Indeks Kepuasan Jemaah Haji Indonesia (IKJHI)", "link" => null],
            ["judul" => "Indeks Kerukunan Umat Beragama (IKUB)", "link" => null],
            ["judul" => "Indeks Pelayanan Keagamaan Menurut Kantor Urusan Agama", "link" => null],
            ["judul" => "Indeks Kesalehan Sosial Umat Beragama", "link" => null],
            ["judul" => "Indeks Sadar Halal Generasi Muslim Milenial", "link" => null],
            ["judul" => "Daftar Judul Penelitian Kementerian Agama", "link" => null],
            ["judul" => "Layanan Penyandang Disabilitas", "link" => null],
            ["judul" => "Info Nikah", "link" => null],
            ["judul" => "Syarat-syarat Pengurusan Dokumen Rohaniawan dan Tenaga Ahli Asing", "link" => null],
            ["judul" => "Syarat-syarat Pengurusan Dokumen bagi Mahasiswa Pelajar Asing", "link" => null],
            ["judul" => "Daftar Produk Hukum", "link" => null],
            ["judul" => "Statistik Kementerian Agama Kabupaten Nganjuk", "link" => "https://ppid.kemenagnganjuk.id/statistik-kementerian-agama-kabupaten-nganjuk"],
            ["judul" => "Informasi jumlah dan prosentase LHKSN dalam lingkup Kementerian Agama", "link" => null],
            ["judul" => "Penyelenggara Satu Data Kementerian Agama", "link" => null],
            ["judul" => "Layanan Masyarakat", "link" => null],
            ["judul" => "Daftar peraturan perundang-undangan, keputusan, dan/atau kebijakan yang telah disahkan atau ditetapkan", "link" => null],
            ["judul" => "Daftar rancangan dan tahap pembentukan peraturan perundang-undangan, keputusan, dan/atau kebijakan yang sedang dalam proses pembuatan", "link" => null],
            ["judul" => "Dokumen rancangan peraturan, keputusan, kebijakan yang dibentuk", "link" => null],
            ["judul" => "Peraturan, Keputusan, dan/atau Kebijakan Kementerian Agama", "link" => null],
        ];

        $order = 1;
        foreach ($data as $item) {
            $link = $item["link"] ?? null;

            InformasiSetiapSaat::create([
                "judul" => $item["judul"],
                "slug" => Str::slug($item["judul"]),
                "link" => $link,
                "link_type" => $link ? "external" : "internal",
                "file" => null,
                "ukuran" => null,
                "status" => "published",
                "sort_order" => $order++,
            ]);
        }
    }
}
