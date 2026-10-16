<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrupDokumen;
use App\Models\PustakaDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PustakaDokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = PustakaDokumen::with('grupDokumen')->latest();

        if ($request->filled('grup')) {
            $query->where('grup_dokumen_id', $request->grup);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $pustakaDokumens = $query->paginate(15)->withQueryString();
        $grupDokumens = GrupDokumen::active()->ordered()->get();

        return view('admin.pustaka_dokumens.index', compact('pustakaDokumens', 'grupDokumens'));
    }

    public function create()
    {
        $grupDokumens = GrupDokumen::active()->ordered()->get();
        return view('admin.pustaka_dokumens.create', compact('grupDokumens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'grup_dokumen_id' => 'required|exists:grup_dokumens,id',
            'nama_dokumen' => 'required|string|max:255',
            'nomor' => 'nullable|string|max:100',
            'tahun' => 'nullable|integer|min:2000|max:2100',
            'link_type' => 'required|in:file,link',
            'file' => 'nullable|required_if:link_type,file|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
            'link_url' => 'nullable|required_if:link_type,link|url',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $validated['created_by'] = auth()->id();

        if ($request->link_type === 'file' && $request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = Str::slug($validated['nama_dokumen']) . '-' . time() . '.' . $extension;
            $path = $file->storeAs('pustaka-dokumen', $filename, 'public');
            $validated['file'] = $path;
            $validated['ukuran'] = $this->formatFileSize($file->getSize());
        }

        PustakaDokumen::create($validated);

        return redirect()->route('admin.pustaka-dokumens.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function edit(PustakaDokumen $pustakaDokumen)
    {
        $grupDokumens = GrupDokumen::active()->ordered()->get();
        return view('admin.pustaka_dokumens.edit', compact('pustakaDokumen', 'grupDokumens'));
    }

    public function update(Request $request, PustakaDokumen $pustakaDokumen)
    {
        $validated = $request->validate([
            'grup_dokumen_id' => 'required|exists:grup_dokumens,id',
            'nama_dokumen' => 'required|string|max:255',
            'nomor' => 'nullable|string|max:100',
            'tahun' => 'nullable|integer|min:2000|max:2100',
            'link_type' => 'required|in:file,link',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
            'link_url' => 'nullable|required_if:link_type,link|url',
        ]);

        if ($request->link_type === 'file') {
            if ($request->hasFile('file')) {
                // Delete old file
                if ($pustakaDokumen->file && Storage::disk('public')->exists($pustakaDokumen->file)) {
                    Storage::disk('public')->delete($pustakaDokumen->file);
                }
                
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $filename = Str::slug($validated['nama_dokumen']) . '-' . time() . '.' . $extension;
                $path = $file->storeAs('pustaka-dokumen', $filename, 'public');
                $validated['file'] = $path;
                $validated['ukuran'] = $this->formatFileSize($file->getSize());
                $validated['link_url'] = null;
            }
        } else {
            // If switching to link type
            $validated['file'] = null;
            $validated['link_url'] = $request->link_url;
        }

        $pustakaDokumen->update($validated);

        return redirect()->route('admin.pustaka-dokumens.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(PustakaDokumen $pustakaDokumen)
    {
        // Delete file if exists
        if ($pustakaDokumen->file && Storage::disk('public')->exists($pustakaDokumen->file)) {
            Storage::disk('public')->delete($pustakaDokumen->file);
        }

        $pustakaDokumen->delete();

        return redirect()->route('admin.pustaka-dokumens.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    private function formatFileSize($bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
