<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Daftar Anggota - Gaia Library</title>
  <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-6 mx-auto"> <div class="auth-form-light text-left py-5 px-4 px-sm-5 shadow-lg" style="border-radius: 15px;">
              <div class="brand-logo text-center">
                <h3 class="fw-bold text-primary">DAFTAR <span class="text-dark">ANGGOTA</span></h3>
              </div>
              <h4 class="text-center font-weight-bold">Buat Akun Baru</h4>
              <h6 class="font-weight-light text-center mb-4">Lengkapi data diri Anda di bawah ini.</h6>
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

              <form class="pt-3" action="{{ url('/register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label class="small font-weight-bold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control border-secondary" placeholder="Nama" value="{{ old('nama') }}" required>
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="small font-weight-bold">Email</label>
                    <input type="email" name="email" class="form-control border-secondary" placeholder="email@example.com" value="{{ old('email') }}" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 form-group">
                    <label class="small font-weight-bold">Password</label>
                    <input type="password" name="password" class="form-control border-secondary" placeholder="Password" required>
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="small font-weight-bold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control border-secondary" placeholder="Ulangi Password" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 form-group">
                    <label class="small font-weight-bold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control border-secondary" required>
                        <option value="">-- Pilih --</option>
                        <option value="laki-laki">--Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="small font-weight-bold">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control border-secondary" value="{{ old('tgl_lahir') }}" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="small font-weight-bold">Alamat</label>
                  <textarea name="alamat" class="form-control border-secondary" rows="3" placeholder="Alamat Lengkap">{{ old('alamat') }}</textarea>
                </div>

                <div class="form-group">
                  <label class="small font-weight-bold">Foto Profil (Opsional)</label>
                  <input type="file" name="image" class="form-control border-secondary">
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn shadow-sm">
                    DAFTAR SEKARANG
                  </button>
                </div>

                <div class="text-center mt-4 font-weight-light">
                  Sudah punya akun? <a href="{{ url('/login') }}" class="text-primary font-weight-bold">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
</body>
</html>