<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicList;
use App\Models\DynamicListColumn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DynamicListController extends Controller
{
    public function index(Request $request)
    {
        $query = DynamicList::withCount(['columns', 'items'])->ordered();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('slug', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $lists = $query->paginate(15)->withQueryString();

        return view('admin.lists.index', compact('lists'));
    }

    public function create()
    {
        return view('admin.lists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:dynamic_lists,slug',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|in:draft,published,archived',
            'show_title' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = $this->resolveSlug($request);
        $validated['show_title'] = $request->boolean('show_title');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['created_by'] = auth()->id();

        $list = DynamicList::create($validated);

        return redirect()->route('admin.lists.columns.index', $list)
            ->with('success', 'Daftar berhasil dibuat. Silakan tambahkan kolom dinamis.');
    }

    public function show(DynamicList $dynamicList)
    {
        $dynamicList->load(['columns', 'items.files']);

        return view('admin.lists.show', compact('dynamicList'));
    }

    public function edit(DynamicList $dynamicList)
    {
        return view('admin.lists.edit', compact('dynamicList'));
    }

    public function update(Request $request, DynamicList $dynamicList)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:dynamic_lists,slug,'.$dynamicList->id,
            'description' => 'nullable|string|max:2000',
            'status' => 'required|in:draft,published,archived',
            'show_title' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = $this->resolveSlug($request, $dynamicList->id);
        $validated['show_title'] = $request->boolean('show_title');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $dynamicList->update($validated);

        return redirect()->route('admin.lists.index')
            ->with('success', 'Daftar berhasil diperbarui.');
    }

    public function destroy(DynamicList $dynamicList)
    {
        $this->deleteListFiles($dynamicList);

        $dynamicList->delete();

        return redirect()->route('admin.lists.index')
            ->with('success', 'Daftar berhasil dihapus.');
    }

    public function toggleStatus(DynamicList $dynamicList)
    {
        $status = $dynamicList->status === 'published' ? 'draft' : 'published';

        $dynamicList->update([
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null,
        ]);

        return back()->with('success', 'Status daftar berhasil diubah menjadi '.ucfirst($status).'.');
    }


    /**
     * Salin definisi daftar beserta kolomnya (tanpa data/baris).
     */
    public function duplicate(DynamicList $dynamicList)
    {
        $copy = DynamicList::create([
            'title' => $dynamicList->title.' (Salinan)',
            'slug' => DynamicList::uniqueSlug($dynamicList->title.' (Salinan)'),
            'description' => $dynamicList->description,
            'status' => 'draft',
            'show_title' => $dynamicList->show_title,
            'sort_order' => (int) $dynamicList->sort_order + 1,
            'created_by' => auth()->id(),
        ]);

        foreach ($dynamicList->columns as $column) {
            $copy->columns()->create([
                'key' => DynamicListColumn::uniqueKey($column->label, $copy->id),
                'label' => $column->label,
                'type' => $column->type,
                'options' => $column->options,
                'action_type' => $column->action_type,
                'is_multiple' => $column->is_multiple,
                'is_required' => $column->is_required,
                'sort_order' => $column->sort_order,
                'width' => $column->width,
            ]);
        }

        return redirect()->route('admin.lists.columns.index', $copy)
            ->with('success', 'Daftar berhasil disalin. Data/baris tidak ikut disalin.');
    }

    /**
     * Slug manual tetap dipakai bila diisi dan valid, selain itu otomatis dari judul.
     */
    private function resolveSlug(Request $request, ?int $ignoreId = null): string
    {
        $manual = trim((string) $request->input('slug'));

        if ($manual !== '') {
            return Str::slug($manual) ?: DynamicList::uniqueSlug((string) $request->input('title'), $ignoreId);
        }

        return DynamicList::uniqueSlug((string) $request->input('title'), $ignoreId);
    }

    /**
     * Hapus seluruh file fisik milik daftar ini beserta recordnya.
     */
    private function deleteListFiles(DynamicList $dynamicList): void
    {
        $files = $dynamicList->items()
            ->with('files')
            ->get()
            ->flatMap(fn ($item) => $item->files);

        foreach ($files as $file) {
            if ($file->path && Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }
        }
    }
}
