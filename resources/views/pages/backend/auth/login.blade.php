<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Login - Gaia Library</title>
  
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
                 <h3 class="fw-bold text-dark">ADMIN<span class="text-primary">PANEL</span></h3>
              </div>
              <h4 class="text-center font-weight-bold">Internal Access</h4>
              <h6 class="font-weight-light text-center mb-4">Masuk untuk mengelola data perpustakaan.</h6>

              @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-3">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif

              @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-3 small">
                    {{ session('success') }}
                </div>
              @endif

              <form class="pt-3" action="{{ url('/admin/login') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label class="small font-weight-bold">Email Staff</label>
                  <input type="email" name="email" class="form-control form-control-lg border-secondary" placeholder="Email Admin" value="{{ old('email') }}" required autofocus>
                </div>
                
                <div class="form-group">
                  <label class="small font-weight-bold">Password</label>
                  <input type="password" name="password" class="form-control form-control-lg border-secondary" placeholder="Password" required>
                </div>

                <div class="mt-4">
                  <button type="submit" class="btn btn-block btn-dark btn-lg font-weight-medium auth-form-btn shadow-sm">
                    LOGIN SISTEM
                  </button>
                </div>

                <div class="my-3 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted small">
                      <input type="checkbox" class="form-check-input" name="remember">
                      Keep me signed in
                    </label>
                  </div>
                </div>

                <div class="text-center mt-5 font-weight-light small text-muted">
                    Sistem Manajemen Perpustakaan &copy; 2026
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
  <script src="{{ asset('assets/js/template.js') }}"></script>
</body>

</html>