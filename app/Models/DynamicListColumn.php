<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class DynamicListColumn extends Model
{
    use HasFactory;

    public const TYPES = [
        'text' => 'Teks Singkat',
        'textarea' => 'Teks Panjang',
        'number' => 'Angka',
        'date' => 'Tanggal',
        'select' => 'Pilihan (Dropdown)',
        'boolean' => 'Ya / Tidak',
        'file' => 'Upload File',
        'action' => 'Aksi (Link / File)',
    ];

    public const ACTION_TYPES = [
        'internal' => 'Link Internal',
        'external' => 'Link Eksternal',
        'file' => 'Upload File',
    ];

    /** Lebar minimum kolom yang boleh diatur (piksel). */
    public const MIN_WIDTH = 40;

    /** Lebar maksimum kolom yang boleh diatur (piksel). */
    public const MAX_WIDTH = 1000;

    /** Lebar fallback (piksel) untuk kolom yang lebarnya otomatis. */
    public const FALLBACK_WIDTH = 160;

    protected $table = 'dynamic_list_columns';

    protected $fillable = [
        'dynamic_list_id',
        'key',
        'label',
        'type',
        'options',
        'action_type',
        'is_multiple',
        'is_required',
        'sort_order',
        'width',
    ];

    protected $casts = [
        'options' => 'array',
        'is_multiple' => 'boolean',
        'is_required' => 'boolean',
        'sort_order' => 'integer',
        'width' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $column) {
            if (blank($column->key)) {
                $column->key = static::uniqueKey($column->label, $column->dynamic_list_id);
            }

            if ($column->type !== 'action') {
                $column->action_type = null;
            }

            if ($column->type === 'select' && !is_array($column->options)) {
                $column->options = [];
            }
        });
    }

    public static function uniqueKey(string $label, int $listId, ?int $ignoreId = null): string
    {
        $base = Str::slug($label) ?: 'kolom';
        $key = $base;
        $counter = 1;

        while (static::where('dynamic_list_id', $listId)
            ->where('key', $key)
            ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
            ->exists()) {
            $key = $base.'_'.(++$counter);
        }

        return $key;
    }

    public function list(): BelongsTo
    {
        return $this->belongsTo(DynamicList::class, 'dynamic_list_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(DynamicListItemFile::class, 'dynamic_list_column_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function isAction(): bool
    {
        return $this->type === 'action';
    }

    public function isFileType(): bool
    {
        return $this->type === 'file' || ($this->type === 'action' && $this->action_type === 'file');
    }

    /**
     * Apakah kolom ini memiliki lebar khusus (dalam piksel)?
     */
    public function hasWidth(): bool
    {
        return $this->width !== null && (int) $this->width > 0;
    }

    /**
     * Gaya CSS untuk lebar kolom; null berarti lebarnya otomatis.
     */
    public function widthStyle(): ?string
    {
        return $this->hasWidth() ? 'width: '.$this->width.'px;' : null;
    }

    /**
     * Lebar efektif kolom (piksel). Kolom otomatis memakai lebar fallback.
     */
    public function resolvedWidth(): int
    {
        return $this->hasWidth() ? (int) $this->width : self::FALLBACK_WIDTH;
    }

    /**
     * Label lebar untuk ditampilkan pada halaman pengelolaan.
     */
    public function widthLabel(): string
    {
        return $this->hasWidth() ? $this->width.' px' : 'Otomatis';
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function actionTypeLabel(): ?string
    {
        return $this->action_type ? (self::ACTION_TYPES[$this->action_type] ?? $this->action_type) : null;
    }

    /**
     * Opsi dropdown disimpan sebagai list [{'label' => ..., 'value' => ...}].
     */
    public function optionPairs(): array
    {
        if (! is_array($this->options)) {
            return [];
        }

        return array_values(array_filter($this->options, fn ($opt) => is_array($opt) && array_key_exists('value', $opt)));
    }

    /**
     * Daftar nilai yang valid untuk kolom select.
     */
    public function optionValues(): array
    {
        return array_map(fn ($opt) => (string) $opt['value'], $this->optionPairs());
    }

    /**
     * Label untuk sebuah nilai (fallback ke nilai itu sendiri).
     */
    public function optionLabel(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        foreach ($this->optionPairs() as $opt) {
            if ((string) $opt['value'] === (string) $value) {
                return $opt['label'] ?? $opt['value'];
            }
        }

        return $value;
    }
}
