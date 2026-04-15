@extends('layouts.frontend.app')

@section('content')
<div class="container-fluid px-md-5 py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">{{ $buku->kategori }}</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">{{ $buku->judul }}</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 25px;">
        <div class="row g-0">
            <div class="col-md-4 bg-light d-flex align-items-center justify-content-center p-5">
                <div class="position-relative shadow-lg" style="border-radius: 15px; overflow: hidden; transform: perspective(1000px) rotateY(-5deg);">
                    @if($buku->gambar)
                        <img src="{{ asset('storage/' . $buku->gambar) }}" 
                             class="img-fluid" 
                             alt="{{ $buku->judul }}"
                             style="max-height: 500px; object-fit: cover;">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center text-white" style="width: 300px; height: 450px;">
                            No Image
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-8 p-4 p-md-5 bg-white">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 mb-2" style="border-radius: 50px; text-transform: capitalize;">
                            {{ $buku->kategori }}
                        </span>
                        <h1 class="display-5 fw-bold text-dark mb-1">{{ $buku->judul }}</h1>
                        <p class="fs-5 text-secondary">Pengarang: <span class="fw-semibold">{{ $buku->pengarang }}</span></p>
                    </div>
                    <button class="btn btn-outline-danger border-0 shadow-sm rounded-circle p-2" title="Tambah ke Favorit">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01z"/></svg>
                    </button>
                </div>

                <hr class="my-4 opacity-25">

                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-md-4">
                        <div class="d-flex flex-column">
                            <span class="text-muted small text-uppercase fw-bold ls-1">Penerbit</span>
                            <span class="text-dark fw-medium">{{ $buku->penerbit }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="d-flex flex-column">
                            <span class="text-muted small text-uppercase fw-bold ls-1">Tahun Terbit</span>
                            <span class="text-dark fw-medium">{{ \Carbon\Carbon::parse($buku->tahun_terbit)->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="d-flex flex-column">
                            <span class="text-muted small text-uppercase fw-bold ls-1">Kondisi</span>
                            <span class="badge {{ $buku->kondisi == 'layak' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} py-2 mt-1" style="width: fit-content; text-transform: capitalize;">
                                {{ $buku->kondisi ?? 'Tidak diketahui' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="d-flex flex-column">
                            <span class="text-muted small text-uppercase fw-bold ls-1">Ketersediaan</span>
                            <span class="fw-bold {{ $buku->stok > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $buku->stok > 0 ? 'Tersedia (' . $buku->stok . ' Buku)' : 'Stok Habis' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="d-flex flex-column">
                            <span class="text-muted small text-uppercase fw-bold ls-1">Status</span>
                            <span class="text-dark fw-medium" style="text-transform: capitalize;">{{ $buku->status ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h5 class="fw-bold text-dark mb-3">Deskripsi</h5>
                    <p class="text-secondary lh-lg" style="text-align: justify;">
                        {{ $buku->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}
                    </p>
                </div>

                <div class="d-grid d-md-flex gap-3 mt-auto">
                    @if($buku->stok > 0 && $buku->status != 'dipinjam')
                        <form action="{{ route('pinjam.ajukan', $buku->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-dark btn-lg px-5 py-3 fw-bold shadow" style="border-radius: 12px;">
                                PINJAM BUKU
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg px-5 py-3 fw-bold disabled" style="border-radius: 12px;">
                            TIDAK DAPAT DIPINJAM
                        </button>
                    @endif
                    
                    <button class="btn btn-outline-dark btn-lg px-4 py-3" style="border-radius: 12px;">
                        Baca Review
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif

<style>
    .ls-1 { letter-spacing: 1px; }
    .bg-primary-subtle { background-color: #e7f1ff; }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .breadcrumb-item + .breadcrumb-item::before { content: "›"; font-size: 1.2rem; line-height: 1; vertical-align: middle; }
    body { background-color: #fcfcfc; }
</style>
@endsection