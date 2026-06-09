<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyFollowUp extends Model
{
    use HasFactory;

    protected $table = 'survey_follow_ups';

    protected $fillable = [
        'survey_period_id',
        'title',
        'description',
        'action_plan',
        'responsible_unit',
        'PIC',
        'target_date',
        'completion_date',
        'status',
        'priority',
        'result',
        'document_path',
    ];

    protected $casts = [
        'target_date' => 'date',
        'completion_date' => 'date',
    ];

    /**
     * Get the period that owns the follow-up
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(SurveyPeriod::class, 'survey_period_id');
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'secondary',
            'in_progress' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
        ][$this->status] ?? 'secondary';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return [
            'pending' => 'Menunggu',
            'in_progress' => 'Sedang Dikerjakan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ][$this->status] ?? 'Unknown';
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute()
    {
        return [
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'info',
        ][$this->priority] ?? 'secondary';
    }

    /**
     * Get priority label
     */
    public function getPriorityLabelAttribute()
    {
        return [
            'high' => 'Tinggi',
            'medium' => 'Sedang',
            'low' => 'Rendah',
        ][$this->priority] ?? 'Unknown';
    }
}
