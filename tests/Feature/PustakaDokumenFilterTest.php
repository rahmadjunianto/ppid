<?php

namespace Tests\Feature;

use App\Models\GrupDokumen;
use App\Models\PustakaDokumen;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PustakaDokumenFilterTest extends TestCase
{
    use DatabaseTransactions;

    protected function grup(string $nama): GrupDokumen
    {
        return GrupDokumen::create([
            'nama_grup'  => $nama,
            'deskripsi'  => 'Grup khusus pengujian filter',
            'sort_order' => 98,
            'is_active'  => true,
        ]);
    }

    protected function dokumen(GrupDokumen $grup, string $nama): PustakaDokumen
    {
        return PustakaDokumen::create([
            'grup_dokumen_id' => $grup->id,
            'nama_dokumen'    => $nama,
            'link_type'       => 'link',
            'link_url'        => 'https://example.com/dokumen.pdf',
        ]);
    }

    public function test_public_index_uses_select_option_for_grup_filter(): void
    {
        $grup = $this->grup('Grup Select Uji');
        $this->dokumen($grup, 'Dokumen Select Uji');

        $response = $this->get(route('pustaka-dokumen.index'));

        $response->assertOk();

        // Filter grup memakai select option di dalam input-group
        $response->assertSee('<select name="grup"', false);
        $response->assertSee('Semua Kategori', false);
        $response->assertSee('Grup Select Uji', false);

        // Baris tombol filter lama sudah dihapus
        $response->assertDontSee('bi-list-ul', false);
    }

    public function test_public_index_shows_document_count_in_select_option(): void
    {
        $grup = $this->grup('Grup Count Uji');
        $this->dokumen($grup, 'Dokumen Count 1');
        $this->dokumen($grup, 'Dokumen Count 2');

        $response = $this->get(route('pustaka-dokumen.index'));

        $response->assertOk();
        $response->assertSee('Grup Count Uji (2)', false);
    }

    public function test_public_index_can_filter_by_grup(): void
    {
        $grupA = $this->grup('Grup Filter Alfa');
        $grupB = $this->grup('Grup Filter Bravo');
        $dokA  = $this->dokumen($grupA, 'Dokumen Alfa Filter');
        $dokB  = $this->dokumen($grupB, 'Dokumen Bravo Filter');

        $response = $this->get(route('pustaka-dokumen.index', ['grup' => $grupA->slug]));

        $response->assertOk();
        $response->assertSee($dokA->nama_dokumen, false);
        $response->assertDontSee($dokB->nama_dokumen, false);

        // Opsi grup terpilih ditandai selected
        $response->assertSee('<option value="' . $grupA->slug . '" selected>', false);
    }

    public function test_public_index_can_search_inside_selected_grup(): void
    {
        $grup = $this->grup('Grup Cari Uji');
        $cocok = $this->dokumen($grup, 'Dokumen Korek Beta');
        $lain  = $this->dokumen($grup, 'Dokumen Lain Gamma');

        $response = $this->get(route('pustaka-dokumen.index', [
            'grup'   => $grup->slug,
            'search' => 'Korek',
        ]));

        $response->assertOk();
        $response->assertSee($cocok->nama_dokumen, false);
        $response->assertDontSee($lain->nama_dokumen, false);
    }

    public function test_public_index_falls_back_to_all_grup_for_invalid_slug(): void
    {
        $response = $this->get(route('pustaka-dokumen.index', ['grup' => 'grup-tidak-ada']));

        $response->assertOk();
        $response->assertSee('Daftar Informasi Publik', false);
    }
}
