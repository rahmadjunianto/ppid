<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class DynamicList extends Model
{
    use HasFactory;

    protected $table = 'dynamic_lists';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'show_title',
        'sort_order',
        'created_by',
        'published_at',
    ];

    protected $casts = [
        'show_title' => 'boolean',
        'sort_order' => 'integer',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    protected static function booted(): void
    {
        static::saving(function (self $list) {
            if (blank($list->slug)) {
                $list->slug = static::uniqueSlug($list->title);
            }

            if ($list->status === 'published' && $list->published_at === null) {
                $list->published_at = now();
            }
        });
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'daftar';
        $slug = $base;
        $counter = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = $base.'-'.(++$counter);
        }

        return $slug;
    }

    public function columns(): HasMany
    {
        return $this->hasMany(DynamicListColumn::class, 'dynamic_list_id')->orderBy('sort_order')->orderBy('id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(DynamicListItem::class, 'dynamic_list_id')->orderBy('sort_order')->orderBy('id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getPublicUrlAttribute(): string
    {
        return route('lists.show', $this->slug);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
