<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveySkmSpakRequest;
use App\Models\SurveySkmSpak;
use Illuminate\Http\Request;

class SurveySkmSpakController extends Controller
{
    /**
     * Display the survey form
     */
    public function index()
    {
        // Get overall statistics for display
        $totalResponses = SurveySkmSpak::count();
        
        $statistics = [];
        if ($totalResponses > 0) {
            $skmScores = SurveySkmSpak::whereNotNull('u1_persyaratan')->get()->map(fn($s) => $s->getSkmAverage());
            $spakScores = SurveySkmSpak::whereNotNull('i1_tidak_diskriminatif')->get()->map(fn($s) => $s->getSpakAverage());

            $statistics = [
                'total_responden' => $totalResponses,
                'skm_average' => $skmScores->count() > 0 ? round($skmScores->avg(), 2) : null,
                'spak_average' => $spakScores->count() > 0 ? round($spakScores->avg(), 2) : null,
            ];
        }

        return view('survey.skm-spak.index', compact('statistics'));
    }

    /**
     * Store the survey response
     */
    public function store(StoreSurveySkmSpakRequest $request)
    {
        // Get IP address and user agent
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        // Merge with validated data
        $data = $request->validated();
        $data['ip_address'] = $ipAddress;
        $data['user_agent'] = $userAgent;

        // Create the survey record
        $survey = SurveySkmSpak::create($data);

        return redirect()->route('survey.skm-spak.success');
    }

    /**
     * Show success page
     */
    public function success()
    {
        return view('survey.skm-spak.success');
    }
}
