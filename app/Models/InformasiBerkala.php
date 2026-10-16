<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InformasiBerkala extends Model
{
    use HasFactory;

    protected $table = 'informasi_berkala';

    protected $fillable = [
        'kategori',
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

    // Kategori options
    public static function getKategoriOptions()
    {
        return [
            'A' => 'A. Profil Kementerian Agama',
            'B' => 'B. Program dan/atau Kegiatan yang Sedang Dijalankan',
            'C' => 'C. Program Strategis sesuai Tugas dan Fungsi',
            'D' => 'D. Ringkasan Program/Kegiatan yang Telah Dijalankan',
            'E' => 'E. Informasi Pekerjaan Pengadaan Barang/Jasa',
        ];
    }

    public static function getKategoriLabel($kategori)
    {
        return self::getKategoriOptions()[$kategori] ?? $kategori;
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

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('kategori')->orderBy('sort_order')->orderBy('id');
    }

    // Accessors
    public function getKategoriBadgeAttribute()
    {
        $colors = [
            'A' => 'primary',
            'B' => 'success',
            'C' => 'info',
            'D' => 'warning',
            'E' => 'secondary',
        ];
        $color = $colors[$this->kategori] ?? 'secondary';
        return '<span class="badge badge-' . $color . '">Kategori ' . $this->kategori . '</span>';
    }

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
    public static function getItemsByKategori()
    {
        return self::published()
            ->ordered()
            ->get()
            ->groupBy('kategori');
    }
}