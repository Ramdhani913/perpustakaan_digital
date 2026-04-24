@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    
    <div class="row mb-4">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                        <div>
                            <p class="mb-2 text-muted">Total Buku</p>
                            <h3 class="mb-0">{{ $totalBuku }}</h3>
                        </div>
                        <i class="typcn typcn-book text-primary icon-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                        <div>
                            <p class="mb-2 text-muted">Total Anggota</p>
                            <h3 class="mb-0">{{ $totalAnggota }}</h3>
                        </div>
                        <i class="typcn typcn-group text-success icon-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                        <div>
                            <p class="mb-2 text-muted">Total Peminjaman</p>
                            <h3 class="mb-0">{{ $totalPeminjaman }}</h3>
                        </div>
                        <i class="typcn typcn-clipboard text-warning icon-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">5 Peminjaman Terbaru</h4>
                        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
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
                                @forelse($peminjamanTerbaru as $p)
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
                                                <a href="{{ route('peminjaman.show', $p->id) }}" class="btn btn-info btn-sm mr-2 btn-icon-text">
                                                    Detail <i class="typcn typcn-info-large btn-icon-append"></i>
                                                </a>

                                                @if($p->status_peminjaman == 'diajukan')
                                                    <form action="{{ route('admin.peminjaman.konfirmasi', $p->id) }}" method="POST" class="mr-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-success btn-sm">Terima</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center p-4">Belum ada aktivitas peminjaman terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection