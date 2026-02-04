@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-0 text-dark">Tambah Kategori Baru</h3>
            <p class="text-muted small mb-0">Form untuk menambahkan kategori alat baru</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary rounded-pill shadow-sm px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-semibold">Nama Kategori</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3">
                            <i class="bi bi-tag text-muted"></i>
                        </span>
                        <input type="text" name="nama_kategori"
                            class="form-control border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary"
                            placeholder="Contoh: Elektronik" required>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary rounded-pill shadow-sm px-4">
                        <i class="bi bi-save me-2"></i>Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection