<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with([
            'peminjaman.anggota', 
            'peminjaman.buku', 
            'pengembalian'
        ]);

        // Filter berdasarkan periode
        if ($request->has('periode') && $request->periode != '') {
            $now = Carbon::now();
            
            $query->whereHas('peminjaman', function($q) use ($request, $now) {
                if ($request->periode == 'mingguan') {
                    $q->whereBetween('tanggal_peminjaman', [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')]);
                } elseif ($request->periode == 'bulanan') {
                    $q->whereMonth('tanggal_peminjaman', $now->month)
                      ->whereYear('tanggal_peminjaman', $now->year);
                } elseif ($request->periode == 'tahunan') {
                    $q->whereYear('tanggal_peminjaman', $now->year);
                }
            });
        }

        // Filter pencarian nama/buku (tambahan agar tetap sinkron)
        $query->when($request->search, function ($q) use ($request) {
            $q->whereHas('peminjaman.anggota', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            })->orWhereHas('peminjaman.buku', function ($query) use ($request) {
                $query->where('judul', 'like', '%' . $request->search . '%');
            });
        });

        $laporans = $query->latest()->get();

        return view('pages.backend.laporan.index', compact('laporans'));
    }

    public function cetak(Request $request)
{
    $query = Laporan::with(['peminjaman.anggota', 'peminjaman.buku', 'pengembalian']);

    // LOGIKA FILTER YANG SAMA DENGAN INDEX
    if ($request->has('periode') && $request->periode != '') {
        $now = \Carbon\Carbon::now();
        $query->whereHas('peminjaman', function($q) use ($request, $now) {
            if ($request->periode == 'mingguan') {
                $q->whereBetween('tanggal_peminjaman', [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')]);
            } elseif ($request->periode == 'bulanan') {
                $q->whereMonth('tanggal_peminjaman', $now->month)->whereYear('tanggal_peminjaman', $now->year);
            } elseif ($request->periode == 'tahunan') {
                $q->whereYear('tanggal_peminjaman', $now->year);
            }
        });
    }

    $laporans = $query->latest()->get();
    $periodeText = $request->periode ?? 'Semua Waktu';

    // Menampilkan view khusus cetak (tanpa navbar/sidebar)
    return view('pages.backend.laporan.cetak', compact('laporans', 'periodeText'));
}
}