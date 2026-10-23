<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    /**
     * Data berita diambil dari database portal (kemenag), tabel `posts`.
     *
     * @var string
     */
    protected $connection = 'mysql_portal';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

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
        'category_id',
        'author_id',
        'title',
        'subtitle',
        'slug',
        'content',
        'thumbnail',
        'image_caption',
        'youtube_url',
        'type',
        'is_headline',
        'is_featured',
        'is_active',
        'status',
        'views',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_headline' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'views' => 'integer',
        'published_at' => 'datetime',
    ];

    /* ---------------------------------------------------------------------
     | Relasi
     | ------------------------------------------------------------------ */

    /**
     * Kategori berita
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'category_id', 'id');
    }

    /**
     * Penulis berita (user portal)
     */
    public function penulis(): BelongsTo
    {
        return $this->belongsTo(PortalUser::class, 'author_id', 'id');
    }

    /**
     * Tag berita
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(PortalTag::class, 'post_tag', 'post_id', 'tag_id');
    }

    /* ---------------------------------------------------------------------
     | Scope
     | ------------------------------------------------------------------ */

    /**
     * Scope untuk berita yang aktif dan sudah dipublikasikan
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope untuk berita headline
     */
    public function scopeHeadline(Builder $query): Builder
    {
        return $query->where('is_headline', true);
    }

    /**
     * Scope untuk berita utama/unggulan
     */
    public function scopeUtama(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /* ---------------------------------------------------------------------
     | Accessor
     | ------------------------------------------------------------------ */

    /**
     * URL-friendly identifier for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * URL gambar utama (varian webp bila nama berkas berupa hash).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->thumbnail)) {
            return null;
        }

        $base = rtrim((string) config('portal.media_url'), '/');
        $file = ltrim($this->thumbnail, '/');

        // Path relatif, contoh: posts/foto.jpg
        if (str_contains($file, '/')) {
            return $base . '/' . $file;
        }

        // Nama berkas baru (hash) -> varian webp
        return $base . '/posts/large-' . $file . '.webp';
    }

    /**
     * URL gambar asli, dipakai sebagai fallback jika varian webp gagal dimuat.
     */
    public function getImageUrlAsliAttribute(): ?string
    {
        if (empty($this->thumbnail)) {
            return null;
        }

        $base = rtrim((string) config('portal.media_url'), '/');
        $file = ltrim($this->thumbnail, '/');

        return str_contains($file, '/') ? $base . '/' . $file : $base . '/posts/' . $file;
    }

    /**
     * Nama penulis berita.
     */
    public function getAuthorAttribute(): ?string
    {
        return $this->penulis?->name ?? $this->penulis?->username;
    }

    /**
     * Ringkasan isi berita tanpa tag HTML.
     */
    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags((string) $this->content), 150);
    }

    /**
     * Cek apakah berita memiliki gambar.
     */
    public function hasValidImage(): bool
    {
        return ! empty($this->thumbnail);
    }
}
