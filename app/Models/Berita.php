<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql_portal';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'berita';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_berita';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'isi_berita',
        'gambar',
        'tanggal',
        'jam',
        'aktif',
        'username',
        'id_kategori',
        'judul_seo'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Get the URL-friendly identifier for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'judul_seo';
    }

    /**
     * Accessor for getting full datetime
     *
     * @return \Carbon\Carbon|null
     */
    public function getTanggalPublishAttribute()
    {
        if ($this->tanggal && $this->jam) {
            // Jika tanggal sudah berupa Carbon object, ambil tanggalnya saja
            $tanggal = $this->tanggal instanceof \Carbon\Carbon
                ? $this->tanggal->format('Y-m-d')
                : $this->tanggal;

            try {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tanggal . ' ' . $this->jam);
            } catch (\Exception $e) {
                // Fallback jika format tidak sesuai
                return $this->tanggal instanceof \Carbon\Carbon
                    ? $this->tanggal
                    : \Carbon\Carbon::parse($this->tanggal);
            }
        }

        return $this->tanggal instanceof \Carbon\Carbon
            ? $this->tanggal
            : ($this->tanggal ? \Carbon\Carbon::parse($this->tanggal) : null);
    }

    /**
     * Accessor for content
     *
     * @return string
     */
    public function getKontenAttribute()
    {
        return $this->isi_berita;
    }

    /**
     * Accessor for author
     *
     * @return string
     */
    public function getAuthorAttribute()
    {
        return $this->username;
    }

    /**
     * Accessor for category ID
     *
     * @return int
     */
    public function getKategoriIdAttribute()
    {
        return $this->id_kategori;
    }

    /**
     * Accessor for slug
     *
     * @return string
     */
    public function getSlugAttribute()
    {
        return $this->judul_seo;
    }

    /**
     * Accessor for status
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->aktif === 'Y' ? 'published' : 'draft';
    }

    /**
     * Scope untuk berita yang aktif/published
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('aktif', 'Y');
    }

    /**
     * Scope untuk berita headline
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHeadline($query)
    {
        return $query->where('headline', 'Y');
    }

    /**
     * Scope untuk berita utama
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUtama($query)
    {
        return $query->where('utama', 'Y');
    }

    /**
     * Get the kategori that owns the berita
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Get formatted tags as array
     *
     * @return array
     */
    public function getFormattedTagsAttribute()
    {
        if (empty($this->tag)) {
            return [];
        }

        // Split tags by comma and clean them
        return array_map('trim', explode(',', $this->tag));
    }
}
