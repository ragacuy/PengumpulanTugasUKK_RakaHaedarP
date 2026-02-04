@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-0 text-dark">Edit Kategori</h3>
            <p class="text-muted small mb-0">Perbarui nama kategori alat</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary rounded-pill shadow-sm px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-semibold">Nama Kategori</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3">
                            <i class="bi bi-tag text-muted"></i>
                        </span>
                        <input type="text" name="nama_kategori"
                            class="form-control border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary @error('nama_kategori') is-invalid @enderror"
                            value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>

                        @error('nama_kategori')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success rounded-pill shadow-sm px-4">
                        <i class="bi bi-check-lg me-2"></i>Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection