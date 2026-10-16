<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiBerkala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;

class InformasiBerkalaController extends Controller
{
    public function index(Request $request)
    {
        $query = InformasiBerkala::query();
        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $informasi = $query->ordered()->paginate(15);
        return view('admin.informasi-berkala.index', [
            'informasi' => $informasi,
            'kategoriOptions' => InformasiBerkala::getKategoriOptions()
        ]);
    }

    public function create()
    {
        return view('admin.informasi-berkala.create', [
            'kategoriOptions' => InformasiBerkala::getKategoriOptions()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|in:A,B,C,D,E',
            'judul' => 'required|string|max:255',
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
            $path = $file->storeAs('informasi-berkala', $filename, 'public');
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

        InformasiBerkala::create($data);
        return redirect()->route('admin.informasi-berkala.index')->with('success', 'Informasi Berkala berhasil ditambahkan.');
    }

    public function show(InformasiBerkala $informasiBerkala)
    {
        return view('admin.informasi-berkala.show', compact('informasiBerkala'));
    }

    public function edit(InformasiBerkala $informasiBerkala)
    {
        return view('admin.informasi-berkala.edit', [
            'informasiBerkala' => $informasiBerkala,
            'kategoriOptions' => InformasiBerkala::getKategoriOptions()
        ]);
    }

    public function update(Request $request, InformasiBerkala $informasiBerkala)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|in:A,B,C,D,E',
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:informasi_berkala,slug,' . $informasiBerkala->id,
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
            if ($informasiBerkala->file && Storage::disk('public')->exists($informasiBerkala->file)) {
                Storage::disk('public')->delete($informasiBerkala->file);
            }
            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('informasi-berkala', $filename, 'public');
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

        $informasiBerkala->update($data);
        return redirect()->route('admin.informasi-berkala.index')->with('success', 'Informasi Berkala berhasil diperbarui.');
    }

    public function destroy(InformasiBerkala $informasiBerkala)
    {
        if ($informasiBerkala->file && Storage::disk('public')->exists($informasiBerkala->file)) {
            Storage::disk('public')->delete($informasiBerkala->file);
        }
        $informasiBerkala->delete();
        return redirect()->route('admin.informasi-berkala.index')->with('success', 'Informasi Berkala berhasil dihapus.');
    }
}
