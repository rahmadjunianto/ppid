<?php

namespace Tests\Feature;

use App\Models\InformasiSetiapSaat;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class InformasiSetiapSaatTest extends TestCase
{
    use DatabaseTransactions;

    protected function admin(): User
    {
        $user = User::create([
            'name'     => 'Admin Test Informasi Setiap Saat',
            'email'    => 'admin.test.informasi.setiap.saat@example.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        return $user;
    }

    protected function item(string $judul = 'Dokumen Setiap Saat Uji', string $status = 'published'): InformasiSetiapSaat
    {
        return InformasiSetiapSaat::create([
            'judul'      => $judul,
            'slug'       => Str::slug($judul) . '-' . uniqid(),
            'link'       => 'https://example.test/dokumen.pdf',
            'link_type'  => 'external',
            'status'     => $status,
            'sort_order' => 1,
        ]);
    }

    /* ---------------------------------------------------------------------
     | Public
     | ------------------------------------------------------------------ */

    public function test_public_index_uses_same_header_structure_as_informasi_berkala(): void
    {
        $response = $this->get(route('informasi-setiap-saat.index'));

        $response->assertOk();

        // Breadcrumb inline (pola yang sama dengan /informasi-berkala)
        $response->assertSee('breadcrumb-page', false);
        $response->assertSee('Informasi Publik', false);
        $response->assertSee(url('/pustaka-dokumen'), false);
        $response->assertSee('Informasi Setiap Saat', false);

        // Judul + deskripsi pada baris header (compact)
        $response->assertSee('Informasi yang wajib tersedia dan dapat diakses oleh publik kapan saja', false);
        $response->assertSee('row mb-3 align-items-center', false);

        // Form pencarian pada kolom kanan
        $response->assertSee('name="search"', false);
        $response->assertSee('Cari informasi setiap saat...', false);
    }

    public function test_public_index_shows_only_published_items(): void
    {
        $published = $this->item('Setiap Saat Published Uji', 'published');
        $draft     = $this->item('Setiap Saat Draft Uji', 'draft');

        $response = $this->get(route('informasi-setiap-saat.index'));

        $response->assertOk();
        $response->assertSee($published->judul, false);
        $response->assertDontSee($draft->judul, false);
    }

    public function test_public_index_can_search_by_judul(): void
    {
        $cocok = $this->item('Pedoman Pengelolaan Keuangan 2026', 'published');
        $lain  = $this->item('Daftar Produk Hukum 2026', 'published');

        $response = $this->get(route('informasi-setiap-saat.index', ['search' => 'Keuangan']));

        $response->assertOk();
        $response->assertSee($cocok->judul, false);
        $response->assertDontSee($lain->judul, false);
    }

    public function test_public_index_shows_item_counter(): void
    {
        $this->item('Dokumen Penghitung Setiap Saat Uji', 'published');

        $total = InformasiSetiapSaat::published()->count();

        $response = $this->get(route('informasi-setiap-saat.index'));

        $response->assertOk();
        $response->assertSee('Menampilkan ' . $total . ' dari ' . $total . ' informasi setiap saat', false);
    }

    public function test_public_index_renders_item_without_link_as_plain_text(): void
    {
        $tanpaLink = InformasiSetiapSaat::create([
            'judul'      => 'Perjanjian dengan Pihak Ketiga',
            'slug'       => 'perjanjian-dengan-pihak-ketiga-' . uniqid(),
            'link'       => null,
            'link_type'  => 'internal',
            'status'     => 'published',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('informasi-setiap-saat.index'));

        $response->assertOk();
        $response->assertSee($tanpaLink->judul, false);
        $response->assertDontSee('href="' . route('informasi-setiap-saat.view', $tanpaLink->id) . '"', false);
    }

    public function test_public_view_and_download_reject_draft_item(): void
    {
        Storage::fake('public');

        $path = 'informasi-setiap-saat/rahasia.pdf';
        Storage::disk('public')->put($path, 'isi');

        $draft = InformasiSetiapSaat::create([
            'judul'      => 'Dokumen Draft Every Saat',
            'slug'       => 'dokumen-draft-every-saat-' . uniqid(),
            'file'       => $path,
            'ukuran'     => 3,
            'link_type'  => 'file',
            'status'     => 'draft',
            'sort_order' => 1,
        ]);

        $this->get(route('informasi-setiap-saat.view', $draft->id))->assertNotFound();
        $this->get(route('informasi-setiap-saat.download', $draft->id))->assertNotFound();
    }

    public function test_public_view_renders_published_item_with_file(): void
    {
        Storage::fake('public');

        $path = 'informasi-setiap-saat/publikasi.pdf';
        Storage::disk('public')->put($path, 'isi');

        $published = InformasiSetiapSaat::create([
            'judul'      => 'Dokumen Publik Setiap Saat',
            'slug'       => 'dokumen-publik-setiap-saat-' . uniqid(),
            'file'       => $path,
            'ukuran'     => 3,
            'link_type'  => 'file',
            'status'     => 'published',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('informasi-setiap-saat.view', $published->id));

        $response->assertOk();
        $response->assertSee($published->judul, false);
    }

    public function test_public_download_returns_file(): void
    {
        Storage::fake('public');

        $path = 'informasi-setiap-saat/unduhan.pdf';
        Storage::disk('public')->put($path, 'isi');

        $published = InformasiSetiapSaat::create([
            'judul'      => 'Dokumen Unduh Setiap Saat',
            'slug'       => 'dokumen-unduh-setiap-saat-' . uniqid(),
            'file'       => $path,
            'ukuran'     => 3,
            'link_type'  => 'file',
            'status'     => 'published',
            'sort_order' => 1,
        ]);

        $this->get(route('informasi-setiap-saat.download', $published->id))->assertOk();
    }

    /* ---------------------------------------------------------------------
     | Admin
     | ------------------------------------------------------------------ */

    public function test_admin_index_renders_filter_block(): void
    {
        $this->admin();
        $item = $this->item('Dokumen Admin Setiap Saat Uji', 'published');

        $response = $this->get(route('admin.informasi-setiap-saat.index'));

        $response->assertOk();
        $response->assertSee($item->judul, false);
        $response->assertSee('Cari informasi setiap saat...', false);
        $response->assertSee('Semua Tipe Link', false);
        $response->assertSee('Semua Status', false);
    }

    public function test_admin_index_can_search_by_judul(): void
    {
        $this->admin();
        $cocok = $this->item('Pedoman Pengelolaan Organisasi', 'published');
        $lain  = $this->item('Program Moderasi Beragama', 'published');

        $response = $this->get(route('admin.informasi-setiap-saat.index', ['search' => 'Pengelolaan']));

        $response->assertOk();
        $response->assertSee($cocok->judul, false);
        $response->assertDontSee($lain->judul, false);
    }

    public function test_admin_index_can_filter_by_status(): void
    {
        $this->admin();
        $published = $this->item('Item Admin Published', 'published');
        $draft     = $this->item('Item Admin Draft', 'draft');

        $response = $this->get(route('admin.informasi-setiap-saat.index', ['status' => 'draft']));

        $response->assertOk();
        $response->assertSee($draft->judul, false);
        $response->assertDontSee($published->judul, false);
    }

    public function test_admin_can_create_item_with_uploaded_file(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.informasi-setiap-saat.store'), [
            'judul'      => 'Pedoman Pengelolaan Administrasi Baru',
            'link_type'  => 'file',
            'file'       => UploadedFile::fake()->create('pedoman.pdf', 50, 'application/pdf'),
            'status'     => 'published',
            'sort_order' => 5,
        ]);

        $response->assertRedirect(route('admin.informasi-setiap-saat.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('informasi_setiap_saat', [
            'judul'  => 'Pedoman Pengelolaan Administrasi Baru',
            'status' => 'published',
        ]);

        $item = InformasiSetiapSaat::where('judul', 'Pedoman Pengelolaan Administrasi Baru')->first();
        $this->assertNotNull($item->file);
        Storage::disk('public')->assertExists($item->file);
    }

    public function test_admin_update_can_replace_file_and_delete_the_old_one(): void
    {
        $this->admin();
        Storage::fake('public');

        $oldPath = 'informasi-setiap-saat/lama.pdf';
        Storage::disk('public')->put($oldPath, 'lama');

        $item = InformasiSetiapSaat::create([
            'judul'      => 'Dokumen Ganti Uji',
            'slug'       => 'dokumen-ganti-uji-' . uniqid(),
            'file'       => $oldPath,
            'ukuran'     => 4,
            'link_type'  => 'file',
            'status'     => 'published',
            'sort_order' => 1,
        ]);

        $response = $this->put(route('admin.informasi-setiap-saat.update', $item), [
            'judul'      => 'Dokumen Ganti Uji',
            'link_type'  => 'file',
            'file'       => UploadedFile::fake()->create('baru.pdf', 60, 'application/pdf'),
            'status'     => 'published',
            'sort_order' => 1,
        ]);

        $response->assertRedirect(route('admin.informasi-setiap-saat.index'));

        $item->refresh();

        $this->assertNotSame($oldPath, $item->file);
        Storage::disk('public')->assertExists($item->file);
        Storage::disk('public')->assertMissing($oldPath);
    }

    public function test_admin_destroy_removes_item_and_its_file(): void
    {
        $this->admin();
        Storage::fake('public');

        $path = 'informasi-setiap-saat/hapus.pdf';
        Storage::disk('public')->put($path, 'isi');

        $item = InformasiSetiapSaat::create([
            'judul'      => 'Dokumen Hapus Uji',
            'slug'       => 'dokumen-hapus-uji-' . uniqid(),
            'file'       => $path,
            'ukuran'     => 3,
            'link_type'  => 'file',
            'status'     => 'published',
            'sort_order' => 1,
        ]);

        $response = $this->delete(route('admin.informasi-setiap-saat.destroy', $item));

        $response->assertRedirect(route('admin.informasi-setiap-saat.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('informasi_setiap_saat', ['id' => $item->id]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_admin_show_and_edit_pages_render(): void
    {
        $this->admin();
        $item = $this->item('Dokumen Detail Setiap Saat', 'published');

        $this->get(route('admin.informasi-setiap-saat.show', $item))->assertOk();
        $this->get(route('admin.informasi-setiap-saat.edit', $item))->assertOk();
        $this->get(route('admin.informasi-setiap-saat.create'))->assertOk();
    }
}


