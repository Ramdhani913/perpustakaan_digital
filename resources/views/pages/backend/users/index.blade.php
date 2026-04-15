@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Pengguna (Users)</h4>
                    
                    <div class="d-flex">
                        {{-- Form Pencarian User --}}
                        <form action="{{ route('users.index') }}" method="GET" class="mr-2">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama/email..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="typcn typcn-zoom"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm btn-icon-text">
                            <i class="typcn typcn-plus btn-icon-prepend"></i>
                            Tambah User
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped project-orders-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Image</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>L/P</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($user->image)
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="image" style="width: 40px; height: 40px; border-radius: 100%; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('images/faces/face0.jpg') }}" alt="default" style="width: 40px; height: 40px; border-radius: 100%;">
                                        @endif
                                    </td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->jenis_kelamin == 'laki-laki')
                                            <span class="badge badge-outline-primary">L</span>
                                        @else
                                            <span class="badge badge-outline-danger">P</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-capitalize badge badge-info">{{ $user->role }}</span>
                                    </td>
                                    <td>
                                        @if($user->status == 'aktif')
                                            <label class="badge badge-success">Aktif</label>
                                        @else
                                            <label class="badge badge-danger">Nonaktif</label>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm p-2 mr-1" title="Detail">
                                                <i class="typcn typcn-eye"></i>
                                            </a>

                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-sm p-2 mr-1" title="Edit">
                                                <i class="typcn typcn-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
                                        Data user tidak ditemukan.
                                        @if(request('search'))
                                            <br><a href="{{ route('users.index') }}" class="btn btn-link btn-sm">Reset Pencarian</a>
                                        @endif
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