<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function ajukanPinjam(Request $request, $id)
{
    // Pastikan user login
    if (!Auth::guard('anggota')->check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    Peminjaman::create([
        'anggota_id' => Auth::guard('anggota')->id(),
        'buku_id' => $id,
        'status_peminjaman' => 'diajukan',
        'tanggal_peminjaman' => null,
        'tenggat_waktu' => null,
    ]);

    return redirect()->back()->with('success', 'Pengajuan pinjam berhasil, silakan tunggu konfirmasi petugas.');
}

public function konfirmasiPinjam($id)
{
    // Load relasi buku dan anggota
    $peminjaman = Peminjaman::with(['buku', 'anggota'])->findOrFail($id);
    
    // 1. Cek apakah stok tersedia
    if ($peminjaman->buku->stok <= 0) {
        return redirect()->back()->with('error', 'Gagal konfirmasi! Stok buku sudah habis.');
    }

    // 2. Update status peminjaman menjadi dipinjam
    $peminjaman->update([
        'status_peminjaman' => 'dipinjam',
        'tanggal_peminjaman' => now(),
        'tenggat_waktu' => now()->addDays(7),
    ]);

    // 3. Kurangi stok buku
    $peminjaman->buku->decrement('stok');

    // 4. PERBARUI STATUS BUKU: jika stok sisa 0 setelah didecrement, ubah status jadi 'dipinjam'
    // Kita refresh data buku untuk mendapatkan nilai stok terbaru setelah decrement
    $peminjaman->buku->refresh(); 
    if ($peminjaman->buku->stok <= 0) {
        $peminjaman->buku->update(['status' => 'dipinjam']);
    }

    // 5. Update jumlah buku_dipinjam pada anggota
    if ($peminjaman->anggota) {
        $peminjaman->anggota->increment('buku_dipinjam');
    }

    // 6. Buat record laporan
    Laporan::create([
        'peminjaman_id' => $peminjaman->id,
    ]);

    return redirect()->back()->with('success', 'Peminjaman diterima dan stok buku telah diperbarui.');
}

public function tolakPinjam($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    // Pastikan hanya pengajuan dengan status 'diajukan' yang bisa ditolak
    if ($peminjaman->status_peminjaman !== 'diajukan') {
        return redirect()->back()->with('error', 'Peminjaman yang sudah dipinjam tidak bisa ditolak.');
    }

    $peminjaman->delete();

    return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil ditolak dan dihapus.');
}

public function index(Request $request)
{
    $search = $request->get('search');
    $status = $request->get('status');

    $peminjamans = Peminjaman::with(['anggota', 'buku'])
        ->when($search, function ($query) use ($search) {
            $query->whereHas('anggota', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhereHas('buku', function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            });
        })
        ->when($status, function ($query) use ($status) {
            return $query->where('status_peminjaman', $status);
        })
        ->latest()
        ->get();

    return view('pages.backend.peminjaman.index', compact('peminjamans'));
}

public function show($id)
{
    // Mengambil data peminjaman dengan relasi Anggota, Buku, dan Laporan
    $peminjaman = Peminjaman::with(['anggota', 'buku', 'laporan'])->findOrFail($id);

    // Sesuaikan path folder: pages.backend.peminjaman.show
    return view('pages.backend.peminjaman.show', compact('peminjaman'));
}



}
