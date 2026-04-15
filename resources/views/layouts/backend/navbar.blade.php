<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="navbar-brand-wrapper d-flex justify-content-center">
    <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
      <a class="navbar-brand brand-logo" href="{{ route('admin.dashboard') }}"><img src="{{ asset('images/logo.jpg') }}" alt="logo"/></a>
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="typcn typcn-th-menu"></span>
      </button>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <ul class="navbar-nav mr-lg-2">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
          {{-- Mengambil nama user yang sedang login --}}
          <span class="nav-profile-name">{{ Auth::user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">
              <i class="typcn typcn-eject text-primary"></i> Logout
            </button>
          </form>
        </div>
      </li>
    </ul>

    <ul class="navbar-nav navbar-nav-right">
      {{-- Tanggal Real Time --}}
      <li class="nav-item nav-date dropdown">
        <a class="nav-link d-flex justify-content-center align-items-center" href="javascript:;">
          <h6 class="date mb-0">Today : {{ now()->format('d M') }}</h6>
          <i class="typcn typcn-calendar"></i>
        </a>
      </li>

      {{-- Notifikasi Antrean (Peminjaman & Pengembalian) --}}
      <li class="nav-item dropdown mr-0">
        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="typcn typcn-bell mx-0"></i>
          @if($notif_count > 0)
            <span class="count"></span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <p class="mb-0 font-weight-normal float-left dropdown-header">Konfirmasi Diperlukan</p>
          
          @if($notif_count == 0)
             <a class="dropdown-item preview-item small text-muted">Tidak ada antrean baru</a>
          @endif

          {{-- Notifikasi Pengembalian --}}
          @if($antrean_pengembalian > 0)
          <a href="{{ route('pengembalian.index') }}" class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-warning">
                <i class="typcn typcn-backspace mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">{{ $antrean_pengembalian }} Pengembalian Baru</h6>
              <p class="font-weight-light small-text mb-0 text-muted">Perlu verifikasi fisik</p>
            </div>
          </a>
          @endif
        </div>
      </li>
    </ul>
  </div>
</nav>

{{--  --}}