@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Detail Data Anggota</h4>
                    <a href="{{ route('anggota.index') }}" class="btn btn-light btn-sm btn-icon-text">
                        <i class="typcn typcn-arrow-back btn-icon-prepend"></i>
                        Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-4 text-center border-right">
                        <div class="py-4">
                            @if($anggota->image)
                                <img src="{{ asset('storage/' . $anggota->image) }}" alt="{{ $anggota->nama }}" class="img-fluid rounded-circle shadow-sm border" style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/faces/face0.jpg') }}" alt="default" class="img-fluid rounded-circle shadow-sm border" style="width: 200px; height: 200px; object-fit: cover;">
                            @endif
                            
                            <h4 class="mt-3 font-weight-bold">{{ $anggota->nama }}</h4>
                            <p class="text-muted">ID Anggota: #{{ str_pad($anggota->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>

                        <div class="mt-2">
                            <h6 class="font-weight-bold">Status Keanggotaan</h6>
                            @if($anggota->status == 'aktif')
                                <div class="badge badge-success">Aktif</div>
                            @else
                                <div class="badge badge-danger">Nonaktif</div>
                            @endif
                        </div>

                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="font-weight-bold text-primary">Riwayat Pinjam</h6>
                            <h3 class="mb-0">{{ $anggota->buku_dipinjam ?? 0 }}</h3>
                            <small class="text-muted">Buku sedang dipinjam</small>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="px-4">
                            <h5 class="card-title text-primary">Informasi Pribadi</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold" style="width: 35%;">Nama Lengkap</td>
                                            <td>: {{ $anggota->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Jenis Kelamin</td>
                                            <td>: {{ ucfirst($anggota->jenis_kelamin) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Tanggal Lahir</td>
                                            <td>: {{ \Carbon\Carbon::parse($anggota->tgl_lahir)->format('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Alamat Lengkap</td>
                                            <td class="text-wrap">: {{ $anggota->alamat }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <hr>

                            <h5 class="card-title text-primary mt-4">Informasi Akun & Sistem</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold" style="width: 35%;">Alamat Email</td>
                                            <td>: {{ $anggota->email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Terdaftar Sejak</td>
                                            <td>: {{ $anggota->created_at->format('d M Y, H:i') }} WIB</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Pembaruan Terakhir</td>
                                            <td>: {{ $anggota->updated_at->format('d M Y, H:i') }} WIB</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-5 pb-3">
                                <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-success btn-icon-text">
                                    <i class="typcn typcn-edit btn-icon-prepend"></i>
                                    Edit Data Anggota
                                </a>
                                <button type="button" onclick="window.print()" class="btn btn-info btn-icon-text ml-2">
                                    <i class="typcn typcn-printer btn-icon-prepend"></i>
                                    Cetak Kartu
                                </button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection