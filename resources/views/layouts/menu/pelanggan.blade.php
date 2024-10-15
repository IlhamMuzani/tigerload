<li class="nav-header">
    Dashboard</li>
<li class="nav-item">
    <a href="{{ url('pelanggan') }}" class="nav-link {{ request()->is('pelanggan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('pelanggan/progres_pengerjaan') }}"
        class="nav-link {{ request()->is('pelanggan/progres_pengerjaan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tasks"></i>
        <p>Monitoring Project</p>
    </a>
<li class="nav-header">Profile</li>
<li class="nav-item">
    <a href="{{ url('pelanggan/profile') }}" class="nav-link {{ request()->is('pelanggan/profile') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-edit"></i>
        <p>Update Profile</p>
    </a>
<li class="nav-item">
    <a href="#" data-toggle="modal" data-target="#modalLogout" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
</li>
