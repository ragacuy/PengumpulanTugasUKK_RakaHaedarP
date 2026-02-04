<div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden">
    <div
        class="card-header bg-white border-bottom border-light py-3 px-4 d-flex justify-content-between align-items-center">
        <div>
            <span class="text-muted small text-uppercase fw-bold me-2">ID: #{{ $p->id }}</span>
            <span class="text-muted small">
                <i class="bi bi-calendar-event me-1"></i>
                {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y, H:i') }}
            </span>
        </div>
        <div>
            @if($p->status == 'pending')
                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Menunggu Konfirmasi</span>
            @elseif($p->status == 'disetujui')
                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">Sedang Dipinjam</span>
            @elseif($p->status == 'ditolak')
                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Ditolak</span>
            @elseif($p->status == 'kembali')
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Selesai</span>
            @endif
        </div>
    </div>
    <div class="card-body px-4 py-3">
        <ul class="list-group list-group-flush">
            @foreach($p->details as $d)
                <li class="list-group-item border-0 px-0 py-2 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded p-2 me-3 text-primary">
                            <i class="bi bi-tools fs-5"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">{{ $d->alat->nama_alat }}</h6>
                            <small class="text-muted">Kategori: {{ $d->alat->kategori->nama_kategori ?? 'Umum' }}</small>
                        </div>
                    </div>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">
                        {{ $d->jumlah }} Unit
                    </span>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- ACTIONS FOOTER --}}
    @if($p->status == 'disetujui')
        <div class="card-footer bg-light border-0 py-3 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted"><i class="bi bi-clock-history me-1"></i> Harap kembalikan tepat waktu.</span>

                <form action="{{ route('peminjam.peminjaman.kembalikan', $p->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm"
                        onclick="return confirm('Kembalikan alat ini?')">
                        <i class="bi bi-box-arrow-in-left me-1"></i> Kembalikan
                    </button>
                </form>
            </div>
        </div>
    @elseif($p->status == 'pending')
        <div class="card-footer bg-light border-0 py-3 px-4 text-muted small">
            <i class="bi bi-info-circle me-1"></i> Menunggu persetujuan petugas.
        </div>
    @endif
</div>