@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-0 text-dark">Edit Peminjaman #{{ $peminjaman->id }}</h3>
            <p class="text-muted small mb-0">Perbarui data atau status peminjaman</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary rounded-pill shadow-sm px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Kolom Kiri: Read-Only Info --}}
            <div class="col-md-5 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-light border-0 py-3 rounded-top-4">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-info-circle me-2"></i>Detail Peminjam & Alat</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small text-muted text-uppercase fw-semibold">Peminjam</label>
                            <div class="fs-5 fw-medium text-dark">{{ $peminjaman->user->name }}</div>
                        </div>

                        <hr class="border-secondary-subtle">

                        <label class="small text-muted text-uppercase fw-semibold mb-2">Alat yang Dipinjam</label>
                        <ul class="list-group list-group-flush">
                            @foreach($peminjaman->details as $d)
                                <li
                                    class="list-group-item px-0 d-flex justify-content-between align-items-center bg-transparent border-bottom">
                                    <div>
                                        <i class="bi bi-tools text-primary me-2"></i>
                                        {{ $d->alat->nama_alat }}
                                    </div>
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill">{{ $d->jumlah }}
                                        unit</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="alert alert-light border mt-3 small text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Item dan jumlah tidak dapat diubah di sini. Silakan hapus dan buat baru jika ada kesalahan item.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Form Edit --}}
            <div class="col-md-7 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-light border-0 py-3 rounded-top-4">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2"></i>Edit Informasi</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Pinjam</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="bi bi-calendar-event text-muted"></i>
                                    </span>
                                    <input type="date" name="tanggal_pinjam"
                                        class="form-control border-start-0 rounded-end-3"
                                        value="{{ $peminjaman->tanggal_pinjam }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Rencana Kembali</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="bi bi-calendar-check text-muted"></i>
                                    </span>
                                    <input type="date" name="tanggal_rencana_kembali"
                                        class="form-control border-start-0 rounded-end-3"
                                        value="{{ $peminjaman->tanggal_rencana_kembali }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status Peminjaman</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-check-circle text-muted"></i>
                                </span>
                                <select name="status"
                                    class="form-select border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary"
                                    required>
                                    <option value="pending" {{ $peminjaman->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="disetujui" {{ $peminjaman->status == 'disetujui' ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="ditolak" {{ $peminjaman->status == 'ditolak' ? 'selected' : '' }}>Ditolak
                                    </option>
                                    <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-success rounded-pill shadow-sm px-4">
                                <i class="bi bi-save me-2"></i>Update Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection