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
        // Semua grup yang tersedia
        $grupOptions = Sop::getGrupOptions();

        // Grup selain SOP PPID digabung dalam satu tab ("unit_kerja")
        $unitKerjaList = array_values(array_diff(array_keys($grupOptions), ['SOP PPID']));

        // Tab aktif: hanya ada 2 tab (ppid & unit_kerja)
        $tab = $request->get('tab', 'ppid');

        // Backward compatibility: tab lama dipetakan ke tab unit_kerja + filter grup
        $legacyTabToGrup = [
            'subbag_tu' => 'Sub Bag TU',
            'bimas' => 'Bimas',
            'pais' => 'Pais',
            'pendma' => 'Pendma',
            'pd_pontren' => 'PD Pontren',
            'penzawa' => 'Penzawa',
        ];

        $grup = null;
        if (isset($legacyTabToGrup[$tab])) {
            $grup = $legacyTabToGrup[$tab];
            $tab = 'unit_kerja';
        } elseif ($tab !== 'unit_kerja') {
            $tab = 'ppid';
        }

        // Filter grup pada tab unit kerja
        if ($tab === 'unit_kerja' && $request->filled('grup')) {
            $requestGrup = $request->get('grup');
            if (in_array($requestGrup, $unitKerjaList, true)) {
                $grup = $requestGrup;
            }
        }

        $search = $request->get('search');

        $query = Sop::published();

        if ($tab === 'unit_kerja') {
            $query->whereIn('grup', $unitKerjaList);

            if ($grup) {
                $query->where('grup', $grup);
            }
        } else {
            $query->where('grup', 'SOP PPID');
        }

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

        return view('pages.sop', compact('sops', 'tab', 'search', 'tahunList', 'grup', 'grupOptions', 'unitKerjaList'));
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

        // Catat jumlah dilihat saat file diunduh
        $sop->increment('view_count');

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

        // Catat jumlah dilihat saat file dibuka
        $sop->increment('view_count');

        // Generate URL for PDF file
        $pdfUrl = asset('storage/' . $sop->file);

        return view('pages.sop-view', compact('sop', 'pdfUrl'));
    }
}
