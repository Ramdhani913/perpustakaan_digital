@extends('layouts.backend.app')

@section ('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Daftar Koleksi Buku</h4>
                    <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm btn-icon-text">
                        <i class="typcn typcn-plus btn-icon-prepend"></i>
                        Tambah Buku
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped project-orders-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Pastikan di Controller namanya $bukus (jamak) --}}
                            @foreach($bukus as $buku)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $buku->judul }}</td>
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
                                            <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-info btn-sm btn-icon-text mr-2">
                                                Detail
                                                <i class="typcn typcn-eye-outline btn-icon-append"></i>
                                            </a>

                                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-success btn-sm btn-icon-text mr-2">
                                                Edit
                                                <i class="typcn typcn-edit btn-icon-append"></i>
                                            </a>
                                            
                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="post" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
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