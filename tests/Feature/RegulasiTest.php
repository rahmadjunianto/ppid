<?php

namespace Tests\Feature;

use App\Models\Regulasi;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegulasiTest extends TestCase
{
    use DatabaseTransactions;

    protected function admin(): User
    {
        $user = User::create([
            'name'     => 'Admin Test Regulasi',
            'email'    => 'admin.test.regulasi@example.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        return $user;
    }

    protected function regulasiPusat(): Regulasi
    {
        return Regulasi::create([
            'nama_regulasi' => 'UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik Uji',
            'nomor'         => 'UU No. 14/2008 UJI',
            'tingkat'       => 'pusat',
            'tahun'         => 2008,
            'link_type'     => 'link',
            'link_url'      => 'https://example.test/dokumen.pdf',
            'status'        => 'published',
            'sort_order'    => 1,
        ]);
    }

    protected function regulasiKankemenag(): Regulasi
    {
        return Regulasi::create([
            'nama_regulasi' => 'SK Kepala Kankemenag tentang Penetapan Pengelola PPID',
            'nomor'         => 'SK No. 12/2026',
            'tingkat'       => 'kankemenag',
            'tahun'         => 2026,
            'link_type'     => 'link',
            'link_url'      => 'https://example.test/sk.pdf',
            'status'        => 'published',
            'sort_order'    => 2,
        ]);
    }

    protected function regulasiBerkas(): Regulasi
    {
        Storage::disk('public')->put('regulasi/contoh.pdf', 'Isi dokumen regulasi contoh');

        return Regulasi::create([
            'nama_regulasi' => 'Peraturan MPZ Berkas',
            'nomor'         => 'MPZ-01/2026',
            'tingkat'       => 'kankemenag',
            'tahun'         => 2026,
            'link_type'     => 'file',
            'file'          => 'regulasi/contoh.pdf',
            'ukuran'        => 1024,
            'status'        => 'published',
        ]);
    }

    public function test_public_index_lists_published_regulasi(): void
    {
        $pusat = $this->regulasiPusat();

        $response = $this->get(route('regulasi.index'));

        $response->assertOk();
        $response->assertSee($pusat->nama_regulasi, false);
        $response->assertSee('Semua Regulasi', false);
        $response->assertSee('Tingkat Pusat', false);
        $response->assertSee('Tingkat Kankemenag', false);
    }

    public function test_draft_regulasi_is_hidden_from_public(): void
    {
        $draft = $this->regulasiPusat();
        $draft->update(['status' => 'draft']);

        $response = $this->get(route('regulasi.index'));

        $response->assertOk();
        $response->assertDontSee($draft->nama_regulasi, false);
    }

    public function test_tab_pusat_only_shows_pusat_regulasi(): void
    {
        $pusat      = $this->regulasiPusat();
        $kankemenag = $this->regulasiKankemenag();

        $response = $this->get(route('regulasi.index', ['tab' => 'pusat']));

        $response->assertOk();
        $response->assertSee($pusat->nama_regulasi, false);
        $response->assertDontSee($kankemenag->nama_regulasi, false);
    }

    public function test_tab_kankemenag_only_shows_kankemenag_regulasi(): void
    {
        $pusat      = $this->regulasiPusat();
        $kankemenag = $this->regulasiKankemenag();

        $response = $this->get(route('regulasi.index', ['tab' => 'kankemenag']));

        $response->assertOk();
        $response->assertSee($kankemenag->nama_regulasi, false);
        $response->assertDontSee($pusat->nama_regulasi, false);
    }

    public function test_invalid_tab_falls_back_to_semua(): void
    {
        $pusat = $this->regulasiPusat();

        $response = $this->get(route('regulasi.index', ['tab' => 'tidak-valid']));

        $response->assertOk();
        $response->assertSee($pusat->nama_regulasi, false);
    }

    public function test_search_filters_regulasi(): void
    {
        $pusat      = $this->regulasiPusat();
        $kankemenag = $this->regulasiKankemenag();

        $response = $this->get(route('regulasi.index', ['search' => 'Penetapan']));

        $response->assertOk();
        $response->assertSee($kankemenag->nama_regulasi, false);
        $response->assertDontSee($pusat->nama_regulasi, false);
    }

    public function test_link_route_redirects_to_external_url_and_increments_view_count(): void
    {
        $regulasi = $this->regulasiPusat();

        $this->assertSame(0, $regulasi->view_count);

        $response = $this->get(route('regulasi.link', $regulasi->id));

        $response->assertRedirect($regulasi->link_url);
        $this->assertSame(1, $regulasi->fresh()->view_count);
    }

    public function test_download_of_link_type_returns_not_found(): void
    {
        $regulasi = $this->regulasiPusat();

        $response = $this->get(route('regulasi.download', $regulasi->id));

        $response->assertNotFound();
        $this->assertSame(0, $regulasi->fresh()->view_count);
    }

    public function test_viewing_uploaded_file_increases_view_count(): void
    {
        $regulasi = $this->regulasiBerkas();

        $response = $this->get(route('regulasi.view', $regulasi->id));

        $response->assertOk();
        $this->assertSame(1, $regulasi->fresh()->view_count);
    }

    public function test_downloading_uploaded_file_returns_the_file(): void
    {
        $regulasi = $this->regulasiBerkas();

        $response = $this->get(route('regulasi.download', $regulasi->id));

        $response->assertOk();
        $this->assertSame(1, $regulasi->fresh()->view_count);
    }

    public function test_admin_routes_require_authentication(): void
    {
        $this->get(route('admin.regulasi.index'))->assertRedirect(route('login'));
    }

    public function test_admin_can_create_regulasi_with_uploaded_file(): void
    {
        $this->admin();

        Storage::fake('public');

        $response = $this->post(route('admin.regulasi.store'), [
            'nama_regulasi' => 'Peraturan Baru',
            'nomor'         => 'PN-01/2026',
            'tingkat'       => 'pusat',
            'tahun'         => 2026,
            'link_type'     => 'file',
            'file'          => UploadedFile::fake()->create('peraturan.pdf', 100, 'application/pdf'),
            'status'        => 'published',
            'sort_order'    => 0,
        ]);

        $response->assertRedirect(route('admin.regulasi.index'));

        $this->assertDatabaseHas('regulasi', [
            'nama_regulasi' => 'Peraturan Baru',
            'tingkat'       => 'pusat',
            'link_type'     => 'file',
        ]);
    }

    public function test_admin_can_create_regulasi_with_external_link(): void
    {
        $this->admin();

        $response = $this->post(route('admin.regulasi.store'), [
            'nama_regulasi' => 'Peraturan Tautan',
            'tingkat'       => 'kankemenag',
            'link_type'     => 'link',
            'link_url'      => 'https://example.test/peraturan.pdf',
            'status'        => 'published',
        ]);

        $response->assertRedirect(route('admin.regulasi.index'));

        $this->assertDatabaseHas('regulasi', [
            'nama_regulasi' => 'Peraturan Tautan',
            'link_type'     => 'link',
            'link_url'      => 'https://example.test/peraturan.pdf',
        ]);
    }

    public function test_store_requires_nama_regulasi(): void
    {
        $this->admin();

        $response = $this->post(route('admin.regulasi.store'), [
            'tingkat'   => 'pusat',
            'link_type' => 'link',
            'link_url'  => 'https://example.test/x.pdf',
            'status'    => 'published',
        ]);

        $response->assertSessionHasErrors('nama_regulasi');
    }

    public function test_store_rejects_invalid_tingkat(): void
    {
        $this->admin();

        $response = $this->post(route('admin.regulasi.store'), [
            'nama_regulasi' => 'Peraturan Tidak Valid',
            'tingkat'       => 'daerah',
            'link_type'     => 'link',
            'link_url'      => 'https://example.test/x.pdf',
            'status'        => 'published',
        ]);

        $response->assertSessionHasErrors('tingkat');
    }

    public function test_admin_can_update_regulasi(): void
    {
        $this->admin();

        $regulasi = $this->regulasiPusat();

        $response = $this->put(route('admin.regulasi.update', $regulasi->id), [
            'nama_regulasi' => 'UU No. 14 Tahun 2008 (Revisi)',
            'tingkat'       => 'pusat',
            'link_type'     => 'link',
            'link_url'      => 'https://example.test/revisi.pdf',
            'status'        => 'published',
        ]);

        $response->assertRedirect(route('admin.regulasi.index'));

        $this->assertDatabaseHas('regulasi', [
            'id'            => $regulasi->id,
            'nama_regulasi' => 'UU No. 14 Tahun 2008 (Revisi)',
        ]);
    }

    public function test_admin_can_delete_regulasi(): void
    {
        $this->admin();

        $regulasi = $this->regulasiPusat();

        $response = $this->delete(route('admin.regulasi.destroy', $regulasi->id));

        $response->assertRedirect(route('admin.regulasi.index'));
        $this->assertDatabaseMissing('regulasi', ['id' => $regulasi->id]);
    }

    public function test_admin_pages_render(): void
    {
        $this->admin();

        $regulasi = $this->regulasiPusat();

        $this->get(route('admin.regulasi.index'))->assertOk();
        $this->get(route('admin.regulasi.create'))->assertOk();
        $this->get(route('admin.regulasi.show', $regulasi->id))->assertOk();
        $this->get(route('admin.regulasi.edit', $regulasi->id))->assertOk();
    }

    public function test_admin_index_can_filter_by_tingkat(): void
    {
        $this->admin();

        $pusat      = $this->regulasiPusat();
        $kankemenag = $this->regulasiKankemenag();

        $response = $this->get(route('admin.regulasi.index', ['tingkat' => 'kankemenag']));

        $response->assertOk();
        $response->assertSee($kankemenag->nama_regulasi, false);
        $response->assertDontSee($pusat->nama_regulasi, false);
    }
}

