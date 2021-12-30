<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('asset_dashboard/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">DOS Witel Jambi</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('asset_dashboard/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
            <a href="{{route("home")}}" class="nav-link {{(request()->is('home*'))?'active': ''}}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                Home
                </p>
            </a>
            </li>
          <li class="nav-item">
            <a href="{{route("reportDOS")}}" class="nav-link {{(request()->is('laporan_dos*'))?'active': ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Incoming DOS
              </p>
            </a>
          </li>
          @if (auth()->user()->role == "admin")
          <li class="nav-item">
            <a href="{{route("getSpv")}}" class="nav-link {{(request()->is('spv*'))?'active': ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Supervisor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route("getSf")}}" class="nav-link {{(request()->is('sf*'))?'active': ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Sales Force
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route("getAgency")}}" class="nav-link {{(request()->is('agencies*'))?'active': ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Agency
              </p>
            </a>
          </li>
          @endif
          @if (auth()->user()->role == "admin" || auth()->user()->role == "pic")
          <li class="nav-item">
            <a href="{{route("getRekapDos")}}" class="nav-link {{(request()->is('rekap-dos*'))?'active': ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Data DOS
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{route("getMaps")}}" class="nav-link {{(request()->is('rekap-dos*'))?'active': ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Maps
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route("getOdp")}}" class="nav-link {{(request()->is('odp*'))?'active': ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Data ODP
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route("logout")}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
