<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    /**
     * Data kategori diambil dari database portal (kemenag), tabel `post_categories`.
     *
     * @var string
     */
    protected $connection = 'mysql_portal';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_categories';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'legacy_id',
        'name',
        'slug',
        'description',
        'is_active',
        'show_in_sidebar',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'show_in_sidebar' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get all berita for this kategori
     */
    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'category_id', 'id');
    }

    /**
     * Scope untuk kategori yang aktif
     */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
