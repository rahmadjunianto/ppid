<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicList;
use App\Models\DynamicListColumn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DynamicListColumnController extends Controller
{
    public function index(DynamicList $dynamicList)
    {
        $columns = $dynamicList->columns()->get();

        return view('admin.lists.columns.index', compact('dynamicList', 'columns'));
    }

    public function create(DynamicList $dynamicList)
    {
        return view('admin.lists.columns.create', compact('dynamicList'));
    }

    public function store(Request $request, DynamicList $dynamicList)
    {
        $validated = $this->validateColumn($request, $dynamicList);

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_multiple'] = $request->boolean('is_multiple');
        $validated['is_required'] = $request->boolean('is_required');
        $validated['options'] = $this->parseOptions($request, $validated['type']);
        $validated['width'] = $this->resolveWidth($request);
        $validated['key'] = $this->resolveKey($request, $dynamicList);

        $dynamicList->columns()->create($validated);

        return redirect()->route('admin.lists.columns.index', $dynamicList)
            ->with('success', 'Kolom "'.$validated['label'].'" berhasil ditambahkan.');
    }

    public function edit(DynamicList $dynamicList, DynamicListColumn $column)
    {
        $this->ensureBelongsTo($dynamicList, $column);

        return view('admin.lists.columns.edit', compact('dynamicList', 'column'));
    }

    public function update(Request $request, DynamicList $dynamicList, DynamicListColumn $column)
    {
        $this->ensureBelongsTo($dynamicList, $column);

        $validated = $this->validateColumn($request, $dynamicList, $column->id);

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_multiple'] = $request->boolean('is_multiple');
        $validated['is_required'] = $request->boolean('is_required');
        $validated['options'] = $this->parseOptions($request, $validated['type']);
        $validated['width'] = $this->resolveWidth($request);

        // Bila key diubah, pindahkan nilai data pada item ke key baru.
        $newKey = $this->resolveKey($request, $dynamicList, $column->id);

        if ($newKey !== $column->key) {
            $this->migrateItemValues($dynamicList, $column->key, $newKey);
        }

        $validated['key'] = $newKey;

        $column->update($validated);

        return redirect()->route('admin.lists.columns.index', $dynamicList)
            ->with('success', 'Kolom berhasil diperbarui.');
    }

    public function destroy(DynamicList $dynamicList, DynamicListColumn $column)
    {
        $this->ensureBelongsTo($dynamicList, $column);

        // Hapus file yang menempel pada kolom ini.
        foreach ($column->files()->get() as $file) {
            if ($file->path && Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }
            $file->delete();
        }

        // Bersihkan nilai kolom pada seluruh item.
        $this->migrateItemValues($dynamicList, $column->key, null);

        $column->delete();

        return redirect()->route('admin.lists.columns.index', $dynamicList)
            ->with('success', 'Kolom berhasil dihapus beserta datanya.');
    }

    /**
     * Simpan urutan kolom baru.
     */
    public function updateOrder(Request $request, DynamicList $dynamicList)
    {
        $order = (array) $request->input('order', []);

        foreach (array_values($order) as $index => $columnId) {
            $dynamicList->columns()->where('id', $columnId)->update(['sort_order' => $index]);
        }

        return back()->with('success', 'Urutan kolom berhasil diperbarui.');
    }


    /**
     * Validasi input kolom. Kolom aksi wajib memilih salah satu dari
     * link internal, link eksternal, atau upload file.
     */
    private function validateColumn(Request $request, DynamicList $dynamicList, ?int $ignoreId = null): array
    {
        return $request->validate([
            'label' => 'required|string|max:255',
            'key' => 'nullable|string|max:100',
            'type' => ['required', Rule::in(array_keys(DynamicListColumn::TYPES))],
            'action_type' => [
                'nullable',
                'required_if:type,action',
                Rule::in(array_keys(DynamicListColumn::ACTION_TYPES)),
            ],
            'options_text' => 'nullable|string|max:5000',
            'is_multiple' => 'nullable|boolean',
            'is_required' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'width' => 'nullable|integer|min:'.DynamicListColumn::MIN_WIDTH.'|max:'.DynamicListColumn::MAX_WIDTH,
        ], [
            'action_type.required_if' => 'Kolom aksi wajib memilih jenis aksi: link internal, link eksternal, atau upload file.',
            'type.in' => 'Tipe kolom tidak valid.',
            'action_type.in' => 'Jenis aksi tidak valid.',
            'width.integer' => 'Lebar kolom harus berupa angka (piksel).',
            'width.min' => 'Lebar kolom minimal '.DynamicListColumn::MIN_WIDTH.' piksel.',
            'width.max' => 'Lebar kolom maksimal '.DynamicListColumn::MAX_WIDTH.' piksel.',
        ]);
    }

    /**
     * Opsi dropdown ditulis satu per baris dengan format "Label | value".
     */
    private function parseOptions(Request $request, string $type): ?array
    {
        if ($type !== 'select') {
            return null;
        }

        $text = (string) $request->input('options_text');
        $options = [];

        foreach (preg_split('/\r\n|\r|\n/', $text) as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            if (str_contains($line, '|')) {
                [$label, $value] = array_pad(explode('|', $line, 2), 2, '');
                $label = trim($label);
                $value = trim($value);
            } else {
                $label = $line;
                $value = $line;
            }

            if ($value === '') {
                continue;
            }

            $options[] = ['label' => $label !== '' ? $label : $value, 'value' => $value];
        }

        return $options;
    }

    /**
     * Normalisasi lebar kolom (piksel). Kosong berarti otomatis (null).
     */
    private function resolveWidth(Request $request): ?int
    {
        if (! $request->filled('width')) {
            return null;
        }

        return (int) $request->input('width');
    }

    /**
     * Tentukan key kolom: pakai input manual bila diisi, jika tidak otomatis dari label.
     */
    private function resolveKey(Request $request, DynamicList $dynamicList, ?int $ignoreId = null): string
    {
        $manual = trim((string) $request->input('key'));

        if ($manual !== '') {
            $base = \Illuminate\Support\Str::slug($manual) ?: 'kolom';
            $key = $base;
            $counter = 1;

            while ($dynamicList->columns()
                ->where('key', $key)
                ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
                ->exists()) {
                $key = $base.'_'.(++$counter);
            }

            return $key;
        }

        return DynamicListColumn::uniqueKey((string) $request->input('label'), $dynamicList->id, $ignoreId);
    }

    /**
     * Pastikan kolom memang milik daftar yang diakses.
     */
    private function ensureBelongsTo(DynamicList $dynamicList, DynamicListColumn $column): void
    {
        abort_unless($column->dynamic_list_id === $dynamicList->id, 404);
    }

    /**
     * Pindahkan (atau hapus bila null) nilai sebuah kolom pada semua item daftar.
     */
    private function migrateItemValues(DynamicList $dynamicList, string $oldKey, ?string $newKey): void
    {
        foreach ($dynamicList->items()->get() as $item) {
            $data = is_array($item->data) ? $item->data : [];

            if (! array_key_exists($oldKey, $data)) {
                continue;
            }

            $value = $data[$oldKey];
            unset($data[$oldKey]);

            if ($newKey !== null) {
                $data[$newKey] = $value;
            }

            $item->update(['data' => $data]);
        }
    }
}
