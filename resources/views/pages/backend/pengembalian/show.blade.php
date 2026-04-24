@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Detail Pengembalian Buku</h4>
                    <a href="{{ route('pengembalian.index') }}" class="btn btn-light btn-sm btn-icon-text">
                        <i class="typcn typcn-arrow-back btn-icon-prepend"></i>
                        Kembali
                    </a>
                </div>

                <div class="row">
                    {{-- Sisi Kiri: Status & Visual --}}
                    <div class="col-md-4 text-center">
                        <div class="bg-light p-4 rounded shadow-sm">
                            <i class="typcn typcn-document-text text-muted" style="font-size: 80px;"></i>
                            <h5 class="font-weight-bold mt-3">ID Transaksi #{{ $pengembalian->id }}</h5>
                            
                            <div class="mt-4">
                                <h6 class="font-weight-bold">Status Pengembalian</h6>
                                @if($pengembalian->status_pengembalian == 'diajukan')
                                    <div class="badge badge-warning">Menunggu Konfirmasi</div>
                                @else
                                    <div class="badge badge-success">Selesai / Kembali</div>
                                @endif
                            </div>

                            <div class="mt-4">
                                <h6 class="font-weight-bold">Status Denda</h6>
                                @if($pengembalian->denda)
                                    <div class="badge {{ $pengembalian->denda->status == 'paid' ? 'badge-primary' : 'badge-danger' }}">
                                        {{ $pengembalian->denda->status == 'paid' ? 'Sudah Lunas' : 'Belum Dibayar' }}
                                    </div>
                                    <h3 class="mt-2 text-danger font-weight-bold">
                                        Rp {{ number_format($pengembalian->denda->total_denda, 0, ',', '.') }}
                                    </h3>
                                @else
                                    <div class="badge badge-secondary">Bebas Denda</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Sisi Kanan: Tabel Detail & Form --}}
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold" style="width: 35%;">Nama Peminjam</td>
                                        <td>: {{ $pengembalian->peminjaman->anggota->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Judul Buku</td>
                                        <td>: <span class="text-info font-weight-bold">{{ $pengembalian->peminjaman->buku->judul }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tanggal Pinjam</td>
                                        <td>: {{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_peminjaman)->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tenggat Waktu</td>
                                        <td>: {{ \Carbon\Carbon::parse($pengembalian->peminjaman->tenggat_waktu)->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tanggal Kembali</td>
                                        <td>: <span class="text-primary">{{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d F Y') }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Pelanggaran Fisik</td>
                                        <td>: 
                                            <span class="badge {{ $pengembalian->jenis_pelanggaran == 'tidak_ada' ? 'badge-info' : 'badge-warning' }}">
                                                {{ str_replace('_', ' ', ucfirst($pengembalian->jenis_pelanggaran)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @if($pengembalian->denda)
                                    <tr>
                                        <td class="font-weight-bold">Keterlambatan</td>
                                        <td>: {{ $pengembalian->denda->jumlah_hari }} Hari</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        {{-- Section Pembayaran --}}
                       {{-- Section Pembayaran --}}
<div class="px-0 mt-4"> {{-- Ubah px-3 jadi px-0 agar full --}}
    <h5 class="font-weight-bold">Aksi Petugas</h5>
    
    @if($pengembalian->denda)
        @if($pengembalian->denda->status == 'unpaid')
            {{-- TAMPILAN JIKA BELUM BAYAR --}}
            <div class="card border-warning shadow-sm mt-3" style="background: #fffdf5">
                <div class="card-body">
                    <h6 class="font-weight-bold text-warning mb-3">Form Pembayaran Denda</h6>
                    <form action="{{ route('denda.bayar', $pengembalian->denda->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label>Total Tagihan: <b class="text-danger">Rp {{ number_format($pengembalian->denda->total_denda, 0, ',', '.') }}</b></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white">Rp</span>
                                </div>
                                <input type="number" name="bayar" class="form-control form-control-lg" placeholder="Masukkan nominal uang..." required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger btn-block btn-lg shadow-sm">
                            <i class="typcn typcn-briefcase btn-icon-prepend"></i> Proses Pelunasan
                        </button>
                    </form>
                </div>
            </div>
        @else
            {{-- TAMPILAN JIKA SUDAH LUNAS --}}
            <div class="card border-success shadow-sm mt-3" style="background: #f8fff9">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="font-weight-bold text-success mb-1">Pembayaran Lunas</h6>
                        <p class="text-muted small mb-0">Uang diterima: Rp {{ number_format($pengembalian->denda->nominal_bayar, 0, ',', '.') }}</p>
                    </div>
                    <a href="{{ route('cetak.struk', $pengembalian->denda->id) }}" target="_blank" class="btn btn-dark btn-icon-text">
                        <i class="typcn typcn-printer btn-icon-prepend"></i> Cetak Struk
                    </a>
                </div>
            </div>
        @endif
    @else
        <div class="alert alert-light border shadow-sm mt-3">
            Tidak ada tangihan denda (Bebas Denda).
        </div>
    @endif
</div>

                    </div>
                </div> {{-- End Row --}}
            </div>
        </div>
    </div>
</div>
@endsection