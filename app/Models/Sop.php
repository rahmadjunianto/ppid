<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Sop extends Model
{
    use HasFactory;

    protected $table = 'sops';

    protected $fillable = [
        'nama_dokumen',
        'grup',
        'nomor',
        'tahun',
        'file',
        'ukuran',
        'status',
        'sort_order',
        'admin_id',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'sort_order' => 'integer',
    ];

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeGrup($query, $grup)
    {
        return $query->where('grup', $grup);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getUkuranFormattedAttribute()
    {
        if (!$this->ukuran) {
            return '-';
        }

        $bytes = (int) $this->ukuran;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 1) . ' ' . $units[$i];
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file) {
            return null;
        }

        return asset('storage/' . $this->file);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'published' => '<span class="badge badge-success">Published</span>',
            'draft' => '<span class="badge badge-secondary">Draft</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-light">Unknown</span>';
    }

    // Helper methods
    public function isPublished()
    {
        return $this->status === 'published';
    }

    public static function getGrupOptions()
    {
        return [
            'SOP PPID' => 'SOP PPID',
            'Sub Bag TU' => 'Sub Bag TU',
            'Bimas' => 'Bimas',
            'Pais' => 'Pais',
            'Pendma' => 'Pendma',
            'PD Pontren' => 'PD Pontren',
            'Penzawa' => 'Penyelenggara Zakat Wakaf',
        ];
    }

    /**
     * Label lengkap untuk grup (mis. "Penzawa" => "Penyelenggara Zakat Wakaf").
     */
    public function getGrupLabelAttribute()
    {
        return static::getGrupOptions()[$this->grup] ?? $this->grup;
    }

    public static function getTahunOptions()
    {
        $tahun = static::published()
                       ->whereNotNull('tahun')
                       ->distinct()
                       ->pluck('tahun')
                       ->sort()
                       ->reverse()
                       ->values();

        if ($tahun->isEmpty()) {
            $currentYear = (int) date('Y');
            $tahun = collect(range($currentYear, $currentYear - 5));
        }

        return $tahun;
    }
}
