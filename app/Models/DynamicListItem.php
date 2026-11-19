<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DynamicListItem extends Model
{
    use HasFactory;

    protected $table = 'dynamic_list_items';

    protected $fillable = [
        'dynamic_list_id',
        'data',
        'sort_order',
    ];

    protected $casts = [
        'data' => 'array',
        'sort_order' => 'integer',
    ];

    public function list(): BelongsTo
    {
        return $this->belongsTo(DynamicList::class, 'dynamic_list_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(DynamicListItemFile::class, 'dynamic_list_item_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Ambil nilai satu kolom pada item ini.
     */
    public function value(string $key, mixed $default = null): mixed
    {
        $data = is_array($this->data) ? $this->data : [];

        return $data[$key] ?? $default;
    }

    /**
     * Nilai kolom yang bisa berupa banyak data (multiple) selalu dinormalisasi ke array.
     */
    public function values(string $key): array
    {
        $value = $this->value($key);

        if ($value === null || $value === '') {
            return [];
        }

        return is_array($value) ? array_values($value) : [$value];
    }
}
