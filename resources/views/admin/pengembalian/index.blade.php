@extends('layouts.app')

@section('title', 'Data Pengembalian')

@section('content')

    <h3>Daftar Pengembalian</h3>

    <a href="/admin/pengembalian/create" class="btn btn-primary mb-3">Tambah Pengembalian</a>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Peminjaman ID</th>
                <th>Peminjam</th>
                <th>Alat yang Dikembalikan</th>
                <th>Jumlah</th>
            
                <th>Tanggal Kembali</th>
                <th>Kondisi</th>
                <th>Denda</th>
                <th>Diterima Oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->peminjaman->id }}</td>
                    <td>{{ $d->peminjaman->user->name }}</td>
                    <td>
                        <ul class="list-unstyled mb-0">
                            @foreach($d->peminjaman->details as $detail)
                                <li>{{ $detail->alat->nama_alat }} </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul class="list-unstyled mb-0">
                            @foreach($d->peminjaman->details as $detail)
                                <li> ({{ $detail->jumlah }}) </li>
                            @endforeach
                        </ul>
                    </td>
        
                    <td>{{ $d->tanggal_kembali }}</td>
                    <td>
                        @if($d->kondisi_kembali == 'Baik')
                            <span class="badge bg-success">Baik</span>
                        @elseif($d->kondisi_kembali == 'Rusak Ringan')
                            <span class="badge bg-warning text-dark">Rusak Ringan</span>
                        @else
                            <span class="badge bg-danger">Rusak Berat</span>
                        @endif
                    </td>
                    <td>
                        Rp {{ number_format($d->denda) }}
                    </td>
                    <td>{{ $d->diterima->name ?? '-' }}</td>
                    <td>
                        <a href="/admin/pengembalian/{{ $d->id }}/edit" class="btn btn-warning btn-sm">Edit</a>

                        <form action="/admin/pengembalian/{{ $d->id }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data pengembalian?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data pengembalian</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection