<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'umur',
        'jenis_kelamin',
        'no_hp',
        'pendidikan',
        'pekerjaan',
        'kemudahan_akses_informasi',
        'kualitas_informasi',
        'kemudahan_permintaan',
        'ketepatan_waktu_jawab',
        'kelengkapan_informasi',
        'ketepatan_tanggap',
        'pelayanan_petugas',
        'saran_masukan',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'umur' => 'integer',
        'kemudahan_akses_informasi' => 'integer',
        'kualitas_informasi' => 'integer',
        'kemudahan_permintaan' => 'integer',
        'ketepatan_waktu_jawab' => 'integer',
        'kelengkapan_informasi' => 'integer',
        'ketepatan_tanggap' => 'integer',
        'pelayanan_petugas' => 'integer',
    ];

    // Mendapatkan label untuk rating
    public function getRatingLabel($score)
    {
        $labels = [
            1 => 'Tidak Baik',
            2 => 'Kurang Baik',
            3 => 'Baik',
            4 => 'Sangat Baik'
        ];

        return $labels[$score] ?? 'Tidak Valid';
    }

    // Mendapatkan rata-rata kepuasan
    public function getAverageRating()
    {
        $scores = [
            $this->kemudahan_akses_informasi,
            $this->kualitas_informasi,
            $this->kemudahan_permintaan,
            $this->ketepatan_waktu_jawab,
            $this->kelengkapan_informasi,
            $this->ketepatan_tanggap,
            $this->pelayanan_petugas,
        ];

        return array_sum($scores) / count($scores);
    }

    // Scope untuk statistik
    public static function getStatistics()
    {
        $total = self::count();

        if ($total == 0) {
            return [
                'total_responden' => 0,
                'rata_rata_kepuasan' => 0,
                'distribusi_rating' => [1 => 0, 2 => 0, 3 => 0, 4 => 0],
                'distribusi_gender' => [],
                'distribusi_pendidikan' => [],
                'rata_rata_per_pertanyaan' => [
                    'kemudahan_akses_informasi' => 0,
                    'kualitas_informasi' => 0,
                    'kemudahan_permintaan' => 0,
                    'ketepatan_waktu_jawab' => 0,
                    'kelengkapan_informasi' => 0,
                    'ketepatan_tanggap' => 0,
                    'pelayanan_petugas' => 0
                ]
            ];
        }

        $surveys = self::all();
        $totalRating = 0;
        $distribusi = [1 => 0, 2 => 0, 3 => 0, 4 => 0];

        // Initialize question averages
        $questionTotals = [
            'kemudahan_akses_informasi' => 0,
            'kualitas_informasi' => 0,
            'kemudahan_permintaan' => 0,
            'ketepatan_waktu_jawab' => 0,
            'kelengkapan_informasi' => 0,
            'ketepatan_tanggap' => 0,
            'pelayanan_petugas' => 0
        ];

        foreach ($surveys as $survey) {
            $avgRating = $survey->getAverageRating();
            $totalRating += $avgRating;

            $roundedRating = round($avgRating);
            if (isset($distribusi[$roundedRating])) {
                $distribusi[$roundedRating]++;
            }

            // Add to question totals
            foreach ($questionTotals as $question => $value) {
                $questionTotals[$question] += $survey->{$question};
            }
        }

        // Calculate question averages
        $questionAverages = [];
        foreach ($questionTotals as $question => $total) {
            $questionAverages[$question] = $total / $surveys->count();
        }

        // Get gender distribution
        $genderDistribution = self::select('jenis_kelamin')
            ->selectRaw('count(*) as count')
            ->groupBy('jenis_kelamin')
            ->pluck('count', 'jenis_kelamin')
            ->toArray();

        // Get education distribution
        $educationDistribution = self::select('pendidikan')
            ->selectRaw('count(*) as count')
            ->groupBy('pendidikan')
            ->pluck('count', 'pendidikan')
            ->toArray();

        return [
            'total_responden' => $surveys->count(),
            'rata_rata_kepuasan' => $totalRating / $surveys->count(),
            'distribusi_rating' => $distribusi,
            'distribusi_gender' => $genderDistribution,
            'distribusi_pendidikan' => $educationDistribution,
            'rata_rata_per_pertanyaan' => $questionAverages
        ];
    }
}
