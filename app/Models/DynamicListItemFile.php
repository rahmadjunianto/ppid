<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DynamicListItemFile extends Model
{
    use HasFactory;

    protected $table = 'dynamic_list_item_files';

    protected $fillable = [
        'dynamic_list_item_id',
        'dynamic_list_column_id',
        'path',
        'original_name',
        'mime_type',
        'size',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(DynamicListItem::class, 'dynamic_list_item_id');
    }

    public function column(): BelongsTo
    {
        return $this->belongsTo(DynamicListColumn::class, 'dynamic_list_column_id');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/'.$this->path);
    }

    public function getDownloadUrlAttribute(): string
    {
        return route('lists.file.download', $this->id);
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = (int) $this->size;

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1).' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 1).' KB';
        }

        return $bytes.' B';
    }

    public function deleteFile(): void
    {
        if ($this->path && Storage::disk('public')->exists($this->path)) {
            Storage::disk('public')->delete($this->path);
        }
    }
}
