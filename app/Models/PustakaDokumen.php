<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PustakaDokumen extends Model
{
    use HasFactory;

    protected $table = 'pustaka_dokumens';

    protected $fillable = [
        'grup_dokumen_id',
        'nama_dokumen',
        'deskripsi',
        'nomor',
        'tahun',
        'link_type',
        'file',
        'link_url',
        'ukuran',
        'created_by',
    ];

    protected $casts = [
        'tahun'      => 'integer',
        'view_count' => 'integer',
    ];

    public function grupDokumen(): BelongsTo
    {
        return $this->belongsTo(GrupDokumen::class, 'grup_dokumen_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

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

    public function scopeByGrup($query, $slug)
    {
        return $query->whereHas('grupDokumen', function ($q) use ($slug) {
            $q->where('slug', $slug);
        });
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nama_dokumen', 'like', "%{$term}%")
              ->orWhere('nomor', 'like', "%{$term}%");
        });
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->nama_dokumen) . '-' . $this->id;
    }

    public static function findBySlug($slug)
    {
        // Extract ID from slug (format: nama-dokumen-id)
        if (preg_match('/-(\d+)$/', $slug, $matches)) {
            $id = $matches[1];
            return self::find($id);
        }
        return null;
    }
}
