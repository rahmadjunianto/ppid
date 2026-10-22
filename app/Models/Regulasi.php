<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Regulasi extends Model
{
    use HasFactory;

    protected $table = 'regulasi';

    protected $fillable = [
        'nama_regulasi',
        'nomor',
        'tingkat',
        'tahun',
        'link_type',
        'file',
        'link_url',
        'ukuran',
        'status',
        'sort_order',
        'admin_id',
    ];

    /**
     * Nilai bawaan untuk atribut yang tidak diisi saat pembuatan record.
     */
    protected $attributes = [
        'tingkat'    => 'pusat',
        'link_type'  => 'file',
        'status'     => 'published',
        'sort_order' => 0,
        'view_count' => 0,
    ];

    protected $casts = [
        'tahun'      => 'integer',
        'sort_order' => 'integer',
        'view_count' => 'integer',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeTingkat($query, $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nama_regulasi', 'like', "%{$term}%")
              ->orWhere('nomor', 'like', "%{$term}%");
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getFileUrlAttribute(): ?string
    {
        if ($this->link_type === 'file' && $this->file) {
            return asset('storage/' . $this->file);
        }

        return null;
    }

    public function getFileExistsAttribute(): bool
    {
        if ($this->link_type === 'file' && $this->file) {
            return Storage::disk('public')->exists($this->file);
        }

        return false;
    }

    public function getUkuranFormattedAttribute(): string
    {
        if (! $this->ukuran) {
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

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'published' => '<span class="badge badge-success">Published</span>',
            'draft'     => '<span class="badge badge-secondary">Draft</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-light">Unknown</span>';
    }

    /**
     * Label tingkat regulasi (Pusat / Kankemenag).
     */
    public function getTingkatLabelAttribute(): string
    {
        return static::getTingkatOptions()[$this->tingkat] ?? $this->tingkat;
    }

    /**
     * Badge Bootstrap untuk tingkat regulasi.
     */
    public function getTingkatBadgeAttribute(): string
    {
        $badges = [
            'pusat'      => '<span class="badge badge-info">Pusat</span>',
            'kankemenag' => '<span class="badge badge-warning">Kankemenag</span>',
        ];

        return $badges[$this->tingkat] ?? '<span class="badge badge-light">' . e($this->tingkat) . '</span>';
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Opsi tingkat regulasi untuk form admin.
     */
    public static function getTingkatOptions(): array
    {
        return [
            'pusat'      => 'Tingkat Pusat',
            'kankemenag' => 'Tingkat Kankemenag',
        ];
    }

    /**
     * Daftar tahun yang tersedia (unik, diurutkan menurun).
     */
    public static function getTahunOptions(): array
    {
        return static::query()
            ->whereNotNull('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->all();
    }
}
