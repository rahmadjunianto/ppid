<?php

namespace App\Http\Controllers;

use App\Models\DynamicList;
use App\Models\DynamicListItemFile;
use Illuminate\Support\Facades\Storage;

class PublicDynamicListController extends Controller
{
    /**
     * Tampilkan daftar published beserta kolom dan datanya.
     */
    public function show(string $slug)
    {
        $dynamicList = DynamicList::published()
            ->where('slug', $slug)
            ->first();

        abort_if($dynamicList === null, 404, 'Daftar tidak ditemukan.');

        $dynamicList->load(['columns']);

        $items = $dynamicList->items()->with('files')->get();

        return view('lists.show', compact('dynamicList', 'items'));
    }

    /**
     * Unduh file yang terlampir pada sebuah baris daftar.
     */
    public function downloadFile(DynamicListItemFile $file)
    {
        abort_unless(Storage::disk('public')->exists($file->path), 404, 'File tidak ditemukan.');

        return Storage::disk('public')->download(
            $file->path,
            $file->original_name,
            ['Content-Type' => $file->mime_type ?: 'application/octet-stream']
        );
    }
}
