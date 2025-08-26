<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'nama',
        'jabatan',
        'golongan',
        'unit_kerja',
        'urutan'
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    // Scope untuk ordering
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc')->orderBy('nama', 'asc');
    }
}
