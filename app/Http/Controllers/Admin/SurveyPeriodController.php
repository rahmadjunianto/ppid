<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyPeriod;
use App\Models\SurveyFollowUp;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Barryvdh\DomPDF\Facade as PDF;

class SurveyPeriodController extends Controller
{
    /**
     * Display a listing of survey periods
     */
    public function index()
    {
        $periods = SurveyPeriod::orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->paginate(15);

        return view('admin.survey-periods.index', compact('periods'));
    }

    /**
     * Show the form for creating a new survey period
     */
    public function create()
    {
        return view('admin.survey-periods.create');
    }

    /**
     * Store a newly created survey period
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer|min:2020|max:2099',
            'quarter' => 'required|in:tw1,tw2,tw3,tw4,annual',
            'survey_type' => 'required|in:ikm,spak,both',
            'ikm_value' => 'nullable|numeric|min:25|max:100',
            'spak_value' => 'nullable|numeric|min:25|max:100',
            'total_respondents' => 'required|integer|min:0',
            'target_respondents' => 'required|integer|min:1',
            'survey_start_date' => 'required|date',
            'survey_end_date' => 'required|date|after_or_equal:survey_start_date',
            'is_published' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Auto-calculate IKM category
        if ($request->ikm_value) {
            $ikmCategory = $this->calculateCategory($request->ikm_value);
            $data['ikm_category'] = $ikmCategory['code'];
            $data['ikm_category_label'] = $ikmCategory['label'];
        }

        // Auto-calculate SPAK category
        if ($request->spak_value) {
            $spakCategory = $this->calculateCategory($request->spak_value);
            $data['spak_category'] = $spakCategory['code'];
            $data['spak_category_label'] = $spakCategory['label'];
        }

        // Calculate response rate
        $data['response_rate'] = ($request->total_respondents / $request->target_respondents) * 100;

        // Set published_at if publishing
        if ($request->is_published && !$request->published_at) {
            $data['published_at'] = Carbon::now();
        }

        $period = SurveyPeriod::create($data);

        return redirect()->route('admin.survey-periods.edit', $period->id)
            ->with('success', 'Periode survei berhasil dibuat. Silakan lengkapi data lainnya.');
    }

    /**
     * Show the form for editing a survey period
     */
    public function edit(SurveyPeriod $surveyPeriod)
    {
        $followUps = $surveyPeriod->followUps()->orderBy('created_at', 'desc')->get();
        
        return view('admin.survey-periods.edit', compact('surveyPeriod', 'followUps'));
    }

    /**
     * Update the specified survey period
     */
    public function update(Request $request, SurveyPeriod $surveyPeriod)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer|min:2020|max:2099',
            'quarter' => 'required|in:tw1,tw2,tw3,tw4,annual',
            'survey_type' => 'required|in:ikm,spak,both',
            'ikm_value' => 'nullable|numeric|min:25|max:100',
            'spak_value' => 'nullable|numeric|min:25|max:100',
            'total_respondents' => 'required|integer|min:0',
            'target_respondents' => 'required|integer|min:1',
            'survey_start_date' => 'required|date',
            'survey_end_date' => 'required|date|after_or_equal:survey_start_date',
            'is_published' => 'boolean',
            'signatory_name' => 'nullable|string|max:255',
            'signatory_position' => 'nullable|string|max:255',
            'signatory_nip' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // Recalculate categories if values changed
        if ($request->ikm_value) {
            $ikmCategory = $this->calculateCategory($request->ikm_value);
            $data['ikm_category'] = $ikmCategory['code'];
            $data['ikm_category_label'] = $ikmCategory['label'];
        }

        if ($request->spak_value) {
            $spakCategory = $this->calculateCategory($request->spak_value);
            $data['spak_category'] = $spakCategory['code'];
            $data['spak_category_label'] = $spakCategory['label'];
        }

        // Recalculate response rate
        $data['response_rate'] = ($request->total_respondents / $request->target_respondents) * 100;

        // Handle publishing
        if ($request->is_published && !$surveyPeriod->published_at) {
            $data['published_at'] = Carbon::now();
        }

        $surveyPeriod->update($data);

        return redirect()->back()
            ->with('success', 'Periode survei berhasil diperbarui.');
    }

    /**
     * Remove the specified survey period
     */
    public function destroy(SurveyPeriod $surveyPeriod)
    {
        $surveyPeriod->delete();

        return redirect()->route('admin.survey-periods.index')
            ->with('success', 'Periode survei berhasil dihapus.');
    }

    /**
     * Toggle publish status
     */
    public function togglePublish(SurveyPeriod $surveyPeriod)
    {
        $surveyPeriod->update([
            'is_published' => !$surveyPeriod->is_published,
            'published_at' => !$surveyPeriod->is_published ? Carbon::now() : null,
        ]);

        $status = $surveyPeriod->is_published ? 'dipublikasikan' : 'dibatalkan publikasinya';
        
        return redirect()->back()
            ->with('success', "Publikasi periode survei berhasil {$status}.");
    }

    /**
     * Add follow-up to a survey period
     */
    public function addFollowUp(Request $request, SurveyPeriod $surveyPeriod)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'action_plan' => 'nullable|string',
            'responsible_unit' => 'nullable|string|max:255',
            'PIC' => 'nullable|string|max:255',
            'target_date' => 'nullable|date',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'priority' => 'nullable|in:high,medium,low',
            'result' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $surveyPeriod->followUps()->create($request->all());

        return redirect()->back()
            ->with('success', 'Tindak lanjut berhasil ditambahkan.');
    }

    /**
     * Update follow-up status
     */
    public function updateFollowUp(Request $request, SurveyFollowUp $followUp)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'result' => 'nullable|string',
            'completion_date' => 'nullable|date',
        ]);

        $data = $request->only(['status', 'result', 'completion_date']);
        
        if ($request->status === 'completed' && !$request->completion_date) {
            $data['completion_date'] = Carbon::now();
        }

        $followUp->update($data);

        return redirect()->back()
            ->with('success', 'Status tindak lanjut berhasil diperbarui.');
    }

    /**
     * Delete follow-up
     */
    public function deleteFollowUp(SurveyFollowUp $followUp)
    {
        $followUp->delete();

        return redirect()->back()
            ->with('success', 'Tindak lanjut berhasil dihapus.');
    }

    /**
     * Calculate category based on value
     */
    private function calculateCategory($value)
    {
        if ($value >= 88.31) {
            return ['code' => 'A', 'label' => 'Sangat Baik'];
        } elseif ($value >= 76.61) {
            return ['code' => 'B', 'label' => 'Baik'];
        } elseif ($value >= 65.00) {
            return ['code' => 'C', 'label' => 'Cukup'];
        } else {
            return ['code' => 'D', 'label' => 'Buruk'];
        }
    }

    /**
     * Show export management page
     */
    public function export()
    {
        $periods = SurveyPeriod::orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();

        return view('admin.survey-periods.export', compact('periods'));
    }

    /**
     * Generate PDF report for a survey period
     */
    public function generateReport(SurveyPeriod $surveyPeriod)
    {
        $followUps = $surveyPeriod->followUps()->orderBy('created_at', 'desc')->get();
        
        $pdf = PDF::loadView('admin.survey-periods.report-pdf', [
            'period' => $surveyPeriod,
            'followUps' => $followUps,
        ]);

        $filename = 'Laporan_IKM_SPAK_' . $surveyPeriod->year . '_' . $surveyPeriod->getQuarterLabel() . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Download existing report
     */
    public function downloadReport(SurveyPeriod $surveyPeriod)
    {
        return $this->generateReport($surveyPeriod);
    }
}
