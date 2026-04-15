@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Koleksi Buku</h4>
                    
                    <div class="d-flex">
                        {{-- Form Pencarian --}}
                        <form action="{{ route('buku.index') }}" method="GET" class="mr-2">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari judul/pengarang..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="typcn typcn-zoom"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm btn-icon-text">
                            <i class="typcn typcn-plus btn-icon-prepend"></i>
                            Tambah Buku
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped project-orders-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bukus as $buku)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="font-weight-bold">{{ $buku->judul }}</span></td>
                                    <td>{{ $buku->pengarang }}</td>
                                    <td>{{ $buku->penerbit }}</td>
                                    <td>{{ \Carbon\Carbon::parse($buku->tahun_terbit)->format('d-m-Y') }}</td>
                                    <td>
                                        @if($buku->status == 'tersedia')
                                            <label class="badge badge-success">Tersedia</label>
                                        @else
                                            <label class="badge badge-danger">Dipinjam</label>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-info btn-sm p-2 mr-2" title="Detail">
                                                <i class="typcn typcn-eye-outline"></i>
                                            </a>

                                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-success btn-sm p-2 mr-2" title="Edit">
                                                <i class="typcn typcn-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="post" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm p-2" title="Hapus">
                                                    <i class="typcn typcn-delete-outline"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-4">
                                        <p class="text-muted">Data buku tidak ditemukan.</p>
                                        {{-- @if(request('search'))
                                            <a href="{{ route('buku.index') }}" class="btn btn-link btn-sm">Tampilkan semua buku</a>
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