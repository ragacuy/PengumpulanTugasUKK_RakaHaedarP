@extends('layouts.app')

@section('title', 'Tambah Pengembalian')

@section('content')

    <h3>Tambah Pengembalian</h3>

    <form action="/admin/pengembalian" method="POST">
        @csrf

        {{-- PILIH PEMINJAMAN --}}
        <div class="mb-3">
            <label class="form-label">Pilih Peminjaman</label>
            <select name="peminjaman_id" id="peminjaman_id" class="form-select" required>
                <option value="">-- Pilih Peminjaman --</option>
                @foreach($peminjamans as $p)
                    <option value="{{ $p->id }}" data-nama="{{ $p->user->name }}">
                        ID {{ $p->id }} - {{ $p->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- NAMA PEMINJAM --}}
        <div class="mb-3">
            <label class="form-label">Nama Peminjam</label>
            <input type="text" id="nama_peminjam" class="form-control" readonly>
        </div>



        <div class="mb-3">
            <label class="form-label">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        {{-- KONDISI KEMBALI --}}
    <div class="mb-3">
        <label class="form-label">Kondisi Kembali</label>
        <select name="kondisi_kembali" class="form-select" required>
            <option value="">-- Pilih Kondisi --</option>
            <option value="Baik">Baik</option>
            <option value="Rusak Ringan">Rusak Ringan</option>
            <option value="Rusak Berat">Rusak Berat</option>
        </select>
    </div>

        {{-- DENDA --}}
        <div class="mb-3">
            <label>Estimasi Denda</label>
            <input type="text" class="form-control" id="estimasi_denda" value="Rp 0" readonly>
            <small class="text-muted">
                * Dihitung otomatis saat disimpan
            </small>
        </div>

        {{-- DITERIMA OLEH --}}
        <div class="mb-3">
            <label class="form-label">Diterima Oleh</label>
            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
        </div>

        {{-- TOMBOL --}}
        <button class="btn btn-primary">Simpan</button>
        <a href="/admin/pengembalian" class="btn btn-secondary">Batal</a>

    </form>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('peminjaman_id');
            const nama = document.getElementById('nama_peminjam');

            select.addEventListener('change', function () {
                const opt = this.options[this.selectedIndex];
                nama.value = opt.dataset.nama || '';
            });
        });
    </script>

@endsection