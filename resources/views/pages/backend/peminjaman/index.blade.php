@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Pengajuan Peminjaman</h4>
                    
                    <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="d-flex">
                        {{-- Filter Status --}}
                        <select name="status" class="form-control form-control-sm mr-2" style="width: 150px;">
                            <option value="">Semua Status</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>dipinjam</option>
                            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>

                        {{-- Input Search --}}
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama/buku..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="typcn typcn-zoom"></i>
                                </button>
                            </div>
                        </div>
                        
                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-light btn-sm ml-2">Reset</a>
                        @endif
                    </form>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped project-orders-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Peminjam</th>
                                <th>Buku</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamans as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $p->anggota->nama ?? 'Unknown' }}</strong><br>
                                        <small class="text-muted">Total Pinjam: {{ $p->anggota->buku_dipinjam ?? 0 }}</small>
                                    </td>
                                    <td>{{ $p->buku->judul }}</td>
                                    <td>
                                        @php
                                            $badge = [
                                                'diajukan' => 'badge-warning',
                                                'dipinjam' => 'badge-success',
                                                'dikembalikan' => 'badge-info'
                                            ][$p->status_peminjaman] ?? 'badge-secondary';
                                        @endphp
                                        <label class="badge {{ $badge }}">
                                            {{ ucfirst($p->status_peminjaman) }}
                                        </label>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('peminjaman.show', $p->id) }}" class="btn btn-info btn-sm mr-2">Detail</a>

                                            @if($p->status_peminjaman == 'diajukan')
                                                <form action="{{ route('admin.peminjaman.konfirmasi', $p->id) }}" method="POST" class="mr-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm">Terima</button>
                                                </form>

                                                <form action="{{ route('admin.peminjaman.tolak', $p->id) }}" method="POST" onsubmit="return confirm('Tolak pengajuan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-4">Data peminjaman tidak ditemukan.</td>
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