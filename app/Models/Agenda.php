<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'tempat',
        'penyelenggara',
        'status',
        'urutan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'urutan' => 'integer',
    ];

    // Scope untuk agenda published
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Scope untuk agenda yang akan datang
    public function scopeUpcoming($query)
    {
        return $query->where('tanggal_mulai', '>=', now());
    }

    // Scope untuk agenda yang sudah lewat
    public function scopePast($query)
    {
        return $query->where('tanggal_mulai', '<', now());
    }

    // Scope untuk ordering
    public function scopeOrdered($query)
    {
        return $query->orderBy('tanggal_mulai', 'asc')->orderBy('urutan', 'asc');
    }

    // Accessor untuk format tanggal Indonesia
    public function getFormattedDateAttribute()
    {
        $locale = 'id_ID';
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $date = $this->tanggal_mulai;
        $day = $date->format('d');
        $month = $months[(int) $date->format('m')];
        $year = $date->format('Y');

        return "{$day} {$month} {$year}";
    }

    // Accessor untuk format waktu
    public function getFormattedTimeAttribute()
    {
        if ($this->tanggal_selesai) {
            return $this->tanggal_mulai->format('H:i') . ' - ' . $this->tanggal_selesai->format('H:i') . ' WIB';
        }

        return $this->tanggal_mulai->format('H:i') . ' WIB';
    }

    // Check if agenda is today
    public function getIsTodayAttribute()
    {
        return $this->tanggal_mulai->isToday();
    }

    // Check if agenda is upcoming
    public function getIsUpcomingAttribute()
    {
        return $this->tanggal_mulai->isFuture();
    }
}
