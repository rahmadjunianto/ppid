<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Portal (kemenag) source
    |--------------------------------------------------------------------------
    |
    | Konfigurasi sumber data portal Kementerian Agama Kabupaten Nganjuk.
    | Data berita pada halaman /berita diambil dari tabel `posts` pada
    | koneksi `mysql_portal` (database portal_v2).
    |
    */

    'url' => env('PORTAL_URL', 'https://kemenagnganjuk.id'),

    /*
    |--------------------------------------------------------------------------
    | Portal media URL
    |--------------------------------------------------------------------------
    |
    | Base URL folder storage publik portal, dipakai untuk menampilkan
    | gambar berita (contoh: https://kemenagnganjuk.id/storage/posts/...).
    |
    */

    'media_url' => env(
        'PORTAL_MEDIA_URL',
        rtrim(env('PORTAL_URL', 'https://kemenagnganjuk.id'), '/') . '/storage'
    ),

];
