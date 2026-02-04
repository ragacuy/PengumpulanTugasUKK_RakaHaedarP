@extends('layouts.app')

@section('title', 'Edit Pengembalian')

@section('content')

    <h3>Edit Pengembalian</h3>

    <form action="{{ url('/admin/pengembalian/' . $pengembalian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="alert alert-info">
            <b>Catatan:</b>
            Edit hanya digunakan jika terjadi kesalahan input tanggal pengembalian.
            Denda akan dihitung ulang otomatis oleh sistem.
        </div>


        {{-- Peminjaman (TIDAK BOLEH DIUBAH) --}}
        <div class="mb-3">
            <label class="form-label">Peminjaman</label>
            <input type="text" class="form-control"
                value="ID {{ $pengembalian->peminjaman->id }} - {{ $pengembalian->peminjaman->user->name }}" readonly>
        </div>

        {{-- Detail Alat --}}
        <div class="mb-3">
            <label class="form-label">Alat yang Dikembalikan</label>
            <ul class="list-group">
                @foreach($pengembalian->peminjaman->details as $detail)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $detail->alat->nama_alat }}</span>
                        <span class="badge bg-secondary">
                            {{ $detail->jumlah }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mb-3">
            <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control"
                value="{{ $pengembalian->tanggal_kembali }}" required>
        </div>

        {{-- Kondisi Kembali --}}
        <div class="mb-3">
            <label class="form-label">Kondisi Kembali</label>
            <select name="kondisi_kembali" class="form-select" required>
                <option value="Baik" {{ $pengembalian->kondisi_kembali == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Rusak Ringan" {{ $pengembalian->kondisi_kembali == 'Rusak Ringan' ? 'selected' : '' }}>Rusak
                    Ringan</option>
                <option value="Rusak Berat" {{ $pengembalian->kondisi_kembali == 'Rusak Berat' ? 'selected' : '' }}>Rusak
                    Berat</option>
            </select>
        </div>

        {{-- Denda --}}
        <div class="mb-3">
            <label>Denda</label>
            <input type="text" class="form-control" value="Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}"
                readonly>
        </div>

        {{-- Diterima Oleh --}}
        <div class="mb-3">
            <label class="form-label">Diterima Oleh</label>
            <input type="text" class="form-control" value="{{ $pengembalian->diterima->name ?? auth()->user()->name }}"
                readonly>
        </div>

        <button type="submit" class="btn btn-primary">
            Update Pengembalian
        </button>
        <a href="{{ url('/admin/pengembalian') }}" class="btn btn-secondary">
            Batal
        </a>
    </form>

@endsection