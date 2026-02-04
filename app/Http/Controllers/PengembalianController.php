<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    // ADMIN - form tambah pengembalian
    public function adminCreate()
    {
        $peminjamans = Peminjaman::with('user')
            ->where('status', 'disetujui')
            ->whereDoesntHave('pengembalian') // optional tapi cakep
            ->get();

        return view('admin.pengembalian.create', compact('peminjamans'));
    }

    // PETUGAS - form pengembalian
    public function create($peminjaman_id)
    {
        $peminjaman = Peminjaman::with('details.alat')
            ->where('status', 'disetujui')
            ->findOrFail($peminjaman_id);

        return view('petugas.pengembalian.create', compact('peminjaman'));
    }



    // PETUGAS - simpan pengembalian
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'kondisi_kembali' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'tanggal_kembali' => 'required|date'
        ]);

        $peminjaman = Peminjaman::with('details.alat')
            ->findOrFail($request->peminjaman_id);

        // =========================
        // HITUNG DENDA OTOMATIS
        // =========================
        // Gunakan tanggal dari input user
        $tanggalKembali = Carbon::parse($request->tanggal_kembali);
        $tanggalRencana = Carbon::parse($peminjaman->tanggal_rencana_kembali);

        $hariTelat = 0;
        if ($tanggalKembali->gt($tanggalRencana)) {
            $hariTelat = $tanggalRencana->diffInDays($tanggalKembali);
        }

        $denda = $hariTelat * 5000;

        // =========================
        // SIMPAN PENGEMBALIAN
        // =========================
        $kembali = Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_kembali' => $tanggalKembali,
            'kondisi_kembali' => $request->kondisi_kembali,
            'denda' => $denda,
            'diterima_oleh' => auth()->id()
        ]);

        // =========================
        // BALIKIN STOK ALAT
        // =========================
        foreach ($peminjaman->details as $detail) {
            $alat = $detail->alat;
            $alat->stok += $detail->jumlah;
            $alat->save();
        }

        // =========================
        // UPDATE STATUS PEMINJAMAN
        // =========================
        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        // =========================
        // LOG AKTIVITAS
        // =========================
        ActivityLog::create([
            'user_id' => auth()->id(),
            'aksi' => 'Proses Pengembalian',
            'deskripsi' =>
                'Pengembalian peminjaman ID ' . $peminjaman->id .
                ' | Telat: ' . $hariTelat . ' hari' .
                ' | Denda: Rp ' . number_format($denda)
        ]);

        // Redirect sesuai role
        $redirectRoute = auth()->user()->role === 'admin'
            ? '/admin/pengembalian'
            : '/petugas/peminjaman';

        return redirect($redirectRoute)
            ->with(
                'success',
                'Pengembalian diproses. ' .
                ($denda > 0
                    ? 'Denda: Rp ' . number_format($denda)
                    : 'Tidak ada denda')
            );
    }


    // ADMIN - daftar pengembalian
    public function adminIndex()
    {
        $data = Pengembalian::with([
            'peminjaman.user',        // untuk nama peminjam
            'peminjaman.details.alat',// untuk daftar alat
            'diterima'                // untuk user yang menerima
        ])
            ->latest()
            ->get();

        return view('admin.pengembalian.index', compact('data'));
    }

    public function edit($id)
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.details.alat',
            'diterima'
        ])->findOrFail($id);

        return view('admin.pengembalian.edit', compact('pengembalian'));
    }


    // PETUGAS - daftar pengembalian
    public function petugasIndex()
    {
        $data = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.details.alat',
            'diterima'
        ])
            ->latest()
            ->get();

        return view('petugas.pengembalian.index', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $pengembalian = Pengembalian::with('peminjaman')->findOrFail($id);

        $request->validate([
            'tanggal_kembali' => 'required|date',
            'kondisi_kembali' => 'required|in:Baik,Rusak Ringan,Rusak Berat'
        ]);

        // Hitung ulang denda
        $tanggalKembali = Carbon::parse($request->tanggal_kembali);
        $tanggalRencana = Carbon::parse($pengembalian->peminjaman->tanggal_rencana_kembali);

        $hariTelat = 0;
        if ($tanggalKembali->gt($tanggalRencana)) {
            $hariTelat = $tanggalRencana->diffInDays($tanggalKembali);
        }
        $denda = $hariTelat * 5000;

        $pengembalian->update([
            'tanggal_kembali' => $tanggalKembali,
            'kondisi_kembali' => $request->kondisi_kembali,
            'denda' => $denda
        ]);

        return redirect('/admin/pengembalian')
            ->with('success', 'Data pengembalian diperbarui. Denda: Rp ' . number_format($denda));
    }

    // ADMIN - Hapus Pengembalian (Rollback)
    public function destroy($id)
    {
        $pengembalian = Pengembalian::with('peminjaman.details.alat')->findOrFail($id);
        $peminjaman = $pengembalian->peminjaman;

        // 1. Rollback Stok (STOK BERKURANG KEMBALI)
        foreach ($peminjaman->details as $detail) {
            $alat = $detail->alat;
            // Kurangi stok karena batal dikembalikan
            $alat->stok -= $detail->jumlah;
            $alat->save();
        }

        // 2. Rollback Status Peminjaman -> 'disetujui'
        $peminjaman->update([
            'status' => 'disetujui'
        ]);

        // 3. Hapus Log Activity (Optional, tapi bagusnya dihapus atau dicatat log baru. Kita log baru saja)
        ActivityLog::create([
            'user_id' => auth()->id(),
            'aksi' => 'Hapus Pengembalian',
            'deskripsi' => 'Membatalkan pengembalian ID ' . $pengembalian->id
        ]);

        // 4. Hapus Data
        $pengembalian->delete();

        return redirect('/admin/pengembalian')
            ->with('success', 'Data pengembalian dihapus. Status peminjaman kembali menjadi disetujui.');
    }

}
