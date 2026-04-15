@extends('layouts.frontend.app')

@section('content')
<div class="container-fluid px-md-5 py-5">
    
    <section class="mb-5">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center border-end-md">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ Auth::guard('anggota')->user()->image ? asset('storage/' . Auth::guard('anggota')->user()->image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::guard('anggota')->user()->nama).'&background=random' }}" 
                                 class="rounded-circle shadow-sm border p-1" 
                                 style="width: 150px; height: 150px; object-fit: cover;" 
                                 alt="Avatar">
                        </div>
                        <h5 class="fw-bold mb-0">{{ Auth::guard('anggota')->user()->nama }}</h5>
                        <p class="text-muted small">ID Anggota: {{ str_pad(Auth::guard('anggota')->user()->id, 3, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    
                    <div class="col-md-9 ps-md-5">
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <label class="text-muted small d-block">Email</label>
                                <span class="fw-semibold">{{ Auth::guard('anggota')->user()->email }}</span>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small d-block">Jenis Kelamin</label>
                                <span class="fw-semibold">{{ Auth::guard('anggota')->user()->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small d-block">Tanggal Lahir</label>
                                <span class="fw-semibold">{{ \Carbon\Carbon::parse(Auth::guard('anggota')->user()->tgl_lahir)->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small d-block">Alamat</label>
                                <span class="fw-semibold">{{ Auth::guard('anggota')->user()->alamat }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top d-flex justify-content-between">
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-4">Edit Profil</button>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4 shadow-sm">LOGOUT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Buku Dipinjam</h2>
            <span class="badge bg-primary rounded-pill px-3">{{ $peminjamans->count() }} Buku</span>
        </div>

        @if($peminjamans->isEmpty())
            <div class="card border-0 shadow-sm p-5 text-center" style="border-radius: 15px;">
                <p class="text-muted mb-0">Anda belum meminjam buku apapun.</p>
            </div>
        @else
            <div class="row row-cols-2 row-cols-md-5 g-4">
               @foreach($peminjamans as $pinjam)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm p-2 position-relative shadow-hover" style="border-radius: 15px;">
                            
                            {{-- Logika Cek apakah sudah lapor kembali --}}
                            @php
                                $sudahLapor = \App\Models\Pengembalian::where('peminjaman_id', $pinjam->id)
                                                ->where('status_pengembalian', 'diajukan')
                                                ->first();
                            @endphp

                            <span class="badge {{ $pinjam->status_peminjaman == 'dipinjam' ? 'bg-info' : 'bg-success' }} position-absolute start-0 m-2 px-3 py-2" 
                                style="z-index: 10; border-radius: 10px; font-size: 10px;">
                                {{ $pinjam->status_peminjaman }}
                            </span>

                            <div class="p-3 bg-light d-flex align-items-center justify-content-center" style="border-radius: 12px; height: 180px;">
                                <img src="{{ asset('storage/' . $pinjam->buku->gambar) }}" 
                                    class="img-fluid" 
                                    style="max-height: 100%; object-fit: contain;"
                                    alt="Buku">
                            </div>

                            <div class="card-body px-1 pt-3 text-center">
                                <h6 class="card-title mb-1 fw-bold text-truncate">{{ $pinjam->buku->judul }}</h6>
                                <p class="text-muted small mb-3">Tenggat: <br> 
                                    <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($pinjam->tenggat_waktu)->format('d/m/Y') }}</span>
                                </p>

                                {{-- TOMBOL AKSI --}}
                                @if($pinjam->status_peminjaman == 'dipinjam')
                                    @if($sudahLapor)
                                        {{-- Jika sudah klik tapi belum dicek petugas --}}
                                        <button class="btn btn-warning btn-sm rounded-pill w-100 disabled shadow-sm" style="font-size: 11px;">
                                            <i class="fas fa-clock me-1"></i> Menunggu Verifikasi
                                        </button>
                                    @else
                                        {{-- Jika benar-benar masih dipinjam --}}
                                        <form action="{{ route('pengembalian.ajukan', $pinjam->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm rounded-pill w-100 shadow-sm" 
                                                    style="font-size: 11px;" 
                                                    onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                                                Kembalikan Buku
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    {{-- Jika status sudah 'selesai' --}}
                                    <button class="btn btn-success btn-sm rounded-pill w-100 disabled shadow-sm" style="font-size: 11px;">
                                        Selesai
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>

<style>
    body { background-color: #fcfcfc; }
    .shadow-hover { 
        transition: all 0.3s ease; 
    }
    .shadow-hover:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08) !important; 
    }
    .border-end-md {
        border-right: 1px solid #eee;
    }
    @media (max-width: 767.98px) {
        .border-end-md {
            border-right: none;
            border-bottom: 1px solid #eee;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
        }
    }
</style>
@endsection