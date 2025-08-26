<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::published();

        // Filter berdasarkan bulan/tahun jika ada
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_mulai', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_mulai', $request->tahun);
        }

        // Filter berdasarkan status (upcoming/past)
        if ($request->filled('status')) {
            if ($request->status == 'upcoming') {
                $query->upcoming();
            } elseif ($request->status == 'past') {
                $query->past();
            }
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                  ->orWhere('tempat', 'like', '%' . $request->search . '%')
                  ->orWhere('penyelenggara', 'like', '%' . $request->search . '%');
            });
        }

        $agendas = $query->ordered()->paginate(10);

        // Data untuk filter
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $tahunList = Agenda::published()
            ->selectRaw('YEAR(tanggal_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('agenda.index', compact('agendas', 'bulanList', 'tahunList'));
    }

    public function show(Agenda $agenda)
    {
        // Only show published agendas
        if ($agenda->status !== 'published') {
            abort(404);
        }

        return view('agenda.show', compact('agenda'));
    }
}
