@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Detail Profil Pengguna</h4>
                    <a href="{{ route('users.index') }}" class="btn btn-light btn-sm btn-icon-text">
                        <i class="typcn typcn-arrow-back btn-icon-prepend"></i>
                        Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-4 text-center border-right">
                        <div class="py-4">
                            @if($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="img-fluid rounded-circle shadow-sm border" style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/faces/face0.jpg') }}" alt="default" class="img-fluid rounded-circle shadow-sm border" style="width: 200px; height: 200px; object-fit: cover;">
                            @endif
                            
                            <h4 class="mt-3 font-weight-bold">{{ $user->name }}</h4>
                            <p class="text-muted text-capitalize">{{ $user->role }}</p>
                        </div>

                        <div class="mt-2">
                            <h6 class="font-weight-bold">Status Akun</h6>
                            @if($user->status == 'aktif')
                                <div class="badge badge-success">Aktif</div>
                            @else
                                <div class="badge badge-danger">Nonaktif</div>
                            @endif
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
                                            <td>: {{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Jenis Kelamin</td>
                                            <td>: {{ ucfirst($user->jenis_kelamin) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Tanggal Lahir</td>
                                            <td>: {{ $user->tgl_lahir ? \Carbon\Carbon::parse($user->tgl_lahir)->format('d F Y') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Nomor HP</td>
                                            <td>: {{ $user->no_hp ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <hr>

                            <h5 class="card-title text-primary mt-4">Informasi Akun</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold" style="width: 35%;">Alamat Email</td>
                                            <td>: {{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Hak Akses (Role)</td>
                                            <td>: <span class="text-capitalize">{{ $user->role }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Bergabung Sejak</td>
                                            <td>: {{ $user->created_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Pembaruan Terakhir</td>
                                            <td>: {{ $user->updated_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 pb-3">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-icon-text">
                                    <i class="typcn typcn-edit btn-icon-prepend"></i>
                                    Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div> </div>
        </div>
    </div>
</div>
@endsection