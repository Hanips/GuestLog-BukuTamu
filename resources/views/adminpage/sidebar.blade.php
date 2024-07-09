<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">SIBPRO</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">SIB</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="{{ Request::is('admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/admin') }}">
          <i class="fas fa-fire"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="menu-header">Master Data</li>
      <li class="{{ Request::is('admin/guest*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/guest') }}">
          <i class="fas fa-book"></i>
          <span>Data Tamu</span>
        </a>
      </li>
      <li class="{{ Request::is('admin/officer') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/officer') }}">
          <i class="fas fa-id-badge"></i>
          <span>Master Petugas</span>
        </a>
      </li>
      @if (Auth::user()->role != 'Satpam')
        <li class="menu-header">Utilitas</li>
        <li class="dropdown {{ Request::is('admin/account*') ? 'active' : '' }}">
          <a href="#" class="nav-link has-dropdown">
            <i class="fas fa-user-lock"></i>
            <span>Pengaturan Akun</span>
          </a>
          <ul class="dropdown-menu">
            <li class="{{ Request::segment(3) === 'user' ? 'active' : '' }}">
              <a href="{{ url('/admin/account/user') }}">Manajemen Pengguna</a>
            </li>
          </ul>
        </li>
        <li class="dropdown {{ Request::is('admin/setting*') ? 'active' : '' }}">
          <a href="#" class="nav-link has-dropdown">
            <i class="fas fa-cog"></i>
            <span>General Setting</span>
          </a>
          <ul class="dropdown-menu">
            <li class="{{ Request::is('admin/setting*') ? 'active' : '' }}">
              <a href="{{ url('/admin/setting/year') }}">Tahun Aktif</a>
            </li>
          </ul>
        </li>
      @endif
    </ul>
  </aside>
</div>
