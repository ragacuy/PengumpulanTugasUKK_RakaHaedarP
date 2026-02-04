@extends('layouts.app')

@section('title', 'Data Kategori')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-0 text-dark">Data Kategori</h3>
            <p class="text-muted small mb-0">Kelola kategori peralatan</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('kategori.create') }}" class="btn btn-primary rounded-pill shadow-sm px-4">
                <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
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
                            <th class="border-0 py-3 ps-4 rounded-start-4 text-secondary text-uppercase small fw-semibold"
                                style="width: 80px;">No</th>
                            <th class="border-0 py-3 text-secondary text-uppercase small fw-semibold">Nama Kategori</th>
                            <th class="border-0 py-3 pe-4 rounded-end-4 text-end text-secondary text-uppercase small fw-semibold"
                                style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoris as $k)
                            <tr>
                                <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                <td class="fw-medium text-dark">{{ $k->nama_kategori }}</td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="/admin/kategori/{{ $k->id }}/edit" class="btn btn-outline-warning btn-sm"
                                            data-bs-toggle="tooltip" title="Edit Kategori">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="/admin/kategori/{{ $k->id }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $k->nama_kategori }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-outline-danger btn-sm rounded-end"
                                                onclick="if(confirm('Hapus kategori {{ $k->nama_kategori }}?')) this.closest('form').submit()">
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

            @if($kategoris->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-tags text-muted display-1"></i>
                    </div>
                    <h5 class="text-muted">Belum ada data kategori</h5>
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary mt-2">Tambah Kategori pertama</a>
                </div>
            @endif
        </div>
    </div>
@endsection