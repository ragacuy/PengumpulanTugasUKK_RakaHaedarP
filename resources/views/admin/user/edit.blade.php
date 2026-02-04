@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
@section('content')
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold mb-0 text-dark">Edit User</h3>
            <p class="text-muted small mb-0">Perbarui informasi pengguna</p>
        </div>
        <div class="col-auto">
            <a href="/admin/user" class="btn btn-secondary rounded-pill shadow-sm px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="/admin/user/{{ $user->id }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-person text-muted"></i>
                                </span>
                                <input type="text" name="name"
                                    class="form-control border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary"
                                    value="{{ $user->name }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-shield-lock text-muted"></i>
                                </span>
                                <select name="role"
                                    class="form-select border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary">
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                    <option value="peminjam" {{ $user->role == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email" name="email"
                                    class="form-control border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary"
                                    value="{{ $user->email }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password <small
                                    class="text-muted fw-normal">(Opsional)</small></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="bi bi-key text-muted"></i>
                                </span>
                                <input type="password" name="password"
                                    class="form-control border-start-0 rounded-end-3 ps-1 focus-ring focus-ring-primary"
                                    placeholder="Kosongkan jika tidak ingin mengubah password">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-success rounded-pill shadow-sm px-4">
                        <i class="bi bi-check-lg me-2"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection