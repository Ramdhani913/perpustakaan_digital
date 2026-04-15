@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Peminjaman #{{ $peminjaman->id }}</h4>
                <hr>
                
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Nama Peminjam</div>
                    <div class="col-sm-8">: {{ $peminjaman->anggota->nama }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Judul Buku</div>
                    <div class="col-sm-8">: {{ $peminjaman->buku->judul }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Tanggal Pinjam</div>
                    <div class="col-sm-8">: {{ $peminjaman->tanggal_peminjaman ? \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d M Y') : 'Belum Dikonfirmasi' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Tenggat Waktu</div>
                    <div class="col-sm-8">: {{ $peminjaman->tenggat_waktu ? \Carbon\Carbon::parse($peminjaman->tenggat_waktu)->format('d M Y') : '-' }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Status</div>
                    <div class="col-sm-8">: 
                        @if($peminjaman->status_peminjaman == 'diajukan')
                            <span class="badge badge-warning">Menunggu Konfirmasi</span>
                        @elseif($peminjaman->status_peminjaman == 'dipinjam')
                            <span class="badge badge-success">Sedang dipinjam</span>
                        @else
                            <span class="badge badge-info">Sudah Dikembalikan</span>
                        @endif
                    </div>
                </div>

                <hr>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-light">Kembali</a>
                
                @if($peminjaman->status_peminjaman == 'diajukan')
                    <form action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary">Terima Peminjaman</button>
                    </form>
                @endif

                
            </div>
        </div>
    </div>

   
</div>
@endsection