@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="container py-4">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold mb-1">Peminjaman Saya</h4>
                <p class="text-muted small mb-0">Pantau status permintaan dan riwayat peminjaman Anda.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                {{-- TABS NAVIGATION --}}
                <ul class="nav nav-pills mb-4 nav-justified bg-white p-2 rounded-4 shadow-sm" id="peminjamanTabs"
                    role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill fw-bold" id="dipinjam-tab" data-bs-toggle="pill"
                            data-bs-target="#dipinjam" type="button" role="tab">
                            <i class="bi bi-box-seam me-1"></i> Dipinjam
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill fw-bold" id="pending-tab" data-bs-toggle="pill"
                            data-bs-target="#pending" type="button" role="tab">
                            <i class="bi bi-hourglass-split me-1"></i> Pending
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill fw-bold" id="riwayat-tab" data-bs-toggle="pill"
                            data-bs-target="#riwayat" type="button" role="tab">
                            <i class="bi bi-clock-history me-1"></i> Riwayat
                        </button>
                    </li>
                </ul>

                {{-- TABS CONTENT --}}
                <div class="tab-content" id="peminjamanTabsContent">

                    {{-- TAB: SEDANG DIPINJAM --}}
                    <div class="tab-pane fade show active" id="dipinjam" role="tabpanel">
                        @forelse($data->where('status', 'disetujui') as $p)
                            @include('peminjam.partials.card-peminjaman', ['p' => $p, 'type' => 'active'])
                        @empty
                            <div class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486777.png" alt="Empty"
                                    style="width: 80px; opacity: 0.5;" class="mb-4">
                                <p class="text-muted fw-bold">Tidak ada alat yang sedang dipinjam.</p>
                                <a href="{{ route('peminjam.alat.index') }}" class="btn btn-primary rounded-pill btn-sm">Pinjam
                                    Alat</a>
                            </div>
                        @endforelse
                    </div>

                    {{-- TAB: PENDING --}}
                    <div class="tab-pane fade" id="pending" role="tabpanel">
                        @forelse($data->where('status', 'pending') as $p)
                            @include('peminjam.partials.card-peminjaman', ['p' => $p, 'type' => 'pending'])
                        @empty
                            <div class="text-center py-5">
                                <div class="mb-3"><i class="bi bi-inbox text-muted opacity-25" style="font-size: 4rem;"></i>
                                </div>
                                <p class="text-muted">Tidak ada permintaan menunggu konfirmasi.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- TAB: RIWAYAT (Selesai/Ditolak) --}}
                    <div class="tab-pane fade" id="riwayat" role="tabpanel">
                        @forelse($data->whereIn('status', ['kembali', 'ditolak']) as $p)
                            @include('peminjam.partials.card-peminjaman', ['p' => $p, 'type' => 'history'])
                        @empty
                            <div class="text-center py-5">
                                <div class="mb-3"><i class="bi bi-clock-history text-muted opacity-25"
                                        style="font-size: 4rem;"></i></div>
                                <p class="text-muted">Belum ada riwayat peminjaman.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

            {{-- SIDEBAR STATS --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 bg-primary text-white mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Informasi</h5>
                        <p class="small opacity-75 mb-0">
                            Gunakan tab di atas untuk menyaring daftar peminjaman. Segera kembalikan alat di tab
                            <strong>"Dipinjam"</strong> jika sudah selesai digunakan.
                        </p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 text-center">
                        <h1 class="display-4 fw-bold text-primary mb-0">{{ $data->where('status', 'disetujui')->count() }}
                        </h1>
                        <p class="text-muted small mb-0">Total Sedang Dipinjam</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection