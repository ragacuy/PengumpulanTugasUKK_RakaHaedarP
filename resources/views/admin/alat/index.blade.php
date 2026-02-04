@extends('layouts.app')

@section('title', 'Data Alat')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-0 text-dark">Data Alat</h3>
            <p class="text-muted small mb-0">Kelola data peralatan dan kategori</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('kategori.index') }}" class="btn btn-info rounded-pill shadow-sm px-4 me-2 text-white">
                <i class="bi bi-tags me-2"></i>Kategori
            </a>
            <a href="/admin/alat/create" class="btn btn-primary rounded-pill shadow-sm px-4">
                <i class="bi bi-plus-lg me-2"></i>Tambah Alat
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 ps-4 rounded-start-4 text-secondary text-uppercase small fw-semibold">
                                Nama Alat</th>
                            <th class="border-0 py-3 text-secondary text-uppercase small fw-semibold">Kategori</th>
                            <th class="border-0 py-3 text-secondary text-uppercase small fw-semibold">Stok</th>
                            <th class="border-0 py-3 text-secondary text-uppercase small fw-semibold">Kondisi</th>
                            <th
                                class="border-0 py-3 pe-4 rounded-end-4 text-end text-secondary text-uppercase small fw-semibold">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alats as $a)
                            <tr>
                                <td class="ps-4 fw-medium text-dark">{{$a->nama_alat}}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $a->kategori->nama_kategori }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold {{ $a->stok > 0 ? 'text-success' : 'text-danger' }}">
                                        {{$a->stok}}
                                    </span> unit
                                </td>
                                <td>
                                    @if($a->kondisi == 'Baik')
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                            <i class="bi bi-check-circle me-1"></i> Baik
                                        </span>
                                    @elseif($a->kondisi == 'Rusak')
                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">
                                            <i class="bi bi-x-circle me-1"></i> Rusak
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3">
                                            {{$a->kondisi}}
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="/admin/alat/{{ $a->id }}/edit" class="btn btn-outline-warning btn-sm"
                                            data-bs-toggle="tooltip" title="Edit Alat">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="/admin/alat/{{ $a->id }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat {{ $a->nama_alat }}? Data yang dihapus tidak dapat dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-outline-danger btn-sm rounded-end"
                                                onclick="if(confirm('Hapus alat {{ $a->nama_alat }}?')) this.closest('form').submit()">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($alats->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-box-seam text-muted display-1"></i>
                    </div>
                    <h5 class="text-muted">Belum ada data alat</h5>
                    <a href="/admin/alat/create" class="btn btn-primary mt-2">Tambah Alat pertama</a>
                </div>
            @endif
        </div>
    </div>
@endsection