@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-clock-history me-2"></i>Log Aktivitas Sistem
                    </h5>
                    <span class="badge bg-light text-secondary rounded-pill px-3 py-2">
                        Total: {{ $logs->total() }} Data
                    </span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="py-3 ps-3">Waktu</th>
                                    <th class="py-3">User</th>
                                    <th class="py-3">Aksi</th>
                                    <th class="py-3">Deskripsi</th>
                                    <th class="py-3 text-end pe-3">Kontrol</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium text-dark">{{ $log->created_at->format('d M Y') }}</span>
                                                <small class="text-muted">{{ $log->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 32px; height: 32px; font-size: 0.8rem; font-weight: bold;">
                                                    {{ substr($log->user->name ?? '?', 0, 1) }}
                                                </div>
                                                <span
                                                    class="fw-medium text-dark">{{ $log->user->name ?? 'User Terhapus' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill">
                                                {{ $log->aksi }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-secondary small">{{ Str::limit($log->deskripsi, 50) }}</span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <form action="/admin/activity/{{ $log->id }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger border-0 rounded-circle"
                                                    onclick="return confirm('Yakin hapus log ini?')" title="Hapus Log">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486831.png" width="60"
                                                class="mb-3 opacity-50" alt="Empty">
                                            <p class="text-muted mb-0">Tidak ada aktivitas yang tercatat.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection