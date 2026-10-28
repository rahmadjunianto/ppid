<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Halaman "/informasi-setiap-saat" kini ditangani oleh modul
     * InformasiSetiapSaat (tabel informasi_setiap_saat) melalui route
     * publik informasi-setiap-saat.*.
     *
     * CMS page lama (slug: informasi-setiap-saat) di-arsipkan supaya:
     * - tidak lagi tayang duplikat di halaman publik,
     * - tidak muncul di sitemap / pencarian halaman,
     * - datanya tetap tersimpan di tabel pages sebagai referensi.
     */
    public function up(): void
    {
        DB::table('pages')
            ->where('slug', 'informasi-setiap-saat')
            ->update([
                'status' => 'archived',
                'show_in_menu' => false,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('pages')
            ->where('slug', 'informasi-setiap-saat')
            ->update([
                'status' => 'published',
                'show_in_menu' => true,
                'updated_at' => now(),
            ]);
    }
};
