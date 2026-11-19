<?php

namespace Tests\Feature;

use App\Models\DynamicList;
use App\Models\DynamicListColumn;
use App\Models\DynamicListItem;
use App\Models\DynamicListItemFile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Uji fitur "Daftar Dinamis" (dynamic list):
 * - CRUD daftar, kolom, dan baris data
 * - validasi per tipe kolom
 * - pengurutan (sort order)
 * - duplikasi daftar
 * - penerbitan (publish) dan tampilan publik
 * - unggah, ganti, dan hapus file
 * - unduh file dengan nama asli
 */
class DynamicListTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected int $sequence = 0;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sequence++;

        $this->admin = User::create([
            'name' => 'Admin Dynamic List '.$this->sequence,
            'email' => 'admin.dynamic.list.'.$this->sequence.'.'.Str::lower(Str::random(8)).'@example.test',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($this->admin);
    }

    /* ---------------------------------------------------------------------
     | Helpers
     | -------------------------------------------------------------------- */

    protected function uniqueTitle(string $prefix = 'Daftar Uji'): string
    {
        return $prefix.' '.Str::upper(Str::random(8));
    }

    protected function makeList(array $attributes = []): DynamicList
    {
        return DynamicList::create(array_merge([
            'title' => $this->uniqueTitle(),
            'description' => 'Deskripsi daftar untuk pengujian otomatis.',
            'status' => 'draft',
            'show_title' => true,
            'sort_order' => 0,
            'created_by' => $this->admin->id,
        ], $attributes));
    }

    protected function makeColumn(DynamicList $list, array $attributes = []): DynamicListColumn
    {
        return $list->columns()->create(array_merge([
            'label' => 'Kolom Uji',
            'type' => 'text',
            'sort_order' => 0,
        ], $attributes));
    }

    protected function makeItem(DynamicList $list, array $data = [], int $sortOrder = 0): DynamicListItem
    {
        return DynamicListItem::create([
            'dynamic_list_id' => $list->id,
            'data' => $data,
            'sort_order' => $sortOrder,
        ]);
    }

    /**
     * Simpan file fisik di disk public dan buat record-nya.
     */
    protected function attachFile(
        DynamicListItem $item,
        DynamicListColumn $column,
        string $originalName = 'panduan.pdf',
        string $contents = 'KONTEN PDF DARI UJIOTOMATIS'
    ): DynamicListItemFile {
        $path = 'dynamic-lists/'.Str::random(12).'-'.$originalName;

        Storage::disk('public')->put($path, $contents);

        return DynamicListItemFile::create([
            'dynamic_list_item_id' => $item->id,
            'dynamic_list_column_id' => $column->id,
            'path' => $path,
            'original_name' => $originalName,
            'mime_type' => 'application/pdf',
            'size' => strlen($contents),
        ]);
    }

    /* ---------------------------------------------------------------------
     | Manajemen daftar (dynamic list)
     | -------------------------------------------------------------------- */

    public function test_halaman_daftar_admin_tampil_dengan_daftar_yang_ada(): void
    {
        $this->makeList(['title' => 'Daftar Asphalt']);

        $response = $this->get(route('admin.lists.index'));

        $response->assertOk();
        $response->assertSee('Daftar Asphalt');
    }

    public function test_halaman_tambah_daftar_admin_tampil(): void
    {
        $response = $this->get(route('admin.lists.create'));

        $response->assertOk();
        $response->assertSee('name="title"', false);
    }

    public function test_menyimpan_daftar_baru_dan_diarahkan_ke_kelola_kolom(): void
    {
        $response = $this->post(route('admin.lists.store'), [
            'title' => 'Daftar Hogan',
            'description' => 'Deskripsi daftar uji.',
            'status' => 'draft',
            'show_title' => '1',
            'sort_order' => 3,
        ]);

        $list = DynamicList::where('title', 'Daftar Hogan')->firstOrFail();

        $response->assertRedirect(route('admin.lists.columns.index', $list));
        $response->assertSessionHas('success');

        $this->assertSame('daftar-hogan', $list->slug);
        $this->assertSame($this->admin->id, $list->created_by);
        $this->assertSame(3, $list->sort_order);
        $this->assertTrue($list->show_title);
    }

    public function test_menyimpan_daftar_tanpa_judul_dan_status_ditolak(): void
    {
        $response = $this->post(route('admin.lists.store'), [
            'description' => 'Tanpa judul dan status.',
        ]);

        $response->assertSessionHasErrors(['title', 'status']);
        $this->assertSame(0, DynamicList::where('description', 'Tanpa judul dan status.')->count());
    }

    public function test_slug_daftar_harus_unik(): void
    {
        $this->makeList(['title' => 'Daftar Unik', 'slug' => 'daftar-unik']);

        $response = $this->post(route('admin.lists.store'), [
            'title' => 'Daftar Unik Dua',
            'slug' => 'daftar-unik',
            'status' => 'draft',
        ]);

        $response->assertSessionHasErrors('slug');
        $this->assertSame(0, DynamicList::where('title', 'Daftar Unik Dua')->count());
    }

    public function test_memperbarui_daftar(): void
    {
        $list = $this->makeList(['title' => 'Daftar Lama', 'status' => 'draft']);

        $response = $this->put(route('admin.lists.update', $list), [
            'title' => 'Daftar Baru',
            'status' => 'published',
            'show_title' => '0',
            'sort_order' => 7,
        ]);

        $response->assertRedirect(route('admin.lists.index'));
        $response->assertSessionHas('success');

        $list->refresh();

        $this->assertSame('Daftar Baru', $list->title);
        $this->assertSame('daftar-baru', $list->slug);
        $this->assertSame('published', $list->status);
        $this->assertNotNull($list->published_at);
        $this->assertFalse($list->show_title);
        $this->assertSame(7, $list->sort_order);
    }

    public function test_mengubah_status_daftar_menjadi_published_lalu_kembali_draft(): void
    {
        $list = $this->makeList(['status' => 'draft']);

        $this->post(route('admin.lists.toggle-status', $list))->assertSessionHas('success');

        $list->refresh();
        $this->assertSame('published', $list->status);
        $this->assertNotNull($list->published_at);

        $this->post(route('admin.lists.toggle-status', $list))->assertSessionHas('success');

        $list->refresh();
        $this->assertSame('draft', $list->status);
        $this->assertNull($list->published_at);
    }

    public function test_menduplikasi_daftar_menyalin_kolom_tanpa_menyalin_data(): void
    {
        $list = $this->makeList(['title' => 'Daftar Asal']);
        $column = $this->makeColumn($list, ['label' => 'Nama', 'type' => 'text', 'width' => 180]);
        $this->makeItem($list, [$column->key => 'Budi']);

        $response = $this->post(route('admin.lists.duplicate', $list));

        $copy = DynamicList::where('title', 'Daftar Asal (Salinan)')->firstOrFail();

        $response->assertRedirect(route('admin.lists.columns.index', $copy));

        $this->assertSame('draft', $copy->status);
        $this->assertCount(1, $copy->columns);
        $this->assertSame('nama', $copy->columns->first()->key);
        $this->assertSame(180, (int) $copy->columns->first()->width);
        $this->assertSame(0, $copy->items()->count());
    }

    public function test_menghapus_daftar_beserta_file_fisik(): void
    {
        Storage::fake('public');

        $list = $this->makeList();
        $column = $this->makeColumn($list, ['label' => 'Lampiran', 'type' => 'file']);
        $item = $this->makeItem($list);
        $file = $this->attachFile($item, $column, 'panduan.pdf');

        $response = $this->delete(route('admin.lists.destroy', $list));

        $response->assertRedirect(route('admin.lists.index'));
        $response->assertSessionHas('success');

        $this->assertNull(DynamicList::find($list->id));
        Storage::disk('public')->assertMissing($file->path);
    }

    public function test_mencari_daftar_berdasarkan_judul_dan_status(): void
    {
        $this->makeList(['title' => 'Daftar Beta', 'status' => 'published']);
        $this->makeList(['title' => 'Daftar Gamma', 'status' => 'draft']);

        $response = $this->get(route('admin.lists.index', ['search' => 'Beta']));
        $response->assertOk();
        $response->assertSee('Daftar Beta');
        $response->assertDontSee('Daftar Gamma');

        $response = $this->get(route('admin.lists.index', ['status' => 'draft']));
        $response->assertOk();
        $response->assertSee('Daftar Gamma');
        $response->assertDontSee('Daftar Beta');
    }

    /* ---------------------------------------------------------------------
     | Manajemen kolom
     | -------------------------------------------------------------------- */

    public function test_halaman_kolom_admin_tampil_dengan_kolom_yang_ada(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Nama Proyek', 'type' => 'text']);

        $response = $this->get(route('admin.lists.columns.index', $list));

        $response->assertOk();
        $response->assertSee('Nama Proyek');
        $response->assertSee('text');
    }

    public function test_menyimpan_kolom_dengan_key_otomatis_dari_label(): void
    {
        $list = $this->makeList();

        $response = $this->post(route('admin.lists.columns.store', $list), [
            'label' => 'Nama Lengkap',
            'type' => 'text',
            'sort_order' => 2,
        ]);

        $column = DynamicListColumn::where('dynamic_list_id', $list->id)->firstOrFail();

        $response->assertRedirect(route('admin.lists.columns.index', $list));
        $response->assertSessionHas('success');

        $this->assertSame('nama-lengkap', $column->key);
        $this->assertSame('Nama Lengkap', $column->label);
        $this->assertSame('text', $column->type);
        $this->assertSame(2, $column->sort_order);
        $this->assertFalse($column->is_required);
        $this->assertFalse($column->is_multiple);
    }

    public function test_key_kolom_dibuat_unik_bila_label_sama(): void
    {
        $list = $this->makeList();

        $this->post(route('admin.lists.columns.store', $list), ['label' => 'Nama', 'type' => 'text']);
        $this->post(route('admin.lists.columns.store', $list), ['label' => 'Nama', 'type' => 'text']);

        $keys = DynamicListColumn::where('dynamic_list_id', $list->id)
            ->orderBy('id')
            ->pluck('key')
            ->all();

        $this->assertSame(['nama', 'nama_2'], $keys);
    }

    public function test_menyimpan_kolom_select_dengan_daftar_pilihan(): void
    {
        $list = $this->makeList();

        $this->post(route('admin.lists.columns.store', $list), [
            'label' => 'Kategori',
            'type' => 'select',
            'options_text' => "Kodefikasi | kode\nNon Kodefikasi | nonkode",
        ]);

        $column = DynamicListColumn::where('dynamic_list_id', $list->id)->firstOrFail();

        $this->assertSame('select', $column->type);
        $this->assertSame(['kode', 'nonkode'], $column->optionValues());
        $this->assertSame('Kodefikasi', $column->optionLabel('kode'));
    }

    public function test_menyimpan_kolom_dengan_tipe_tidak_valid_ditolak(): void
    {
        $list = $this->makeList();

        $response = $this->post(route('admin.lists.columns.store', $list), [
            'label' => 'Kolom Ajaib',
            'type' => 'wizard',
        ]);

        $response->assertSessionHasErrors('type');
        $this->assertSame(0, $list->columns()->count());
    }

    public function test_menyimpan_kolom_tipe_aksi_tanpa_jenis_aksi_ditolak(): void
    {
        $list = $this->makeList();

        $response = $this->post(route('admin.lists.columns.store', $list), [
            'label' => 'Tautan',
            'type' => 'action',
        ]);

        $response->assertSessionHasErrors('action_type');
        $this->assertSame(0, $list->columns()->count());
    }

    public function test_memperbarui_kolom_dan_memindahkan_nilai_item(): void
    {
        $list = $this->makeList();
        $column = $this->makeColumn($list, ['label' => 'Nama', 'type' => 'text']);
        $item = $this->makeItem($list, [$column->key => 'Budi']);

        $response = $this->put(route('admin.lists.columns.update', [$list, $column]), [
            'label' => 'Nama Lengkap',
            'key' => 'nama-lengkap',
            'type' => 'text',
        ]);

        $response->assertRedirect(route('admin.lists.columns.index', $list));
        $response->assertSessionHas('success');

        $column->refresh();
        $item->refresh();

        $this->assertSame('nama-lengkap', $column->key);
        $this->assertSame(['nama-lengkap' => 'Budi'], $item->data);
    }

    public function test_menghapus_kolom_membuang_nilai_item_dan_file_fisik(): void
    {
        Storage::fake('public');

        $list = $this->makeList();
        $column = $this->makeColumn($list, ['label' => 'Lampiran', 'type' => 'file']);
        $item = $this->makeItem($list, [$column->key => 'lama']);
        $file = $this->attachFile($item, $column);

        $response = $this->delete(route('admin.lists.columns.destroy', [$list, $column]));

        $response->assertRedirect(route('admin.lists.columns.index', $list));
        $response->assertSessionHas('success');

        $item->refresh();

        $this->assertNull(DynamicListColumn::find($column->id));
        $this->assertArrayNotHasKey('lampiran', $item->data);
        Storage::disk('public')->assertMissing($file->path);
    }

    public function test_mengubah_urutan_kolom(): void
    {
        $list = $this->makeList();
        $first = $this->makeColumn($list, ['label' => 'Pertama', 'sort_order' => 0]);
        $second = $this->makeColumn($list, ['label' => 'Kedua', 'sort_order' => 1]);

        $response = $this->post(route('admin.lists.columns.update-order', $list), [
            'order' => [$second->id, $first->id],
        ]);

        $response->assertSessionHas('success');

        $this->assertSame(0, $second->fresh()->sort_order);
        $this->assertSame(1, $first->fresh()->sort_order);
    }

    public function test_kolom_dari_daftar_lain_tidak_bisa_diakses(): void
    {
        $listA = $this->makeList();
        $listB = $this->makeList();
        $column = $this->makeColumn($listB, ['label' => 'Milik Daftar B']);

        $this->get(route('admin.lists.columns.edit', [$listA, $column]))->assertNotFound();
        $this->put(route('admin.lists.columns.update', [$listA, $column]), [
            'label' => 'X',
            'type' => 'text',
        ])->assertNotFound();
        $this->delete(route('admin.lists.columns.destroy', [$listA, $column]))->assertNotFound();

        $this->assertNotNull(DynamicListColumn::find($column->id));
    }

    /* ---------------------------------------------------------------------
     | Lebar kolom (width)
     | -------------------------------------------------------------------- */

    public function test_menyimpan_kolom_dengan_lebar_khusus(): void
    {
        $list = $this->makeList();

        $response = $this->post(route('admin.lists.columns.store', $list), [
            'label' => 'Kolom Lebar',
            'type' => 'text',
            'sort_order' => 0,
            'width' => 220,
        ]);

        $response->assertRedirect(route('admin.lists.columns.index', $list));

        $column = $list->columns()->where('label', 'Kolom Lebar')->first();

        $this->assertNotNull($column);
        $this->assertSame(220, (int) $column->width);
        $this->assertTrue($column->hasWidth());

        $this->get(route('admin.lists.columns.index', $list))
            ->assertOk()
            ->assertSee('220 px');
    }

    public function test_lebar_kolom_kosong_berarti_otomatis(): void
    {
        $list = $this->makeList();

        $this->post(route('admin.lists.columns.store', $list), [
            'label' => 'Kolom Otomatis',
            'type' => 'text',
            'sort_order' => 0,
            'width' => '',
        ])->assertRedirect(route('admin.lists.columns.index', $list));

        $column = $list->columns()->where('label', 'Kolom Otomatis')->first();

        $this->assertNotNull($column);
        $this->assertNull($column->width);
        $this->assertFalse($column->hasWidth());

        $this->get(route('admin.lists.columns.index', $list))
            ->assertOk()
            ->assertSee('Otomatis');
    }

    public function test_lebar_kolom_diluar_rentang_ditolak(): void
    {
        $list = $this->makeList();

        $this->post(route('admin.lists.columns.store', $list), [
            'label' => 'Kolom Terlalu Sempit',
            'type' => 'text',
            'width' => 10,
        ])->assertSessionHasErrors('width');

        $this->post(route('admin.lists.columns.store', $list), [
            'label' => 'Kolom Terlalu Lebar',
            'type' => 'text',
            'width' => 5000,
        ])->assertSessionHasErrors('width');

        $this->assertSame(0, $list->columns()->count());
    }

    public function test_formulir_kolom_menampilkan_input_lebar(): void
    {
        $list = $this->makeList();
        $column = $this->makeColumn($list, ['label' => 'Kolom Uji', 'width' => 175]);

        $this->get(route('admin.lists.columns.create', $list))
            ->assertOk()
            ->assertSee('name="width"', false)
            ->assertSee('Lebar Kolom (px)', false);

        $this->get(route('admin.lists.columns.edit', [$list, $column]))
            ->assertOk()
            ->assertSee('name="width"', false)
            ->assertSee('value="175"', false);
    }

    public function test_memperbarui_lebar_kolom(): void
    {
        $list = $this->makeList();
        $column = $this->makeColumn($list, ['label' => 'Lebar Lama', 'width' => 120]);

        $this->put(route('admin.lists.columns.update', [$list, $column]), [
            'label' => 'Lebar Baru',
            'type' => 'text',
            'width' => 320,
        ])->assertRedirect(route('admin.lists.columns.index', $list));

        $this->assertSame(320, (int) $column->fresh()->width);

        // Kosongkan kembali -> lebar otomatis.
        $this->put(route('admin.lists.columns.update', [$list, $column]), [
            'label' => 'Lebar Baru',
            'type' => 'text',
            'width' => '',
        ])->assertRedirect(route('admin.lists.columns.index', $list));

        $this->assertNull($column->fresh()->width);
    }

    public function test_lebar_kolom_tidak_diterapkan_di_halaman_data_admin(): void
    {
        $list = $this->makeList();
        $column = $this->makeColumn($list, ['label' => 'Judul Dokumen', 'width' => 250]);
        $this->makeItem($list, [$column->key => 'Dokumen A']);

        $response = $this->get(route('admin.lists.items.index', $list));

        $response->assertOk();
        $response->assertDontSee('width: 250px', false);
    }

    public function test_lebar_kolom_diterapkan_di_halaman_publik(): void
    {
        $list = $this->makeList(['status' => 'published']);
        $column = $this->makeColumn($list, ['label' => 'Judul Dokumen', 'width' => 250]);
        $this->makeItem($list, [$column->key => 'Dokumen A']);

        $response = $this->get(route('lists.show', $list->slug));

        $response->assertOk();
        $response->assertSee('width: 250px', false);
    }

    /* ---------------------------------------------------------------------
     | Tampilan link aksi
     | -------------------------------------------------------------------- */

    public function test_link_aksi_di_halaman_publik_menampilkan_icon_tanpa_label(): void
    {
        $list = $this->makeList(['status' => 'published']);
        $internal = $this->makeColumn($list, ['label' => 'Dokumen Internal', 'type' => 'action', 'action_type' => 'internal']);
        $external = $this->makeColumn($list, ['label' => 'Situs External', 'type' => 'action', 'action_type' => 'external']);
        $this->makeItem($list, [
            $internal->key => '/dokumen/internal',
            $external->key => 'https://contoh.go.id/dokumen',
        ]);

        $response = $this->get(route('lists.show', $list->slug));

        $response->assertOk();
        $response->assertSee('fas fa-external-link-alt me-1', false);
        $response->assertSee('href="https://contoh.go.id/dokumen"', false);

        // Teks label link sudah dihapus di tampilan publik.
        $response->assertDontSee('</i>https://contoh.go.id/dokumen', false);
        $response->assertDontSee('</i>/dokumen/internal', false);
    }

    public function test_link_aksi_di_halaman_admin_tetap_menampilkan_label(): void
    {
        $list = $this->makeList();
        $external = $this->makeColumn($list, ['label' => 'Situs External', 'type' => 'action', 'action_type' => 'external']);
        $this->makeItem($list, [$external->key => 'https://contoh.go.id/dokumen']);

        $response = $this->get(route('admin.lists.items.index', $list));

        $response->assertOk();
        $response->assertSee('</i>https://contoh.go.id/dokumen', false);
    }

    /* ---------------------------------------------------------------------
     | Manajemen data (item) daftar
     | -------------------------------------------------------------------- */

    public function test_halaman_tambah_data_menampilkan_baris_sebanyak_jumlah_diminta(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Nama', 'type' => 'text']);

        $response = $this->get(route('admin.lists.items.create', [$list, 'jumlah' => 3]));

        $response->assertOk();
        $response->assertSee('name="items[0][nama]"', false);
        $response->assertSee('name="items[2][nama]"', false);
        $response->assertDontSee('name="items[3][nama]"', false);
    }

    public function test_halaman_tambah_data_mengarah_ke_kelola_kolom_bila_kolom_kosong(): void
    {
        $list = $this->makeList();

        $response = $this->get(route('admin.lists.items.create', $list));

        $response->assertRedirect(route('admin.lists.columns.index', $list));
        $response->assertSessionHas('error');
    }

    public function test_menyimpan_banyak_baris_data_sekaligus(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Nama', 'type' => 'text']);
        $this->makeColumn($list, ['label' => 'Umur', 'type' => 'number', 'sort_order' => 1]);

        $response = $this->post(route('admin.lists.items.store', $list), [
            'items' => [
                ['nama' => 'Budi', 'umur' => '30'],
                ['nama' => 'Siti', 'umur' => '25'],
            ],
        ]);

        $response->assertRedirect(route('admin.lists.items.index', $list));
        $response->assertSessionHas('success');

        $items = DynamicListItem::where('dynamic_list_id', $list->id)->orderBy('id')->get();

        $this->assertCount(2, $items);
        $this->assertSame('Budi', $items[0]->value('nama'));
        $this->assertSame('30', $items[0]->value('umur'));
        $this->assertSame('Siti', $items[1]->value('nama'));
    }

    public function test_baris_kosong_otomatis_dilewati_saat_disimpan(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Nama', 'type' => 'text']);

        $response = $this->post(route('admin.lists.items.store', $list), [
            'items' => [
                ['nama' => 'Budi'],
                ['nama' => ''],
            ],
        ]);

        $response->assertRedirect(route('admin.lists.items.index', $list));
        $response->assertSessionHas('success', '1 baris data berhasil disimpan. 1 baris kosong dilewati.');

        $this->assertSame(1, DynamicListItem::where('dynamic_list_id', $list->id)->count());
    }

    public function test_kolom_wajib_kosong_membuat_baris_gagal_disimpan(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Nama', 'type' => 'text', 'is_required' => true]);
        $this->makeColumn($list, ['label' => 'Keterangan', 'type' => 'text', 'sort_order' => 1]);

        $response = $this->post(route('admin.lists.items.store', $list), [
            'items' => [
                ['nama' => '', 'keterangan' => 'Ada isian lain'],
            ],
        ]);

        $response->assertSessionHas('failed_items');
        $response->assertSessionHas('error');

        $this->assertSame(0, DynamicListItem::where('dynamic_list_id', $list->id)->count());
    }

    public function test_validasi_tipe_kolom_angka_dan_tanggal(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Umur', 'type' => 'number']);
        $this->makeColumn($list, ['label' => 'Tanggal', 'type' => 'date', 'sort_order' => 1]);

        $response = $this->post(route('admin.lists.items.store', $list), [
            'items' => [
                ['umur' => 'bukan-angka', 'tanggal' => '31-02-2020'],
            ],
        ]);

        $response->assertSessionHasErrors(['items.0.umur', 'items.0.tanggal']);

        $this->assertSame(0, DynamicListItem::where('dynamic_list_id', $list->id)->count());
    }

    public function test_nilai_select_di_luar_daftar_pilihan_ditolak(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, [
            'label' => 'Kategori',
            'type' => 'select',
            'options' => [['label' => 'Kodefikasi', 'value' => 'kode']],
        ]);

        $response = $this->post(route('admin.lists.items.store', $list), [
            'items' => [
                ['kategori' => 'di luar pilihan'],
            ],
        ]);

        $response->assertSessionHas('failed_items');

        $this->assertSame(0, DynamicListItem::where('dynamic_list_id', $list->id)->count());
    }

    public function test_kolom_multi_menyimpan_beberapa_nilai(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Tag', 'type' => 'text', 'is_multiple' => true]);

        $response = $this->post(route('admin.lists.items.store', $list), [
            'items' => [
                ['tag' => ['satu', 'dua']],
            ],
        ]);

        $response->assertRedirect(route('admin.lists.items.index', $list));

        $item = DynamicListItem::where('dynamic_list_id', $list->id)->firstOrFail();

        $this->assertSame(['satu', 'dua'], $item->values('tag'));
    }

    public function test_kolom_aksi_link_eksternal_menyimpan_url_valid(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Tautan', 'type' => 'action', 'action_type' => 'external']);

        $response = $this->post(route('admin.lists.items.store', $list), [
            'items' => [
                ['tautan' => 'https://contoh.go.id/dokumen'],
            ],
        ]);

        $response->assertRedirect(route('admin.lists.items.index', $list));

        $item = DynamicListItem::where('dynamic_list_id', $list->id)->firstOrFail();

        $this->assertSame('https://contoh.go.id/dokumen', $item->value('tautan'));
    }

    public function test_kolom_aksi_link_eksternal_menolak_url_tidak_valid(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Tautan', 'type' => 'action', 'action_type' => 'external']);

        $response = $this->post(route('admin.lists.items.store', $list), [
            'items' => [
                ['tautan' => 'bukan-url'],
            ],
        ]);

        $response->assertSessionHasErrors('items.0.tautan');

        $this->assertSame(0, DynamicListItem::where('dynamic_list_id', $list->id)->count());
    }

    public function test_kolom_aksi_link_internal_menolak_alamat_luar_situs(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Tautan', 'type' => 'action', 'action_type' => 'internal']);

        $response = $this->post(route('admin.lists.items.store', $list), [
            'items' => [
                ['tautan' => 'https://contoh.go.id'],
            ],
        ]);

        $response->assertSessionHas('failed_items');

        $this->assertSame(0, DynamicListItem::where('dynamic_list_id', $list->id)->count());
    }

    public function test_memperbarui_baris_data_lama(): void
    {
        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Nama', 'type' => 'text']);
        $item = $this->makeItem($list, ['nama' => 'Budi']);

        $response = $this->put(route('admin.lists.items.update', [$list, $item]), [
            'item' => ['nama' => 'Budi Santoso'],
        ]);

        $response->assertRedirect(route('admin.lists.items.index', $list));
        $response->assertSessionHas('success');

        $this->assertSame('Budi Santoso', $item->fresh()->value('nama'));
    }

    public function test_menghapus_baris_data_beserta_file(): void
    {
        Storage::fake('public');

        $list = $this->makeList();
        $column = $this->makeColumn($list, ['label' => 'Lampiran', 'type' => 'file']);
        $item = $this->makeItem($list);
        $file = $this->attachFile($item, $column);

        $response = $this->delete(route('admin.lists.items.destroy', [$list, $item]));

        $response->assertRedirect(route('admin.lists.items.index', $list));

        $this->assertNull(DynamicListItem::find($item->id));
        Storage::disk('public')->assertMissing($file->path);
    }

    public function test_mengubah_urutan_baris_data(): void
    {
        $list = $this->makeList();
        $first = $this->makeItem($list, ['nama' => 'Satu'], 0);
        $second = $this->makeItem($list, ['nama' => 'Dua'], 1);

        $response = $this->post(route('admin.lists.items.update-order', $list), [
            'order' => [$second->id, $first->id],
        ]);

        $response->assertSessionHas('success');

        $this->assertSame(0, $second->fresh()->sort_order);
        $this->assertSame(1, $first->fresh()->sort_order);
    }

    public function test_baris_dari_daftar_lain_tidak_bisa_diakses(): void
    {
        $listA = $this->makeList();
        $listB = $this->makeList();
        $item = $this->makeItem($listB);

        $this->get(route('admin.lists.items.edit', [$listA, $item]))->assertNotFound();
        $this->delete(route('admin.lists.items.destroy', [$listA, $item]))->assertNotFound();

        $this->assertNotNull(DynamicListItem::find($item->id));
    }

    /* ---------------------------------------------------------------------
     | Unggah, ganti, dan hapus file
     | -------------------------------------------------------------------- */

    public function test_mengunggah_file_otomatis_disimpan_ke_disk_public(): void
    {
        Storage::fake('public');

        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Lampiran', 'type' => 'file']);
        $this->makeColumn($list, ['label' => 'Nama', 'type' => 'text', 'sort_order' => 1]);

        $response = $this->post(route('admin.lists.items.store', $list), [
            'items' => [
                [
                    'nama' => 'Berkas Uji',
                    'lampiran' => [UploadedFile::fake()->create('panduan.pdf', 20, 'application/pdf')],
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.lists.items.index', $list));
        $response->assertSessionHas('success');

        $item = DynamicListItem::where('dynamic_list_id', $list->id)->firstOrFail();
        $file = DynamicListItemFile::where('dynamic_list_item_id', $item->id)->firstOrFail();

        $this->assertSame('panduan.pdf', $file->original_name);
        $this->assertSame('application/pdf', $file->mime_type);
        $this->assertStringStartsWith('dynamic-lists/', $file->path);

        Storage::disk('public')->assertExists($file->path);
    }

    public function test_mengunggah_berkas_ditolak_bila_tipe_tidak_didukung(): void
    {
        Storage::fake('public');

        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Lampiran', 'type' => 'file']);

        $response = $this->post(route('admin.lists.items.store', $list), [
            'items' => [
                [
                    'lampiran' => [UploadedFile::fake()->create('skrip.php', 10, 'text/plain')],
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items.0.lampiran.0');

        $this->assertSame(0, DynamicListItemFile::count());
    }

    public function test_memperbarui_baris_dengan_menambah_berkas_baru(): void
    {
        Storage::fake('public');

        $list = $this->makeList();
        $this->makeColumn($list, ['label' => 'Lampiran', 'type' => 'file']);
        $item = $this->makeItem($list);

        $response = $this->put(route('admin.lists.items.update', [$list, $item]), [
            'item' => [
                'lampiran' => [UploadedFile::fake()->create('baru.pdf', 10, 'application/pdf')],
            ],
        ]);

        $response->assertRedirect(route('admin.lists.items.index', $list));
        $response->assertSessionHas('success');

        $file = DynamicListItemFile::where('dynamic_list_item_id', $item->id)->firstOrFail();

        $this->assertSame('baru.pdf', $file->original_name);
        Storage::disk('public')->assertExists($file->path);
    }

    public function test_berkas_lama_dihapus_saat_dicentang_hapus(): void
    {
        Storage::fake('public');

        $list = $this->makeList();
        $column = $this->makeColumn($list, ['label' => 'Lampiran', 'type' => 'file']);
        $item = $this->makeItem($list);
        $file = $this->attachFile($item, $column, 'lama.pdf');

        $response = $this->put(route('admin.lists.items.update', [$list, $item]), [
            'item' => ['lampiran' => []],
            'remove_files' => ['lampiran' => [$file->id]],
        ]);

        $response->assertRedirect(route('admin.lists.items.index', $list));

        $this->assertSame(0, DynamicListItemFile::where('dynamic_list_item_id', $item->id)->count());
        Storage::disk('public')->assertMissing($file->path);
    }

    public function test_berkas_lama_tetap_disimpan_saat_baris_diperbarui_tanpa_uncheck(): void
    {
        Storage::fake('public');

        $list = $this->makeList();
        $column = $this->makeColumn($list, ['label' => 'Lampiran', 'type' => 'file']);
        $this->makeColumn($list, ['label' => 'Nama', 'type' => 'text', 'sort_order' => 1]);
        $item = $this->makeItem($list);
        $file = $this->attachFile($item, $column, 'lama.pdf');

        $response = $this->put(route('admin.lists.items.update', [$list, $item]), [
            'item' => ['nama' => 'Nama Baru'],
        ]);

        $response->assertRedirect(route('admin.lists.items.index', $list));

        $this->assertSame(1, DynamicListItemFile::where('dynamic_list_item_id', $item->id)->count());
        Storage::disk('public')->assertExists($file->path);
    }

    /* ---------------------------------------------------------------------
     | Tampilan publik dan unduhan berkas
     | -------------------------------------------------------------------- */

    public function test_halaman_publik_menampilkan_judul_kolom_dan_data(): void
    {
        $list = $this->makeList(['title' => 'Daftar Publik', 'status' => 'published']);
        $this->makeColumn($list, ['label' => 'Nama Nurse', 'type' => 'text']);
        $this->makeItem($list, ['nama-nurse' => 'Budi Santoso']);

        $response = $this->get(route('lists.show', $list->slug));

        $response->assertOk();
        $response->assertSee('Daftar Publik');
        $response->assertSee('Nama Nurse');
        $response->assertSee('Budi Santoso');
    }

    public function test_halaman_publik_menampilkan_label_pilihan_dan_nilai_boolean(): void
    {
        $list = $this->makeList(['status' => 'published']);
        $this->makeColumn($list, [
            'label' => 'Kategori',
            'type' => 'select',
            'options' => [['label' => 'Kodefikasi', 'value' => 'kode']],
        ]);
        $this->makeColumn($list, ['label' => 'Aktif', 'type' => 'boolean', 'sort_order' => 1]);
        $this->makeItem($list, ['kategori' => 'kode', 'aktif' => '1']);

        $response = $this->get(route('lists.show', $list->slug));

        $response->assertOk();
        $response->assertSee('Kodefikasi');
        $response->assertSee('Ya');
    }

    public function test_halaman_publik_menampilkan_pesan_kosong_bila_belum_ada_data(): void
    {
        $list = $this->makeList(['status' => 'published']);

        $response = $this->get(route('lists.show', $list->slug));

        $response->assertOk();
        $response->assertSee('Belum ada data pada daftar ini.');
    }

    public function test_daftar_berstatus_draft_tidak_tampil_di_halaman_publik(): void
    {
        $list = $this->makeList(['status' => 'draft']);

        $this->get(route('lists.show', $list->slug))->assertNotFound();
    }

    public function test_slug_yang_tidak_dikenal_menghasilkan_404(): void
    {
        $this->get(route('lists.show', 'daftar-hantu-404'))->assertNotFound();
    }

    public function test_halaman_publik_tidak_membutuhkan_login(): void
    {
        auth()->logout();

        $list = $this->makeList(['status' => 'published']);

        $this->get(route('lists.show', $list->slug))->assertOk();
    }

    public function test_halaman_admin_membutuhkan_login(): void
    {
        auth()->logout();

        $this->get(route('admin.lists.index'))->assertRedirect(route('login'));
    }

    public function test_halaman_publik_menampilkan_tautan_unduh_berkas(): void
    {
        Storage::fake('public');

        $list = $this->makeList(['status' => 'published']);
        $column = $this->makeColumn($list, ['label' => 'Lampiran', 'type' => 'file']);
        $item = $this->makeItem($list);
        $file = $this->attachFile($item, $column, 'panduan.pdf');

        $response = $this->get(route('lists.show', $list->slug));

        $response->assertOk();
        $response->assertSee(route('lists.file.download', $file->id), false);
        $response->assertSee('panduan.pdf');
    }

    public function test_mengunduh_berkas_dengan_nama_asli(): void
    {
        Storage::fake('public');

        $list = $this->makeList(['status' => 'published']);
        $column = $this->makeColumn($list, ['label' => 'Lampiran', 'type' => 'file']);
        $item = $this->makeItem($list);
        $file = $this->attachFile($item, $column, 'panduan.pdf', 'ISI PANDUAN UJI');

        $response = $this->get(route('lists.file.download', $file->id));

        $response->assertOk();
        $response->assertDownload('panduan.pdf');
        $this->assertStringContainsString('ISI PANDUAN UJI', $response->streamedContent());
    }

    public function test_mengunduh_berkas_yang_tidak_ada_di_disk_menghasilkan_404(): void
    {
        Storage::fake('public');

        $list = $this->makeList(['status' => 'published']);
        $column = $this->makeColumn($list, ['label' => 'Lampiran', 'type' => 'file']);
        $item = $this->makeItem($list);
        $file = $this->attachFile($item, $column, 'hilang.pdf');

        Storage::disk('public')->delete($file->path);

        $this->get(route('lists.file.download', $file->id))->assertNotFound();
    }

    public function test_mengunduh_berkas_dengan_id_tidak_dikenal_menghasilkan_404(): void
    {
        $this->get(route('lists.file.download', 999999))->assertNotFound();
    }
}
