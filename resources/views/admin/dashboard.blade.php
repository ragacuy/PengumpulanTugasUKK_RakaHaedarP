@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
            border-radius: 1rem;
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(78, 84, 200, 0.2);
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .stat-card {
            border: none;
            border-radius: 1rem;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            height: 100%;
            padding: 1.5rem;
            display: flex;
            align-items: center;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.75rem;
            margin-right: 1.25rem;
        }

        .bg-soft-primary {
            background-color: rgba(78, 84, 200, 0.1);
            color: #4e54c8;
        }

        .bg-soft-success {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }

        .bg-soft-warning {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            line-height: 1;
        }

        .stat-label {
            color: #888;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -2rem;
            top: 0.25rem;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: white;
            border: 3px solid #4e54c8;
            box-shadow: 0 0 0 3px rgba(78, 84, 200, 0.2);
        }

        .timeline-content {
            background: #f8f9fa;
            border-radius: 0.75rem;
            padding: 1rem;
            transition: background 0.2s;
        }

        .timeline-content:hover {
            background: #f1f3f5;
        }

        .timeline-time {
            color: #aaa;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
    </style>
@endpush

@section('content')
    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 1;">
            <div>
                <h2 class="fw-bold mb-1">Hello, {{ auth()->user()->name }}! 👋</h2>
                <p class="mb-0 text-white-50">Selamat datang di Panel Admin Peminjaman Alat.</p>
            </div>
            <div class="d-none d-md-block text-end">
                <p class="mb-0 fw-medium bg-white bg-opacity-25 px-3 py-1 rounded-pill">
                    <i class="bi bi-calendar-event me-2"></i> {{ date('l, d M Y') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-4">
        <!-- Users -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-soft-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h6 class="stat-label">Total Pengguna</h6>
                    <h3 class="stat-value">{{ \App\Models\User::count() }}</h3>
                </div>
            </div>
        </div>
        <!-- Tools -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-soft-success">
                    <i class="bi bi-tools"></i>
                </div>
                <div>
                    <h6 class="stat-label">Total Alat</h6>
                    <h3 class="stat-value">{{ \App\Models\Alat::count() }}</h3>
                </div>
            </div>
        </div>
        <!-- Loans -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon-box bg-soft-warning">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <div>
                    <h6 class="stat-label">Peminjaman Aktif</h6>
                    <h3 class="stat-value">{{ \App\Models\Peminjaman::where('status', 'disetujui')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log & Quick Actions -->
    <div class="row g-4">
        <!-- Activity Timeline -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">📊 Aktivitas Terbaru</h5>
                    <a href="/admin/activity" class="btn btn-sm btn-light text-primary fw-medium rounded-pill px-3">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body p-4">
                    @if($logs->count() > 0)
                        <div class="timeline">
                            @foreach($logs as $log)
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-semibold text-dark">{{ $log->user->name ?? 'User Terhapus' }}</span>
                                            <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="text-muted small mb-1">{{ $log->aksi }}</div>
                                        @if($log->deskripsi)
                                            <div class="bg-white p-2 rounded border border-light text-secondary small mt-2">
                                                {{ $log->deskripsi }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486777.png" width="80"
                                class="mb-3 opacity-50" alt="No Data">
                            <p class="text-muted">Belum ada aktivitas tercatat.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions / Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">🚀 Aksi Cepat</h5>
                    <div class="d-grid gap-2">
                        <a href="/admin/alat/create"
                            class="btn btn-outline-primary text-start p-3 rounded-3 d-flex align-items-center transition-hover">
                            <i class="bi bi-plus-circle-fill fs-4 me-3"></i>
                            <div>
                                <div class="fw-bold">Tambah Alat Baru</div>
                                <div class="small opacity-75">Input data alat inventaris</div>
                            </div>
                        </a>
                        <a href="/admin/user/create"
                            class="btn btn-outline-success text-start p-3 rounded-3 d-flex align-items-center transition-hover">
                            <i class="bi bi-person-plus-fill fs-4 me-3"></i>
                            <div>
                                <div class="fw-bold">Tambah User</div>
                                <div class="small opacity-75">Registrasi pengguna baru</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <h5 class="fw-bold relative z-1">Butuh Bantuan?</h5>
                    <p class="small opacity-75 relative z-1 mb-3">Hubungi tim developer jika terjadi kendala pada sistem.
                    </p>
                    <button class="btn btn-sm btn-light text-primary fw-bold relative z-1 rounded-pill px-4">Kontak
                        Support</button>

                    <i class="bi bi-headset position-absolute"
                        style="font-size: 8rem; right: -2rem; bottom: -3rem; opacity: 0.15; transform: rotate(-15deg);"></i>
                </div>
            </div>
        </div>
    </div>
@endsection