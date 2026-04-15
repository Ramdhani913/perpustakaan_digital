<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login Anggota - Gaia Library</title>
  
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
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5 shadow-lg" style="border-radius: 15px;">
              <div class="brand-logo text-center">
                <img Src={{ asset('images/logo.jpg') }}>
              </div>
              <h4 class="text-center font-weight-bold">Selamat Datang!</h4>
              <h6 class="font-weight-light text-center mb-4">Silahkan login untuk mengakses katalog buku.</h6>

              @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-3">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif

              <form class="pt-3" action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label class="small font-weight-bold">Email Address</label>
                  <input type="email" name="email" class="form-control form-control-lg border-secondary" placeholder="Email" value="{{ old('email') }}" required>
                </div>
                
                <div class="form-group">
                  <label class="small font-weight-bold">Password</label>
                  <input type="password" name="password" class="form-control form-control-lg border-secondary" placeholder="Password" required>
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn shadow-sm">
                    LOG IN
                  </button>
                </div>

                <div class="my-3 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Ingat Saya
                    </label>
                  </div>
                </div>

                <div class="text-center mt-4 font-weight-light">
                  Belum memiliki akun? <a href="{{ url('/register') }}" class="text-primary font-weight-bold">Daftar Sekarang</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>

  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>
  <script src="{{ asset('assets/js/settings.js') }}"></script>
  <script src="{{ asset('assets/js/todolist.js') }}"></script>
</body>

</html>