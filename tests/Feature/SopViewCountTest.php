<?php

namespace Tests\Feature;

use App\Models\Sop;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SopViewCountTest extends TestCase
{
    use DatabaseTransactions;

    protected function admin(): User
    {
        $user = User::create([
            'name'     => 'Admin Test SOP View Count',
            'email'    => 'admin.test.sop.viewcount@example.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        return $user;
    }

    protected function sopFile(): Sop
    {
        Storage::disk('public')->put('sops/contoh.pdf', 'Isi dokumen SOP contoh');

        return Sop::create([
            'nama_dokumen' => 'Dokumen SOP Berkas',
            'grup'         => 'SOP PPID',
            'nomor'        => 'SOP-001/2026',
            'tahun'        => 2026,
            'file'         => 'sops/contoh.pdf',
            'ukuran'       => '24 B',
            'status'       => 'published',
        ])->refresh();
    }

    public function test_viewing_sop_file_increases_view_count(): void
    {
        $sop = $this->sopFile();

        $this->assertSame(0, $sop->view_count);

        $response = $this->get(route('sop.view', $sop->id));

        $response->assertOk();
        $this->assertSame(1, $sop->fresh()->view_count);
    }

    public function test_downloading_sop_file_increases_view_count(): void
    {
        $sop = $this->sopFile();

        $response = $this->get(route('sop.download', $sop->id));

        $response->assertOk();
        $this->assertSame(1, $sop->fresh()->view_count);
    }

    public function test_draft_sop_is_not_counted(): void
    {
        $sop = $this->sopFile();
        $sop->update(['status' => 'draft']);

        $response = $this->get(route('sop.view', $sop->id));

        $response->assertNotFound();
        $this->assertSame(0, $sop->fresh()->view_count);
    }

    public function test_public_index_displays_view_count(): void
    {
        $sop = $this->sopFile();
        $sop->increment('view_count');

        $response = $this->get(route('sop.index'));

        $response->assertOk();
        $response->assertSee('Dilihat', false);
        $response->assertSee($sop->nama_dokumen, false);
    }

    public function test_admin_index_displays_view_count(): void
    {
        $this->admin();

        $sop = $this->sopFile();
        $sop->increment('view_count');

        $response = $this->get(route('admin.sops.index'));

        $response->assertOk();
        $response->assertSee('Dilihat', false);
        $response->assertSee($sop->nama_dokumen, false);
    }

    public function test_admin_show_displays_view_count(): void
    {
        $this->admin();

        $sop = $this->sopFile();
        $sop->increment('view_count');

        $response = $this->get(route('admin.sops.show', $sop));

        $response->assertOk();
        $response->assertSee('Jumlah Dilihat', false);
    }
}
