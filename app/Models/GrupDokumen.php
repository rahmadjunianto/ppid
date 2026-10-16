<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class GrupDokumen extends Model
{
    use HasFactory;

    protected $table = 'grup_dokumens';

    protected $fillable = [
        'nama_grup',
        'slug',
        'deskripsi',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama_grup);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('nama_grup') && !$model->isDirty('slug')) {
                $model->slug = Str::slug($model->nama_grup);
            }
        });
    }

    public function pustakaDokumens(): HasMany
    {
        return $this->hasMany(PustakaDokumen::class, 'grup_dokumen_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('nama_grup');
    }
}
