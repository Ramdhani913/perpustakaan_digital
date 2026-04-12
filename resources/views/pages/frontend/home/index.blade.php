@extends('layouts.frontend.app')

@section('content')
<div class="container-fluid px-md-5 py-5">
    
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Category</h2>
            <div class="d-flex align-items-center">
                <a href="#" class="text-muted small text-decoration-none me-3">View All Categories →</a>
                <div class="btn-group">
                    <button class="btn btn-light btn-sm border shadow-sm">❮</button>
                    <button class="btn btn-light btn-sm border shadow-sm">❯</button>
                </div>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-md-4 g-3">
            @foreach($bukus as $kategori => $item)
            <div class="col">
                <div class="card border-0 shadow-sm py-4 text-center h-100 shadow-hover">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <h5 class="mb-0 fw-semibold">{{ $kategori }}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    @foreach($bukus as $kategori => $daftarBuku)
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">{{ $kategori }}</h2>
            <div class="d-flex align-items-center">
                <a href="#" class="text-muted small text-decoration-none me-2">View All</a>
                <button class="btn btn-light btn-sm rounded-circle border shadow-sm">❯</button>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-md-5 g-4">
            @foreach($daftarBuku as $buku)
            <div class="col">
                <a href="{{ route('frontend.show', $buku->id) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm p-2 position-relative shadow-hover" style="border-radius: 15px;">
                        
                        <button type="button" class="btn btn-white shadow-sm rounded-circle position-absolute end-0 m-2 p-1" style="z-index: 10; width: 32px; height: 32px;">
                            <small>❤️</small>
                        </button>
                        
                        <div class="p-3 bg-light d-flex align-items-center justify-content-center" style="border-radius: 12px; height: 200px;">
                            <img src="{{ asset('storage/' . $buku->gambar) }}" 
                                 class="img-fluid" 
                                 alt="{{ $buku->judul }}" 
                                 style="max-height: 100%; object-fit: contain;">
                        </div>

                        <div class="card-body px-1 pt-3">
                            <h6 class="card-title mb-1 fw-bold text-truncate">{{ $buku->judul }}</h6>
                            <p class="text-muted small mb-0">STOK: {{ $buku->stok }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endforeach
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
    .btn-white { background: white; border: none; }
    /* Menghilangkan border biru saat diklik pada beberapa browser */
    a:focus .card { outline: none; }
</style>
@endsection