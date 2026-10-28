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
    ["judul" => "Dokumen Pendukung dalam Penyusunan Peraturan/Kebijakan/Keputusan yang Telah Ditetapkan", "link" => "https://ppid.kemenagnganjuk.id/regulasi"],
    ["judul" => "Perjanjian dengan Pihak Ketiga", "link" => "https://ppid.kemenagnganjuk.id/regulasi"],
    ["judul" => "Pedoman Pengelolaan Administrasi", "link" => "https://ppid.kemenag.go.id/v5/administrasi.php"],
    ["judul" => "Pedoman Pengelolaan Organisasi", "link" => "https://ppid.kemenag.go.id/v5/organisasi.php"],
    ["judul" => "Pedoman Pengelolaan Kepegawaian", "link" => "https://ppid.kemenag.go.id/v5/kepegawaian.php"],
    ["judul" => "Prosedur Pengelolaan Keuangan", "link" => "https://ppid.kemenag.go.id/v5/keuangan.php"],
    ["judul" => "Statistik Kepegawaian - berdasarkan Agama, Pendidikan, Jenis Kelamin, Pangkat, Golongan, Usia, Tipe Jabatan, Jabatan Struktural, dan JFT", "link" => "https://lookerstudio.google.com/s/gCf689Lhcpk"],
    ["judul" => "Statistik Kepegawaian - berdasarkan Sebaran PNS, Agama, Jenis Kelamin, Jenjang Pendidikan, Perkiraan Pensiun, Penerimaan PNS", "link" => "https://lookerstudio.google.com/s/gCf689Lhcpk"],
    ["judul" => "Program Moderasi Beragama", "link" => "https://kemenag.go.id/nasional/kemenag-perpres-58-2023-wujudkan-moderasi-beragama-kian-kuat-dan-kolaboratif-yUoWM"],
    ["judul" => "Ensiklopedia Agama", "link" => "https://ppid.kemenag.go.id/v5/ensiklopedia.php"],
    ["judul" => "Pedoman Induk Penanggulangan Darurat Kebakaran dan Bencana Alam di Lingkungan Kantor Pusat", "link" => "https://jdih.bnpb.go.id/storage/file/2025pbbnpb001.pdf"],
    ["judul" => "Indeks Kepuasan Jemaah Haji Indonesia (IKJHI)", "link" => "https://www.bps.go.id/id/pressrelease/2025/09/10/2524/nilai-indeks-kepuasan-jemaah-haji-indonesia--ikjhi--tahun-2025-sebesar-88-46--sangat-memuaskan--meningkat-sebesar-0-26-poin-dibandingkan-tahun-2024.html"],
    ["judul" => "Indeks Kerukunan Umat Beragama (IKUB)", "link" => "https://kemenag.go.id/nasional/indeks-kerukunan-umat-beragama-2024-naik-jadi-76-47-wG2qs"],
    ["judul" => "Indeks Pelayanan Keagamaan Menurut Kantor Urusan Agama", "link" => "https://kemenag.go.id/nasional/survei-litbang-kemenag-indeks-kesalehan-sosial-82-59-dan-indeks-kepuasan-layanan-kua-83-237-FZe6N"],
    ["judul" => "Indeks Kesalehan Sosial Umat Beragama", "link" => "https://kemenag.go.id/nasional/survei-litbang-kemenag-indeks-kesalehan-sosial-82-59-dan-indeks-kepuasan-layanan-kua-83-237-FZe6N"],
    ["judul" => "Indeks Sadar Halal Generasi Muslim Milenial", "link" => "https://simlitbang.balitbangdiklat.net/spdata/upload/policy_paper/16202880692._Policy_Paper_-_Milenial_Sadar_Halal_[13-1-2021]_.pdf"],
    ["judul" => "Daftar Judul Penelitian Kementerian Agama", "link" => "https://satudata.kemenag.go.id/dataset/detail/daftar-judul-penelitian-badan-penelitian-dan-pengembangan-dan-pendidikan-dan-pelatihan"],
    ["judul" => "Layanan Penyandang Disabilitas", "link" => null],
    ["judul" => "Info Nikah", "link" => "https://simkah4.kemenag.go.id/"],
    ["judul" => "Syarat-syarat Pengurusan Dokumen Rohaniawan dan Tenaga Ahli Asing", "link" => null],
    ["judul" => "Syarat-syarat Pengurusan Dokumen bagi Mahasiswa Pelajar Asing", "link" => null],
    ["judul" => "Daftar Produk Hukum", "link" => "https://ppid.kemenagnganjuk.id/regulasi"],
    ["judul" => "Statistik Kementerian Agama Kabupaten Nganjuk", "link" => "https://ppid.kemenagnganjuk.id/statistik-kementerian-agama-kabupaten-nganjuk"],
    ["judul" => "Informasi jumlah dan prosentase LHKSN dalam lingkup Kementerian Agama", "link" => "https://ppid.kemenag.go.id/v5/files/2025/informasi_tersedia_setiap_saat/LHKAN/Salinan%2047.%20LHKAN%20%20Itjen%20Kemenag%202025%20fix.pdf"],
    ["judul" => "Penyelenggara Satu Data Kementerian Agama", "link" => "https://ppid.kemenag.go.id/v5/files/if_tersedia/KMA%20465%20Tahun%202020%20tentang%20Walidata%20dan%20Produsen%20Data%20Kemenag.pdf"],
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
