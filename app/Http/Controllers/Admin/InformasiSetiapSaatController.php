<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiSetiapSaat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;

class InformasiSetiapSaatController extends Controller
{
    public function index(Request $request)
    {
        $query = InformasiSetiapSaat::query();
        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }
        if ($request->filled('link_type')) {
            $query->where('link_type', $request->link_type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $informasi = $query->ordered()->paginate(15);
        return view('admin.informasi-setiap-saat.index', [
            'informasi' => $informasi,
            'linkTypeOptions' => InformasiSetiapSaat::getLinkTypeOptions()
        ]);
    }

    public function create()
    {
        return view('admin.informasi-setiap-saat.create', [
            'linkTypeOptions' => InformasiSetiapSaat::getLinkTypeOptions()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:informasi_setiap_saat,slug',
            'link' => 'nullable|string',
            'link_type' => 'required|in:internal,external,file',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
            'status' => 'required|in:published,draft',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['admin_id'] = auth()->id();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('informasi-setiap-saat', $filename, 'public');
            $data['file'] = $path;
            $data['ukuran'] = $file->getSize();
            if (empty($data['link'])) {
                $data['link'] = asset('storage/' . $path);
                $data['link_type'] = 'file';
            }
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['judul']) . '-' . time();
        }

        InformasiSetiapSaat::create($data);
        return redirect()->route('admin.informasi-setiap-saat.index')->with('success', 'Informasi Setiap Saat berhasil ditambahkan.');
    }

    public function show(InformasiSetiapSaat $informasiSetiapSaat)
    {
        return view('admin.informasi-setiap-saat.show', compact('informasiSetiapSaat'));
    }

    public function edit(InformasiSetiapSaat $informasiSetiapSaat)
    {
        return view('admin.informasi-setiap-saat.edit', [
            'informasiSetiapSaat' => $informasiSetiapSaat,
            'linkTypeOptions' => InformasiSetiapSaat::getLinkTypeOptions()
        ]);
    }

    public function update(Request $request, InformasiSetiapSaat $informasiSetiapSaat)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:informasi_setiap_saat,slug,' . $informasiSetiapSaat->id,
            'link' => 'nullable|string',
            'link_type' => 'required|in:internal,external,file',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
            'status' => 'required|in:published,draft',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('file')) {
            if ($informasiSetiapSaat->file && Storage::disk('public')->exists($informasiSetiapSaat->file)) {
                Storage::disk('public')->delete($informasiSetiapSaat->file);
            }
            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('informasi-setiap-saat', $filename, 'public');
            $data['file'] = $path;
            $data['ukuran'] = $file->getSize();
            if (empty($data['link'])) {
                $data['link'] = asset('storage/' . $path);
                $data['link_type'] = 'file';
            }
        } else {
            unset($data['file']);
            unset($data['ukuran']);
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['judul']) . '-' . time();
        }

        $informasiSetiapSaat->update($data);
        return redirect()->route('admin.informasi-setiap-saat.index')->with('success', 'Informasi Setiap Saat berhasil diperbarui.');
    }

    public function destroy(InformasiSetiapSaat $informasiSetiapSaat)
    {
        if ($informasiSetiapSaat->file && Storage::disk('public')->exists($informasiSetiapSaat->file)) {
            Storage::disk('public')->delete($informasiSetiapSaat->file);
        }
        $informasiSetiapSaat->delete();
        return redirect()->route('admin.informasi-setiap-saat.index')->with('success', 'Informasi Setiap Saat berhasil dihapus.');
    }
}
