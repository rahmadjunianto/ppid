<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Pengujian halaman /berita yang sumber datanya diambil dari tabel `posts`
 * pada koneksi database portal (`mysql_portal`).
 */
class BeritaPortalPostsTest extends TestCase
{
    public function test_model_berita_menggunakan_tabel_posts_pada_koneksi_portal(): void
    {
        $berita = new Berita();

        $this->assertSame('mysql_portal', $berita->getConnectionName());
        $this->assertSame('posts', $berita->getTable());
        $this->assertSame('id', $berita->getKeyName());
    }

    public function test_halaman_berita_menampilkan_data_dari_tabel_posts(): void
    {
        $post = Berita::published()->orderBy('published_at', 'desc')->first();

        $this->assertNotNull($post, 'Tidak ada berita published pada database portal.');

        $response = $this->get('/berita');

        $response->assertOk();
        $response->assertSee(Str::limit($post->title, 60));
        $response->assertSee(route('berita.show', $post->slug), false);
    }

    public function test_filter_kategori_menyaring_berita(): void
    {
        $kategori = Kategori::whereHas('berita', function ($query) {
            $query->published();
        })->first();

        $this->assertNotNull($kategori, 'Tidak ada kategori yang memiliki berita published.');

        $post = Berita::published()
            ->where('category_id', $kategori->id)
            ->orderBy('published_at', 'desc')
            ->first();

        $response = $this->get('/berita?kategori=' . $kategori->id);

        $response->assertOk();
        $response->assertSee(Str::limit($post->title, 60));
        $response->assertSee('value="' . $kategori->id . '"', false);
        $response->assertSee('selected', false);
    }

    public function test_pencarian_berita_berfungsi(): void
    {
        $post = Berita::published()->orderBy('published_at', 'desc')->first();
        $keyword = Str::before($post->title, ' ');

        $response = $this->get('/berita?q=' . urlencode($keyword));

        $response->assertOk();
        $response->assertSee(Str::limit($post->title, 60));
    }

    public function test_halaman_detail_berita_menampilkan_isi_dan_menaikkan_jumlah_dibaca(): void
    {
        $post = Berita::published()->orderBy('published_at', 'desc')->first();
        $viewsBefore = $post->views;

        DB::connection('mysql_portal')->beginTransaction();

        try {
            $response = $this->get('/berita/' . $post->slug);

            $response->assertOk();
            $response->assertSee($post->title);
            $response->assertSee($post->published_at->format('d F Y'));

            $this->assertSame(
                $viewsBefore + 1,
                Berita::where('id', $post->id)->value('views')
            );
        } finally {
            DB::connection('mysql_portal')->rollBack();
        }
    }

    public function test_berita_dengan_slug_tidak_ditemukan_menghasilkan_404(): void
    {
        $response = $this->get('/berita/slug-yang-tidak-ditemukan-12345');

        $response->assertNotFound();
    }

    public function test_endpoint_berita_terbaru_mengembalikan_data_posts(): void
    {
        $response = $this->getJson('/berita/latest/5');

        $response->assertOk();
        $response->assertJsonPath('status', 'success');

        $data = $response->json('data');
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('slug', $data[0]);
        $this->assertArrayHasKey('title', $data[0]);
    }
}
