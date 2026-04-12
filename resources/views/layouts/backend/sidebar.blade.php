<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/dashboard') }}">
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

    <li class="nav-item">
      <a class="nav-link" href="https://bootstrapdash.com/demo/polluxui-free/docs/documentation.html" target="_blank">
        <i class="typcn typcn-mortar-board menu-icon"></i>
        <span class="menu-title">Documentation</span>
      </a>
    </li>
  </ul>
</nav>