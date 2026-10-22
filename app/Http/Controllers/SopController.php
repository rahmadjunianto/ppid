<?php

namespace App\Http\Controllers;

use App\Models\Sop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SopController extends Controller
{
    /**
     * Display a listing of SOP for public.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'ppid');
        
        // Map tab to grup
        $tabToGrup = [
            'ppid' => 'SOP PPID',
            'subbag_tu' => 'Sub Bag TU',
            'bimas' => 'Bimas',
            'pais' => 'Pais',
            'pendma' => 'Pendma',
            'pd_pontren' => 'PD Pontren',
            'penzawa' => 'Penzawa',
        ];
        
        $grup = $tabToGrup[$tab] ?? 'SOP PPID';
        $search = $request->get('search');

        $query = Sop::published()->where('grup', $grup);

        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_dokumen', 'like', "%{$search}%")
                  ->orWhere('nomor', 'like', "%{$search}%");
            });
        }

        $sops = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->get();

        // Get available years for filter
        $tahunList = Sop::published()
                        ->whereNotNull('tahun')
                        ->distinct()
                        ->pluck('tahun')
                        ->sort()
                        ->reverse()
                        ->values();

        return view('pages.sop', compact('sops', 'tab', 'search', 'tahunList'));
    }

    /**
     * Download SOP file.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($id)
    {
        $sop = Sop::published()->findOrFail($id);

        if (!$sop->file) {
            abort(404, 'File tidak ditemukan');
        }

        if (!Storage::disk('public')->exists($sop->file)) {
            abort(404, 'File tidak ditemukan');
        }

        $extension = pathinfo($sop->file, PATHINFO_EXTENSION);
        $filename = Str::slug($sop->nama_dokumen) . '.' . $extension;

        return Storage::disk('public')->download($sop->file, $filename);
    }

    /**
     * View SOP file in browser.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $sop = Sop::published()->findOrFail($id);

        if (!$sop->file) {
            abort(404, 'File tidak ditemukan');
        }

        if (!Storage::disk('public')->exists($sop->file)) {
            abort(404, 'File tidak ditemukan');
        }

        // Generate URL for PDF file
        $pdfUrl = asset('storage/' . $sop->file);

        return view('pages.sop-view', compact('sop', 'pdfUrl'));
    }
}
