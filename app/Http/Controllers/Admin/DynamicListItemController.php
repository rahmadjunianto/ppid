<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicList;
use App\Models\DynamicListColumn;
use App\Models\DynamicListItem;
use App\Models\DynamicListItemFile;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class DynamicListItemController extends Controller
{
    public function index(DynamicList $dynamicList)
    {
        $dynamicList->load(['columns']);

        $items = $dynamicList->items()->with('files')->get();

        return view('admin.lists.items.index', compact('dynamicList', 'items'));
    }

    public function create(DynamicList $dynamicList, Request $request)
    {
        $columns = $dynamicList->columns()->get();

        if ($columns->isEmpty()) {
            return redirect()->route('admin.lists.columns.index', $dynamicList)
                ->with('error', 'Tambahkan minimal satu kolom terlebih dahulu sebelum mengisi data.');
        }

        $jumlahRows = (int) $request->query('jumlah', 1);

        $oldItems = $request->session()->getOldInput('items');

        if (is_array($oldItems) && count($oldItems) > $jumlahRows) {
            $jumlahRows = count($oldItems);
        }

        $jumlahRows = max(1, min($jumlahRows, 50));

        $internalLinks = $this->internalLinkOptions();

        return view('admin.lists.items.create', compact('dynamicList', 'columns', 'jumlahRows', 'internalLinks'));
    }

    /**
     * Simpan banyak baris sekaligus (multiple form).
     */
    public function store(Request $request, DynamicList $dynamicList)
    {
        $columns = $dynamicList->columns()->get();

        if ($columns->isEmpty()) {
            return redirect()->route('admin.lists.columns.index', $dynamicList)
                ->with('error', 'Tambahkan minimal satu kolom terlebih dahulu sebelum mengisi data.');
        }

        $request->validate($this->buildRules($columns));

        $rows = (array) $request->input('items', []);

        if (count($rows) === 0) {
            return redirect()->route('admin.lists.items.create', $dynamicList)
                ->withErrors(['items' => 'Minimal satu baris data harus diisi.'])
                ->withInput();
        }

        $saved = 0;
        $skipped = 0;
        $failed = [];
        $sortOrder = (int) $dynamicList->items()->max('sort_order');

        foreach ($rows as $index => $row) {
            $row = is_array($row) ? $row : [];

            if ($this->isEmptyRow($row, $columns, $request, $index)) {
                $skipped++;

                continue;
            }

            try {
                $this->saveRow($dynamicList, $columns, $row, $request, $index, ++$sortOrder);
                $saved++;
            } catch (Throwable $e) {
                $failed[] = 'Baris '.($index + 1).': '.$e->getMessage();
            }
        }

        if ($saved > 0) {
            $message = $saved.' baris data berhasil disimpan.';

            if ($skipped > 0) {
                $message .= ' '.$skipped.' baris kosong dilewati.';
            }

            if (count($failed) > 0) {
                $message .= ' '.count($failed).' baris gagal disimpan.';
            }

            return redirect()->route('admin.lists.items.index', $dynamicList)
                ->with('success', $message)
                ->with('failed_items', $failed);
        }

        return redirect()->route('admin.lists.items.create', $dynamicList)
            ->with('error', 'Gagal menyimpan data: '.(count($failed) > 0 ? implode('; ', $failed) : 'Tidak ada baris yang terisi.'))
            ->with('failed_items', $failed)
            ->withInput();
    }

    public function edit(DynamicList $dynamicList, DynamicListItem $item)
    {
        $this->ensureBelongsTo($dynamicList, $item);

        $columns = $dynamicList->columns()->get();
        $item->load('files');
        $internalLinks = $this->internalLinkOptions();

        return view('admin.lists.items.edit', compact('dynamicList', 'item', 'columns', 'internalLinks'));
    }

    public function update(Request $request, DynamicList $dynamicList, DynamicListItem $item)
    {
        $this->ensureBelongsTo($dynamicList, $item);

        $columns = $dynamicList->columns()->get();

        $request->validate($this->buildRules($columns, 'item'));

        try {
            $this->saveRow($dynamicList, $columns, (array) $request->input('item', []), $request, null, (int) $item->sort_order, $item);
        } catch (Throwable $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan data: '.$e->getMessage());
        }

        return redirect()->route('admin.lists.items.index', $dynamicList)
            ->with('success', 'Data baris berhasil diperbarui.');
    }

    public function destroy(DynamicList $dynamicList, DynamicListItem $item)
    {
        $this->ensureBelongsTo($dynamicList, $item);

        foreach ($item->files as $file) {
            $file->deleteFile();
            $file->delete();
        }

        $item->delete();

        return redirect()->route('admin.lists.items.index', $dynamicList)
            ->with('success', 'Baris data berhasil dihapus.');
    }

    /**
     * Simpan urutan baris baru.
     */
    public function updateOrder(Request $request, DynamicList $dynamicList)
    {
        $order = (array) $request->input('order', []);

        foreach (array_values($order) as $index => $itemId) {
            $dynamicList->items()->where('id', $itemId)->update(['sort_order' => $index]);
        }

        return back()->with('success', 'Urutan data berhasil diperbarui.');
    }

    /**
     * Susun aturan validasi dinamis mengikuti definisi kolom.
     *
     * @param  \Illuminate\Support\Collection  $columns
     */
    private function buildRules($columns, string $prefix = 'items'): array
    {
        $rules = [];

        foreach ($columns as $column) {
            $base = $prefix === 'items' ? $prefix.'.*.'.$column->key : $prefix.'.'.$column->key;

            if ($column->isFileType()) {
                // Kolom file (termasuk kolom aksi bertipe file): array of file
                $rules[$base] = ['nullable', 'array'];
                $rules[$base.'.*'] = ['file', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg', 'max:10240'];

                continue;
            }

            if ($column->is_multiple) {
                $rules[$base] = ['nullable', 'array'];

                foreach ($this->valueRules($column) as $singleRule) {
                    $rules[$base.'.*'] = $singleRule;
                }

                continue;
            }

            $rules[$base] = $this->valueRules($column);
        }

        // Minimal satu baris harus diisi.
        $rules[$prefix] = ['required', 'array'];

        return $rules;
    }

    /**
     * Aturan validasi untuk satu nilai kolom.
     *
     * Kolom wajib dicek manual di saveRow() supaya baris kosong
     * (baris tambahan yang tidak diisi user) tidak dianggap error.
     */
    private function valueRules(DynamicListColumn $column): array
    {
        if ($column->isAction()) {
            return match ($column->action_type) {
                'external' => ['nullable', 'string', 'max:2048', 'url'],
                default => ['nullable', 'string', 'max:2048'],
            };
        }

        return match ($column->type) {
            'number' => ['nullable', 'numeric'],
            'date' => ['nullable', 'date'],
            'boolean' => ['nullable', 'boolean'],
            'select' => ['nullable', 'string', 'max:255'],
            'textarea' => ['nullable', 'string', 'max:5000'],
            default => ['nullable', 'string', 'max:255'],
        };
    }

    /**
     * Simpan satu baris data beserta file yang diunggah.
     */
    private function saveRow(
        DynamicList $dynamicList,
        $columns,
        array $row,
        Request $request,
        ?int $index,
        int $sortOrder,
        ?DynamicListItem $existing = null
    ): DynamicListItem {
        $data = [];
        $uploadedFiles = [];

        foreach ($columns as $column) {
            $value = $row[$column->key] ?? null;

            if ($column->isFileType()) {
                $uploadedFiles[$column->key] = $this->collectFiles($request, $column, $index, $existing);

                continue;
            }

            if ($column->is_multiple) {
                $value = is_array($value) ? array_values(array_filter($value, fn ($v) => $v !== null && $v !== '')) : [];

                foreach ($value as $single) {
                    $this->validateValue($column, $single);
                }

                $data[$column->key] = $value;

                continue;
            }

            if ($value === '' || $value === null) {
                if ($column->is_required) {
                    throw new RuntimeException('Kolom "'.$column->label.'" wajib diisi.');
                }

                $data[$column->key] = null;

                continue;
            }

            $this->validateValue($column, $value);

            $data[$column->key] = $value;
        }

        // Kolom wajib bertipe multi harus punya minimal satu nilai.
        foreach ($columns as $column) {
            if ($column->is_required && $column->is_multiple && empty($data[$column->key] ?? [])) {
                throw new RuntimeException('Kolom "'.$column->label.'" wajib diisi minimal satu nilai.');
            }
        }

        $item = $existing ?: new DynamicListItem;
        $item->dynamic_list_id = $dynamicList->id;
        $item->sort_order = $sortOrder;
        $item->data = $data;
        $item->save();

        foreach ($uploadedFiles as $columnKey => $files) {
            $column = $columns->firstWhere('key', $columnKey);

            if (! $column) {
                continue;
            }

            foreach ($files as $file) {
                $this->storeFile($item, $column, $file);
            }
        }

        return $item;
    }

    /**
     * Validasi manual untuk satu nilai kolom.
     */
    private function validateValue(DynamicListColumn $column, $value): void
    {
        if ($column->isAction()) {
            if ($column->action_type === 'external' && ! filter_var($value, FILTER_VALIDATE_URL)) {
                throw new RuntimeException('Kolom "'.$column->label.'" harus berisi URL yang valid.');
            }

            if ($column->action_type === 'internal' && ! $this->isValidInternalLink($value)) {
                throw new RuntimeException('Kolom "'.$column->label.'" harus berisi path link internal yang valid.');
            }

            return;
        }

        if ($column->type === 'select') {
            $allowed = $column->optionValues();

            if (count($allowed) > 0 && ! in_array((string) $value, array_map('strval', $allowed), true)) {
                throw new RuntimeException('Nilai pada kolom "'.$column->label.'" tidak sesuai pilihan yang tersedia.');
            }
        }
    }

    /**
     * Link internal harus berupa path relatif (diawali /) tanpa skema eksternal.
     */
    private function isValidInternalLink($value): bool
    {
        $value = trim((string) $value);

        if ($value === '') {
            return false;
        }

        if (preg_match('#^(https?:)?//#i', $value)) {
            return false;
        }

        return str_starts_with($value, '/');
    }

    /**
     * Ambil file yang diunggah untuk sebuah kolom.
     */
    private function collectFiles(Request $request, DynamicListColumn $column, ?int $index, ?DynamicListItem $existing): array
    {
        $files = [];

        if ($index !== null) {
            $uploaded = $request->file('items.'.$index.'.'.$column->key, []);
        } else {
            $uploaded = $request->file('item.'.$column->key, []);
        }

        if ($uploaded instanceof UploadedFile) {
            $uploaded = [$uploaded];
        }

        foreach ((array) $uploaded as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $files[] = $file;
            }
        }

        // Pada mode edit, file lama tetap dipertahankan kecuali ditandai hapus.
        if ($existing && $index === null) {
            $removeIds = array_map('intval', (array) $request->input('remove_files.'.$column->key, []));

            foreach ($existing->files->where('dynamic_list_column_id', $column->id) as $oldFile) {
                if (in_array((int) $oldFile->id, $removeIds, true)) {
                    $oldFile->deleteFile();
                    $oldFile->delete();
                }
            }
        }

        return $files;
    }

    /**
     * Simpan satu file ke disk public dan catat recordnya.
     */
    private function storeFile(DynamicListItem $item, DynamicListColumn $column, UploadedFile $file): void
    {
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'-'.time().'-'.Str::random(4).'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('dynamic-lists', $filename, 'public');

        DynamicListItemFile::create([
            'dynamic_list_item_id' => $item->id,
            'dynamic_list_column_id' => $column->id,
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    /**
     * Deteksi baris yang kosong (tidak ada nilai yang diisi).
     */
    private function isEmptyRow(array $row, $columns, Request $request, int $index): bool
    {
        foreach ($columns as $column) {
            if ($column->isFileType()) {
                $uploaded = $request->file('items.'.$index.'.'.$column->key, []);

                if ($uploaded instanceof UploadedFile) {
                    return false;
                }

                foreach ((array) $uploaded as $file) {
                    if ($file instanceof UploadedFile) {
                        return false;
                    }
                }

                continue;
            }

            $value = $row[$column->key] ?? null;

            if (is_array($value)) {
                if (count(array_filter($value, fn ($v) => $v !== null && $v !== '')) > 0) {
                    return false;
                }

                continue;
            }

            if ($value !== null && $value !== '') {
                return false;
            }
        }

        return true;
    }

    /**
     * Opsi link internal: halaman yang sudah published.
     */
    private function internalLinkOptions(): array
    {
        return Page::published()
            ->orderBy('title')
            ->get()
            ->map(fn ($page) => [
                'value' => $this->internalPath($page),
                'label' => $page->title,
            ])
            ->values()
            ->all();
    }

    /**
     * Path relatif (tanpa domain) dari sebuah halaman.
     */
    private function internalPath(Page $page): string
    {
        $segments = collect([$page->slug]);
        $parent = $page->parent;

        while ($parent) {
            $segments->prepend($parent->slug);
            $parent = $parent->parent;
        }

        return '/'.$segments->implode('/');
    }

    /**
     * Pastikan item memang milik daftar yang diakses.
     */
    private function ensureBelongsTo(DynamicList $dynamicList, DynamicListItem $item): void
    {
        abort_unless((int) $item->dynamic_list_id === (int) $dynamicList->id, 404);
    }
}
