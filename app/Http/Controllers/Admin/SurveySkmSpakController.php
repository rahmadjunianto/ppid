<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveySkmSpak;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SurveySkmSpakExport;

class SurveySkmSpakController extends Controller
{
    /**
     * Display a listing of survey responses
     */
    public function index(Request $request)
    {
        $query = SurveySkmSpak::query();

        // Search by kategori_responden
        if ($request->filled('kategori_responden')) {
            $query->where('kategori_responden', $request->kategori_responden);
        }

        // Search by jenis_pelayanan
        if ($request->filled('jenis_pelayanan')) {
            $query->where('jenis_pelayanan', $request->jenis_pelayanan);
        }

        // Search by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Search by SKM score range
        if ($request->filled('skm_min')) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw("ROUND((COALESCE(u1_persyaratan, 0) + COALESCE(u2_prosedur, 0) + COALESCE(u3_waktu_pelayanan, 0) + COALESCE(u4_biaya_tarif, 0) + COALESCE(u5_hasil_pelayanan, 0) + COALESCE(u6_kompetensi_petugas, 0) + COALESCE(u7_perilaku_petugas, 0) + COALESCE(u8_pengaduan, 0) + COALESCE(u9_sarana_prasarana, 0)) / 9, 2) >= ?)", [$request->skm_min]);
            });
        }

        $surveys = $query->orderByDesc('created_at')->paginate(15);

        // Calculate overall statistics
        $allSurveys = SurveySkmSpak::all();
        $statistics = $this->calculateStatistics($allSurveys);

        // Get unique values for filter dropdowns
        $kategoris = SurveySkmSpak::distinct()->pluck('kategori_responden')->filter();
        $layananList = SurveySkmSpak::distinct()->pluck('jenis_pelayanan')->filter();

        return view('admin.surveys-skm-spak.index', compact('surveys', 'statistics', 'kategoris', 'layananList'));
    }

    /**
     * Display the specified survey response
     */
    public function show($id)
    {
        $survey = SurveySkmSpak::findOrFail($id);
        $statistics = $survey->getStatistics();

        return view('admin.surveys-skm-spak.show', compact('survey', 'statistics'));
    }

    /**
     * Delete the specified survey response
     */
    public function destroy($id)
    {
        $survey = SurveySkmSpak::findOrFail($id);
        $survey->delete();

        return redirect()->route('admin.surveys-skm-spak.index')->with('success', 'Survey berhasil dihapus');
    }

    /**
     * Export survey responses to Excel
     */
    public function export(Request $request)
    {
        $fileName = 'Survey_SKM_SPAK_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new SurveySkmSpakExport($request), $fileName);
    }

    /**
     * Calculate statistics from survey collection
     */
    private function calculateStatistics($surveys)
    {
        if ($surveys->isEmpty()) {
            return [
                'total_responden' => 0,
                'skm_average' => null,
                'spak_average' => null,
                'total_average' => null,
            ];
        }

        $skmAverages = $surveys->map(fn($s) => $s->getSkmAverage())->filter();
        $spakAverages = $surveys->map(fn($s) => $s->getSpakAverage())->filter();
        $totalAverages = $surveys->map(fn($s) => $s->getTotalAverage())->filter();

        return [
            'total_responden' => $surveys->count(),
            'skm_average' => $skmAverages->count() > 0 ? round($skmAverages->avg(), 2) : null,
            'spak_average' => $spakAverages->count() > 0 ? round($spakAverages->avg(), 2) : null,
            'total_average' => $totalAverages->count() > 0 ? round($totalAverages->avg(), 2) : null,
        ];
    }
}
