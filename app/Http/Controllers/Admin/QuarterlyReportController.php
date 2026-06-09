<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuarterlyReport;
use App\Models\SurveySkmSpak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class QuarterlyReportController extends Controller
{
    /**
     * Display a listing of quarterly reports with trend data
     */
    public function index(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $quarter = $request->get('quarter');

        // Get available years from survey data
        $availableYears = SurveySkmSpak::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        // Ensure current year is in the list
        $currentYear = Carbon::now()->year;
        if (!in_array($currentYear, $availableYears)) {
            $availableYears[] = $currentYear;
        }
        sort($availableYears);

        // Get reports based on filters
        $query = QuarterlyReport::query()
            ->forYear($year)
            ->orderBy('quarter')
            ->orderBy('type');

        if ($quarter) {
            $query->forQuarter($quarter);
        }

        $reports = $query->get()->groupBy('type');

        // Get trend data for charts
        $trendData = $this->getTrendData($year);

        // Statistics for the year
        $statistics = $this->getYearStatistics($year);

        // Group reports by type for display
        $publications = $reports->get('publication', collect());
        $trendCharts = $reports->get('trend', collect());
        $followUps = $reports->get('follow_up', collect());
        $summaries = $reports->get('summary', collect());

        return view('admin.surveys-skm-spak.reports', compact(
            'year',
            'quarter',
            'availableYears',
            'publications',
            'trendCharts',
            'followUps',
            'summaries',
            'trendData',
            'statistics'
        ));
    }

    /**
     * Show form to create a new report
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'publication');
        $year = $request->get('year', Carbon::now()->year);
        $quarter = $request->get('quarter', $this->getCurrentQuarter());

        $availableYears = range(Carbon::now()->year - 2, Carbon::now()->year + 1);

        return view('admin.surveys-skm-spak.report-form', compact(
            'type',
            'year',
            'quarter',
            'availableYears'
        ));
    }

    /**
     * Store a newly created report
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:2030',
            'quarter' => 'required|integer|min:1|max:4',
            'type' => 'required|in:publication,trend,follow_up,summary',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,xlsx,xls,doc,docx|max:10240',
            'is_published' => 'boolean',
        ]);

        $data = $request->only([
            'year',
            'quarter',
            'type',
            'title',
            'description',
            'is_published'
        ]);

        $data['is_published'] = $request->boolean('is_published');

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileType = strtolower($file->getClientOriginalExtension());
            
            // Create directory if not exists
            $directory = "reports/{$data['year']}/Q{$data['quarter']}";
            $path = $file->storeAs($directory, "{$data['type']}_{$data['year']}_Q{$data['quarter']}_{$fileName}");
            
            $data['file_path'] = $path;
            $data['file_name'] = $fileName;
            $data['file_type'] = $fileType;
            
            // Mark as trend chart if it's a trend type
            if ($data['type'] === 'trend') {
                $data['is_trend_chart'] = true;
            }
        }

        QuarterlyReport::create($data);

        return redirect()
            ->route('admin.surveys-skm-spak.reports', ['year' => $data['year'], 'quarter' => $data['quarter']])
            ->with('success', 'Laporan berhasil disimpan');
    }

    /**
     * Display the specified report
     */
    public function show(QuarterlyReport $report)
    {
        return view('admin.surveys-skm-spak.report-show', compact('report'));
    }

    /**
     * Show form to edit the specified report
     */
    public function edit(QuarterlyReport $report)
    {
        $availableYears = range(Carbon::now()->year - 2, Carbon::now()->year + 1);
        return view('admin.surveys-skm-spak.report-form', compact('report', 'availableYears'));
    }

    /**
     * Update the specified report
     */
    public function update(Request $request, QuarterlyReport $report)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:2030',
            'quarter' => 'required|integer|min:1|max:4',
            'type' => 'required|in:publication,trend,follow_up,summary',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,xlsx,xls,doc,docx|max:10240',
            'is_published' => 'boolean',
        ]);

        $data = $request->only([
            'year',
            'quarter',
            'type',
            'title',
            'description',
            'is_published'
        ]);

        $data['is_published'] = $request->boolean('is_published');

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($report->file_path && Storage::exists($report->file_path)) {
                Storage::delete($report->file_path);
            }

            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileType = strtolower($file->getClientOriginalExtension());
            
            $directory = "reports/{$data['year']}/Q{$data['quarter']}";
            $path = $file->storeAs($directory, "{$data['type']}_{$data['year']}_Q{$data['quarter']}_{$fileName}");
            
            $data['file_path'] = $path;
            $data['file_name'] = $fileName;
            $data['file_type'] = $fileType;
        }

        $report->update($data);

        return redirect()
            ->route('admin.surveys-skm-spak.reports', ['year' => $data['year'], 'quarter' => $data['quarter']])
            ->with('success', 'Laporan berhasil diperbarui');
    }

    /**
     * Remove the specified report
     */
    public function destroy(QuarterlyReport $report)
    {
        // Delete file if exists
        if ($report->file_path && Storage::exists($report->file_path)) {
            Storage::delete($report->file_path);
        }

        $report->delete();

        return redirect()
            ->route('admin.surveys-skm-spak.reports')
            ->with('success', 'Laporan berhasil dihapus');
    }

    /**
     * Download report file
     */
    public function download(QuarterlyReport $report)
    {
        if (!$report->file_path || !Storage::exists($report->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        return Storage::download($report->file_path, $report->file_name);
    }

    /**
     * Generate trend data for charts
     */
    private function getTrendData($year)
    {
        $surveys = SurveySkmSpak::whereYear('created_at', $year)->get();

        $quarters = [1, 2, 3, 4];
        $skmData = [];
        $spakData = [];
        $totalData = [];
        $respondentCount = [];

        foreach ($quarters as $q) {
            $startMonth = ($q - 1) * 3 + 1;
            $endMonth = $q * 3;

            $qSurveys = $surveys->filter(function ($survey) use ($startMonth, $endMonth) {
                $month = $survey->created_at->month;
                return $month >= $startMonth && $month <= $endMonth;
            });

            $skmAverages = $qSurveys->map(fn($s) => $s->getSkmAverage())->filter();
            $spakAverages = $qSurveys->map(fn($s) => $s->getSpakAverage())->filter();
            $totalAverages = $qSurveys->map(fn($s) => $s->getTotalAverage())->filter();

            $skmData[$q] = $skmAverages->count() > 0 ? round($skmAverages->avg(), 2) : 0;
            $spakData[$q] = $spakAverages->count() > 0 ? round($spakAverages->avg(), 2) : 0;
            $totalData[$q] = $totalAverages->count() > 0 ? round($totalAverages->avg(), 2) : 0;
            $respondentCount[$q] = $qSurveys->count();
        }

        return [
            'quarters' => $quarters,
            'skm' => $skmData,
            'spak' => $spakData,
            'total' => $totalData,
            'respondents' => $respondentCount,
        ];
    }

    /**
     * Get year statistics
     */
    private function getYearStatistics($year)
    {
        $surveys = SurveySkmSpak::whereYear('created_at', $year)->get();

        if ($surveys->isEmpty()) {
            return [
                'total_responden' => 0,
                'skm_average' => 0,
                'spak_average' => 0,
                'total_average' => 0,
            ];
        }

        $skmAverages = $surveys->map(fn($s) => $s->getSkmAverage())->filter();
        $spakAverages = $surveys->map(fn($s) => $s->getSpakAverage())->filter();
        $totalAverages = $surveys->map(fn($s) => $s->getTotalAverage())->filter();

        return [
            'total_responden' => $surveys->count(),
            'skm_average' => $skmAverages->count() > 0 ? round($skmAverages->avg(), 2) : 0,
            'spak_average' => $spakAverages->count() > 0 ? round($spakAverages->avg(), 2) : 0,
            'total_average' => $totalAverages->count() > 0 ? round($totalAverages->avg(), 2) : 0,
        ];
    }

    /**
     * Get current quarter
     */
    private function getCurrentQuarter()
    {
        $month = Carbon::now()->month;
        return (int) ceil($month / 3);
    }

    /**
     * API endpoint for chart data
     */
    public function chartData(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $trendData = $this->getTrendData($year);

        return response()->json([
            'success' => true,
            'data' => $trendData,
        ]);
    }

    /**
     * Export quarterly summary as PDF/Excel
     */
    public function export(Request $request, $year, $quarter)
    {
        // This would typically use a package like DomPDF or Maatwebsite Excel
        // For now, we'll just redirect back with a message
        return redirect()
            ->route('admin.surveys-skm-spak.reports', ['year' => $year, 'quarter' => $quarter])
            ->with('info', 'Fitur export akan segera hadir');
    }
}
