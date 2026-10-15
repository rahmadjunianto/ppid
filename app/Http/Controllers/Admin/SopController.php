<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SopController extends Controller
{
    /**
     * Display a listing of SOP.
     */
    public function index(Request $request)
    {
        $query = Sop::query();

        // Search by nama_dokumen
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_dokumen', 'like', "%{$search}%")
                  ->orWhere('nomor', 'like', "%{$search}%");
            });
        }

        // Filter by grup
        if ($request->filled('grup')) {
            $query->where('grup', $request->grup);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $sops = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(15);
        $grupOptions = Sop::getGrupOptions();
        $tahunOptions = Sop::getTahunOptions();

        return view('admin.sops.index', compact('sops', 'grupOptions', 'tahunOptions'));
    }

    /**
     * Show the form for creating a new SOP.
     */
    public function create()
    {
        $grupOptions = Sop::getGrupOptions();
        return view('admin.sops.create', compact('grupOptions'));
    }

    /**
     * Store a newly created SOP in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'grup' => 'required|in:SOP PPID,Sub Bag TU,Bimas,Pais,Pendma,PD Pontren',
            'nomor' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['admin_id'] = auth()->id();

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sops', $filename, 'public');
            $data['file'] = $path;
            $data['ukuran'] = $file->getSize();
        }

        Sop::create($data);

        return redirect()->route('admin.sops.index')
                        ->with('success', 'SOP berhasil ditambahkan.');
    }

    /**
     * Display the specified SOP.
     */
    public function show(Sop $sop)
    {
        return view('admin.sops.show', compact('sop'));
    }

    /**
     * Show the form for editing the specified SOP.
     */
    public function edit(Sop $sop)
    {
        $grupOptions = Sop::getGrupOptions();
        return view('admin.sops.edit', compact('sop', 'grupOptions'));
    }

    /**
     * Update the specified SOP in storage.
     */
    public function update(Request $request, Sop $sop)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'grup' => 'required|in:SOP PPID,Sub Bag TU,Bimas,Pais,Pendma,PD Pontren',
            'nomor' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();

        // Handle file upload (replace old file)
        if ($request->hasFile('file')) {
            // Delete old file
            if ($sop->file && Storage::disk('public')->exists($sop->file)) {
                Storage::disk('public')->delete($sop->file);
            }

            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sops', $filename, 'public');
            $data['file'] = $path;
            $data['ukuran'] = $file->getSize();
        } else {
            // Keep existing file fields
            unset($data['file']);
            unset($data['ukuran']);
        }

        $sop->update($data);

        return redirect()->route('admin.sops.index')
                        ->with('success', 'SOP berhasil diperbarui.');
    }

    /**
     * Remove the specified SOP from storage.
     */
    public function destroy(Sop $sop)
    {
        // Delete file
        if ($sop->file && Storage::disk('public')->exists($sop->file)) {
            Storage::disk('public')->delete($sop->file);
        }

        $sop->delete();

        return redirect()->route('admin.sops.index')
                        ->with('success', 'SOP berhasil dihapus.');
    }
}

