@extends('layouts.frontend.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Hasil Pencarian: <span class="text-primary">"{{ $keyword }}"</span></h4>
        <span class="badge bg-soft-primary text-dark border">{{ $results->count() }} Buku ditemukan</span>
    </div>

    @if($results->isEmpty())
        <div class="text-center py-5">
            <img src="{{ asset('images/no-results.png') }}" alt="Empty" style="width: 200px; opacity: 0.5;">
            <p class="mt-3 text-muted">Maaf, buku yang Anda cari tidak ditemukan.</p>
            <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4">Kembali ke Beranda</a>
        </div>
    @else
        <div class="row row-cols-2 row-cols-md-5 g-4">
            @foreach($results as $buku)
            <div class="col">
                <a href="{{ route('frontend.show', $buku->id) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm p-2 position-relative shadow-hover" style="border-radius: 15px;">
                        
                       
                        <div class="p-3 bg-light d-flex align-items-center justify-content-center" style="border-radius: 12px; height: 200px;">
                            <img src="{{ asset('storage/' . $buku->gambar) }}" 
                                 class="img-fluid" 
                                 alt="{{ $buku->judul }}" 
                                 style="max-height: 100%; object-fit: contain;">
                        </div>

                        <div class="card-body px-1 pt-3 text-center">
                            <h6 class="card-title mb-1 fw-bold text-truncate">{{ $buku->judul }}</h6>
                            <p class="text-muted small mb-1">{{ $buku->pengarang }}</p>
                            <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill" style="font-size: 10px;">
                                STOK: {{ $buku->stok }}
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .shadow-hover:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .bg-soft-primary {
        background-color: #e7f1ff;
    }
</style>
@endsection