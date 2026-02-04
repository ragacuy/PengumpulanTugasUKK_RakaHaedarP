@extends('layouts.app')

@section('title', 'Monitoring Data Pengembalian')

@section('content')
    <div class="container-fluid px-0">
        {{-- Header --}}
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Riwayat Pengembalian</h4>
                <p class="text-muted small mb-0">Monitoring data alat yang telah dikembalikan.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-inline-flex gap-2">
                    <button class="btn btn-dark shadow-sm rounded-3">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Export
                    </button>
                </div>
            </div>
        </div>

        {{-- Card Container --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 text-secondary small text-uppercase fw-bold border-0"
                                    style="width: 25%;">Peminjam</th>
                                <th class="px-4 py-3 text-secondary small text-uppercase fw-bold border-0"
                                    style="width: 30%;">Alat Dikembalikan</th>
                                <th class="px-4 py-3 text-secondary small text-uppercase fw-bold border-0"
                                    style="width: 25%;">Detail Waktu</th>
                                <th class="px-4 py-3 text-secondary small text-uppercase fw-bold border-0 text-end"
                                    style="width: 20%;">Kondisi & Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $kembali)
                                <tr>
                                    {{-- Peminjam Info --}}
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm rounded-circle bg-success bg-opacity-10 text-success fw-bold me-3 d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; font-size: 14px;">
                                                {{ substr($kembali->peminjaman->user->name ?? '?', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $kembali->peminjaman->user->name ?? '-' }}
                                                </div>
                                                <div class="small text-muted">ID: #{{ $kembali->id }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Alat Info --}}
                                    <td class="px-4">
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($kembali->peminjaman->details as $detail)
                                                <li class="mb-1 d-flex align-items-center">
                                                    <i class="bi bi-check2-circle text-success me-2 small"></i>
                                                    <span class="text-dark fw-medium">{{ $detail->alat->nama_alat }}</span>
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary ms-2 rounded-pill"
                                                        style="font-size: 10px;">x{{ $detail->jumlah }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    {{-- Waktu Info --}}
                                    <td class="px-4">
                                        <div class="d-flex flex-column gap-1 small">
                                            <div class="text-muted">
                                                Pinjam: <span
                                                    class="text-dark fw-medium">{{ \Carbon\Carbon::parse($kembali->peminjaman->tanggal_pinjam)->format('d M Y') }}</span>
                                            </div>
                                            <div class="text-muted">
                                                Kembali: <span
                                                    class="text-primary fw-medium">{{ \Carbon\Carbon::parse($kembali->tanggal_kembali)->format('d M Y') }}</span>
                                            </div>
                                            @php
                                                $terlambat = \Carbon\Carbon::parse($kembali->tanggal_kembali)->gt(\Carbon\Carbon::parse($kembali->peminjaman->tanggal_rencana_kembali));
                                            @endphp
                                            @if($terlambat)
                                                <div class="text-danger fst-italic mt-1" style="font-size: 11px;">
                                                    <i class="bi bi-exclamation-circle me-1"></i> Terlambat dikembalikan
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Kondisi & Denda --}}
                                    <td class="px-4 text-end">
                                        <div class="mb-2">
                                            @if($kembali->kondisi_kembali == 'Baik')
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Baik</span>
                                            @elseif($kembali->kondisi_kembali == 'Rusak Ringan')
                                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Rusak
                                                    Ringan</span>
                                            @elseif($kembali->kondisi_kembali == 'Rusak Berat')
                                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Rusak
                                                    Berat</span>
                                            @else
                                                <span
                                                    class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">{{ $kembali->kondisi_kembali }}</span>
                                            @endif
                                        </div>
                                        <div class="small">
                                            <span class="text-muted me-1">Denda:</span>
                                            @if($kembali->denda > 0)
                                                <span class="text-danger fw-bold">Rp
                                                    {{ number_format($kembali->denda, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-success fw-bold">Rp 0</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div
                                            class="d-flex flex-column align-items-center justify-content-center text-muted col-6 mx-auto">
                                            <div class="bg-light rounded-circle p-4 mb-3">
                                                <i class="bi bi-clipboard-check fs-1 text-secondary opacity-50"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">Belum ada data pengembalian</h6>
                                            <p class="small mb-0">Riwayat pengembalian alat akan muncul di sini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white py-3 border-0">
                <div class="text-muted small text-center">Menampilkan semua riwayat pengembalian</div>
            </div>
        </div>
    </div>
@endsection