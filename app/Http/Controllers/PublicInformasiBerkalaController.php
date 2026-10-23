<?php

namespace App\Http\Controllers;

use App\Models\InformasiBerkala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicInformasiBerkalaController extends Controller
{
    /**
     * Display Informasi Berkala by kategori
     */
    public function index(Request $request)
    {
        $kategori = $request->get("kategori");
        $search = $request->get("search");

        $query = InformasiBerkala::published();

        if ($kategori) {
            $query->where("kategori", $kategori);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where("judul", "like", "%{$search}%");
            });
        }

        $items = $query->ordered()->get();
        $itemsByKategori = $items->groupBy("kategori");

        $kategoriOptions = InformasiBerkala::getKategoriOptions();
        $selectedKategori = $kategori ? ($kategoriOptions[$kategori] ?? $kategori) : null;

        // Jumlah data per kategori (untuk opsi select filter)
        $counts = ["semua" => InformasiBerkala::published()->count()];
        foreach (array_keys($kategoriOptions) as $key) {
            $counts[$key] = InformasiBerkala::published()->where("kategori", $key)->count();
        }

        return view("pages.informasi-berkala", [
            "items" => $items,
            "itemsByKategori" => $itemsByKategori,
            "kategori" => $kategori,
            "search" => $search,
            "kategoriOptions" => $kategoriOptions,
            "selectedKategori" => $selectedKategori,
            "counts" => $counts,
        ]);
    }

    /**
     * Download file
     */
    public function download($id)
    {
        $item = InformasiBerkala::published()->findOrFail($id);

        if (!$item->file) {
            abort(404, "File tidak ditemukan");
        }

        if (!Storage::disk('public')->exists($item->file)) {
            abort(404, "File tidak ditemukan");
        }

        $extension = pathinfo($item->file, PATHINFO_EXTENSION);
        $filename = Str::slug($item->judul) . "." . $extension;

        return Storage::disk('public')->download($item->file, $filename);
    }

    /**
     * Open file in browser
     */
    public function view($id)
    {
        $item = InformasiBerkala::published()->findOrFail($id);

        if (!$item->file) {
            abort(404, "File tidak ditemukan");
        }

        if (!Storage::disk('public')->exists($item->file)) {
            abort(404, "File tidak ditemukan");
        }

        $pdfUrl = asset("storage/" . $item->file);
        $kategoriOptions = InformasiBerkala::getKategoriOptions();

        return view("pages.informasi-berkala-view", compact("item", "pdfUrl", "kategoriOptions"));
    }
}
