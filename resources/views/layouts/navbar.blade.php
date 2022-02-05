<nav class="p-0 navbar align-items-stretch navbar-light flex-md-nowrap">
  <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
    <!-- <div class="ml-3 input-group input-group-seamless">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    {{-- <i class="fas fa-search"></i> --}}
                </div>
            </div>
            <input class="navbar-search form-control" type="text" placeholder=""
                aria-label="Search">
        </div> -->
  </form>
  <ul class="flex-row navbar-nav border-left ">
    @role('admin|nasabah')
    {{-- @yield('notif') --}}
    <li class="nav-item border-right dropdown notifications">
      <a class="text-center nav-link nav-link-icon" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <div class="nav-link-icon__wrapper">
          <i class="material-icons">&#xE7F4;</i>
          <span class="badge badge-pill badge-danger"></span>
        </div>
      </a>
      <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
        {{-- <a class="dropdown-item" href="#">
          <div class="notification__content">
            <span class="notification__category">Analytics</span>
            <p>Your website’s active users count increased by
              <span class="text-success text-semibold">28%</span> in the last week.
              Great job!
            </p>
          </div>
        </a> --}}
        @role('admin')
        @foreach ($notif_admin as $item)
        <a class="dropdown-item {{ $item->read == 'false' ? 'text-white bg-secondary' : '' }}"
          href="{{ route('detail.notif',$item->slug) }}">
          <div class="notification__content">
            <p>{{ $item->user->name }} {!! \Illuminate\Support\Str::words($item->message, 5,'....') !!}</p>
          </div>
        </a>
        @endforeach
        <a class="text-center dropdown-item notification__all" href="{{ route('notif') }}">Lihat Notifikasi</a>
        @endrole
        @role('nasabah')
        @foreach ($notif_user as $item)
        <a class="dropdown-item {{ $item->read == 'false' ? 'text-white bg-secondary' : '' }}"
          href="{{ route('detail.notif.nasabah',$item->slug) }}">
          <div class="notification__content">
            <p>{{ $item->user->name }} {!! \Illuminate\Support\Str::words($item->message, 5,'....') !!}</p>
          </div>
        </a>
        @endforeach
        <a class="text-center dropdown-item notification__all" href="{{ route('notif.nasabah') }}">Lihat Notifikasi</a>
        @endrole
      </div>
    </li>
    @endrole
    <li class="nav-item dropdown">
      <a class="px-3 nav-link dropdown-toggle text-nowrap" data-toggle="dropdown" href="#" role="button"
        aria-haspopup="true" aria-expanded="false">
        <img class="mr-2 user-avatar rounded-circle" src="{{ asset('images/'.Auth::user()->foto) }}" alt="User Avatar">
        <span class="d-none d-md-inline-block">{{ Auth::user()->name }}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-small">
        {{-- <a class="dropdown-item" href="user-profile-lite.html">
          <i class="material-icons">&#xE7FD;</i> Profile</a>
        <a class="dropdown-item" href="components-blog-posts.html">
          <i class="material-icons">vertical_split</i> Blog Posts</a>
        <a class="dropdown-item" href="add-new-post.html">
          <i class="material-icons">note_add</i> Add New Post</a>
        <div class="dropdown-divider"></div> --}}
        <a class="dropdown-item text-danger" href="#" onclick="getElementById('logout').submit();">
          <i class="material-icons text-danger">&#xE879;</i> Logout</a>
        <form action="{{ route('logout') }}" id="logout" method="post">
          @csrf
        </form>
      </div>
    </li>
  </ul>
  <nav class="nav">
    <a href="#" class="text-center nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none border-left"
      data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
      <i class="material-icons">&#xE5D2;</i>
    </a>
  </nav>
</nav>