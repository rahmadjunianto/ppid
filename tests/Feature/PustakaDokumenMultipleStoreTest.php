<?php

namespace Tests\Feature;

use App\Models\GrupDokumen;
use App\Models\PustakaDokumen;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PustakaDokumenMultipleStoreTest extends TestCase
{
    use DatabaseTransactions;

    protected function admin(): User
    {
        $user = User::create([
            'name'     => 'Admin Test Pustaka',
            'email'    => 'admin.test.pustaka@example.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        return $user;
    }

    protected function grup(): GrupDokumen
    {
        return GrupDokumen::create([
            'nama_grup'  => 'Grup Dokumen Test',
            'deskripsi'  => 'Grup untuk pengujian otomatis',
            'sort_order' => 1,
            'is_active'  => true,
        ]);
    }

    public function test_create_page_renders_multiple_rows(): void
    {
        $this->admin();

        $response = $this->get(route('admin.pustaka-dokumens.create', ['jumlah' => 5]));

        $response->assertOk();
        $response->assertSee('name="items[0][nama_dokumen]"', false);
        $response->assertSee('name="items[4][nama_dokumen]"', false);
        $response->assertSee('id="btn-add-row"', false);
        $response->assertSee('id="pustaka-row-template"', false);
    }

    public function test_create_page_defaults_to_single_row(): void
    {
        $this->admin();

        $response = $this->get(route('admin.pustaka-dokumens.create'));

        $response->assertOk();
        $response->assertSee('name="items[0][nama_dokumen]"', false);
        $response->assertDontSee('name="items[1][nama_dokumen]"', false);
    }

    public function test_create_page_contains_javascript_row_template(): void
    {
        $this->admin();

        $response = $this->get(route('admin.pustaka-dokumens.create', ['jumlah' => 3]));

        $response->assertOk();
        $response->assertSee('name="items[__INDEX__][nama_dokumen]"', false);
        $response->assertSee('id="btn-add-5-rows"', false);
        $response->assertSee('btn-remove-row', false);
    }

    public function test_index_page_shows_tambah_banyak_button(): void
    {
        $this->admin();

        $response = $this->get(route('admin.pustaka-dokumens.index'));

        $response->assertOk();
        $response->assertSee('Tambah Banyak', false);
        $response->assertSee(route('admin.pustaka-dokumens.create', ['jumlah' => 5]), false);
    }

    public function test_store_creates_multiple_documents_from_one_request(): void
    {
        $this->admin();
        $grup = $this->grup();
        Storage::fake('public');

        $response = $this->post(route('admin.pustaka-dokumens.store'), [
            'items' => [
                0 => [
                    'grup_dokumen_id' => $grup->id,
                    'nama_dokumen'    => 'Dokumen Pertama',
                    'deskripsi'       => 'Dokumen pertama',
                    'nomor'           => '001/INFO/2026',
                    'tahun'           => 2026,
                    'link_type'       => 'file',
                    'file'            => UploadedFile::fake()->create('dokumen-1.pdf', 100, 'application/pdf'),
                ],
                1 => [
                    'grup_dokumen_id' => $grup->id,
                    'nama_dokumen'    => 'Dokumen Kedua',
                    'deskripsi'       => 'Dokumen kedua',
                    'nomor'           => '002/INFO/2026',
                    'tahun'           => 2026,
                    'link_type'       => 'link',
                    'link_url'        => 'https://example.com/dokumen-2.pdf',
                ],
            ],
        ]);
        $response->assertRedirect(route('admin.pustaka-dokumens.index'));
        $response->assertSessionHas('success');

        $this->assertSame(1, PustakaDokumen::where('nama_dokumen', 'Dokumen Pertama')->count());
        $this->assertSame(1, PustakaDokumen::where('nama_dokumen', 'Dokumen Kedua')->count());

        $fileDoc = PustakaDokumen::where('nama_dokumen', 'Dokumen Pertama')->first();
        $this->assertSame('file', $fileDoc->link_type);
        $this->assertNotNull($fileDoc->file);
        $this->assertSame('100.00 KB', $fileDoc->ukuran);
        Storage::disk('public')->assertExists($fileDoc->file);

        $linkDoc = PustakaDokumen::where('nama_dokumen', 'Dokumen Kedua')->first();
        $this->assertSame('link', $linkDoc->link_type);
        $this->assertSame('https://example.com/dokumen-2.pdf', $linkDoc->link_url);
        $this->assertNull($linkDoc->file);
    }



    public function test_blank_rows_are_ignored(): void
    {
        $this->admin();
        $grup = $this->grup();
        Storage::fake('public');

        $response = $this->post(route('admin.pustaka-dokumens.store'), [
            'items' => [
                0 => [
                    'grup_dokumen_id' => $grup->id,
                    'nama_dokumen'    => 'Dokumen Valid',
                    'tahun'           => 2026,
                    'link_type'       => 'file',
                    'file'            => UploadedFile::fake()->create('ok.pdf', 50, 'application/pdf'),
                ],
                1 => [
                    'grup_dokumen_id' => '',
                    'nama_dokumen'    => '',
                    'nomor'           => '',
                    'tahun'           => '',
                    'link_type'       => 'file',
                    'link_url'        => '',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.pustaka-dokumens.index'));
        $response->assertSessionHas('success');

        $this->assertSame(1, PustakaDokumen::where('nama_dokumen', 'Dokumen Valid')->count());
        $this->assertSame(0, PustakaDokumen::where('nama_dokumen', '')->count());
    }

    public function test_file_is_required_when_link_type_is_file(): void
    {
        $this->admin();
        $grup = $this->grup();
        Storage::fake('public');

        $response = $this->post(route('admin.pustaka-dokumens.store'), [
            'items' => [
                0 => [
                    'grup_dokumen_id' => $grup->id,
                    'nama_dokumen'    => 'Tanpa File',
                    'tahun'           => 2026,
                    'link_type'       => 'file',
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items.0.file');
        $this->assertSame(0, PustakaDokumen::where('nama_dokumen', 'Tanpa File')->count());
    }

    public function test_link_url_is_required_when_link_type_is_link(): void
    {
        $this->admin();
        $grup = $this->grup();
        Storage::fake('public');

        $response = $this->post(route('admin.pustaka-dokumens.store'), [
            'items' => [
                0 => [
                    'grup_dokumen_id' => $grup->id,
                    'nama_dokumen'    => 'Tanpa Link',
                    'tahun'           => 2026,
                    'link_type'       => 'link',
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items.0.link_url');
        $this->assertSame(0, PustakaDokumen::where('nama_dokumen', 'Tanpa Link')->count());
    }

    public function test_nama_dokumen_is_required_for_each_row(): void
    {
        $this->admin();
        $grup = $this->grup();
        Storage::fake('public');

        $response = $this->post(route('admin.pustaka-dokumens.store'), [
            'items' => [
                0 => [
                    'grup_dokumen_id' => $grup->id,
                    'nama_dokumen'    => 'Sah',
                    'tahun'           => 2026,
                    'link_type'       => 'link',
                    'link_url'        => 'https://example.com/sah.pdf',
                ],
                1 => [
                    'grup_dokumen_id' => $grup->id,
                    'nama_dokumen'    => '',
                    'tahun'           => 2026,
                    'link_type'       => 'link',
                    'link_url'        => 'https://example.com/kosong.pdf',
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items.1.nama_dokumen');
        $this->assertSame(0, PustakaDokumen::where('nama_dokumen', 'Sah')->count());
    }

    public function test_single_document_flow_still_works(): void
    {
        $this->admin();
        $grup = $this->grup();
        Storage::fake('public');

        $response = $this->post(route('admin.pustaka-dokumens.store'), [
            'grup_dokumen_id' => $grup->id,
            'nama_dokumen'    => 'Dokumen Tunggal',
            'nomor'           => '003/INFO/2026',
            'tahun'           => 2026,
            'link_type'       => 'file',
            'file'            => UploadedFile::fake()->create('tunggal.pdf', 20, 'application/pdf'),
        ]);

        $response->assertRedirect(route('admin.pustaka-dokumens.index'));
        $response->assertSessionHas('success');

        $dokumen = PustakaDokumen::where('nama_dokumen', 'Dokumen Tunggal')->first();

        $this->assertNotNull($dokumen);
        Storage::disk('public')->assertExists($dokumen->file);
    }
}
