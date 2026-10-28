<?php

namespace App\Http\Controllers;

use App\Models\InformasiSetiapSaat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicInformasiSetiapSaatController extends Controller
{
    /**
     * Display Informasi Setiap Saat
     */
    public function index(Request $request)
    {
        $search = $request->get("search");

        $query = InformasiSetiapSaat::published();

        if ($search) {
            $query->where("judul", "like", "%{$search}%");
        }

        $items = $query->ordered()->get();
        $total = InformasiSetiapSaat::published()->count();

        return view("pages.informasi-setiap-saat", [
            "items" => $items,
            "search" => $search,
            "total" => $total,
        ]);
    }

    /**
     * Open file in browser
     */
    public function view($id)
    {
        $item = InformasiSetiapSaat::published()->findOrFail($id);

        if (!$item->file) {
            abort(404, "File tidak ditemukan");
        }

        if (!Storage::disk('public')->exists($item->file)) {
            abort(404, "File tidak ditemukan");
        }

        $pdfUrl = asset("storage/" . $item->file);

        return view("pages.informasi-setiap-saat-view", compact("item", "pdfUrl"));
    }

    /**
     * Download file
     */
    public function download($id)
    {
        $item = InformasiSetiapSaat::published()->findOrFail($id);

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
}
