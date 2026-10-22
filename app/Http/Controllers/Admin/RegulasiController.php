<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regulasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegulasiController extends Controller
{
    /**
     * Display a listing of Regulasi.
     */
    public function index(Request $request)
    {
        $query = Regulasi::query();

        // Search by nama_regulasi / nomor
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_regulasi', 'like', "%{$search}%")
                  ->orWhere('nomor', 'like', "%{$search}%");
            });
        }

        // Filter by tingkat
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $regulasi = $query->ordered()->paginate(15)->withQueryString();

        $tingkatOptions = Regulasi::getTingkatOptions();
        $tahunOptions   = Regulasi::getTahunOptions();

        return view('admin.regulasi.index', compact('regulasi', 'tingkatOptions', 'tahunOptions'));
    }

    /**
     * Show the form for creating a new Regulasi.
     */

    /**
     * Store a newly created Regulasi in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_regulasi' => 'required|string|max:255',
            'nomor'         => 'nullable|string|max:255',
            'tingkat'       => ['required', Rule::in(array_keys(Regulasi::getTingkatOptions()))],
            'tahun'         => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'link_type'     => 'required|in:file,link',
            'file'          => 'required_if:link_type,file|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'link_url'      => 'required_if:link_type,link|nullable|url|max:255',
            'status'        => 'required|in:draft,published',
            'sort_order'    => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['admin_id'] = auth()->id();

        if ($request->hasFile('file')) {
            $file     = $request->file('file');
            $filename = time() . '_' . Str::random(6) . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('regulasi', $filename, 'public');

            $data['file']   = $path;
            $data['ukuran'] = $file->getSize();
        }

        // Normalisasi field sesuai link_type
        if ($data['link_type'] === 'link') {
            $data['file'] = null;
        } else {
            $data['link_url'] = null;
        }

        Regulasi::create($data);

        return redirect()->route('admin.regulasi.index')
                        ->with('success', 'Regulasi berhasil ditambahkan.');
    }

    /**
     * Display the specified Regulasi.
     */
    public function show($id)
    {
        $regulasi = Regulasi::findOrFail($id);

        return view('admin.regulasi.show', compact('regulasi'));
    }

    /**
     * Show the form for editing the specified Regulasi.
     */
    public function edit($id)
    {
        $regulasi      = Regulasi::findOrFail($id);
        $tingkatOptions = Regulasi::getTingkatOptions();

        return view('admin.regulasi.edit', compact('regulasi', 'tingkatOptions'));
    }

    public function create()
    {
        $tingkatOptions = Regulasi::getTingkatOptions();

        return view('admin.regulasi.create', compact('tingkatOptions'));
    }


    /**
     * Update the specified Regulasi in storage.
     */
    public function update(Request $request, $id)
    {
        $regulasi = Regulasi::findOrFail($id);

        $request->validate([
            'nama_regulasi' => 'required|string|max:255',
            'nomor'         => 'nullable|string|max:255',
            'tingkat'       => ['required', Rule::in(array_keys(Regulasi::getTingkatOptions()))],
            'tahun'         => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'link_type'     => 'required|in:file,link',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'link_url'      => 'nullable|url|max:255',
            'status'        => 'required|in:draft,published',
            'sort_order'    => 'nullable|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('file')) {
            // Hapus file lama bila ada
            if ($regulasi->file) {
                Storage::disk('public')->delete($regulasi->file);
            }

            $file     = $request->file('file');
            $filename = time() . '_' . Str::random(6) . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('regulasi', $filename, 'public');

            $data['file']   = $path;
            $data['ukuran'] = $file->getSize();
        }

        // Normalisasi field sesuai link_type
        if ($data['link_type'] === 'link') {
            $data['file'] = null;
        } else {
            $data['link_url'] = null;
        }

        $regulasi->update($data);

        return redirect()->route('admin.regulasi.index')
                        ->with('success', 'Regulasi berhasil diperbarui.');
    }

    /**
     * Remove the specified Regulasi from storage.
     */
    public function destroy($id)
    {
        $regulasi = Regulasi::findOrFail($id);

        // Hapus file terkait bila ada
        if ($regulasi->file) {
            Storage::disk('public')->delete($regulasi->file);
        }

        $regulasi->delete();

        return redirect()->route('admin.regulasi.index')
                        ->with('success', 'Regulasi berhasil dihapus.');
    }
}
