<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\PeminjamController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

/*
|--------------------------------------------------------------------------
| SEMUA YANG SUDAH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin + 5 log terakhir
    Route::get('/admin', function () {
        $logs = \App\Models\ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('logs'));
    });

    // ======================
    // CRUD USER
    // ======================
    Route::resource('/admin/user', UserController::class)
        ->except(['show']);

    // ======================
    // CRUD ALAT
    // ======================
    Route::resource('/admin/alat', AlatController::class)
        ->except(['show']);

    // ======================
    // CRUD KATEGORI
    // ======================
    Route::resource('/admin/kategori', KategoriController::class)
        ->except(['show']);

    // ======================
    // CRUD DATA PEMINJAMAN (ADMIN hanya kelola data)
    // ======================
    Route::resource('/admin/peminjaman', PeminjamanController::class)
        ->except(['show']);



    // ======================
    // MONITOR DATA PENGEMBALIAN (read only)
    // ======================
    Route::get('admin/pengembalian', [PengembalianController::class, 'adminIndex'])
        ->name('admin.pengembalian.index')
        ->middleware('role:admin');

    Route::get('admin/pengembalian/create', [PengembalianController::class, 'adminCreate'])
        ->name('admin.pengembalian.create')
        ->middleware('role:admin');

    Route::get('admin/pengembalian/{id}/edit', [PengembalianController::class, 'edit']);
    Route::post('/admin/pengembalian', [PengembalianController::class, 'store']);
    Route::put('admin/pengembalian/{id}', [PengembalianController::class, 'update']);
    Route::delete('admin/pengembalian/{id}', [PengembalianController::class, 'destroy']);






    // ======================
    // LOG AKTIVITAS
    // ======================
    Route::resource('/admin/activity', ActivityController::class)
        ->only(['index', 'destroy']);
});

/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas'])->group(function () {

    Route::get('/petugas', function () {
        $pending = \App\Models\Peminjaman::where('status', 'pending')->count();
        $active = \App\Models\Peminjaman::where('status', 'disetujui')->count();
        $completed = \App\Models\Peminjaman::where('status', 'kembali')->count();

        $recent = \App\Models\Peminjaman::with(['user', 'alat'])
            ->latest()
            ->take(5)
            ->get();

        return view('petugas.dashboard', compact('pending', 'active', 'completed', 'recent'));
    });

    // Lihat daftar peminjaman untuk diproses
    Route::get('/petugas/peminjaman', [PeminjamanController::class, 'petugasIndex']);

    Route::get('petugas/pengembalian', [PengembalianController::class, 'petugasIndex'])
        ->name('petugas.pengembalian.index')
        ->middleware('role:petugas');

    // Setujui peminjaman
    Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve']);

    // PETUGAS - TOLAK PEMINJAMAN
    Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])
        ->middleware('role:petugas');


    // Tolak peminjaman (opsional kalau kamu bikin methodnya)
    Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject']);

    // Form pengembalian alat
    Route::get('/pengembalian/{id}/create', [PengembalianController::class, 'create']);

    // Simpan pengembalian alat
    Route::post('/pengembalian', [PengembalianController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| PEMINJAM
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:peminjam'])->group(function () {

    Route::get('/peminjam', fn() => view('peminjam.dashboard'));

    // Daftar Alat & Booking
    Route::get('/peminjam/alat', [PeminjamController::class, 'alat'])->name('peminjam.alat.index');
    Route::post('/peminjam/pinjam', [PeminjamController::class, 'store'])->name('peminjam.pinjam.store');

    // Riwayat Peminjaman
    Route::get('/peminjam/peminjaman', [PeminjamController::class, 'peminjamanSaya'])->name('peminjam.peminjaman.index');
    Route::post('/peminjam/kembalikan/{id}', [PeminjamController::class, 'kembalikan'])->name('peminjam.peminjaman.kembalikan');
});
