@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Anggota Perpustakaan</h4>
                    
                    <div class="d-flex">
                        {{-- Form Pencarian Anggota --}}
                        <form action="{{ route('anggota.index') }}" method="GET" class="mr-2">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama/email..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="typcn typcn-zoom"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm btn-icon-text">
                            <i class="typcn typcn-plus btn-icon-prepend"></i>
                            Tambah Anggota
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped project-orders-table text-center">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Foto</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th> 
                                <th>L/P</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anggota as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="image" style="width: 40px; height: 40px; border-radius: 100%; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('images/faces/face0.jpg') }}" alt="default" style="width: 40px; height: 40px; border-radius: 100%;">
                                        @endif
                                    </td>
                                    <td class="text-left"><strong>{{ $item->nama }}</strong></td>
                                    <td class="text-left">{{ $item->email }}</td> 
                                    <td>
                                        @if($item->jenis_kelamin == 'laki-laki')
                                            <span class="badge badge-outline-primary">L</span>
                                        @else
                                            <span class="badge badge-outline-danger">P</span>
                                        @endif
                                    </td>
                                    <td class="text-left text-wrap" style="max-width: 200px;">
                                        {{ Str::limit($item->alamat, 50) }}
                                    </td>
                                    <td>
                                        @if($item->status == 'aktif')
                                            <label class="badge badge-success">Aktif</label>
                                        @else
                                            <label class="badge badge-danger">Nonaktif</label>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="{{ route('anggota.show', $item->id) }}" class="btn btn-info btn-sm p-2 mr-1" title="Detail">
                                                <i class="typcn typcn-eye"></i>
                                            </a>

                                            <a href="{{ route('anggota.edit', $item->id) }}" class="btn btn-success btn-sm p-2 mr-1" title="Edit">
                                                <i class="typcn typcn-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('anggota.destroy', $item->id) }}" method="post" onsubmit="return confirm('Hapus data anggota ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm p-2" title="Hapus">
                                                    <i class="typcn typcn-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center p-4">
                                        Data anggota tidak ditemukan.
                                        {{-- @if(request('search'))
                                            <br><a href="{{ route('anggota.index') }}" class="btn btn-link btn-sm">Kembali ke semua data</a>
                                        @endif --}}
                                    </td>
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