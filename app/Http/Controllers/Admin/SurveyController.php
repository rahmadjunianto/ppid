<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of surveys.
     */
    public function index(Request $request)
    {
        $query = Survey::query();

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('pekerjaan', 'like', "%{$search}%")
                  ->orWhere('saran_masukan', 'like', "%{$search}%");
            });
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            // This will filter by average rating
            $surveys = $query->get()->filter(function($survey) use ($request) {
                $avgRating = $survey->getAverageRating();
                return round($avgRating) == $request->rating;
            });

            // Convert back to paginated collection
            $currentPage = $request->get('page', 1);
            $perPage = 15;
            $total = $surveys->count();
            $surveys = $surveys->slice(($currentPage - 1) * $perPage, $perPage);

            $surveys = new \Illuminate\Pagination\LengthAwarePaginator(
                $surveys->values(),
                $total,
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $surveys = $query->latest()->paginate(15);
        }

        $statistics = Survey::getStatistics();

        return view('admin.surveys.index', compact('surveys', 'statistics'));
    }

    /**
     * Display the specified survey.
     */
    public function show(Survey $survey)
    {
        return view('admin.surveys.show', compact('survey'));
    }

    // /**
    //  * Remove the specified survey from storage.
    //  */
    // public function destroy(Survey $survey)
    // {
    //     $survey->delete();

    //     return redirect()->route('admin.surveys.index')
    //                     ->with('success', 'Data survey berhasil dihapus.');
    // }

    // /**
    //  * Export survey data to CSV
    //  */
    // public function export()
    // {
    //     $surveys = Survey::all();

    //     $headers = [
    //         'Content-Type' => 'text/csv',
    //         'Content-Disposition' => 'attachment; filename="survey-data-' . date('Y-m-d') . '.csv"',
    //     ];

    //     $callback = function() use ($surveys) {
    //         $file = fopen('php://output', 'w');

    //         // Header CSV
    //         fputcsv($file, [
    //             'ID',
    //             'Nama',
    //             'Umur',
    //             'Jenis Kelamin',
    //             'No HP',
    //             'Pendidikan',
    //             'Pekerjaan',
    //             'Kemudahan Akses',
    //             'Kualitas Informasi',
    //             'Kemudahan Permintaan',
    //             'Ketepatan Waktu Jawab',
    //             'Kelengkapan Informasi',
    //             'Ketepatan Tanggap',
    //             'Pelayanan Petugas',
    //             'Rata-rata Rating',
    //             'Saran Masukan',
    //             'Tanggal Submit'
    //         ]);

    //         // Data
    //         foreach ($surveys as $survey) {
    //             fputcsv($file, [
    //                 $survey->id,
    //                 $survey->nama,
    //                 $survey->umur,
    //                 $survey->jenis_kelamin,
    //                 $survey->no_hp,
    //                 $survey->pendidikan,
    //                 $survey->pekerjaan,
    //                 $survey->kemudahan_akses_informasi,
    //                 $survey->kualitas_informasi,
    //                 $survey->kemudahan_permintaan,
    //                 $survey->ketepatan_waktu_jawab,
    //                 $survey->kelengkapan_informasi,
    //                 $survey->ketepatan_tanggap,
    //                 $survey->pelayanan_petugas,
    //                 number_format($survey->getAverageRating(), 2),
    //                 $survey->saran_masukan,
    //                 $survey->created_at->format('Y-m-d H:i:s')
    //             ]);
    //         }

    //         fclose($file);
    //     };

    //     return response()->stream($callback, 200, $headers);
    // }

    /**
     * Show survey statistics dashboard
     */
    public function statistics()
    {
        $statistics = Survey::getStatistics();

        // Additional statistics
        $monthlyStats = Survey::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                             ->whereYear('created_at', date('Y'))
                             ->groupBy('month')
                             ->pluck('count', 'month')
                             ->toArray();

        // Fill missing months with 0
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyStats[$i])) {
                $monthlyStats[$i] = 0;
            }
        }
        ksort($monthlyStats);

        return view('admin.surveys.statistics', compact('statistics', 'monthlyStats'));
    }

    /**
     * Export surveys to Excel
     */
    public function export()
    {
        $surveys = Survey::latest()->get();

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="data-survey-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($surveys) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for proper encoding in Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'No',
                'Nama',
                'Email',
                'No HP',
                'Jenis Kelamin',
                'Umur',
                'Pendidikan',
                'Pekerjaan',
                'Alamat',
                'Kepuasan Layanan',
                'Kemudahan Akses',
                'Kecepatan Respon',
                'Kejelasan Informasi',
                'Keramahan Petugas',
                'Fasilitas Layanan',
                'Kepuasan Keseluruhan',
                'Rating Rata-rata',
                'Saran & Masukan',
                'Tanggal Submit'
            ]);

            // Data
            foreach ($surveys as $index => $survey) {
                $avgRating = collect([
                    $survey->kepuasan_layanan,
                    $survey->kemudahan_akses,
                    $survey->kecepatan_respon,
                    $survey->kejelasan_informasi,
                    $survey->keramahan_petugas,
                    $survey->fasilitas_layanan,
                    $survey->kepuasan_keseluruhan
                ])->avg();

                fputcsv($file, [
                    $index + 1,
                    $survey->nama,
                    $survey->email,
                    $survey->no_hp,
                    $survey->jenis_kelamin,
                    $survey->umur,
                    $survey->pendidikan,
                    $survey->pekerjaan,
                    $survey->alamat,
                    $survey->kepuasan_layanan,
                    $survey->kemudahan_akses,
                    $survey->kecepatan_respon,
                    $survey->kejelasan_informasi,
                    $survey->keramahan_petugas,
                    $survey->fasilitas_layanan,
                    $survey->kepuasan_keseluruhan,
                    number_format($avgRating, 2),
                    $survey->saran_masukan,
                    $survey->created_at->format('d/m/Y H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Remove the specified survey from storage.
     */
    public function destroy(Survey $survey)
    {
        try {
            $survey->delete();

            return redirect()->route('admin.surveys.index')
                           ->with('success', 'Survey berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.surveys.index')
                           ->with('error', 'Gagal menghapus survey: ' . $e->getMessage());
        }
    }
}
