<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PegawaiHeaderTest extends TestCase
{
    use DatabaseTransactions;

    protected function pegawai(string $nama, string $unitKerja = 'Unit Kerja Uji'): Pegawai
    {
        return Pegawai::create([
            'nama'       => $nama,
            'jabatan'    => 'Jabatan Uji',
            'golongan'   => 'III/a',
            'unit_kerja' => $unitKerja,
            'urutan'     => 0,
        ]);
    }

    public function test_index_uses_compact_header_with_filter_input_group(): void
    {
        $response = $this->get(route('pegawai.index'));

        $response->assertOk();

        // Header ringkas: judul + deskripsi di kiri, filter di kanan
        $response->assertSee('row mb-3 align-items-center g-3', false);
        $response->assertSee('<h4 class="fw-bold text-success mb-1">', false);
        $response->assertSee('Informasi lengkap pegawai Kementerian Agama Kabupaten Nganjuk', false);

        // Breadcrumb diletakkan di atas konten, bukan di dalam banner
        $response->assertSee('aria-current="page">Data Pegawai<', false);

        // Form filter memakai input-group
        $response->assertSee('<div class="input-group">', false);
        $response->assertSee('name="search"', false);
        $response->assertSee('<select name="unit_kerja"', false);

        // Hero besar, kartu filter, dan kartu pagination lama sudah dihapus
        $response->assertDontSee('page-header', false);
        $response->assertDontSee('filter-section', false);
        $response->assertDontSee('pagination-wrapper', false);
    }

    public function test_index_pagination_uses_centered_links_with_counter(): void
    {
        for ($i = 1; $i <= 13; $i++) {
            $this->pegawai('Pegawai Pagination Uji ' . $i);
        }

        $total = Pegawai::count();

        $response = $this->get(route('pegawai.index'));

        $response->assertOk();
        $response->assertSee('d-flex justify-content-center mt-4', false);
        $response->assertSee('Menampilkan 1 - 12 dari ' . $total . ' pegawai', false);
    }

    public function test_index_filter_tetap_berfungsi_dan_counter_menampilkan_total_filter(): void
    {
        $this->pegawai('Pegawai Alpha Uji', 'Unit Alpha Uji');
        $this->pegawai('Pegawai Beta Uji', 'Unit Beta Uji');

        $response = $this->get(route('pegawai.index', ['search' => 'Alpha Uji']));

        $response->assertOk();
        $response->assertSee('Pegawai Alpha Uji', false);
        $response->assertDontSee('Pegawai Beta Uji', false);

        // Filter unit kerja terpilih tetap ditandai selected
        $response = $this->get(route('pegawai.index', ['unit_kerja' => 'Unit Beta Uji']));

        $response->assertOk();
        $response->assertSee('Pegawai Beta Uji', false);
        $response->assertDontSee('Pegawai Alpha Uji', false);
        $response->assertSee('<option value="Unit Beta Uji" selected>', false);
    }
}
