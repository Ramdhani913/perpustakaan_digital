@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title mb-0">Daftar Pengembalian</h4>
                        {{-- Badge diletakkan di bawah judul agar tetap rapi saat ada form di kanan --}}
                        <span class="badge badge-warning mt-2">{{ $antrean }} Menunggu Verifikasi</span>
                    </div>
                    
                    {{-- Form Search & Filter (Persis Peminjaman) --}}
                    <form action="{{ route('pengembalian.index') }}" method="GET" class="d-flex">
                        {{-- Filter Status --}}
                        <select name="status" class="form-control form-control-sm mr-2" style="width: 150px;">
                            <option value="">Semua Status</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>

                        {{-- Input Search --}}
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari nama/buku..." value="{{ request('keyword') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="typcn typcn-zoom"></i>
                                </button>
                            </div>
                        </div>
                        
                        {{-- Tombol Reset muncul jika ada filter yang aktif --}}
                        @if(request('keyword') || request('status'))
                            <a href="{{ route('pengembalian.index') }}" class="btn btn-light btn-sm ml-2">Reset</a>
                        @endif
                    </form>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped project-orders-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Anggota</th>
                                <th>Judul Buku</th>
                                <th>Tgl Lapor Kembali</th>
                                <th>Status Kembali</th>
                                <th>Denda</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengembalian as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $p->peminjaman->anggota->nama ?? 'Tidak Ditemukan' }}</strong>
                                    </td>
                                    <td>{{ $p->peminjaman->buku->judul }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d M Y') }}</td>
                                    <td>
                                        @if($p->status_pengembalian == 'diajukan')
                                            <label class="badge badge-info">Diajukan</label>
                                        @else
                                            <label class="badge badge-success">Selesai</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->denda)
                                            <small class="text-danger fw-bold">Rp {{ number_format($p->denda->total_denda, 0, ',', '.') }}</small>
                                            <br>
                                            @if($p->denda->status == 'unpaid')
                                                <span class="badge badge-outline-danger" style="font-size: 10px;">Belum Bayar</span>
                                            @else
                                                <span class="badge badge-outline-success" style="font-size: 10px;">Lunas</span>
                                            @endif
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($p->status_pengembalian == 'diajukan')
                                                <a href="{{ route('pengembalian.konfirmasi', $p->id) }}" class="btn btn-primary btn-sm mr-2">
                                                    Konfirmasi
                                                </a>
                                            @endif
                                            <a href="{{ route('pengembalian.show', $p->id) }}" class="btn btn-info btn-sm">
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-4">Data pengembalian tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection