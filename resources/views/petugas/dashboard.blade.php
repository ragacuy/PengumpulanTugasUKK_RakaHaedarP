@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="container-fluid px-0">

    {{-- ================= HEADER ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Overview</h4>
            <p class="text-muted small mb-0">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-light border shadow-sm btn-sm px-3 rounded-3 text-muted">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh
            </button>
            <button class="btn btn-dark btn-sm px-3 rounded-3 shadow-sm">
                <i class="bi bi-download me-1"></i> Report
            </button>
        </div>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="row g-3 mb-4">

        {{-- Pending --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 position-relative overflow-hidden">
                <div class="card-body p-4 d-flex justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-semibold mb-1 ls-1">Menunggu</p>
                        <h2 class="fw-bold mb-0">{{ $pending }}</h2>
                        <span class="badge bg-warning bg-opacity-10 text-warning mt-2 rounded-pill px-2">
                            <i class="bi bi-arrow-up-short"></i> Perlu Review
                        </span>
                    </div>
                    <div class="icon-circle bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                </div>
                <div class="accent accent-warning"></div>
            </div>
        </div>

        {{-- Active --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 position-relative overflow-hidden">
                <div class="card-body p-4 d-flex justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-semibold mb-1 ls-1">Aktif Dipinjam</p>
                        <h2 class="fw-bold mb-0">{{ $active }}</h2>
                        <span class="badge bg-info bg-opacity-10 text-info mt-2 rounded-pill px-2">
                            <i class="bi bi-activity"></i> Sedang Berjalan
                        </span>
                    </div>
                    <div class="icon-circle bg-info bg-opacity-10 text-info">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
                <div class="accent accent-info"></div>
            </div>
        </div>

    </div>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="row g-4">

        {{-- ===== AKTIVITAS TERKINI ===== --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 px-4">
                    <h6 class="fw-bold mb-0">Aktivitas Terkini</h6>
                </div>

                <div class="card-body p-0">
                    <div class="list-group list-group-flush">

                        @forelse($recent as $item)
                            <div class="list-group-item px-4 py-3 border-light">
                                <div class="d-flex justify-content-between align-items-center">

                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3">
                                            {{ substr($item->user->name, 0, 2) }}
                                        </div>

                                        <div>
                                            <h6 class="mb-0">{{ $item->user->name }}</h6>
                                            <small class="text-muted">
                                                Meminjam
                                                <span class="fw-medium text-dark">
                                                    {{ $item->alat->nama_alat }}
                                                </span>
                                                • {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>

                                    {{-- STATUS --}}
                                    <div class="text-end">
                                        @if($item->status === 'pending')
                                            <span class="badge bg-warning bg-opacity-10 text-warning d-block mb-1">
                                                Pending
                                            </span>
                                            <form action="/peminjaman/{{ $item->id }}/approve" method="POST">
                                                @csrf
                                                <button class="btn btn-xs btn-outline-success rounded-pill">
                                                    Approve
                                                </button>
                                            </form>

                                        @elseif($item->status === 'disetujui')
                                            <span class="badge bg-info bg-opacity-10 text-info">Dipinjam</span>

                                        @elseif($item->status === 'kembali')
                                            <span class="badge bg-success bg-opacity-10 text-success">Selesai</span>

                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                {{ $item->status }}
                                            </span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                Tidak ada aktivitas terbaru.
                            </div>
                        @endforelse

                    </div>
                </div>

                <div class="card-footer bg-white text-center">
                    <a href="/petugas/peminjaman" class="fw-bold small text-primary text-decoration-none">
                        Lihat Semua Aktivitas <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== SIDEBAR ===== --}}
        <div class="col-lg-4">

            {{-- STATUS SISTEM --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Status Sistem</h6>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small">Server Status</span>
                        <span class="badge bg-success rounded-pill status-dot">Online</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small">Total Alat</span>
                        <span class="fw-bold">{{ \App\Models\Alat::count() }} Unit</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Pengguna</span>
                        <span class="fw-bold">{{ \App\Models\User::count() }} User</span>
                    </div>

                    <hr>

                    <a href="#" class="btn btn-outline-dark btn-sm w-100 text-start">
                        <i class="bi bi-file-earmark-text me-2"></i> Export Laporan Hari Ini
                    </a>
                </div>
            </div>

            {{-- JAM --}}
            <div class="card border-0 shadow-sm rounded-3 bg-primary text-white">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <h5 class="fw-bold mb-1">{{ \Carbon\Carbon::now()->format('H:i') }}</h5>
                    <small class="opacity-75">Waktu Server Sekarang</small>

                    <i class="bi bi-clock position-absolute end-0 bottom-0 opacity-25"
                       style="font-size:5rem;"></i>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ================= CUSTOM STYLE ================= --}}
<style>
    .ls-1 { letter-spacing: 1px; }

    .btn-xs {
        font-size: 0.75rem;
        padding: 0.15rem 0.6rem;
    }

    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .accent {
        height: 4px;
        width: 100%;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .accent-warning { background: #ffc107; }
    .accent-info { background: #0dcaf0; }

    .avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #0d6efd;
        font-size: 14px;
    }

    .status-dot::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        background: white;
        border-radius: 50%;
        margin-right: 6px;
    }
</style>
@endsection
