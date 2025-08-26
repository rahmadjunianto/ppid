<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::query();

        // Filter berdasarkan unit kerja
        if ($request->filled('unit_kerja')) {
            $query->where('unit_kerja', 'like', '%' . $request->unit_kerja . '%');
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('jabatan', 'like', '%' . $request->search . '%')
                  ->orWhere('golongan', 'like', '%' . $request->search . '%');
            });
        }

        $pegawai = $query->ordered()->paginate(15);

        // Data untuk filter
        $unitKerja = Pegawai::select('unit_kerja')
            ->distinct()
            ->orderBy('unit_kerja')
            ->pluck('unit_kerja');

        return view('admin.pegawai.index', compact('pegawai', 'unitKerja'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'golongan' => 'nullable|string|max:50',
            'unit_kerja' => 'required|string|max:255',
            'urutan' => 'nullable|integer|min:0'
        ]);

        Pegawai::create($request->all());

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function show(Pegawai $pegawai)
    {
        return view('admin.pegawai.show', compact('pegawai'));
    }

    public function edit(Pegawai $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'golongan' => 'nullable|string|max:50',
            'unit_kerja' => 'required|string|max:255',
            'urutan' => 'nullable|integer|min:0'
        ]);

        $pegawai->update($request->all());

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }
}
