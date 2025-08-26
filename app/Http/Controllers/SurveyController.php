<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display the survey form
     */
    public function index()
    {
        $statistics = Survey::getStatistics();
        return view('survey.index', compact('statistics'));
    }

    /**
     * Store survey response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:10|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'required|string|max:20',
            'pendidikan' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'kemudahan_akses_informasi' => 'required|integer|between:1,4',
            'kualitas_informasi' => 'required|integer|between:1,4',
            'kemudahan_permintaan' => 'required|integer|between:1,4',
            'ketepatan_waktu_jawab' => 'required|integer|between:1,4',
            'kelengkapan_informasi' => 'required|integer|between:1,4',
            'ketepatan_tanggap' => 'required|integer|between:1,4',
            'pelayanan_petugas' => 'required|integer|between:1,4',
            'saran_masukan' => 'nullable|string|max:1000',
        ]);

        // Store survey data
        $surveyData = [
            'nama' => $request->nama,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'kemudahan_akses_informasi' => $request->kemudahan_akses_informasi,
            'kualitas_informasi' => $request->kualitas_informasi,
            'kemudahan_permintaan' => $request->kemudahan_permintaan,
            'ketepatan_waktu_jawab' => $request->ketepatan_waktu_jawab,
            'kelengkapan_informasi' => $request->kelengkapan_informasi,
            'ketepatan_tanggap' => $request->ketepatan_tanggap,
            'pelayanan_petugas' => $request->pelayanan_petugas,
            'saran_masukan' => $request->saran_masukan,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

        Survey::create($surveyData);

        return redirect()->route('survey.success')
                        ->with('success', 'Terima kasih! Survey Anda telah berhasil dikirim.')
                        ->with('survey_data', $surveyData);
    }

    /**
     * Show success page
     */
    public function success()
    {
        // Check if we have survey data from the session
        if (!session('survey_data')) {
            return redirect()->route('survey.index')
                           ->with('error', 'Silakan isi survey terlebih dahulu.');
        }

        return view('survey.success');
    }

    /**
     * Show survey results/statistics
     */
    public function results()
    {
        $statistics = Survey::getStatistics();
        $recentSurveys = Survey::latest()->take(10)->get();

        return view('survey.results', compact('statistics', 'recentSurveys'));
    }
}
