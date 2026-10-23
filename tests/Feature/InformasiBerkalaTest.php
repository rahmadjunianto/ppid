<?php

namespace Tests\Feature;

use App\Models\InformasiBerkala;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class InformasiBerkalaTest extends TestCase
{
    use DatabaseTransactions;

    protected function admin(): User
    {
        $user = User::create([
            'name'     => 'Admin Test Informasi Berkala',
            'email'    => 'admin.test.informasi.berkala@example.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        return $user;
    }

    protected function item(string $kategori = 'A', string $judul = 'Dokumen Berkala Uji', string $status = 'published'): InformasiBerkala
    {
        return InformasiBerkala::create([
            'kategori'   => $kategori,
            'judul'      => $judul,
            'slug'       => Str::slug($judul) . '-' . uniqid(),
            'link'       => 'https://example.test/dokumen.pdf',
            'link_type'  => 'external',
            'status'     => $status,
            'sort_order' => 1,
        ]);
    }

    public function test_public_index_uses_same_header_structure_as_regulasi(): void
    {
        $response = $this->get(route('informasi-berkala.index'));

        $response->assertOk();

        // Breadcrumb inline (pola yang sama dengan /regulasi)
        $response->assertSee('breadcrumb-page', false);
        $response->assertSee('Informasi Publik', false);
        $response->assertSee(url('/pustaka-dokumen'), false);
        $response->assertSee('Informasi Berkala', false);

        // Judul + deskripsi pada baris header (compact)
        $response->assertSee('Informasi yang wajib tersedia setiap saat', false);
        $response->assertSee('row mb-3 align-items-center', false);

        // Form pencarian pada kolom kanan
        $response->assertSee('name="search"', false);
        $response->assertSee('Cari informasi berkala...', false);

        // Filter kategori memakai select option (bukan baris tombol)
        $response->assertSee('<select name="kategori"', false);
        $response->assertSee('Semua Kategori', false);
        $response->assertSee('Profil Kementerian Agama', false);
        $response->assertDontSee('bi-folder2', false);
    }

    public function test_public_index_shows_only_published_items(): void
    {
        $published = $this->item('A', 'Berkala Published Uji', 'published');
        $draft     = $this->item('B', 'Berkala Draft Uji', 'draft');

        $response = $this->get(route('informasi-berkala.index'));

        $response->assertOk();
        $response->assertSee($published->judul, false);
        $response->assertDontSee($draft->judul, false);
    }

    public function test_public_index_can_search_by_judul(): void
    {
        $cocok = $this->item('A', 'Laporan Anggaran 2026', 'published');
        $lain  = $this->item('B', 'Daftar Pegawai 2026', 'published');

        $response = $this->get(route('informasi-berkala.index', ['search' => 'Anggaran']));

        $response->assertOk();
        $response->assertSee($cocok->judul, false);
        $response->assertDontSee($lain->judul, false);
    }

    public function test_public_index_can_filter_by_kategori(): void
    {
        $kategoriA = $this->item('A', 'Dokumen Kategori Alpha', 'published');
        $kategoriB = $this->item('B', 'Dokumen Kategori Bravo', 'published');

        $response = $this->get(route('informasi-berkala.index', ['kategori' => 'B']));

        $response->assertOk();
        $response->assertSee($kategoriB->judul, false);
        $response->assertDontSee($kategoriA->judul, false);
    }

    public function test_public_index_shows_item_counter(): void
    {
        $this->item('A', 'Dokumen Penghitung Uji', 'published');

        $total = InformasiBerkala::published()->count();

        $response = $this->get(route('informasi-berkala.index'));

        $response->assertOk();
        $response->assertSee('Menampilkan ' . $total . ' dari ' . $total . ' informasi berkala', false);
    }

    public function test_public_index_counter_reflects_selected_kategori(): void
    {
        $this->item('C', 'Dokumen Kategori Charlie', 'published');

        $total        = InformasiBerkala::published()->count();
        $jumlahKategori = InformasiBerkala::published()->where('kategori', 'C')->count();

        $response = $this->get(route('informasi-berkala.index', ['kategori' => 'C']));

        $response->assertOk();
        $response->assertSee('Menampilkan ' . $jumlahKategori . ' dari ' . $total . ' informasi berkala', false);
    }

    public function test_public_index_counter_reflects_search_result(): void
    {
        $this->item('A', 'Dokumen Pencarian Khusus', 'published');

        $total       = InformasiBerkala::published()->count();
        $jumlahHasil = InformasiBerkala::published()->where('judul', 'like', '%Pencarian Khusus%')->count();

        $response = $this->get(route('informasi-berkala.index', ['search' => 'Pencarian Khusus']));

        $response->assertOk();
        $response->assertSee('Menampilkan ' . $jumlahHasil . ' dari ' . $total . ' informasi berkala', false);
    }

    public function test_admin_index_renders_filter_block_like_regulasi(): void
    {
        $this->admin();
        $item = $this->item('A', 'Dokumen Admin Berkala Uji', 'published');

        $response = $this->get(route('admin.informasi-berkala.index'));

        $response->assertOk();
        $response->assertSee($item->judul, false);
        $response->assertSee('Cari informasi berkala...', false);
        $response->assertSee('Semua Kategori', false);
        $response->assertSee('Semua Status', false);
    }

    public function test_admin_index_can_filter_by_kategori(): void
    {
        $this->admin();
        $kategoriA = $this->item('A', 'Admin Kategori Alpha', 'published');
        $kategoriB = $this->item('B', 'Admin Kategori Bravo', 'published');

        $response = $this->get(route('admin.informasi-berkala.index', ['kategori' => 'B']));

        $response->assertOk();
        $response->assertSee($kategoriB->judul, false);
        $response->assertDontSee($kategoriA->judul, false);
    }
}
