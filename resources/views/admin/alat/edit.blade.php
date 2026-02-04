@extends('layouts.app')

@section('title', 'Edit Alat')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-0 text-dark">Edit Alat</h3>
            <p class="text-muted small mb-0">Perbarui informasi peralatan</p>
        </div>
        <div class="col-auto">
            <a href="/admin/alat" class="btn btn-secondary rounded-pill shadow-sm px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="/admin/alat/{{ $alat->id }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Alat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-tools text-muted"></i>
                                </span>
                                <input type="text" name="nama_alat"
                                    class="form-control border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary"
                                    value="{{ $alat->nama_alat }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-tag text-muted"></i>
                                </span>
                                <select name="kategori_id"
                                    class="form-select border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary"
                                    required>
                                    <option value="" disabled>-- Pilih Kategori --</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}" {{ $alat->kategori_id == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kondisi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-clipboard-check text-muted"></i>
                                </span>
                                <select name="kondisi"
                                    class="form-select border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary"
                                    required>
                                    <option value="" disabled>-- Pilih Kondisi --</option>
                                    <option value="Baik" {{ $alat->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ $alat->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>
                                        Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ $alat->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak
                                        Berat</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <div class="input-group">
                                <button class="btn btn-outline-danger border-end-0 rounded-start-3" type="button"
                                    onclick="kurangiStok()">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" name="stok" id="stok"
                                    class="form-control text-center border-start-0 border-end-0"
                                    value="{{ old('stok', $alat->stok) }}" min="1" readonly>
                                <button class="btn btn-outline-success border-start-0 rounded-end-3" type="button"
                                    onclick="tambahStok()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-success rounded-pill shadow-sm px-4">
                        <i class="bi bi-check-lg me-2"></i>Update Alat
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function tambahStok() {
            let stok = document.getElementById('stok');
            stok.value = parseInt(stok.value) + 1;
        }

        function kurangiStok() {
            let stok = document.getElementById('stok');
            if (stok.value > 1) {
                stok.value = parseInt(stok.value) - 1;
            }
        }
    </script>
@endsection