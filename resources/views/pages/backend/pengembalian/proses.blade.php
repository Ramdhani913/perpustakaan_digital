@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm" style="border-radius: 15px;">
            <div class="card-body">
                <h4 class="card-title text-primary">Konfirmasi & Cek Fisik Buku</h4>
                <p class="text-muted small">Validasi kondisi buku sebelum menyelesaikan transaksi.</p>
                <hr>
                
                <div class="row mb-4">
                    <div class="col-md-6 border-right">
                        <p class="text-muted mb-1 small">Nama Peminjam</p>
                        <h5 class="fw-bold">{{ $pengembalian->peminjaman->anggotas->nama ?? 'unknown' }}</h5>
                        
                        <p class="text-muted mb-1 mt-3 small">Judul Buku</p>
                        <h5 class="fw-bold">{{ $pengembalian->peminjaman->buku->judul }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1 small">Tenggat Waktu</p>
                        <h5 class="{{ now()->gt($pengembalian->peminjaman->tenggat_waktu) ? 'text-danger' : 'text-dark' }}">
                            {{ \Carbon\Carbon::parse($pengembalian->peminjaman->tenggat_waktu)->format('d M Y') }}
                        </h5>
                        
                        <p class="text-muted mb-1 mt-3 small">Status Keterlambatan</p>
                        @php
                            $tenggat = \Carbon\Carbon::parse($pengembalian->peminjaman->tenggat_waktu);
                            $tgl_kembali = \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian);
                        @endphp

                        @if($tgl_kembali->gt($tenggat))
                            <span class="badge badge-danger">
                                Terlambat {{ $tgl_kembali->diffInDays($tenggat) }} Hari
                            </span>
                        @else
                            <span class="badge badge-success">Tepat Waktu</span>
                        @endif
                    </div>
                </div>

                {{-- Action diarahkan ke PengembalianController@selesai --}}
                <form action="{{ route('pengembalian.selesai', $pengembalian->id) }}" method="POST">
                    @csrf
                    <div class="form-group bg-light p-3" style="border-radius: 10px;">
                        <label class="fw-bold">Pilih Kondisi Buku (Pemeriksaan Fisik)</label>
                        <select name="jenis_pelanggaran" class="form-control" required>
                            <option value="tidak_ada">Kondisi Bagus / Normal (Tanpa Denda Fisik)</option>
                            <option value="kerusakan">Buku Rusak (+ Rp 20.000)</option>
                            <option value="hilang">Buku Hilang (+ Rp 50.000)</option>
                        </select>
                        <div class="mt-2">
                            <small class="text-primary d-block">
                                <i class="typcn typcn-info-large"></i> 
                                Sistem akan menghitung otomatis denda keterlambatan (Rp 500/hari).
                            </small>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('pengembalian.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm" onclick="return confirm('Selesaikan proses pengembalian ini?')">
                            Validasi & Selesaikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection