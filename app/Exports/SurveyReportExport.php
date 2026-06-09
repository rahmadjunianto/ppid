<?php

namespace App\Exports;

use App\Models\SurveyPeriod;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;

class SurveyReportExport implements FromView, ShouldAutoSize
{
    protected $period;
    protected $type;

    public function __construct(SurveyPeriod $period, string $type = 'all')
    {
        $this->period = $period;
        $this->type = $type;
    }

    public function view(): View
    {
        $period = $this->period;
        $followUps = $period->followUps ?? collect();
        
        return view('survey.export.report', [
            'period' => $period,
            'followUps' => $followUps,
            'type' => $this->type,
        ]);
    }

    /**
     * Export by period ID
     */
    public static function download(SurveyPeriod $period, string $type = 'all')
    {
        return Excel::download(
            new self($period, $type),
            "Laporan_{$period->year}_{$period->quarter}_{$type}.xlsx"
        );
    }
}
