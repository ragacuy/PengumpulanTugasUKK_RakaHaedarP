@extends('layouts.app')

@section('title','Data User')

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-0 text-dark">Data User</h3>
            <p class="text-muted small mb-0">Kelola data pengguna sistem</p>
        </div>
        <div class="col-auto">
            <a href="/admin/user/create" class="btn btn-primary rounded-pill shadow-sm px-4">
                <i class="bi bi-plus-lg me-2"></i>Tambah User
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
                            <th class="border-0 py-3 ps-4 rounded-start-4 text-secondary text-uppercase small fw-semibold">User</th>
                            <th class="border-0 py-3 text-secondary text-uppercase small fw-semibold">Role</th>
                            <th class="border-0 py-3 text-secondary text-uppercase small fw-semibold">Informasi</th>
                            <th class="border-0 py-3 pe-4 rounded-end-4 text-end text-secondary text-uppercase small fw-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=random&color=ffffff&size=48"
                                                alt="{{ $u->name }}" class="rounded-circle" width="48"
                                                height="48">
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bold text-dark">{{ $u->name }}</h6>
                                            <small class="text-muted text-truncate d-block" style="max-width: 250px;">
                                                ID: #{{ $u->id }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($u->role == 'admin')
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2">
                                            <i class="bi bi-shield-check me-1"></i> Admin
                                        </span>
                                    @elseif ($u->role == 'petugas')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                           <i class="bi bi-person-workspace me-1"></i> Petugas
                                        </span>
                                    @else
                                         <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-2">
                                            <i class="bi bi-person me-1"></i> User
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="bi bi-envelope me-2"></i> {{ $u->email }}
                                    </div>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="/admin/user/{{ $u->id }}/edit"
                                            class="btn btn-outline-warning btn-sm" data-bs-toggle="tooltip"
                                            title="Edit User">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="/admin/user/{{ $u->id }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $u->name }}? Data yang dihapus tidak dapat dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-outline-danger btn-sm rounded-end"
                                                onclick="if(confirm('Hapus user {{ $u->name }}?')) this.closest('form').submit()">
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
            
            @if($users->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-people text-muted display-1"></i>
                    </div>
                    <h5 class="text-muted">Belum ada data user</h5>
                </div>
            @endif
        </div>
    </div>
@endsection
