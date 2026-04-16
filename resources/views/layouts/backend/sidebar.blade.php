<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="typcn typcn-device-desktop menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('users.index') }}">
        <i class="typcn typcn-group-outline menu-icon"></i>
        <span class="menu-title">Data Pengguna</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('anggota*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('anggota.index') }}">
        <i class="typcn typcn-user-add-outline menu-icon"></i>
        <span class="menu-title">Data Anggota</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('buku*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('buku.index') }}">
        <i class="typcn typcn-book menu-icon"></i>
        <span class="menu-title">Data Buku</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/peminjaman*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.peminjaman.index') }}">
        <i class="typcn typcn-export menu-icon"></i>
        <span class="menu-title">Peminjaman</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/pengembalian*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('pengembalian.index') }}">
        <i class="typcn typcn-import menu-icon"></i>
        <span class="menu-title">Pengembalian</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/laporan*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.laporan.index') }}">
        <i class="typcn typcn-document-text menu-icon"></i>
        <span class="menu-title">Laporan</span>
      </a>
    </li>
  </ul>
</nav>