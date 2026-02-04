@extends('layouts.app')

@section('title', 'Data Peminjam')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-0 text-dark">Data Peminjaman</h3>
            <p class="text-muted small mb-0">Kelola data peminjaman alat</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary rounded-pill shadow-sm px-4">
                <i class="bi bi-plus-lg me-2"></i>Buat Peminjaman
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 800px;">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary text-uppercase small fw-semibold">ID</th>
                            <th class="px-4 py-3 text-secondary text-uppercase small fw-semibold">Peminjam</th>
                            <th class="px-4 py-3 text-secondary text-uppercase small fw-semibold">Tanggal</th>
                            <th class="px-4 py-3 text-secondary text-uppercase small fw-semibold w-25">Alat & Jumlah</th>
                            <th class="px-4 py-3 text-secondary text-uppercase small fw-semibold text-center">Status</th>
                            <th class="px-4 py-3 text-secondary text-uppercase small fw-semibold text-end"
                                style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $p)
                            <tr>
                                <td class="px-4 text-muted">#{{ $p->id }}</td>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($p->user->name) }}&background=random"
                                                class="rounded-circle" width="32" height="32" alt="{{ $p->user->name }}">
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $p->user->name }}</div>
                                            <div class="small text-muted">User ID: {{ $p->user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">Pinjam:</small>
                                        <span
                                            class="fw-medium text-dark">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</span>
                                        <small class="text-muted mt-1">Kembali:</small>
                                        <span
                                            class="fw-medium text-danger">{{ \Carbon\Carbon::parse($p->tanggal_rencana_kembali)->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <ul class="list-group list-group-flush small">
                                        @foreach($p->details as $d)
                                            <li
                                                class="list-group-item bg-transparent px-0 py-1 border-0 d-flex justify-content-between">
                                                <span><i class="bi bi-tools text-primary me-2"></i>{{ $d->alat->nama_alat }}</span>
                                                <span
                                                    class="badge bg-secondary-subtle text-secondary rounded-pill">{{ $d->jumlah }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-4 text-center">
                                    @php
                                        $statusClass = match ($p->status) {
                                            'pending' => 'bg-warning-subtle text-warning-emphasis',
                                            'disetujui' => 'bg-primary-subtle text-primary-emphasis',
                                            'ditolak' => 'bg-danger-subtle text-danger-emphasis',
                                            'dikembalikan' => 'bg-success-subtle text-success-emphasis',
                                            default => 'bg-secondary-subtle text-secondary-emphasis'
                                        };
                                        $statusIcon = match ($p->status) {
                                            'pending' => 'bi-hourglass-split',
                                            'disetujui' => 'bi-check-circle',
                                            'ditolak' => 'bi-x-circle',
                                            'dikembalikan' => 'bi-box-seam',
                                            default => 'bi-question-circle'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill px-3 py-2">
                                        <i class="bi {{ $statusIcon }} me-1"></i>
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td class="px-4 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('peminjaman.edit', $p->id) }}" class="btn btn-sm btn-outline-warning"
                                            data-bs-toggle="tooltip" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        @if($p->status == 'pending')
                                            <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Hapus data peminjaman ini?')" data-bs-toggle="tooltip"
                                                    title="Hapus Data">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-2"><i class="bi bi-inbox fs-1"></i></div>
                                    Belum ada data peminjaman
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection