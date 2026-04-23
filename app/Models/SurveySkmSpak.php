<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveySkmSpak extends Model
{
    use HasFactory;

    protected $table = 'surveys_skm_spak';

    protected $fillable = [
        'jenis_kelamin',
        'usia',
        'pendidikan_terakhir',
        'pekerjaan',
        'kategori_responden',
        'unit_kerja',
        'jabatan',
        'jenis_pelayanan',
        'u1_persyaratan',
        'u2_prosedur',
        'u3_waktu_pelayanan',
        'u4_biaya_tarif',
        'u5_hasil_pelayanan',
        'u6_kompetensi_petugas',
        'u7_perilaku_petugas',
        'u8_pengaduan',
        'u9_sarana_prasarana',
        'i1_tidak_diskriminatif',
        'i2_tidak_curang',
        'i3_tidak_imbalan',
        'i4_tidak_percaloan',
        'i5_tidak_pungli',
        'kritik_saran',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get average SKM score (unsur u1-u9)
     */
    public function getSkmAverage()
    {
        $skmFields = [
            'u1_persyaratan',
            'u2_prosedur',
            'u3_waktu_pelayanan',
            'u4_biaya_tarif',
            'u5_hasil_pelayanan',
            'u6_kompetensi_petugas',
            'u7_perilaku_petugas',
            'u8_pengaduan',
            'u9_sarana_prasarana',
        ];

        $values = [];
        foreach ($skmFields as $field) {
            if ($this->$field !== null) {
                $values[] = $this->$field;
            }
        }

        return count($values) > 0 ? round(array_sum($values) / count($values), 2) : null;
    }

    /**
     * Get average SPAK score (unsur i1-i5)
     */
    public function getSpakAverage()
    {
        $spakFields = [
            'i1_tidak_diskriminatif',
            'i2_tidak_curang',
            'i3_tidak_imbalan',
            'i4_tidak_percaloan',
            'i5_tidak_pungli',
        ];

        $values = [];
        foreach ($spakFields as $field) {
            if ($this->$field !== null) {
                $values[] = $this->$field;
            }
        }

        return count($values) > 0 ? round(array_sum($values) / count($values), 2) : null;
    }

    /**
     * Get total average of all numeric scores (u1-u9, i1-i5)
     */
    public function getTotalAverage()
    {
        $allScoreFields = [
            'u1_persyaratan',
            'u2_prosedur',
            'u3_waktu_pelayanan',
            'u4_biaya_tarif',
            'u5_hasil_pelayanan',
            'u6_kompetensi_petugas',
            'u7_perilaku_petugas',
            'u8_pengaduan',
            'u9_sarana_prasarana',
            'i1_tidak_diskriminatif',
            'i2_tidak_curang',
            'i3_tidak_imbalan',
            'i4_tidak_percaloan',
            'i5_tidak_pungli',
        ];

        $values = [];
        foreach ($allScoreFields as $field) {
            if ($this->$field !== null) {
                $values[] = $this->$field;
            }
        }

        return count($values) > 0 ? round(array_sum($values) / count($values), 2) : null;
    }

    /**
     * Get all statistics in one call
     */
    public function getStatistics()
    {
        return [
            'skm_average' => $this->getSkmAverage(),
            'spak_average' => $this->getSpakAverage(),
            'total_average' => $this->getTotalAverage(),
        ];
    }

    /**
     * Get SKM score category label (Sangat Puas, Puas, Netral, Tidak Puas)
     */
    public static function getSkmScoreLabel($score)
    {
        switch ($score) {
            case 1:
                return 'Tidak Sesuai';
            case 2:
                return 'Kurang Sesuai';
            case 3:
                return 'Sesuai';
            case 4:
                return 'Sangat Sesuai';
            default:
                return 'N/A';
        }
    }

    /**
     * Get SPAK score category label
     */
    public static function getSpakScoreLabel($score)
    {
        switch ($score) {
            case 1:
                return 'Ada';
            case 2:
                return 'Jarang';
            case 3:
                return 'Sangat Jarang';
            case 4:
                return 'Tidak Ada';
            default:
                return 'N/A';
        }
    }

    /**
     * Get rating label for overall satisfaction
     */
    public static function getRatingLabel($score)
    {
        switch ($score) {
            case 1:
                return 'Sangat Tidak Puas';
            case 2:
                return 'Tidak Puas';
            case 3:
                return 'Netral';
            case 4:
                return 'Puas';
            case 5:
                return 'Sangat Puas';
            default:
                return 'N/A';
        }
    }
}
