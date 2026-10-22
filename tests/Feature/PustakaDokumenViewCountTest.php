<?php

namespace Tests\Feature;

use App\Models\GrupDokumen;
use App\Models\PustakaDokumen;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PustakaDokumenViewCountTest extends TestCase
{
    use DatabaseTransactions;

    protected function grup(): GrupDokumen
    {
        return GrupDokumen::create([
            'nama_grup'  => 'Grup Dokumen View Count',
            'deskripsi'  => 'Grup untuk pengujian jumlah dilihat',
            'sort_order' => 1,
            'is_active'  => true,
        ]);
    }

    protected function dokumenFile(): PustakaDokumen
    {
        Storage::disk('public')->put('pustaka-dokumen/contoh.pdf', 'Isi dokumen contoh');

        return PustakaDokumen::create([
            'grup_dokumen_id' => $this->grup()->id,
            'nama_dokumen'    => 'Dokumen Berkas',
            'link_type'       => 'file',
            'file'            => 'pustaka-dokumen/contoh.pdf',
            'ukuran'          => '18 B',
        ])->refresh();
    }

    protected function dokumenLink(): PustakaDokumen
    {
        return PustakaDokumen::create([
            'grup_dokumen_id' => $this->grup()->id,
            'nama_dokumen'    => 'Dokumen Tautan',
            'link_type'       => 'link',
            'link_url'        => 'https://example.com/dokumen.pdf',
        ])->refresh();
    }

    public function test_viewing_file_increases_view_count(): void
    {
        $dokumen = $this->dokumenFile();

        $this->assertSame(0, $dokumen->view_count);

        $response = $this->get(route('pustaka-dokumen.view', $dokumen->slug));

        $response->assertOk();
        $this->assertSame(1, $dokumen->fresh()->view_count);
    }

    public function test_downloading_file_increases_view_count(): void
    {
        $dokumen = $this->dokumenFile();

        $response = $this->get(route('pustaka-dokumen.download', $dokumen->slug));

        $response->assertOk();
        $this->assertSame(1, $dokumen->fresh()->view_count);
    }

    public function test_clicking_external_link_increases_view_count_and_redirects(): void
    {
        $dokumen = $this->dokumenLink();

        $response = $this->get(route('pustaka-dokumen.link', $dokumen->slug));

        $response->assertRedirect('https://example.com/dokumen.pdf');
        $this->assertSame(1, $dokumen->fresh()->view_count);
    }

    public function test_link_route_returns_404_for_file_document(): void
    {
        $dokumen = $this->dokumenFile();

        $response = $this->get(route('pustaka-dokumen.link', $dokumen->slug));

        $response->assertNotFound();
        $this->assertSame(0, $dokumen->fresh()->view_count);
    }

    public function test_public_index_displays_view_count_and_tracking_link(): void
    {
        $dokumen = $this->dokumenLink();
        $dokumen->increment('view_count');

        $response = $this->get(route('pustaka-dokumen.index'));

        $response->assertOk();
        $response->assertSee(route('pustaka-dokumen.link', $dokumen->slug), false);
        $response->assertSee('Dilihat', false);
    }
}
