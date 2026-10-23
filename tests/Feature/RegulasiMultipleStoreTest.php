<?php

namespace Tests\Feature;

use App\Models\Regulasi;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegulasiMultipleStoreTest extends TestCase
{
    use DatabaseTransactions;

    protected function admin(): User
    {
        $user = User::create([
            'name'     => 'Admin Test Regulasi Multi',
            'email'    => 'admin.test.regulasi.multi@example.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        return $user;
    }

    public function test_create_page_renders_multiple_rows(): void
    {
        $this->admin();

        $response = $this->get(route('admin.regulasi.create', ['jumlah' => 5]));

        $response->assertOk();
        $response->assertSee('name="items[0][nama_regulasi]"', false);
        $response->assertSee('name="items[4][nama_regulasi]"', false);
        $response->assertSee('id="btn-add-row"', false);
        $response->assertSee('id="regulasi-row-template"', false);
    }

    public function test_create_page_defaults_to_single_row(): void
    {
        $this->admin();

        $response = $this->get(route('admin.regulasi.create'));

        $response->assertOk();
        $response->assertSee('name="items[0][nama_regulasi]"', false);
        $response->assertDontSee('name="items[1][nama_regulasi]"', false);
    }

    public function test_create_page_contains_javascript_row_template(): void
    {
        $this->admin();

        $response = $this->get(route('admin.regulasi.create', ['jumlah' => 3]));

        $response->assertOk();
        $response->assertSee('name="items[__INDEX__][nama_regulasi]"', false);
        $response->assertSee('id="btn-add-5-rows"', false);
        $response->assertSee('btn-remove-row', false);
    }

    public function test_index_page_shows_tambah_banyak_button(): void
    {
        $this->admin();

        $response = $this->get(route('admin.regulasi.index'));

        $response->assertOk();
        $response->assertSee('Tambah Banyak', false);
        $response->assertSee(route('admin.regulasi.create', ['jumlah' => 5]), false);
    }

    public function test_store_creates_multiple_regulasi_from_one_request(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.regulasi.store'), [
            'items' => [
                0 => [
                    'nama_regulasi' => 'UU No. 14 Tahun 2008',
                    'nomor'         => 'UU No. 14/2008',
                    'tingkat'       => 'pusat',
                    'tahun'         => 2008,
                    'link_type'     => 'file',
                    'file'          => UploadedFile::fake()->create('regulasi-1.pdf', 100, 'application/pdf'),
                    'status'        => 'published',
                    'sort_order'    => 1,
                ],
                1 => [
                    'nama_regulasi' => 'SK Kepala Kankemenag',
                    'nomor'         => 'SK No. 12/2026',
                    'tingkat'       => 'kankemenag',
                    'tahun'         => 2026,
                    'link_type'     => 'link',
                    'link_url'      => 'https://example.test/sk.pdf',
                    'status'        => 'draft',
                    'sort_order'    => 2,
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.regulasi.index'));
        $response->assertSessionHas('success');

        $this->assertSame(1, Regulasi::where('nama_regulasi', 'UU No. 14 Tahun 2008')->count());
        $this->assertSame(1, Regulasi::where('nama_regulasi', 'SK Kepala Kankemenag')->count());

        $fileRegulasi = Regulasi::where('nama_regulasi', 'UU No. 14 Tahun 2008')->first();
        $this->assertNotNull($fileRegulasi);
        $this->assertSame('file', $fileRegulasi->link_type);
        Storage::disk('public')->assertExists($fileRegulasi->file);

        $linkRegulasi = Regulasi::where('nama_regulasi', 'SK Kepala Kankemenag')->first();
        $this->assertNotNull($linkRegulasi);
        $this->assertSame('link', $linkRegulasi->link_type);
        $this->assertSame('https://example.test/sk.pdf', $linkRegulasi->link_url);
        $this->assertNull($linkRegulasi->file);
    }

    public function test_blank_rows_are_ignored(): void
    {
        $this->admin();
        Storage::fake('public');

        $before = Regulasi::count();

        $response = $this->post(route('admin.regulasi.store'), [
            'items' => [
                0 => [
                    'nama_regulasi' => 'Regulasi Valid',
                    'tingkat'       => 'pusat',
                    'tahun'         => 2026,
                    'link_type'     => 'link',
                    'link_url'      => 'https://example.test/valid.pdf',
                    'status'        => 'published',
                ],
                1 => [
                    'nama_regulasi' => '',
                    'tingkat'       => '',
                    'tahun'         => '',
                    'link_type'     => '',
                    'link_url'      => '',
                    'status'        => '',
                    'file'          => '',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.regulasi.index'));
        $response->assertSessionHas('success');

        $this->assertSame(1, Regulasi::where('nama_regulasi', 'Regulasi Valid')->count());
        $this->assertSame($before + 1, Regulasi::count());
    }

    public function test_all_blank_rows_returns_error(): void
    {
        $this->admin();
        Storage::fake('public');

        $before = Regulasi::count();

        $response = $this->post(route('admin.regulasi.store'), [
            'items' => [
                0 => [
                    'nama_regulasi' => '',
                    'tingkat'       => 'pusat',
                    'link_type'     => 'link',
                    'link_url'      => '',
                    'status'        => 'published',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.regulasi.create'));
        $response->assertSessionHasErrors('items');
        $this->assertSame($before, Regulasi::count());
    }

    public function test_file_is_required_when_link_type_is_file(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.regulasi.store'), [
            'items' => [
                0 => [
                    'nama_regulasi' => 'Tanpa File',
                    'tingkat'       => 'pusat',
                    'tahun'         => 2026,
                    'link_type'     => 'file',
                    'status'        => 'published',
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items.0.file');
        $this->assertSame(0, Regulasi::where('nama_regulasi', 'Tanpa File')->count());
    }

    public function test_link_url_is_required_when_link_type_is_link(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.regulasi.store'), [
            'items' => [
                0 => [
                    'nama_regulasi' => 'Tanpa Link',
                    'tingkat'       => 'pusat',
                    'tahun'         => 2026,
                    'link_type'     => 'link',
                    'status'        => 'published',
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items.0.link_url');
        $this->assertSame(0, Regulasi::where('nama_regulasi', 'Tanpa Link')->count());
    }

    public function test_nama_regulasi_is_required_for_each_row(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.regulasi.store'), [
            'items' => [
                0 => [
                    'nama_regulasi' => 'Sah',
                    'tingkat'       => 'pusat',
                    'link_type'     => 'link',
                    'link_url'      => 'https://example.test/sah.pdf',
                    'status'        => 'published',
                ],
                1 => [
                    'nama_regulasi' => '',
                    'tingkat'       => 'pusat',
                    'link_type'     => 'link',
                    'link_url'      => 'https://example.test/kosong.pdf',
                    'status'        => 'published',
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items.1.nama_regulasi');
        $this->assertSame(0, Regulasi::where('nama_regulasi', 'Sah')->count());
    }

    public function test_invalid_tingkat_is_rejected_per_row(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.regulasi.store'), [
            'items' => [
                0 => [
                    'nama_regulasi' => 'Tingkat Tidak Valid',
                    'tingkat'       => 'daerah',
                    'link_type'     => 'link',
                    'link_url'      => 'https://example.test/x.pdf',
                    'status'        => 'published',
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items.0.tingkat');
        $this->assertSame(0, Regulasi::where('nama_regulasi', 'Tingkat Tidak Valid')->count());
    }

    public function test_single_regulasi_flow_still_works(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.regulasi.store'), [
            'nama_regulasi' => 'Regulasi Tunggal',
            'nomor'         => 'UU No. 14/2008',
            'tingkat'       => 'pusat',
            'tahun'         => 2008,
            'link_type'     => 'file',
            'file'          => UploadedFile::fake()->create('tunggal.pdf', 20, 'application/pdf'),
            'status'        => 'published',
        ]);

        $response->assertRedirect(route('admin.regulasi.index'));
        $response->assertSessionHas('success');

        $regulasi = Regulasi::where('nama_regulasi', 'Regulasi Tunggal')->first();

        $this->assertNotNull($regulasi);
        Storage::disk('public')->assertExists($regulasi->file);
    }
}
