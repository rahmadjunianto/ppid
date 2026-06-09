<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuarterlyReport extends Model
{
    use HasFactory;

    protected $table = 'quarterly_reports';

    protected $fillable = [
        'year',
        'quarter',
        'type',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'is_published',
        'is_trend_chart',
    ];

    protected $casts = [
        'year' => 'integer',
        'quarter' => 'integer',
        'is_published' => 'boolean',
        'is_trend_chart' => 'boolean',
    ];

    /**
     * Get type label
     */
    public static function getTypeLabel($type)
    {
        return [
            'publication' => 'Bukti Publikasi',
            'trend' => 'Grafik Tren',
            'follow_up' => 'Laporan Tindak Lanjut',
            'summary' => 'Ringkasan Laporan',
        ][$type] ?? $type;
    }

    /**
     * Get quarter label
     */
    public static function getQuarterLabel($quarter)
    {
        return [
            1 => 'Triwulan I (Januari - Maret)',
            2 => 'Triwulan II (April - Juni)',
            3 => 'Triwulan III (Juli - September)',
            4 => 'Triwulan IV (Oktober - Desember)',
        ][$quarter] ?? "Triwulan {$quarter}";
    }

    /**
     * Get quarter short label
     */
    public function getQuarterShortLabel()
    {
        return "TW {$this->quarter}";
    }

    /**
     * Get full period label
     */
    public function getPeriodLabel()
    {
        return "{$this->year} - " . self::getQuarterLabel($this->quarter);
    }

    /**
     * Get file icon based on file type
     */
    public function getFileIcon()
    {
        return [
            'pdf' => 'fa-file-pdf text-danger',
            'excel' => 'fa-file-excel text-success',
            'xlsx' => 'fa-file-excel text-success',
            'xls' => 'fa-file-excel text-success',
            'doc' => 'fa-file-word text-primary',
            'docx' => 'fa-file-word text-primary',
        ][$this->file_type] ?? 'fa-file text-secondary';
    }

    /**
     * Scope for published reports
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for specific year
     */
    public function scopeForYear($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Scope for specific quarter
     */
    public function scopeForQuarter($query, $quarter)
    {
        return $query->where('quarter', $quarter);
    }

    /**
     * Scope for specific type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
