<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuarterlyReport extends Model
{
    use HasFactory;

    protected $table = 'quarterly_reports';

    protected $fillable = [
        'title',
        'description',
        'year',
        'quarter',
        'file_type',
        'file_path',
        'file_name',
        'is_published',
    ];

    protected $casts = [
        'year' => 'integer',
        'quarter' => 'string',
        'is_published' => 'boolean',
    ];

    /**
     * Get the period label
     */
    public function getPeriodLabel()
    {
        return SurveyPeriod::getQuarterLabel($this->quarter) . ' ' . $this->year;
    }

    /**
     * Get file extension
     */
    public function getFileExtension()
    {
        return strtoupper($this->file_type ?? 'PDF');
    }
}
