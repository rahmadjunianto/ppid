<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;
use Carbon\Carbon;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agendas = [
            [
                'judul' => 'Sosialisasi Implementasi Peraturan Menteri Agama tentang Transparansi Publik',
                'deskripsi' => 'Kegiatan sosialisasi mengenai implementasi peraturan terbaru Menteri Agama yang berkaitan dengan transparansi dan akuntabilitas pelayanan publik. Kegiatan ini akan menghadirkan narasumber dari Direktorat Jenderal Bimbingan Masyarakat Islam dan para ahli hukum administrasi negara.',
                'tanggal_mulai' => Carbon::now()->addDays(5)->setTime(8, 0),
                'tanggal_selesai' => Carbon::now()->addDays(5)->setTime(17, 0),
                'tempat' => 'Auditorium Kementerian Agama RI, Jakarta',
                'penyelenggara' => 'PPID Kementerian Agama RI',
                'status' => 'published',
                'urutan' => 1
            ],
            [
                'judul' => 'Workshop Peningkatan Kapasitas Pengelola Informasi dan Dokumentasi',
                'deskripsi' => 'Program pelatihan intensif untuk para pengelola informasi dan dokumentasi di lingkungan Kementerian Agama. Workshop ini akan membahas teknik-teknik terbaru dalam pengelolaan arsip digital, sistem informasi manajemen dokumen, dan strategi pelayanan informasi publik yang efektif.',
                'tanggal_mulai' => Carbon::now()->addDays(12)->setTime(9, 0),
                'tanggal_selesai' => Carbon::now()->addDays(14)->setTime(16, 0),
                'tempat' => 'Hotel Santika Premier, Bandung',
                'penyelenggara' => 'PPID Kementerian Agama RI bekerjasama dengan Pusdiklat Kemenag',
                'status' => 'published',
                'urutan' => 2
            ],
            [
                'judul' => 'Rapat Koordinasi PPID Se-Indonesia',
                'deskripsi' => 'Rapat koordinasi tahunan yang menghadirkan seluruh PPID dari kantor wilayah dan kantor daerah Kementerian Agama se-Indonesia. Agenda utama meliputi evaluasi kinerja, pembahasan permasalahan, dan penyusunan program kerja tahun mendatang.',
                'tanggal_mulai' => Carbon::now()->addDays(20)->setTime(8, 30),
                'tanggal_selesai' => Carbon::now()->addDays(22)->setTime(15, 30),
                'tempat' => 'Hotel Grand Sahid Jaya, Jakarta',
                'penyelenggara' => 'PPID Kementerian Agama RI',
                'status' => 'published',
                'urutan' => 3
            ],
            [
                'judul' => 'Pelatihan Teknis Pelayanan Informasi Publik',
                'deskripsi' => 'Pelatihan khusus bagi petugas front office dan customer service untuk meningkatkan kualitas pelayanan informasi publik. Materi meliputi etika pelayanan, komunikasi efektif, dan penanganan komplain masyarakat.',
                'tanggal_mulai' => Carbon::now()->addDays(35)->setTime(8, 0),
                'tanggal_selesai' => Carbon::now()->addDays(35)->setTime(16, 0),
                'tempat' => 'Ruang Pelatihan PPID Kemenag, Jakarta',
                'penyelenggara' => 'PPID Kementerian Agama RI',
                'status' => 'published',
                'urutan' => 4
            ],
            [
                'judul' => 'Seminar Nasional Keterbukaan Informasi Publik',
                'deskripsi' => 'Seminar nasional yang menghadirkan akademisi, praktisi, dan stakeholder terkait untuk membahas perkembangan terkini dalam implementasi UU Keterbukaan Informasi Publik. Acara ini juga akan menghadirkan sharing session dari berbagai lembaga negara.',
                'tanggal_mulai' => Carbon::now()->addDays(45)->setTime(8, 0),
                'tanggal_selesai' => Carbon::now()->addDays(45)->setTime(17, 0),
                'tempat' => 'Ballroom Hotel Indonesia Kempinski, Jakarta',
                'penyelenggara' => 'PPID Kementerian Agama RI bekerjasama dengan Komisi Informasi Pusat',
                'status' => 'published',
                'urutan' => 5
            ],
            [
                'judul' => 'Dialog Publik: Reformasi Birokrasi di Era Digital',
                'deskripsi' => 'Forum dialog terbuka antara pimpinan Kementerian Agama dengan masyarakat untuk membahas upaya reformasi birokrasi di era digitalisasi. Dialog ini akan membahas inovasi pelayanan publik dan transformasi digital di lingkungan Kemenag.',
                'tanggal_mulai' => Carbon::now()->addDays(60)->setTime(9, 0),
                'tanggal_selesai' => Carbon::now()->addDays(60)->setTime(12, 0),
                'tempat' => 'Auditorium Kementerian Agama RI, Jakarta',
                'penyelenggara' => 'Sekretariat Jenderal Kementerian Agama RI',
                'status' => 'published',
                'urutan' => 6
            ],
            [
                'judul' => 'Peringatan Hari Keterbukaan Informasi Publik',
                'deskripsi' => 'Peringatan Hari Keterbukaan Informasi Publik dengan serangkaian kegiatan meliputi pameran, talkshow, dan pemberian penghargaan kepada PPID berprestasi. Acara ini terbuka untuk umum dan menghadirkan berbagai komunitas peduli transparansi.',
                'tanggal_mulai' => Carbon::parse('2024-04-30')->setTime(8, 0),
                'tanggal_selesai' => Carbon::parse('2024-04-30')->setTime(17, 0),
                'tempat' => 'Gedung Kementerian Agama RI, Jakarta',
                'penyelenggara' => 'PPID Kementerian Agama RI',
                'status' => 'published',
                'urutan' => 7
            ],
            [
                'judul' => 'Monitoring dan Evaluasi Kinerja PPID Triwulan IV',
                'deskripsi' => 'Kegiatan monitoring dan evaluasi rutin untuk menilai kinerja PPID di seluruh unit kerja Kementerian Agama. Evaluasi meliputi aspek kualitas layanan, ketepatan waktu respon, dan tingkat kepuasan masyarakat.',
                'tanggal_mulai' => Carbon::now()->subDays(30)->setTime(8, 0),
                'tanggal_selesai' => Carbon::now()->subDays(28)->setTime(17, 0),
                'tempat' => 'Ruang Rapat PPID Kemenag, Jakarta',
                'penyelenggara' => 'PPID Kementerian Agama RI',
                'status' => 'published',
                'urutan' => 8
            ],
            [
                'judul' => 'Sosialisasi Sistem Informasi Pelayanan Publik Terpadu',
                'deskripsi' => 'Pengenalan sistem informasi terbaru untuk pelayanan publik terpadu yang memungkinkan masyarakat mengakses berbagai layanan Kemenag melalui satu platform digital. Sosialisasi ditujukan untuk pegawai dan masyarakat umum.',
                'tanggal_mulai' => Carbon::now()->subDays(15)->setTime(9, 0),
                'tanggal_selesai' => Carbon::now()->subDays(15)->setTime(16, 0),
                'tempat' => 'Ruang Sosialisasi Kemenag, Jakarta',
                'penyelenggara' => 'Pusat Data dan Sistem Informasi Kemenag',
                'status' => 'published',
                'urutan' => 9
            ],
            [
                'judul' => 'Focus Group Discussion: Peningkatan Kualitas Website PPID',
                'deskripsi' => 'Diskusi terarah dengan berbagai stakeholder untuk mendapatkan masukan dalam rangka peningkatan kualitas website PPID. FGD akan membahas aspek user experience, konten informasi, dan fitur-fitur yang dibutuhkan masyarakat.',
                'tanggal_mulai' => Carbon::now()->subDays(5)->setTime(10, 0),
                'tanggal_selesai' => Carbon::now()->subDays(5)->setTime(15, 0),
                'tempat' => 'Ruang Meeting PPID Kemenag, Jakarta',
                'penyelenggara' => 'PPID Kementerian Agama RI',
                'status' => 'published',
                'urutan' => 10
            ],
            [
                'judul' => 'Bimbingan Teknis Pengelolaan Media Sosial PPID',
                'deskripsi' => 'Program bimbingan teknis untuk tim pengelola media sosial PPID dalam rangka optimalisasi komunikasi dan edukasi publik melalui platform digital. Materi meliputi strategi konten, engagement, dan crisis management.',
                'tanggal_mulai' => Carbon::now()->addMonths(2)->setTime(9, 0),
                'tanggal_selesai' => Carbon::now()->addMonths(2)->addDays(1)->setTime(16, 0),
                'tempat' => 'Hotel Mercure, Yogyakarta',
                'penyelenggara' => 'PPID Kementerian Agama RI',
                'status' => 'published',
                'urutan' => 11
            ],
            [
                'judul' => 'Evaluasi Implementasi Standar Pelayanan Publik',
                'deskripsi' => 'Kegiatan evaluasi menyeluruh terhadap implementasi standar pelayanan publik di lingkungan Kementerian Agama. Evaluasi akan melibatkan auditor internal dan eksternal untuk memastikan compliance terhadap regulasi yang berlaku.',
                'tanggal_mulai' => Carbon::now()->addMonths(3)->setTime(8, 30),
                'tanggal_selesai' => Carbon::now()->addMonths(3)->addDays(2)->setTime(16, 30),
                'tempat' => 'Hotel Grand Mercure, Surabaya',
                'penyelenggara' => 'Inspektorat Jenderal Kementerian Agama RI',
                'status' => 'published',
                'urutan' => 12
            ]
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }
    }
}
