@extends('layouts.app')

@section('title', 'Setujui Pengembalian')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-0 text-dark">Proses Pengembalian</h3>
            <p class="text-muted small mb-0">Form untuk memproses pengembalian alat</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-secondary rounded-pill shadow-sm px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Kolom Kiri: Detail Peminjaman --}}
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-light border-0 py-3 rounded-top-4">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-info-circle me-2"></i>Detail Peminjaman</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="small text-muted text-uppercase fw-semibold">Peminjam</label>
                        <div class="fs-5 fw-medium text-dark">{{ $peminjaman->user->name }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="small text-muted text-uppercase fw-semibold">Tanggal Pinjam</label>
                            <div class="text-dark"><i class="bi bi-calendar-event me-2"></i>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</div>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted text-uppercase fw-semibold">Rencana Kembali</label>
                            <div class="text-danger fw-medium"><i class="bi bi-calendar-x me-2"></i>{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</div>
                        </div>
                    </div>

                    <hr class="border-secondary-subtle">

                    <label class="small text-muted text-uppercase fw-semibold mb-2">Alat yang DIpinjam</label>
                    <ul class="list-group list-group-flush">
                        @foreach($peminjaman->details as $d)
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center bg-transparent border-bottom">
                                <div>
                                    <i class="bi bi-tools text-primary me-2"></i>
                                    {{ $d->alat->nama_alat }}
                                </div>
                                <span class="badge bg-primary-subtle text-primary rounded-pill">{{ $d->jumlah }} unit</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Form Pengembalian --}}
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <form method="POST" action="{{ url('/pengembalian') }}">
                        @csrf
                        <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tanggal Dikembalikan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-calendar-check text-muted"></i>
                                </span>
                                <input type="date" name="tanggal_kembali" class="form-control border-start-0 rounded-end-3" 
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-text text-muted">Secara default diisi tanggal hari ini.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kondisi Alat Saat Kembali</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-clipboard-check text-muted"></i>
                                </span>
                                <select name="kondisi_kembali" class="form-select border-start-0 rounded-end-3" required>
                                    <option value="Baik" selected>Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis d-flex align-items-start">
                             <i class="bi bi-exclamation-triangle-fill me-3 mt-1 fs-5"></i>
                             <div>
                                 <strong>Info Denda:</strong><br>
                                 Sistem akan otomatis menghitung denda keterlambatan (Rp 5.000 / hari) berdasarkan tanggal rencana kembali dan tanggal dikembalikan.
                             </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary rounded-pill shadow-sm py-2 fw-medium">
                                <i class="bi bi-check-lg me-2"></i>Konfirmasi Pengembalian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
