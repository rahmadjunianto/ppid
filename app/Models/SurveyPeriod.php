<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyPeriod extends Model
{
    use HasFactory;

    protected $table = 'survey_periods';

    protected $fillable = [
        'year',
        'quarter',
        'survey_type',
        'ikm_value',
        'ikm_category',
        'ikm_category_label',
        'spak_value',
        'spak_category',
        'spak_category_label',
        'total_respondents',
        'target_respondents',
        'response_rate',
        'ikm_unsur_details',
        'spak_unsur_details',
        'survey_start_date',
        'survey_end_date',
        'notes',
        'is_published',
        'published_at',
        'signatory_name',
        'signatory_position',
        'signatory_nip',
        'approval_document_path',
    ];

    protected $casts = [
        'year' => 'integer',
        'ikm_value' => 'decimal:2',
        'spak_value' => 'decimal:2',
        'response_rate' => 'decimal:2',
        'total_respondents' => 'integer',
        'target_respondents' => 'integer',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'survey_start_date' => 'date',
        'survey_end_date' => 'date',
        'ikm_unsur_details' => 'array',
        'spak_unsur_details' => 'array',
    ];

    /**
     * Get quarter label (instance method)
     */
    public function getQuarterLabel()
    {
        return [
            'tw1' => 'Triwulan I (Januari - Maret)',
            'tw2' => 'Triwulan II (April - Juni)',
            'tw3' => 'Triwulan III (Juli - September)',
            'tw4' => 'Triwulan IV (Oktober - Desember)',
            'annual' => 'Tahunan',
        ][$this->quarter] ?? $this->quarter;
    }

    /**
     * Get quarter short label
     */
    public function getQuarterShortLabel()
    {
        return [
            'tw1' => 'TW I',
            'tw2' => 'TW II',
            'tw3' => 'TW III',
            'tw4' => 'TW IV',
            'annual' => 'Tahunan',
        ][$this->quarter] ?? $this->quarter;
    }

    /**
     * Get full period label
     */
    public function getPeriodLabel()
    {
        return "{$this->year} - " . $this->getQuarterLabel();
    }

    /**
     * Get IKM category info
     */
    public function getIkmCategoryInfo()
    {
        $categories = [
            'A' => [
                'label' => 'Sangat Baik',
                'color' => 'success',
                'icon' => 'fa-star',
                'description' => 'Indeks Kepuasan Masyarakat pada kategori Sangat Baik'
            ],
            'B' => [
                'label' => 'Baik',
                'color' => 'info',
                'icon' => 'fa-thumbs-up',
                'description' => 'Indeks Kepuasan Masyarakat pada kategori Baik'
            ],
            'C' => [
                'label' => 'Cukup',
                'color' => 'warning',
                'icon' => 'fa-exclamation-triangle',
                'description' => 'Indeks Kepuasan Masyarakat pada kategori Cukup'
            ],
            'D' => [
                'label' => 'Buruk',
                'color' => 'danger',
                'icon' => 'fa-times-circle',
                'description' => 'Indeks Kepuasan Masyarakat pada kategori Buruk'
            ],
        ];

        return $categories[$this->ikm_category] ?? [
            'label' => 'N/A',
            'color' => 'secondary',
            'icon' => 'fa-question',
            'description' => 'Kategori belum ditentukan'
        ];
    }

    /**
     * Get SPAK category info
     */
    public function getSpakCategoryInfo()
    {
        $categories = [
            'A' => [
                'label' => 'Sangat Baik',
                'color' => 'success',
                'icon' => 'fa-shield-alt',
                'description' => 'Perilaku Anti Korupsi pada kategori Sangat Baik'
            ],
            'B' => [
                'label' => 'Baik',
                'color' => 'info',
                'icon' => 'fa-shield-alt',
                'description' => 'Perilaku Anti Korupsi pada kategori Baik'
            ],
            'C' => [
                'label' => 'Cukup',
                'color' => 'warning',
                'icon' => 'fa-shield-alt',
                'description' => 'Perilaku Anti Korupsi pada kategori Cukup'
            ],
            'D' => [
                'label' => 'Buruk',
                'color' => 'danger',
                'icon' => 'fa-shield-alt',
                'description' => 'Perilaku Anti Korupsi pada kategori Buruk'
            ],
        ];

        return $categories[$this->spak_category] ?? [
            'label' => 'N/A',
            'color' => 'secondary',
            'icon' => 'fa-question',
            'description' => 'Kategori belum ditentukan'
        ];
    }

    /**
     * Calculate category from raw score (scale 1-4)
     */
    public static function calculateCategory($rawScore)
    {
        // Konversi dari skala 1-4 ke skala 25-100
        $value = $rawScore * 25;
        
        if ($value >= 88.31) {
            return ['category' => 'A', 'label' => 'Sangat Baik'];
        } elseif ($value >= 76.61) {
            return ['category' => 'B', 'label' => 'Baik'];
        } elseif ($value >= 65.00) {
            return ['category' => 'C', 'label' => 'Cukup'];
        } else {
            return ['category' => 'D', 'label' => 'Buruk'];
        }
    }

    /**
     * Scope for published periods
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
     * Scope for IKM type
     */
    public function scopeIkm($query)
    {
        return $query->whereIn('survey_type', ['ikm', 'both']);
    }

    /**
     * Scope for SPAK type
     */
    public function scopeSpak($query)
    {
        return $query->whereIn('survey_type', ['spak', 'both']);
    }

    /**
     * Scope order by period (year desc, quarter desc)
     */
    public function scopeOrderByPeriod($query)
    {
        return $query->orderBy('year', 'desc')
                    ->orderByRaw("FIELD(quarter, 'tw4', 'tw3', 'tw2', 'tw1', 'annual')");
    }

    /**
     * Relationship with follow-ups
     */
    public function followUps(): HasMany
    {
        return $this->hasMany(SurveyFollowUp::class, 'period_id');
    }

    /**
     * Get IKM category with fallback to calculated value
     */
    public function getIkmCategoryWithFallback(): string
    {
        if ($this->ikm_category) {
            return $this->ikm_category;
        }
        
        if ($this->ikm_value) {
            $result = self::calculateCategory($this->ikm_value);
            return $result['category'];
        }
        
        return '-';
    }

    /**
     * Get IKM category label with fallback
     */
    public function getIkmCategoryLabelWithFallback(): string
    {
        if ($this->ikm_category_label) {
            return $this->ikm_category_label;
        }
        
        if ($this->ikm_value) {
            $result = self::calculateCategory($this->ikm_value);
            return $result['label'];
        }
        
        return '-';
    }

    /**
     * Get SPAK category with fallback to calculated value
     */
    public function getSpakCategoryWithFallback(): string
    {
        if ($this->spak_category) {
            return $this->spak_category;
        }
        
        if ($this->spak_value) {
            $result = self::calculateCategory($this->spak_value);
            return $result['category'];
        }
        
        return '-';
    }

    /**
     * Get SPAK category label with fallback
     */
    public function getSpakCategoryLabelWithFallback(): string
    {
        if ($this->spak_category_label) {
            return $this->spak_category_label;
        }
        
        if ($this->spak_value) {
            $result = self::calculateCategory($this->spak_value);
            return $result['label'];
        }
        
        return '-';
    }
}
