@extends('layouts.app')

@section('title', 'Dashboard Peminjam')

@section('content')
    <div class="row g-4 mb-4">
        {{-- Hero Section --}}
        <div class="col-12">
            <div class="card bg-primary text-white border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="card-body p-5">
                    <div class="d-flex align-items-center justify-content-between position-relative z-1">
                        <div>
                            <h2 class="fw-bold display-6 mb-2">Halo, {{ auth()->user()->name }}! 👋</h2>
                            <p class="mb-0 fs-5 text-white-50">Selamat datang di sistem peminjaman alat.</p>
                            <div class="mt-4">
                                <a href="{{ route('peminjam.alat.index') }}"
                                    class="btn btn-light rounded-pill px-4 fw-bold text-primary shadow-sm me-2">
                                    <i class="bi bi-search me-1"></i> Cari Alat
                                </a>
                                <a href="{{ route('peminjam.peminjaman.index') }}"
                                    class="btn btn-outline-light rounded-pill px-4 fw-bold">
                                    <i class="bi bi-clock-history me-1"></i> Riwayat
                                </a>
                            </div>
                        </div>
                        <div class="d-none d-md-block opacity-50">
                            <i class="bi bi-grid-1x2" style="font-size: 5rem;"></i>
                        </div>
                    </div>
                </div>
                <!-- Decorative circle -->
                <div class="position-absolute top-0 end-0 rounded-circle bg-white opacity-10"
                    style="width: 250px; height: 250px; margin-top: -50px; margin-right: -50px;"></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Stats Cards --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                            <i class="bi bi-journal-check fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 text-uppercase small fw-bold">Peminjaman Saya</h6>
                            <h3 class="fw-bold mb-0">
                                {{ \App\Models\Peminjaman::where('user_id', auth()->id())->count() }}
                            </h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-muted small">
                        <span class="text-info fw-bold me-1"><i class="bi bi-arrow-right"></i></span>
                        <span>Total riwayat transaksi</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                            <i class="bi bi-hourglass-split fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 text-uppercase small fw-bold">Sedang Dipinjam/Pending</h6>
                            <h3 class="fw-bold mb-0">
                                {{ \App\Models\Peminjaman::where('user_id', auth()->id())->whereIn('status', ['pending', 'disetujui'])->count() }}
                            </h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-muted small">
                        <span class="text-warning fw-bold me-1"><i class="bi bi-info-circle"></i></span>
                        <span>Perlu perhatian</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .transition {
            transition: all 0.3s ease;
        }
    </style>
@endsection