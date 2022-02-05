<li class="nav-item">
  <a class="nav-link {{ Request::is('deposit*') ? 'active' : '' }}" href="{{ route('simpanan.nasabah') }}">
    <i class="material-icons">swap_horiz</i>
    <span>Simpanan</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link {{ Request::is('loans') ? 'active' : '' }}" href="{{ route('pinjaman.nasabah') }}">
    <i class="material-icons">swipe</i>
    <span>Pinjaman</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link {{ Request::is('withdraw') ? 'active' : '' }}" href="{{ route('penarikan.nasabah') }}">
    <i class="material-icons">point_of_sale</i>
    <span>Penarikan</span>
  </a>
</li>
<li class="nav-item">
  <a class="nav-link {{ Request::is('notifikasi*') ? 'active' : '' }}" href="{{ route('notif.nasabah') }}">
    <i class="material-icons">notifications</i>
    <span>Notifikasi</span>
  </a>
</li>