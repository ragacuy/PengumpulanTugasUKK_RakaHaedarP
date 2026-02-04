@extends('layouts.app')

@section('title', 'Tambah Alat')

@section('content')
    @section('content')
        <div class="row align-items-center mb-4">
            <div class="col">
                <h3 class="fw-bold mb-0 text-dark">Tambah Alat Baru</h3>
                <p class="text-muted small mb-0">Form untuk menambahkan data peralatan baru</p>
            </div>
            <div class="col-auto">
                <a href="/admin/alat" class="btn btn-secondary rounded-pill shadow-sm px-4">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form method="POST" action="/admin/alat">
                    @csrf

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
                                        placeholder="Contoh: Proyektor Epson" required>
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
                                        <option value="" selected disabled>-- Pilih Kategori --</option>
                                        @foreach($kategoris as $k)
                                            <option value="{{ $k->id }}">
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
                                        <option value="" selected disabled>-- Pilih Kondisi --</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Stok</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-danger border-end-0 rounded-start-3" type="button"
                                        id="minus">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" class="form-control text-center border-start-0 border-end-0" id="stok"
                                        name="stok" value="1" min="1" max="{{ $stokMaks }}" readonly>
                                    <button class="btn btn-outline-success border-start-0 rounded-end-3" type="button"
                                        id="plus">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                                <div class="form-text small text-end">Maksimal stok: {{ $stokMaks }} unit</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill shadow-sm px-4">
                            <i class="bi bi-save me-2"></i>Simpan Alat
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const plus = document.getElementById('plus');
            const minus = document.getElementById('minus');
            const stok = document.getElementById('stok');
            const max = parseInt(stok.getAttribute('max'));

            plus.addEventListener('click', () => {
                if (parseInt(stok.value) < max) {
                    stok.value = parseInt(stok.value) + 1;
                }
            });

            minus.addEventListener('click', () => {
                if (parseInt(stok.value) > 1) {
                    stok.value = parseInt(stok.value) - 1;
                }
            });
        </script>
    @endsection

@endsection