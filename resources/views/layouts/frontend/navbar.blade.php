<header class="border-bottom bg-white sticky-top">
    <div class="container-fluid px-md-5">
        <div class="row py-3 align-items-center">
            
            <div class="col-6 col-md-3">
                <div class="main-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/smk.jpeg') }}" alt="logo" class="img-fluid" 
                             style="max-width: 50px; width: 15vw; min-width: 50px;">
                        <img src="{{ asset('images/logo.jpg') }}" alt="logo" class="img-fluid" 
                             style="max-width: 180px; width: 15vw; min-width: 120px;">
                    </a>
                </div>
            </div>

            <div class="col-md-5 d-none d-lg-block">
                <div class="d-flex justify-content-center">
                    <form action="{{ route('frontend.search') }}" method="GET" 
                          class="bg-light px-3 py-1 rounded-pill d-flex align-items-center border w-100" 
                          style="max-width: 450px;"> <input type="text" name="keyword" 
                               class="form-control border-0 bg-transparent shadow-none form-control-sm" 
                               placeholder="Cari judul buku atau penulis..." 
                               value="{{ request('keyword') }}">
                        
                        <button type="submit" class="btn p-0 ms-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21l-6-6m2-5a7 7 0 1 1-14 0a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-6 col-md-4 d-flex justify-content-end align-items-center gap-3">
                @if(Auth::guard('anggota')->check())
                    <div class="support-box text-end d-none d-xl-block me-2">
                        <span class="fs-6 text-muted">Selamat Datang,</span>
                        <h6 class="mb-0 fw-bold">{{ Auth::guard('anggota')->user()->nama }}</h6>
                    </div>
                    
                    <a href="{{ route('anggota.profil') }}" class="rounded-circle bg-light p-2 d-flex align-items-center shadow-sm border shadow-hover">
                        <img src="{{ Auth::guard('anggota')->user()->image ? asset('storage/' . Auth::guard('anggota')->user()->image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::guard('anggota')->user()->nama) }}" 
                             alt="profil" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 btn-sm fw-bold">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4 btn-sm fw-bold shadow-sm">Daftar</a>
                @endif
            </div>

        </div>
    </div>
</header>