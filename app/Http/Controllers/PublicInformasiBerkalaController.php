<?php

namespace App\Http\Controllers;

use App\Models\InformasiBerkala;
use Illuminate\Http\Request;
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

        return view("pages.informasi-berkala", [
            "items" => $items,
            "itemsByKategori" => $itemsByKategori,
            "kategori" => $kategori,
            "search" => $search,
            "kategoriOptions" => $kategoriOptions,
            "selectedKategori" => $selectedKategori,
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

        $filePath = storage_path("app/public/" . $item->file);

        if (!file_exists($filePath)) {
            abort(404, "File tidak ditemukan");
        }

        $extension = pathinfo($item->file, PATHINFO_EXTENSION);
        $filename = Str::slug($item->judul) . "." . $extension;

        return response()->download($filePath, $filename);
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

        $filePath = storage_path("app/public/" . $item->file);

        if (!file_exists($filePath)) {
            abort(404, "File tidak ditemukan");
        }

        $pdfUrl = asset("storage/" . $item->file);
        $kategoriOptions = InformasiBerkala::getKategoriOptions();

        return view("pages.informasi-berkala-view", compact("item", "pdfUrl", "kategoriOptions"));
    }
}
