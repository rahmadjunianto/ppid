<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample page untuk testing
        Page::create([
            'title' => 'Tentang PPID',
            'slug' => 'tentang-ppid',
            'content' => '<h2>Tentang PPID Kemenag Nganjuk</h2>
                <p>Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kementerian Agama Kabupaten Nganjuk...</p>',
            'excerpt' => 'Informasi tentang PPID Kemenag Nganjuk',
            'template' => 'default',
            'status' => 'published',
            'show_in_menu' => true,
            'sort_order' => 1,
            'admin_id' => 1,
            'published_at' => now()
        ]);

        Page::create([
            'title' => 'Layanan Kami',
            'slug' => 'layanan-kami',
            'content' => '<h2>Layanan PPID</h2>
                <p>Berbagai layanan informasi publik yang tersedia...</p>',
            'excerpt' => 'Layanan informasi publik PPID',
            'template' => 'default',
            'status' => 'published',
            'show_in_menu' => true,
            'sort_order' => 2,
            'admin_id' => 1,
            'published_at' => now()
        ]);
    }
}
