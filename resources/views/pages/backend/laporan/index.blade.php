@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="font-weight-bold mb-0">Laporan Transaksi</h4>
                        <a href="{{ route('laporan.cetak', request()->query()) }}" target="_blank" class="btn btn-primary btn-sm btn-icon-text">
                            <i class="typcn typcn-printer mr-1"></i> Cetak
                        </a>
                    </div>

                    <hr>

                    {{-- Form Filter Baris Tunggal --}}
                    <form action="{{ route('admin.laporan.index') }}" method="GET" class="form-row align-items-center mb-4">
                        <div class="col-md-4 my-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i {{--class="typcn typcn-zoom-outline"  --}}></i></div>
                                </div>
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari Anggota/Buku..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="col-md-3 my-1">
                            <select name="periode" class="form-control form-control-sm">
                                <option value="">-- Semua Waktu --</option>
                                <option value="mingguan" {{ request('periode') == 'mingguan' ? 'selected' : '' }}>Minggu Ini</option>
                                <option value="bulanan" {{ request('periode') == 'bulanan' ? 'selected' : '' }}>Bulan Ini</option>
                                <option value="tahunan" {{ request('periode') == 'tahunan' ? 'selected' : '' }}>Tahun Ini</option>
                            </select>
                        </div>

                        <div class="col-auto my-1">
                            <button type="submit" class="btn btn-info btn-sm">Filter</button>
                            <a href="{{ route('admin.laporan.index') }}" class="btn btn-light btn-sm ml-1">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped project-orders-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Anggota & Buku</th>
                                    <th>Tgl Kembali</th>
                                    <th>Status</th>
                                    <th>Total Denda</th>
                                    <th>Dibayar</th>
                                    <th>Sisa</th>
                                    <th style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporans as $laporan)
                                <tr>
                                    <td>#{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="font-weight-bold">{{ $laporan->peminjaman->anggota->nama ?? 'Data Terhapus' }}</span><br>
                                        <small class="text-muted">{{ $laporan->peminjaman->buku->judul ?? '-' }}</small>
                                    </td>
                                    <td>{{ $laporan->pengembalian ? \Carbon\Carbon::parse($laporan->pengembalian->tanggal_pengembalian)->format('d M Y') : '-' }}</td>
                                    <td>
                                        @if($laporan->status_keterlambatan == 'terlambat')
                                            <label class="badge badge-danger">Terlambat</label>
                                        @elseif($laporan->status_keterlambatan == 'tepat_waktu')
                                            <label class="badge badge-success">Tepat Waktu</label>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>Rp{{ number_format($laporan->total_denda ?? 0, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($laporan->denda_dibayar ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        @php 
                                            $sisa = ($laporan->total_denda ?? 0) - ($laporan->denda_dibayar ?? 0); 
                                        @endphp
                                        @if($sisa > 0)
                                            <span class="text-danger font-weight-bold">Rp{{ number_format($sisa, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-success font-weight-bold">Lunas</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($laporan->pengembalian_id)
                                            <a href="{{ route('pengembalian.show', $laporan->pengembalian_id) }}" class="btn btn-success btn-sm p-2">
                                                <i class="typcn typcn-eye"></i>
                                            </a>
                                        @else
                                            <span class="badge badge-light">Proses</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center p-4">Data tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection