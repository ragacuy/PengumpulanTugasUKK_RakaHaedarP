@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
    <div class="container-fluid px-0">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h4 class="fw-bold text-dark mb-1">Daftar Peminjaman</h4>
                <p class="text-muted small mb-0">Kelola permintaan dan status peminjaman alat.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-inline-flex gap-2">
                    <div class="input-group shadow-sm" style="max-width: 250px;">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari peminjam..."
                            aria-label="Search">
                    </div>
                    <button class="btn btn-white border shadow-sm rounded-3">
                        <i class="bi bi-filter"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 text-secondary small text-uppercase fw-bold border-0">ID</th>
                                <th class="px-4 py-3 text-secondary small text-uppercase fw-bold border-0">Peminjam</th>
                                <th class="px-4 py-3 text-secondary small text-uppercase fw-bold border-0">Detail Alat</th>
                                <th class="px-4 py-3 text-secondary small text-uppercase fw-bold border-0">Jadwal</th>
                                <th class="px-4 py-3 text-secondary small text-uppercase fw-bold border-0">Status</th>
                                <th class="px-4 py-3 text-secondary small text-uppercase fw-bold border-0 text-end">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $p)
                                <tr>
                                    <td class="px-4 text-muted">#{{ $p->id }}</td>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 text-primary fw-bold me-3 d-flex align-items-center justify-content-center"
                                                style="width: 35px; height: 35px; font-size: 14px;">
                                                {{ substr($p->user->name ?? '?', 0, 1) }}
                                            </div>
                                            <span class="fw-medium text-dark">{{ $p->user->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4">
                                        <div class="d-flex flex-column gap-1">
                                            @foreach($p->details as $d)
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-dot text-primary me-1"></i>
                                                    <span class="text-dark small">{{ $d->alat->nama_alat }}</span>
                                                    <span class="badge bg-light text-secondary border ms-2 rounded-pill"
                                                        style="font-size: 10px;">{{ $d->jumlah }} unit</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-4 text-muted small">
                                        <div><i
                                                class="bi bi-calendar-event me-2"></i>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M') }}
                                        </div>
                                        <div><i class="bi bi-arrow-right-short me-1 text-danger"></i>
                                            {{ \Carbon\Carbon::parse($p->tanggal_rencana_kembali)->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-4">
                                        @if($p->status == 'pending')
                                            <span
                                                class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill border border-warning border-opacity-10">
                                                <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                            </span>
                                        @elseif($p->status == 'disetujui')
                                            <span
                                                class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill border border-info border-opacity-10">
                                                <i class="bi bi-check-circle me-1"></i> Dipinjam
                                            </span>
                                        @elseif($p->status == 'ditolak')
                                            <span
                                                class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill border border-danger border-opacity-10">
                                                <i class="bi bi-x-circle me-1"></i> Ditolak
                                            </span>
                                        @elseif($p->status == 'kembali')
                                            <span
                                                class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill border border-success border-opacity-10">
                                                <i class="bi bi-check-all me-1"></i> Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 text-end">
                                        @if($p->status == 'pending')
                                            <div class="d-flex gap-1 justify-content-end">
                                                <form action="{{ url('/peminjaman/' . $p->id . '/approve') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm px-3 rounded-pill"
                                                        title="Setujui">
                                                        <i class="bi bi-check-lg"></i> Acc
                                                    </button>
                                                </form>
                                                <form action="{{ url('/peminjaman/' . $p->id . '/tolak') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="catatan" value="Ditolak oleh petugas">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-pill"
                                                        onclick="return confirm('Tolak peminjaman ini?')" title="Tolak">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($p->status == 'disetujui')
                                            <a href="{{ url('/pengembalian/' . $p->id . '/create') }}"
                                                class="btn btn-primary btn-sm px-3 rounded-pill shadow-sm">
                                                <i class="bi bi-box-arrow-in-down-left me-1"></i> Proses Kembali
                                            </a>
                                        @else
                                            <span class="text-muted small"><i class="bi bi-dash-lg"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div
                                            class="d-flex flex-column align-items-center justify-content-center text-muted col-6 mx-auto">
                                            <div class="bg-light rounded-circle p-4 mb-3">
                                                <i class="bi bi-inbox fs-1 text-secondary opacity-50"></i>
                                            </div>
                                            <h6 class="fw-bold mb-1">Belum ada data peminjaman</h6>
                                            <p class="small mb-0">Permintaan peminjaman baru akan muncul di sini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination (Optional if using paginate in controller, adding placeholder for now) --}}
            <div class="card-footer bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <span class="text-muted small">Menampilkan semua data</span>
                {{-- {{ $data->links() }} --}}
            </div>
        </div>
    </div>
@endsection