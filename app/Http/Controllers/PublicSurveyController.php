<?php

namespace App\Http\Controllers;

use App\Models\SurveyPeriod;
use App\Models\QuarterlyReport;
use App\Exports\SurveyReportExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PublicSurveyController extends Controller
{
    /**
     * Display the IKM/SPAK publication index page
     */
    public function index()
    {
        $currentYear = Carbon::now()->year;
        
        // Get published survey periods
        $surveyPeriods = SurveyPeriod::published()
            ->orderByPeriod()
            ->limit(12)
            ->get();
        
        // Get latest published period
        $latestPeriod = $surveyPeriods->first();
        
        // Get available years for filter
        $availableYears = SurveyPeriod::published()
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        // Get trend data (last 8 periods)
        $trendData = SurveyPeriod::published()
            ->orderByPeriod()
            ->limit(8)
            ->get();
        
        // Get downloadable reports
        $reports = QuarterlyReport::where('is_published', true)
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();

        return view('survey.publication.index', compact(
            'surveyPeriods',
            'latestPeriod',
            'availableYears',
            'trendData',
            'reports'
        ));
    }

    /**
     * Display IKM/SPAK details for a specific period
     */
    public function show($year, $quarter)
    {
        $period = SurveyPeriod::where('year', $year)
            ->where('quarter', $quarter)
            ->published()
            ->firstOrFail();

        // Get follow-ups if any
        $followUps = $period->followUps()->orderBy('created_at', 'desc')->get();

        // Get previous period for comparison
        $previousPeriod = $this->getPreviousPeriod($year, $quarter);

        // Get next period for comparison
        $nextPeriod = $this->getNextPeriod($year, $quarter);

        return view('survey.publication.show', compact(
            'period',
            'followUps',
            'previousPeriod',
            'nextPeriod'
        ));
    }

    /**
     * Download report file
     */
    public function download($id)
    {
        $report = QuarterlyReport::findOrFail($id);
        
        if (!$report->is_published || !$report->file_path) {
            abort(404);
        }

        $filePath = storage_path('app/' . $report->file_path);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        $fileName = $report->file_name ?? 'laporan_' . $report->type . '.pdf';

        return response()->download($filePath, $fileName);
    }

    /**
     * Get IKM/SPAK statistics - Public Page View
     */
    public function statistics()
    {
        $currentYear = Carbon::now()->year;
        
        // Get all published data (triwulanan + tahunan)
        $allPublishedData = SurveyPeriod::published()
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();

        // Get data grouped by year for yearly trends
        $yearlyData = SurveyPeriod::published()
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get()
            ->groupBy('year');

        // Get quarterly data for current year
        $quarterlyData = SurveyPeriod::published()
            ->where('year', $currentYear)
            ->orderBy('quarter')
            ->get();

        // Calculate statistics from all published data
        $avgIkm = $allPublishedData->avg('ikm_value') ?? 0;
        $avgSpak = $allPublishedData->avg('spak_value') ?? 0;
        $totalRespondents = $allPublishedData->sum('total_respondents');
        $totalSurveys = $allPublishedData->count();
        
        return view('survey.publication.statistics', compact(
            'allPublishedData',
            'yearlyData',
            'quarterlyData',
            'currentYear',
            'avgIkm',
            'avgSpak',
            'totalRespondents',
            'totalSurveys'
        ));
    }

    /**
     * Get IKM/SPAK statistics for API (JSON)
     */
    public function statisticsApi()
    {
        $currentYear = Carbon::now()->year;
        
        $annualData = SurveyPeriod::published()
            ->where('quarter', 'annual')
            ->orderBy('year', 'desc')
            ->limit(5)
            ->get();

        $quarterlyData = SurveyPeriod::published()
            ->where('year', $currentYear)
            ->orderBy('quarter')
            ->get();

        return response()->json([
            'success' => true,
            'annual' => $annualData,
            'quarterly' => $quarterlyData,
            'last_updated' => Carbon::now()->toIso8601String(),
        ]);
    }

    /**
     * Get previous period
     */
    private function getPreviousPeriod($year, $quarter)
    {
        $quarters = ['tw1', 'tw2', 'tw3', 'tw4'];
        $quarterIndex = array_search($quarter, $quarters);
        
        if ($quarterIndex === false) {
            // If annual, get previous year annual
            return SurveyPeriod::where('year', $year - 1)
                ->where('quarter', 'annual')
                ->published()
                ->first();
        }
        
        if ($quarterIndex > 0) {
            // Previous quarter in same year
            return SurveyPeriod::where('year', $year)
                ->where('quarter', $quarters[$quarterIndex - 1])
                ->published()
                ->first();
        }
        
        // First quarter, get previous year fourth quarter
        return SurveyPeriod::where('year', $year - 1)
            ->where('quarter', 'tw4')
            ->published()
            ->first();
    }

    /**
     * Get next period
     */
    private function getNextPeriod($year, $quarter)
    {
        $quarters = ['tw1', 'tw2', 'tw3', 'tw4'];
        $quarterIndex = array_search($quarter, $quarters);
        
        if ($quarterIndex === false) {
            // If annual, no next period
            return null;
        }
        
        if ($quarterIndex < 3) {
            // Next quarter in same year
            return SurveyPeriod::where('year', $year)
                ->where('quarter', $quarters[$quarterIndex + 1])
                ->published()
                ->first();
        }
        
        // Fourth quarter, no next period yet
        return null;
    }

    /**
     * Display IKM/SPAK Trend Page
     */
    public function trendChart()
    {
        $trendData = SurveyPeriod::published()
            ->orderByPeriod()
            ->limit(12)
            ->get();

        $ikmTarget = 88.31;
        $spakTarget = 88.31;

        return view('survey.publication.trend', compact(
            'trendData',
            'ikmTarget',
            'spakTarget'
        ));
    }

    /**
     * Get trend data API (JSON)
     */
    public function trendChartApi()
    {
        $data = SurveyPeriod::published()
            ->orderByPeriod()
            ->limit(12)
            ->get()
            ->map(function ($period) {
                return [
                    'period' => $period->getPeriodLabel(),
                    'year' => $period->year,
                    'quarter' => $period->quarter,
                    'ikm_value' => $period->ikm_value,
                    'ikm_category' => $period->ikm_category,
                    'ikm_category_label' => $period->ikm_category_label,
                    'spak_value' => $period->spak_value,
                    'spak_category' => $period->spak_category,
                    'spak_category_label' => $period->spak_category_label,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $data,
            'ikm_target' => 88.31,
            'spak_target' => 88.31,
        ]);
    }

    /**
     * Export survey period report to Excel
     */
    public function exportPeriod($year, $quarter)
    {
        $period = SurveyPeriod::where('year', $year)
            ->where('quarter', $quarter)
            ->published()
            ->firstOrFail();

        return Excel::download(
            new SurveyReportExport($period, 'all'),
            "IKM_SPAK_{$period->year}_{$period->quarter}.xlsx"
        );
    }

    /**
     * Export IKM only report
     */
    public function exportIkm($year, $quarter)
    {
        $period = SurveyPeriod::where('year', $year)
            ->where('quarter', $quarter)
            ->published()
            ->firstOrFail();

        return Excel::download(
            new SurveyReportExport($period, 'ikm'),
            "IKM_{$period->year}_{$period->quarter}.xlsx"
        );
    }

    /**
     * Export SPAK only report
     */
    public function exportSpak($year, $quarter)
    {
        $period = SurveyPeriod::where('year', $year)
            ->where('quarter', $quarter)
            ->published()
            ->firstOrFail();

        return Excel::download(
            new SurveyReportExport($period, 'spak'),
            "SPAK_{$period->year}_{$period->quarter}.xlsx"
        );
    }

    /**
     * Export follow-up report
     */
    public function exportFollowUp($year, $quarter)
    {
        $period = SurveyPeriod::where('year', $year)
            ->where('quarter', $quarter)
            ->published()
            ->firstOrFail();

        return Excel::download(
            new SurveyReportExport($period, 'followup'),
            "TINDAK_LANJUT_{$period->year}_{$period->quarter}.xlsx"
        );
    }
}
