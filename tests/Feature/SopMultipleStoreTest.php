<?php

namespace Tests\Feature;

use App\Models\Sop;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SopMultipleStoreTest extends TestCase
{
    use DatabaseTransactions;

    protected function admin(): User
    {
        $user = User::create([
            'name'     => 'Admin Test SOP',
            'email'    => 'admin.test.sop@example.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        return $user;
    }

    public function test_create_page_renders_multiple_rows(): void
    {
        $this->admin();

        $response = $this->get(route('admin.sops.create', ['jumlah' => 5]));

        $response->assertOk();
        $response->assertSee('name="items[0][nama_dokumen]"', false);
        $response->assertSee('name="items[4][nama_dokumen]"', false);
        $response->assertSee('id="btn-add-row"', false);
        $response->assertSee('id="sop-row-template"', false);
    }

    public function test_store_creates_multiple_sops_from_one_request(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.sops.store'), [
            'items' => [
                0 => [
                    'nama_dokumen' => 'SOP Barang/Jasa',
                    'nomor'        => 'SOP-001/2026',
                    'grup'         => 'SOP PPID',
                    'tahun'        => 2026,
                    'status'       => 'published',
                    'sort_order'   => 1,
                    'file'         => UploadedFile::fake()->create('sop-1.pdf', 100, 'application/pdf'),
                ],
                1 => [
                    'nama_dokumen' => 'SOP purposely broken',
                    'nomor'        => 'SOP-002/2026',
                    'grup'         => 'Bimas',
                    'tahun'        => 2026,
                    'status'       => 'draft',
                    'sort_order'   => 2,
                    'file'         => UploadedFile::fake()->create('sop-2.pdf', 100, 'application/pdf'),
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.sops.index'));
        $response->assertSessionHas('success');

        $this->assertSame(1, Sop::where('nama_dokumen', 'SOP Barang/Jasa')->count());
        $this->assertSame(1, Sop::where('nama_dokumen', 'SOP purposely broken')->count());

        Storage::disk('public')->assertExists(Sop::where('nama_dokumen', 'SOP Barang/Jasa')->first()->file);
    }

    public function test_blank_rows_are_ignored(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.sops.store'), [
            'items' => [
                0 => [
                    'nama_dokumen' => 'SOP Valid',
                    'grup'         => 'Pais',
                    'tahun'        => 2026,
                    'status'       => 'published',
                    'file'         => UploadedFile::fake()->create('ok.pdf', 50, 'application/pdf'),
                ],
                1 => [
                    'nama_dokumen' => '',
                    'grup'         => '',
                    'tahun'        => '',
                    'status'       => '',
                    'file'         => '',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.sops.index'));
        $response->assertSessionHasNoErrors();

        $this->assertSame(1, Sop::where('nama_dokumen', 'SOP Valid')->count());
    }

    public function test_validation_error_points_to_the_failing_row(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.sops.store'), [
            'items' => [
                0 => [
                    'nama_dokumen' => 'SOP Tanpa File',
                    'grup'         => 'Pendma',
                    'tahun'        => 2026,
                    'status'       => 'published',
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items.0.file');
    }

    public function test_single_mode_still_works(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.sops.store'), [
            'nama_dokumen' => 'SOP Tunggal',
            'grup'         => 'SOP PPID',
            'tahun'        => 2026,
            'status'       => 'published',
            'sort_order'   => 0,
            'file'         => UploadedFile::fake()->create('single.pdf', 50, 'application/pdf'),
        ]);

        $response->assertRedirect(route('admin.sops.index'));
        $response->assertSessionHasNoErrors();

        $this->assertSame(1, Sop::where('nama_dokumen', 'SOP Tunggal')->count());
    }

    public function test_penzawa_group_is_accepted_and_labeled(): void
    {
        $this->admin();
        Storage::fake('public');

        $response = $this->post(route('admin.sops.store'), [
            'nama_dokumen' => 'SOP Penzawa',
            'grup'         => 'Penzawa',
            'tahun'        => 2026,
            'status'       => 'published',
            'sort_order'   => 0,
            'file'         => UploadedFile::fake()->create('penzawa.pdf', 50, 'application/pdf'),
        ]);

        $response->assertRedirect(route('admin.sops.index'));
        $response->assertSessionHasNoErrors();

        $sop = Sop::where('nama_dokumen', 'SOP Penzawa')->first();

        $this->assertNotNull($sop);
        $this->assertSame('Penzawa', $sop->grup);
        $this->assertSame('Penyelenggara Zakat Wakaf', $sop->grup_label);
    }

    public function test_penzawa_group_is_available_in_admin_form(): void
    {
        $this->admin();

        $response = $this->get(route('admin.sops.create'));

        $response->assertOk();
        $response->assertSee('value="Penzawa"', false);
        $response->assertSee('Penyelenggara Zakat Wakaf');
    }

    public function test_penzawa_public_tab_lists_published_sop(): void
    {
        $this->admin();
        Storage::fake('public');

        $this->post(route('admin.sops.store'), [
            'nama_dokumen' => 'SOP Public Penzawa',
            'grup'         => 'Penzawa',
            'tahun'        => 2026,
            'status'       => 'published',
            'sort_order'   => 0,
            'file'         => UploadedFile::fake()->create('penzawa-public.pdf', 50, 'application/pdf'),
        ]);

        $response = $this->get('/sop?tab=penzawa');

        $response->assertOk();
        $response->assertSee('SOP Public Penzawa');
    }

    public function test_unit_kerja_tab_lists_all_non_ppid_groups(): void
    {
        Storage::fake('public');

        foreach ([
            'SOP PPID'   => 'Dokumen Milik PPID',
            'Bimas'      => 'Dokumen Milik Bimas',
            'Pais'       => 'Dokumen Milik Pais',
            'Pendma'     => 'Dokumen Milik Pendma',
            'Penzawa'    => 'Dokumen Milik Penzawa',
            'Sub Bag TU' => 'Dokumen Milik Sub Bag TU',
            'PD Pontren' => 'Dokumen Milik PD Pontren',
        ] as $grup => $nama) {
            Sop::create([
                'nama_dokumen' => $nama,
                'grup'         => $grup,
                'tahun'        => 2026,
                'status'       => 'published',
                'sort_order'   => 0,
            ]);
        }

        $response = $this->get('/sop?tab=unit_kerja');

        $response->assertOk();
        $response->assertSee('Dokumen Milik Bimas');
        $response->assertSee('Dokumen Milik Pais');
        $response->assertSee('Dokumen Milik Pendma');
        $response->assertSee('Dokumen Milik Penzawa');
        $response->assertSee('Dokumen Milik Sub Bag TU');
        $response->assertSee('Dokumen Milik PD Pontren');
        $response->assertDontSee('Dokumen Milik PPID');
    }

    public function test_ppid_tab_only_lists_ppid_documents(): void
    {
        Storage::fake('public');

        Sop::create([
            'nama_dokumen' => 'Dokumen Milik PPID',
            'grup'         => 'SOP PPID',
            'tahun'        => 2026,
            'status'       => 'published',
            'sort_order'   => 0,
        ]);
        Sop::create([
            'nama_dokumen' => 'Dokumen Milik Bimas',
            'grup'         => 'Bimas',
            'tahun'        => 2026,
            'status'       => 'published',
            'sort_order'   => 0,
        ]);

        $response = $this->get('/sop?tab=ppid');

        $response->assertOk();
        $response->assertSee('Dokumen Milik PPID');
        $response->assertDontSee('Dokumen Milik Bimas');
    }

    public function test_unit_kerja_tab_can_filter_by_grup(): void
    {
        Storage::fake('public');

        Sop::create([
            'nama_dokumen' => 'Dokumen Milik Bimas',
            'grup'         => 'Bimas',
            'tahun'        => 2026,
            'status'       => 'published',
            'sort_order'   => 0,
        ]);
        Sop::create([
            'nama_dokumen' => 'Dokumen Milik Pais',
            'grup'         => 'Pais',
            'tahun'        => 2026,
            'status'       => 'published',
            'sort_order'   => 0,
        ]);

        $response = $this->get('/sop?tab=unit_kerja&grup=Bimas');

        $response->assertOk();
        $response->assertSee('Dokumen Milik Bimas');
        $response->assertDontSee('Dokumen Milik Pais');
    }

    public function test_legacy_unit_tab_redirects_to_merged_tab_with_filter(): void
    {
        Storage::fake('public');

        Sop::create([
            'nama_dokumen' => 'Dokumen Milik Penzawa',
            'grup'         => 'Penzawa',
            'tahun'        => 2026,
            'status'       => 'published',
            'sort_order'   => 0,
        ]);
        Sop::create([
            'nama_dokumen' => 'Dokumen Milik Pais',
            'grup'         => 'Pais',
            'tahun'        => 2026,
            'status'       => 'published',
            'sort_order'   => 0,
        ]);

        $response = $this->get('/sop?tab=penzawa');

        $response->assertOk();
        $response->assertSee('Dokumen Milik Penzawa');
        $response->assertDontSee('Dokumen Milik Pais');
    }
}
