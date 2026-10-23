<?php

namespace Tests\Feature;

use App\Models\GrupDokumen;
use App\Models\PustakaDokumen;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Menjamin penamaan "Kategori" konsisten di halaman admin
 * /admin/grup-dokumens dan /admin/pustaka-dokumens.
 *
 * Nama kolom (nama_grup, grup_dokumen_id), route, dan query param ?grup=
 * sengaja TIDAK diubah agar data & link lama tetap valid.
 */
class AdminKategoriLabelTest extends TestCase
{
    use DatabaseTransactions;

    protected function admin(): User
    {
        $user = User::create([
            'name'     => 'Admin Test Label Kategori',
            'email'    => 'admin.test.label.kategori@example.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        return $user;
    }

    protected function grup(): GrupDokumen
    {
        return GrupDokumen::create([
            'nama_grup'  => 'Kategori Label Uji ' . uniqid(),
            'deskripsi'  => 'Kategori khusus pengujian label',
            'sort_order' => 97,
            'is_active'  => true,
        ]);
    }

    public function test_admin_grup_dokumens_index_uses_kategori_label(): void
    {
        $this->admin();
        $this->grup();

        $response = $this->get(route('admin.grup-dokumens.index'));

        $response->assertOk();
        $response->assertSee('Master Kategori Dokumen');
        $response->assertSee('Tambah Kategori');
        $response->assertSee('<th>Nama Kategori</th>', false);
        $response->assertDontSee('Master Grup Dokumen');
        $response->assertDontSee('<th>Nama Grup</th>', false);
    }

    public function test_admin_grup_dokumens_create_uses_kategori_label(): void
    {
        $this->admin();

        $response = $this->get(route('admin.grup-dokumens.create'));

        $response->assertOk();
        $response->assertSee('Tambah Kategori Dokumen');
        $response->assertSee('>Nama Kategori <span', false);
        $response->assertDontSee('Tambah Grup Dokumen');
    }

    public function test_admin_pustaka_dokumens_index_uses_kategori_label(): void
    {
        $this->admin();
        $grup = $this->grup();

        PustakaDokumen::create([
            'grup_dokumen_id' => $grup->id,
            'nama_dokumen'    => 'Dokumen Label Kategori',
            'link_type'       => 'link',
            'link_url'        => 'https://example.com/dokumen.pdf',
        ]);

        $response = $this->get(route('admin.pustaka-dokumens.index'));

        $response->assertOk();
        $response->assertSee('Semua Kategori');
        $response->assertSee('<th>Kategori</th>', false);
        $response->assertDontSee('Semua Grup');
        $response->assertDontSee('<th>Grup</th>', false);
    }

    public function test_admin_pustaka_dokumens_form_uses_kategori_label(): void
    {
        $this->admin();

        $response = $this->get(route('admin.pustaka-dokumens.create'));

        $response->assertOk();
        $response->assertSee('<label>Kategori Dokumen <span class="text-danger">*</span></label>', false);
        $response->assertSee('-- Pilih Kategori --');
        $response->assertDontSee('-- Pilih Grup --');
    }
}
