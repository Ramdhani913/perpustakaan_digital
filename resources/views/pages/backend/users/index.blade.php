@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Daftar Pengguna (Users)</h4>
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm btn-icon-text">
                        <i class="typcn typcn-plus btn-icon-prepend"></i>
                        Tambah User
                    </a>
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
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($user->image)
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="image" style="width: 40px; height: 40px; border-radius: 100%;">
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
                                        <span class="text-capitalize">{{ $user->role }}</span>
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
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm btn-icon-text mr-2">
                                                Detail
                                                <i class="typcn typcn-eye-outline btn-icon-append"></i>
                                            </a>

                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-sm btn-icon-text mr-2">
                                                Edit
                                                <i class="typcn typcn-edit btn-icon-append"></i>
                                            </a>
                                            
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm btn-icon-text">
                                                    Delete
                                                    <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection