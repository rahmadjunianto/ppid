<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InformasiSetiapSaat extends Model
{
    use HasFactory;

    protected $table = 'informasi_setiap_saat';

    protected $fillable = [
        'judul',
        'slug',
        'link',
        'link_type',
        'file',
        'ukuran',
        'status',
        'sort_order',
        'admin_id',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    // Link type options
    public static function getLinkTypeOptions()
    {
        return [
            'internal' => 'Internal (halaman/site)',
            'external' => 'External (URL luar)',
            'file' => 'File (dokumen)',
        ];
    }

    public static function getLinkTypeLabel($linkType)
    {
        return self::getLinkTypeOptions()[$linkType] ?? $linkType;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        if ($this->status === 'published') {
            return '<span class="badge badge-success">Published</span>';
        }
        return '<span class="badge badge-secondary">Draft</span>';
    }

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

    public function getLinkTypeBadgeAttribute()
    {
        $badges = [
            'internal' => '<span class="badge badge-info"><i class="fas fa-link"></i> Internal</span>',
            'external' => '<span class="badge badge-primary"><i class="fas fa-external-link-alt"></i> External</span>',
            'file' => '<span class="badge badge-warning"><i class="fas fa-file"></i> File</span>',
        ];
        return $badges[$this->link_type] ?? '-';
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file) {
            return null;
        }
        return asset('storage/' . $this->file);
    }

    /**
     * URL tujuan pada halaman publik.
     * - file   -> halaman viewer/unduh dokumen
     * - external -> URL luar apa adanya
     * - internal -> halaman internal pada situs ini
     * - tanpa link -> null (ditampilkan sebagai teks biasa)
     */
    public function getPublicUrlAttribute()
    {
        if ($this->link_type === 'file' && $this->file) {
            return route('informasi-setiap-saat.view', $this->id);
        }

        if (empty($this->link)) {
            return null;
        }

        if ($this->link_type === 'external') {
            return $this->link;
        }

        return url($this->link);
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['slug'] = Str::slug($this->judul ?? 'informasi') . '-' . time();
        } else {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    // Helper methods
    public static function getPublishedItems()
    {
        return self::published()
            ->ordered()
            ->get();
    }
}
