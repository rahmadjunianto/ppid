<?php

namespace Tests\Feature;

use App\Models\Agenda;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AgendaHeaderPaginationTest extends TestCase
{
    use DatabaseTransactions;

    protected function agenda(string $judul, string $tanggal, string $status = 'published'): Agenda
    {
        return Agenda::create([
            'judul'           => $judul,
            'deskripsi'       => 'Deskripsi agenda untuk pengujian header dan pagination',
            'tanggal_mulai'   => $tanggal,
            'tanggal_selesai' => $tanggal,
            'tempat'          => 'Kantor Kemenag Nganjuk',
            'penyelenggara'   => 'Panitia Uji',
            'status'          => $status,
            'urutan'          => 1,
        ]);
    }

    public function test_index_uses_compact_header_with_filter_input_group(): void
    {
        $response = $this->get(route('agenda.index'));

        $response->assertOk();

        // Header ringkas: judul + deskripsi di kiri, filter di kanan
        $response->assertSee('row mb-3 align-items-center g-3', false);
        $response->assertSee('<h4 class="fw-bold text-success mb-1">', false);

        // Form filter memakai input-group
        $response->assertSee('<div class="input-group">', false);
        $response->assertSee('name="search"', false);
        $response->assertSee('<select name="bulan"', false);
        $response->assertSee('<select name="tahun"', false);
        $response->assertSee('<select name="status"', false);

        // Hero besar dan kartu filter lama sudah dihapus
        $response->assertDontSee('hero-section', false);
        $response->assertDontSee('filter-card', false);
        $response->assertDontSee('display-4', false);
    }

    public function test_index_pagination_uses_centered_links_with_counter(): void
    {
        for ($i = 1; $i <= 12; $i++) {
            $this->agenda('Agenda Uji ' . $i, sprintf('2026-01-%02d 09:00:00', $i));
        }

        $total = Agenda::published()->count();

        $response = $this->get(route('agenda.index'));

        $response->assertOk();
        $response->assertSee('d-flex justify-content-center mt-4', false);
        $response->assertSee('Menampilkan 1 - 10 dari ' . $total . ' agenda', false);

        // Wrapper pagination lama sudah dihapus
        $response->assertDontSee('pagination-wrapper', false);
    }

    public function test_index_filter_tetap_berfungsi_dan_counter_menampilkan_total_filter(): void
    {
        $this->agenda('Agenda Alpha Uji', '2026-03-05 09:00:00');
        $this->agenda('Agenda Beta Uji', '2026-04-05 09:00:00');

        $response = $this->get(route('agenda.index', ['bulan' => 3]));

        $response->assertOk();
        $response->assertSee('Agenda Alpha Uji', false);
        $response->assertDontSee('Agenda Beta Uji', false);

        // Filter terpilih tetap ditandai selected
        $response->assertSee('<option value="3" selected>', false);
    }
}
