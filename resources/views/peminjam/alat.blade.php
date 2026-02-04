@extends('layouts.app')

@section('title', 'Daftar Alat')

@section('content')
    <div class="container py-4">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold mb-1">Peminjaman Alat</h4>
                <p class="text-muted small mb-0">Pilih alat yang ingin Anda pinjam dari daftar tersedia.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="input-group shadow-sm w-md-50 ms-auto">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari alat..."
                        aria-label="Search">
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($alat as $a)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden wrapper-card">
                        {{-- Placeholder Image (Since we don't have real images yet) --}}
                        <div class="bg-light d-flex align-items-center justify-content-center p-4" style="height: 180px;">
                            <i class="bi bi-tools text-secondary opacity-25" style="font-size: 5rem;"></i>
                        </div>

                        <div class="card-body p-4 d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill small mb-2">
                                    {{ $a->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                                <h5 class="card-title fw-bold text-dark mb-1">{{ $a->nama_alat }}</h5>
                                <div class="d-flex align-items-center">
                                    <span class="text-muted small me-2">Stok Tersedia:</span>
                                    <span class="fw-bold {{ $a->stok > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $a->stok }} Unit
                                    </span>
                                </div>
                            </div>

                            <div class="mt-auto pt-3 border-top border-light">
                                <form action="{{ route('peminjam.pinjam.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="alat_id" value="{{ $a->id }}">

                                    <div class="d-flex gap-2">
                                        <div class="w-50">
                                            <input type="number" name="jumlah" class="form-control form-control-sm text-center"
                                                placeholder="Jml" min="1" max="{{ $a->stok }}" required {{ $a->stok == 0 ? 'disabled' : '' }}>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3 shadow-sm" {{ $a->stok == 0 ? 'disabled' : '' }}>
                                            @if($a->stok > 0)
                                                <i class="bi bi-cart-plus me-1"></i> Pinjam
                                            @else
                                                Habis
                                            @endif
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-box-seam text-muted opacity-25" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="fw-bold text-muted">Belum ada alat tersedia</h5>
                        <p class="text-muted small">Silakan hubungi petugas jika Anda membutuhkan bantuan.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .wrapper-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .wrapper-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        }
    </style>
@endsection