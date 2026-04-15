<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Laporan;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    // Halaman Utama: Menyatukan Antrean & Selesai
    public function index(Request $request)
{
    // Ambil input filter
    $keyword = $request->get('keyword');
    $status = $request->get('status');

    $pengembalian = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku', 'denda'])
        ->when($keyword, function ($query) use ($keyword) {
            $query->whereHas('peminjaman.anggota', function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%");
            })->orWhereHas('peminjaman.buku', function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%");
            });
        })
        ->when($status, function ($query) use ($status) {
            return $query->where('status_pengembalian', $status);
        })
        ->latest()
        ->get();

    // Hitung total antrean (tanpa filter keyword/status agar badge tetap akurat)
    $antrean = Pengembalian::where('status_pengembalian', 'diajukan')->count();
                            
    return view('pages.backend.pengembalian.index', compact('pengembalian', 'antrean'));
}

    public function ajukan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $exists = Pengembalian::where('peminjaman_id', $id)
                    ->where('status_pengembalian', 'diajukan')
                    ->first();
        
        if($exists) return redirect()->back()->with('error', 'Sudah dalam antrean petugas.');

        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_pengembalian' => now(),
            'status_pengembalian' => 'diajukan',
        ]);

        return redirect()->back()->with('success', 'Berhasil lapor. Serahkan buku ke petugas.');
    }

    public function konfirmasi($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku'])->findOrFail($id);
        return view('pages.backend.pengembalian.proses', compact('pengembalian'));
    }

public function selesai(Request $request, $id)
{
    $request->validate([
        'jenis_pelanggaran' => 'required|in:tidak_ada,kerusakan,hilang'
    ]);

    $pengembalian = Pengembalian::with(['peminjaman.buku', 'peminjaman.anggota'])->findOrFail($id);
    $peminjaman = $pengembalian->peminjaman;

    // 1. Logika Tanggal & Keterlambatan
    $tenggat = \Carbon\Carbon::parse($peminjaman->tenggat_waktu)->startOfDay();
    $tgl_kembali = \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->startOfDay();
    
    $hari_telat = 0;

    // Gunakan if yang lebih ketat
    if ($tgl_kembali->gt($tenggat)) {
        // diffInDays secara default di Carbon menghasilkan nilai absolut (positif)
        // Namun untuk memastikan, kita paksa perhitungannya hanya jika benar-benar telat
        $hari_telat = $tgl_kembali->diffInDays($tenggat);
    } else {
        $hari_telat = 0; // Tepat waktu atau lebih awal
    }
    
    // Pastikan hari_telat tidak negatif dengan max(0, ...)
    $hari_telat = max(0, $hari_telat);

    $denda_waktu = $hari_telat * 500; 

    // 2. Logika Denda Fisik
    $denda_fisik = 0;
    if ($request->jenis_pelanggaran == 'kerusakan') $denda_fisik = 20000;
    if ($request->jenis_pelanggaran == 'hilang') $denda_fisik = 50000;

    // Total Akumulasi (Pasti Positif)
    $total_akumulasi = $denda_waktu + $denda_fisik;

    // 3. Simpan/Update Tabel Denda
    if ($total_akumulasi > 0) {
        \App\Models\Denda::updateOrCreate(
            ['pengembalian_id' => $pengembalian->id],
            [
                'jumlah_hari' => $hari_telat, 
                'total_denda' => $total_akumulasi, 
                'status' => 'unpaid'
            ]
        );
    }

    // Update status pengembalian & peminjaman jangan lupa
    $pengembalian->update(['status_pengembalian' => 'selesai']);
    $peminjaman->update(['status_peminjaman' => 'dikembalikan']);
    
    // Tambah stok buku kembali
    $peminjaman->buku->increment('stok');

    return redirect()->back()->with('success', 'Proses pengembalian berhasil diselesaikan.');
} 

// Fungsi untuk melihat detail pengembalian (View Detail)
    public function show($id)
    {
        // Mengambil data dengan relasi lengkap
        $pengembalian = Pengembalian::with([
            'peminjaman.anggota', 
            'peminjaman.buku', 
            'denda'
        ])->findOrFail($id);

        return view('pages.backend.pengembalian.show', compact('pengembalian'));
    }

    // Fungsi untuk proses pelunasan denda
   // Tambahkan di PengembalianController

// ... (Bagian atas tetap sama)

    public function bayarDenda(Request $request, $id)
    {
        $denda = Denda::findOrFail($id);
        
        $request->validate([
            'bayar' => 'required|numeric|min:0',
        ]);

        $total_tagihan = $denda->total_denda;
        $nominal_bayar = $request->bayar;

        if ($nominal_bayar < $total_tagihan) {
            return redirect()->back()->with('error', 'Uang pembayaran kurang!');
        }

        // Simpan status dan nominal bayar secara PERMANEN
        $denda->update([
            'status' => 'paid',
            'nominal_bayar' => $nominal_bayar
        ]);

        // UPDATE LAPORAN
        Laporan::where('pengembalian_id', $denda->pengembalian_id)->update([
            'denda_dibayar' => $total_tagihan
        ]);

        $kembalian = $nominal_bayar - $total_tagihan;
        return redirect()->back()->with('success', 'Denda lunas! Kembalian: Rp ' . number_format($kembalian, 0, ',', '.'));
    }

    // Fungsi Cetak Struk
    public function cetakStruk($id)
    {
        // Mencari denda berdasarkan ID pengembalian agar lebih mudah dipanggil dari view detail
        $denda = Denda::with(['pengembalian.peminjaman.anggota', 'pengembalian.peminjaman.buku'])->findOrFail($id);
        
        return view('pages.backend.pengembalian.struk', compact('denda'));
    }
}