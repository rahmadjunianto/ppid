<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrupDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GrupDokumenController extends Controller
{
    public function index()
    {
        $grupDokumens = GrupDokumen::ordered()->get();
        return view('admin.grup_dokumens.index', compact('grupDokumens'));
    }

    public function create()
    {
        return view('admin.grup_dokumens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_grup' => 'required|string|max:255|unique:grup_dokumens,nama_grup',
            'deskripsi' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->nama_grup);
        $validated['is_active'] = $request->boolean('is_active', true);

        GrupDokumen::create($validated);

        return redirect()->route('admin.grup-dokumens.index')
            ->with('success', 'Kategori dokumen berhasil ditambahkan.');
    }

    public function edit(GrupDokumen $grupDokumen)
    {
        return view('admin.grup_dokumens.edit', compact('grupDokumen'));
    }

    public function update(Request $request, GrupDokumen $grupDokumen)
    {
        $validated = $request->validate([
            'nama_grup' => [
                'required',
                'string',
                'max:255',
                Rule::unique('grup_dokumens', 'nama_grup')->ignore($grupDokumen->id),
            ],
            'deskripsi' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->nama_grup);
        $validated['is_active'] = $request->boolean('is_active', true);

        $grupDokumen->update($validated);

        return redirect()->route('admin.grup-dokumens.index')
            ->with('success', 'Kategori dokumen berhasil diperbarui.');
    }

    public function destroy(GrupDokumen $grupDokumen)
    {
        $grupDokumen->delete();

        return redirect()->route('admin.grup-dokumens.index')
            ->with('success', 'Kategori dokumen berhasil dihapus.');
    }
}
