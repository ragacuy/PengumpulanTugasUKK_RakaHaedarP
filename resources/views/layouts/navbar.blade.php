<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">

        {{-- BRAND --}}
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="#">
            <i class="bi bi-box-seam me-2 fs-4"></i>
            <span>Peminjaman Alat</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            {{-- MENU KIRI --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">

                {{-- ADMIN --}}
                @if(auth()->check() && auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin') ? 'active fw-semibold text-primary' : '' }}"
                            href="/admin">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/user*') ? 'active fw-semibold text-primary' : '' }}"
                            href="/admin/user/">
                            <i class="bi bi-people me-1"></i> User
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/alat*') ? 'active fw-semibold text-primary' : '' }}"
                            href="/admin/alat/">
                            <i class="bi bi-tools me-1"></i> Alat
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/peminjaman*') ? 'active fw-semibold text-primary' : '' }}"
                            href="/admin/peminjaman">
                            <i class="bi bi-clipboard-check me-1"></i> Peminjaman
                        </a>
                    </li>
                                <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/pengembalian*') ? 'active fw-semibold text-primary' : '' }}"
                            href="/admin/pengembalian">
                            <i class="bi bi-clipboard-check me-1"></i> Pengembalian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/activity*') ? 'active fw-semibold text-primary' : '' }}"
                            href="/admin/activity">
                            <i class="bi bi-activity me-1"></i> Log Aktivitas
                        </a>
                    </li>
                @endif

                {{-- PETUGAS --}}
                @if(auth()->check() && auth()->user()->role == 'petugas')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('petugas') ? 'active fw-semibold text-primary' : '' }}"
                            href="/petugas">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>

                   <a class="nav-link {{ request()->is('petugas/peminjaman*') ? 'active fw-semibold text-primary' : '' }}"
                            href="/petugas/peminjaman">
                            <i class="bi bi-check-circle me-1"></i> Verifikasi
                        </a>
                    </li>

                    <li class="nav-item">
                       <a class="nav-link {{ request()->is('petugas/pengembalian*') ? 'active fw-semibold text-primary' : '' }}"
                            href="/petugas/pengembalian">
                            <i class="bi bi-arrow-return-left me-1"></i> Pengembalian
                        </a>
                    </li>
                @endif

                {{-- PEMINJAM --}}
                @if(auth()->check() && auth()->user()->role == 'peminjam')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('peminjam') ? 'active fw-semibold text-primary' : '' }}"
                            href="/peminjam">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                          <a class="nav-link {{ request()->is('peminjam/alat') ? 'active fw-semibold text-primary' : '' }}"
                            href="/peminjam/alat">
                            <i class="bi bi-plus-circle me-1"></i> Ajukan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('peminjam/peminjaman') ? 'active fw-semibold text-primary' : '' }}"
                            href="/peminjam/peminjaman">
                            <i class="bi bi-clock-history me-1"></i> Riwayat
                        </a>
                    </li>
                @endif
            </ul>

            {{-- MENU KANAN --}}
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2 text-primary fw-bold"
                                style="width: 35px; height: 35px;">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="fw-medium">{{ auth()->user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="min-width: 200px;">
                            <li>
                                <div class="px-3 py-2">
                                    <small class="text-uppercase text-muted"
                                        style="font-size: 0.75rem; letter-spacing: 0.5px;">Role</small>
                                    <div class="fw-medium text-capitalize">{{ auth()->user()->role }}</div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger d-flex align-items-center">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>

        </div>
    </div>
</nav>