@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Detail Informasi Buku</h4>
                    <a href="{{ route('buku.index') }}" class="btn btn-light btn-sm btn-icon-text">
                        <i class="typcn typcn-arrow-back btn-icon-prepend"></i>
                        Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-4 text-center">
                        @if($buku->gambar)
                            <img src="{{ asset('storage/' . $buku->gambar) }}" alt="{{ $buku->judul }}" class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 300px;">
                                <i class="typcn typcn-image text-muted" style="font-size: 50px;"></i>
                                <p class="text-muted ml-2">Tidak ada gambar</p>
                            </div>
                        @endif
                        
                        <div class="mt-4">
                            <h5 class="font-weight-bold">Status Buku</h5>
                            @if($buku->status == 'tersedia')
                                <div class="badge badge-success">Tersedia untuk Dipinjam</div>
                            @else
                                <div class="badge badge-danger">Sedang Dipinjam</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold" style="width: 30%;">Judul Buku</td>
                                        <td>: {{ $buku->judul }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Pengarang</td>
                                        <td>: {{ $buku->pengarang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Penerbit</td>
                                        <td>: {{ $buku->penerbit }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tahun Terbit</td>
                                        <td>: {{ \Carbon\Carbon::parse($buku->tahun_terbit)->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Kategori</td>
                                        <td>: <span class="text-capitalize">{{ $buku->kategori }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Stok Tersedia</td>
                                        <td>: {{ $buku->stok }} buah</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Kondisi Fisik</td>
                                        <td>: 
                                            <span class="badge {{ $buku->kondisi == 'layak' ? 'badge-info' : 'badge-warning' }}">
                                                {{ ucfirst($buku->kondisi) }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <div class="px-3">
                            <h5 class="font-weight-bold">Deskripsi / Sinopsis</h5>
                            <p class="text-justify mt-2" style="line-height: 1.6;">
                                {{ $buku->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}
                            </p>
                        </div>

                        <div class="mt-4 px-3">
                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-success btn-icon-text">
                                <i class="typcn typcn-edit btn-icon-prepend"></i>
                                Edit Buku
                            </a>
                        </div>
                    </div>
                </div> </div>
        </div>
    </div>
</div>
@endsection