@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-0 text-dark">Buat Peminjaman Baru</h3>
            <p class="text-muted small mb-0">Form untuk membuat pengajuan peminjaman alat</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary rounded-pill shadow-sm px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('peminjaman.store') }}">
        @csrf
        <div class="row">
            {{-- Kolom Kiri: Informasi Peminjam --}}
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-light border-0 py-3 rounded-top-4">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-person-lines-fill me-2"></i>Informasi Peminjam</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Pilih Peminjam</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-person text-muted"></i>
                                </span>
                                <select name="user_id" class="form-select border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary" required>
                                    <option value="" selected disabled>-- Pilih User --</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal Pinjam</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                            <i class="bi bi-calendar-event text-muted"></i>
                                        </span>
                                        <input type="date" name="tanggal_pinjam" class="form-control border-start-0 rounded-end-3" 
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Rencana Kembali</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                            <i class="bi bi-calendar-check text-muted"></i>
                                        </span>
                                        <input type="date" name="tanggal_rencana_kembali" class="form-control border-start-0 rounded-end-3" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Informasi Alat --}}
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-light border-0 py-3 rounded-top-4">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-tools me-2"></i>Informasi Alat</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Pilih Alat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-box-seam text-muted"></i>
                                </span>
                                <select name="alat_id" class="form-select border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary" required>
                                    <option value="" selected disabled>-- Pilih Alat --</option>
                                    @foreach($alats as $alat)
                                        <option value="{{ $alat->id }}" {{ $alat->stok <= 0 ? 'disabled' : '' }}>
                                            {{ $alat->nama_alat }} 
                                            (Stok: {{ $alat->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-text text-muted">Hanya alat dengan stok tersedia yang dapat dipilih.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Jumlah Pinjam</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-123 text-muted"></i>
                                </span>
                                <input type="number" name="jumlah" class="form-control border-start-0 rounded-end-3" 
                                    min="1" placeholder="Masukkan jumlah" required>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis d-flex align-items-center">
                            <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                            <div>
                                Pastikan stok mencukupi sebelum menyimpan. Stok akan otomatis berkurang saat disimpan.
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary rounded-pill shadow-sm py-2 fw-medium">
                                <i class="bi bi-save me-2"></i>Simpan Peminjaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
