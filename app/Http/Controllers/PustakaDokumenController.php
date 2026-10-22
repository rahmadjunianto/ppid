<?php

namespace App\Http\Controllers;

use App\Models\GrupDokumen;
use App\Models\PustakaDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PustakaDokumenController extends Controller
{
    public function index(Request $request)
    {
        $grupAktif = $request->get('grup');
        $search = $request->get('search');

        // Get active grups
        $grupDokumens = GrupDokumen::active()->ordered()->get();

        // Query documents
        $query = PustakaDokumen::with('grupDokumen')->latest();

        if ($grupAktif) {
            $grup = GrupDokumen::where('slug', $grupAktif)->first();
            if ($grup) {
                $query->where('grup_dokumen_id', $grup->id);
            }
        }

        if ($search) {
            $query->search($search);
        }

        $dokumens = $query->paginate(10)->withQueryString();

        // Get selected grup name
        $selectedGrup = $grupAktif 
            ? GrupDokumen::where('slug', $grupAktif)->first()?->nama_grup 
            : 'Semua Grup';

        return view('pages.pustaka-dokumen', compact(
            'dokumens',
            'grupDokumens',
            'grupAktif',
            'search',
            'selectedGrup'
        ));
    }

    public function download($slug)
    {
        $dokumen = PustakaDokumen::findBySlug($slug);

        if (!$dokumen) {
            abort(404, 'Dokumen tidak ditemukan');
        }

        if ($dokumen->link_type !== 'file' || !$dokumen->file) {
            abort(404, 'File tidak ditemukan');
        }

        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($dokumen->file)) {
            abort(404, 'File tidak ditemukan');
        }

        // Catat jumlah dilihat saat file diunduh
        $dokumen->increment('view_count');

        $extension = pathinfo($dokumen->file, PATHINFO_EXTENSION);
        $filename = Str::slug($dokumen->nama_dokumen) . '.' . $extension;

        return \Illuminate\Support\Facades\Storage::disk('public')->download($dokumen->file, $filename);
    }

    public function view($slug)
    {
        $dokumen = PustakaDokumen::findBySlug($slug);

        if (!$dokumen) {
            abort(404, 'Dokumen tidak ditemukan');
        }

        if ($dokumen->link_type !== 'file' || !$dokumen->file) {
            abort(404, 'File tidak ditemukan');
        }

        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($dokumen->file)) {
            abort(404, 'File tidak ditemukan');
        }

        // Catat jumlah dilihat saat file dibuka
        $dokumen->increment('view_count');

        $fileUrl = asset('storage/' . $dokumen->file);

        return view('pages.pustaka-dokumen-view', compact('dokumen', 'fileUrl'));
    }

    /**
     * Redirect ke URL eksternal sambil mencatat jumlah dilihat.
     */
    public function link($slug)
    {
        $dokumen = PustakaDokumen::findBySlug($slug);

        if (!$dokumen) {
            abort(404, 'Dokumen tidak ditemukan');
        }

        if ($dokumen->link_type !== 'link' || !$dokumen->link_url) {
            abort(404, 'Link tidak ditemukan');
        }

        // Catat jumlah dilihat saat tautan eksternal diklik
        $dokumen->increment('view_count');

        return redirect()->away($dokumen->link_url);
    }
}
