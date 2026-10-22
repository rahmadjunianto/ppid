<?php

namespace App\Http\Controllers;

use App\Models\Regulasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegulasiController extends Controller
{
    /**
     * Halaman daftar Regulasi & Peraturan.
     *
     * Mendukung tab: semua (default), pusat, kankemenag.
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'semua');

        if (! in_array($tab, ['semua', 'pusat', 'kankemenag'], true)) {
            $tab = 'semua';
        }

        $search = $request->get('search');

        $query = Regulasi::published();

        if ($tab !== 'semua') {
            $query->where('tingkat', $tab);
        }

        if ($search) {
            $query->search($search);
        }

        $regulasi = $query->ordered()->paginate(15)->withQueryString();

        // Jumlah data per tingkat (untuk tab)
        $counts = [
            'semua'      => Regulasi::published()->count(),
            'pusat'      => Regulasi::published()->tingkat('pusat')->count(),
            'kankemenag' => Regulasi::published()->tingkat('kankemenag')->count(),
        ];

        return view('pages.regulasi', compact('regulasi', 'tab', 'search', 'counts'));
    }

    /**
     * Unduh dokumen regulasi (file yang diunggah di dashboard admin).
     */
    public function download($id)
    {
        $regulasi = Regulasi::published()->findOrFail($id);

        if ($regulasi->link_type !== 'file' || ! $regulasi->file) {
            abort(404, 'File tidak ditemukan');
        }

        if (! Storage::disk('public')->exists($regulasi->file)) {
            abort(404, 'File tidak ditemukan');
        }

        // Catat jumlah dilihat saat file diunduh
        $regulasi->increment('view_count');

        $extension = pathinfo($regulasi->file, PATHINFO_EXTENSION);
        $filename = Str::slug($regulasi->nama_regulasi) . '.' . $extension;

        return Storage::disk('public')->download($regulasi->file, $filename);
    }

    /**
     * Tampilkan dokumen regulasi di dalam browser (PDF).
     */
    public function view($id)
    {
        $regulasi = Regulasi::published()->findOrFail($id);

        if ($regulasi->link_type !== 'file' || ! $regulasi->file) {
            abort(404, 'File tidak ditemukan');
        }

        if (! Storage::disk('public')->exists($regulasi->file)) {
            abort(404, 'File tidak ditemukan');
        }

        // Catat jumlah dilihat saat file dibuka
        $regulasi->increment('view_count');

        $pdfUrl = asset('storage/' . $regulasi->file);

        return view('pages.regulasi-view', compact('regulasi', 'pdfUrl'));
    }

    /**
     * Redirect ke URL dokumen eksternal sambil mencatat jumlah dilihat.
     */
    public function link($id)
    {
        $regulasi = Regulasi::published()->findOrFail($id);

        if ($regulasi->link_type !== 'link' || ! $regulasi->link_url) {
            abort(404, 'Tautan tidak ditemukan');
        }

        // Catat jumlah dilihat saat tautan eksternal diklik
        $regulasi->increment('view_count');

        return redirect()->away($regulasi->link_url);
    }
}
