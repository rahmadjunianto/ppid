<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::ordered();

        // Filter berdasarkan unit kerja jika ada
        if ($request->filled('unit_kerja')) {
            $query->where('unit_kerja', 'like', '%' . $request->unit_kerja . '%');
        }

        // Filter berdasarkan nama jika ada
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('jabatan', 'like', '%' . $request->search . '%')
                  ->orWhere('golongan', 'like', '%' . $request->search . '%')
                  ->orWhere('unit_kerja', 'like', '%' . $request->search . '%');
            });
        }

        $pegawai = $query->paginate(12);

        // Dapatkan daftar unit kerja untuk filter
        $unitKerja = Pegawai::select('unit_kerja')
            ->distinct()
            ->orderBy('unit_kerja')
            ->pluck('unit_kerja');

        return view('pegawai.index', compact('pegawai', 'unitKerja'));
    }

    public function show($id)
    {
        $pegawai = Pegawai::where('status', 'aktif')->findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }
}
