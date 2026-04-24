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

    $pengembalian = Pengembalian::findOrFail($id);
    $peminjaman = $pengembalian->peminjaman;
    $buku = $peminjaman->buku;

    // 1. Logika Tanggal (Mekanisme Fixed)
    $tenggat = Carbon::parse($peminjaman->tenggat_waktu)->startOfDay();
    $tgl_kembali = Carbon::parse($pengembalian->tanggal_pengembalian)->startOfDay();
    
    // Hitung selisih murni terlebih dahulu
    $selisih_hari = $tgl_kembali->diffInDays($tenggat, false); 
    
    // Mekanisme: Jika selisih negatif (karena tgl_kembali > tenggat), 
    // kita gunakan abs() untuk menjamin nilai positif 100%
    $hari_telat = 0;
    if ($tgl_kembali->gt($tenggat)) {
        $hari_telat = abs($selisih_hari); 
    }
    
    $denda_waktu = $hari_telat * 500; 

    // 2. Denda Fisik
    $denda_fisik = 0;
    if ($request->jenis_pelanggaran == 'kerusakan') $denda_fisik = 20000;
    if ($request->jenis_pelanggaran == 'hilang') $denda_fisik = 50000;

    // Menghasilkan total akumulasi yang dijamin positif
    $total_akumulasi = (int)$denda_waktu + (int)$denda_fisik;

    // 3. Simpan ke Tabel Denda
    if ($total_akumulasi > 0) {
        Denda::updateOrCreate(
            ['pengembalian_id' => $pengembalian->id],
            [
                'jumlah_hari' => $hari_telat, 
                'total_denda' => $total_akumulasi, 
                'status' => 'unpaid'
            ]
        );
    }

    // 4. Update Stok Buku & Status Buku (Jika tidak hilang)
    if ($request->jenis_pelanggaran != 'hilang') {
        $buku->increment('stok');
        $buku->update(['status' => 'tersedia']);
    }

    // 5. Update data Peminjaman & Pengembalian
    $pengembalian->update([
        'status_pengembalian' => 'selesai', 
        'jenis_pelanggaran' => $request->jenis_pelanggaran
    ]);
    
    $peminjaman->update(['status_peminjaman' => 'selesai']);

    // 6. UPDATE LAPORAN
    Laporan::where('peminjaman_id', $peminjaman->id)->update([
        'pengembalian_id' => $pengembalian->id,
        'total_denda' => $total_akumulasi,
        'status_keterlambatan' => $hari_telat > 0 ? 'terlambat' : 'tepat_waktu',
    ]);

    return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil diselesaikan!');
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