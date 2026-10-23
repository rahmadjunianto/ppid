<?php

namespace Tests\Feature;

use App\Models\GrupDokumen;
use App\Models\PustakaDokumen;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PustakaDokumenPaginationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Marker HTML dari view pagination bawaan Laravel (Tailwind).
     * Halaman admin & publik memakai Bootstrap, sehingga markup ini tidak boleh muncul.
     */
    private const TAILWIND_MARKER = 'inline-flex items-center px-4 py-2 text-sm font-medium';

    protected function admin(): User
    {
        $user = User::create([
            'name'     => 'Admin Test Pustaka Pagination',
            'email'    => 'admin.test.pustaka.pagination@example.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        return $user;
    }

    protected function grup(): GrupDokumen
    {
        return GrupDokumen::create([
            'nama_grup'  => 'Grup Pagination ' . uniqid(),
            'deskripsi'  => 'Grup khusus pengujian pagination',
            'sort_order' => 99,
            'is_active'  => true,
        ]);
    }

    protected function createDokumen(GrupDokumen $grup, int $jumlah): void
    {
        for ($i = 1; $i <= $jumlah; $i++) {
            PustakaDokumen::create([
                'grup_dokumen_id' => $grup->id,
                'nama_dokumen'    => 'Dokumen Pagination ' . $grup->id . '-' . $i,
                'link_type'       => 'link',
                'link_url'        => 'https://example.com/dokumen-' . $i . '.pdf',
            ]);
        }
    }

    public function test_admin_index_uses_admin_pagination_view(): void
    {
        $this->admin();
        $grup = $this->grup();
        $this->createDokumen($grup, 20);

        $response = $this->get(route('admin.pustaka-dokumens.index', ['grup' => $grup->id]));

        $response->assertOk();

        // View pagination admin (Bootstrap 4 / AdminLTE), sama seperti /admin/sops
        $response->assertSee('pagination pagination-sm m-0 float-right', false);
        $response->assertSee('fas fa-angle-left', false);

        // Bukan view pagination bawaan Laravel (Tailwind)
        $response->assertDontSee(self::TAILWIND_MARKER, false);
    }

    public function test_admin_index_shows_pagination_counter(): void
    {
        $this->admin();
        $grup = $this->grup();
        $this->createDokumen($grup, 20);

        $response = $this->get(route('admin.pustaka-dokumens.index', ['grup' => $grup->id]));

        $response->assertOk();
        $response->assertSee('Menampilkan 1 - 15', false);
        $response->assertSee('dari 20 Dokumen', false);
    }

    public function test_admin_index_pagination_keeps_current_filter(): void
    {
        $this->admin();
        $grup = $this->grup();
        $this->createDokumen($grup, 20);

        $response = $this->get(route('admin.pustaka-dokumens.index', ['grup' => $grup->id]));

        $response->assertOk();
        $response->assertSee('grup=' . $grup->id . '&amp;page=2', false);
    }

    public function test_public_index_uses_bootstrap_pagination_view(): void
    {
        $grup = $this->grup();
        $this->createDokumen($grup, 20);

        $response = $this->get(route('pustaka-dokumen.index', ['grup' => $grup->slug]));

        $response->assertOk();

        // View pagination publik (Bootstrap 5), sama seperti halaman /regulasi
        $response->assertSee('pagination justify-content-center mb-0', false);
        $response->assertSee('bi bi-chevron-left', false);

        // Bukan view pagination bawaan Laravel (Tailwind)
        $response->assertDontSee(self::TAILWIND_MARKER, false);
    }

    public function test_public_index_shows_pagination_counter(): void
    {
        $grup = $this->grup();
        $this->createDokumen($grup, 20);

        $response = $this->get(route('pustaka-dokumen.index', ['grup' => $grup->slug]));

        $response->assertOk();
        $response->assertSee('Menampilkan 1 - 10 dari 20 dokumen', false);
    }

    public function test_public_index_pagination_keeps_current_filter(): void
    {
        $grup = $this->grup();
        $this->createDokumen($grup, 20);

        $response = $this->get(route('pustaka-dokumen.index', ['grup' => $grup->slug]));

        $response->assertOk();
        $response->assertSee('grup=' . $grup->slug . '&amp;page=2', false);
    }

    public function test_public_index_hides_pagination_when_single_page(): void
    {
        $grup = $this->grup();
        $this->createDokumen($grup, 3);

        $response = $this->get(route('pustaka-dokumen.index', ['grup' => $grup->slug]));

        $response->assertOk();
        $response->assertSee('Menampilkan 1 - 3 dari 3 dokumen', false);
        $response->assertDontSee('pagination justify-content-center mb-0', false);
    }
}
