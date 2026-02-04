<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Alat;
use App\Models\ActivityLog;
use App\Models\DetailPeminjaman;


class PeminjamanController extends Controller
{
    // =========================
    // ADMIN - LIST DATA
    // =========================
    public function index()
    {
        $data = Peminjaman::with('user')->latest()->get();
        return view('admin.peminjaman.index', compact('data'));
    }

    // =========================
    // ADMIN - FORM CREATE
    // =========================
    public function create()
    {
        $users = User::where('role','peminjam')->get();
        $alats = Alat::with('kategori')->get();

        return view('admin.peminjaman.create', compact('users','alats'));
    }

    // =========================
    // ADMIN - SIMPAN (STATUS MENUNGGU)
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_rencana_kembali' => 'required|date'
        ]);

        // CEK STOK DULU
        $alat = Alat::findOrFail($request->alat_id);
        if ($alat->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak cukup! Sisa stok: ' . $alat->stok);
        }

        // KURANGI STOK LANGSUNG DI SINI (Booking)
        $alat->stok -= $request->jumlah;
        $alat->save();

        // header peminjaman
        $pinjam = Peminjaman::create([
            'user_id' => $request->user_id,
            'alat_id' => $request->alat_id, // Opsional jika sudah pakai detail, tapi di DB sepertinya ada
            'jumlah' => $request->jumlah,   // Opsional jika sudah pakai detail
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_rencana_kembali' => $request->tanggal_rencana_kembali,
            'status' => 'pending'
        ]);

        DetailPeminjaman::create([
            'peminjaman_id' => $pinjam->id,
            'alat_id'       => $request->alat_id,
            'jumlah'        => $request->jumlah,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aksi' => 'Buat Peminjaman',
            'deskripsi' => 'Membuat peminjaman ID '.$pinjam->id.' (menunggu persetujuan)'
        ]);

        return redirect('/admin/peminjaman')
            ->with('success','Peminjaman dibuat, stok alat telah diamankan.');
    }

    // =========================
    // ADMIN - FORM EDIT
    // =========================
    public function edit($id)
    {
        $peminjaman = Peminjaman::with(['user','details.alat.kategori'])
                        ->findOrFail($id);

        $alats = Alat::with('kategori')->get();

        return view('admin.peminjaman.edit', compact('peminjaman','alats'));
    }


    // =========================
    // ADMIN - UPDATE DATA
    // =========================
    public function update(Request $request, $id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_rencana_kembali' => 'required|date',
            'status' => 'required|in:pending,disetujui,ditolak,dikembalikan'
        ]);

        // NOTE: update status via admin edit might bypass stock logic if changed abruptly.
        // For safety, let's keep it minimal or handle strict transitions.
        // Assuming admin only updates dates here, status changes should be via specific actions.

        $pinjam->update([
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_rencana_kembali' => $request->tanggal_rencana_kembali,
            'status' => $request->status
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aksi' => 'Update Peminjaman',
            'deskripsi' => 'Update peminjaman ID '.$pinjam->id.' | Status: '.$request->status
        ]);

        return redirect('/admin/peminjaman')
            ->with('success','Data peminjaman berhasil diperbarui');
    }

    // =========================
    // ADMIN - HAPUS JIKA MASIH MENUNGGU
    // =========================
    public function destroy($id)
    {
        $pinjam = Peminjaman::with('details')->findOrFail($id);

        // Jika status pending, berarti stok sudah dikurangi, jadi harus dikembalikan
        if($pinjam->status == 'pending'){
            // KEMBALIKAN STOK
            foreach ($pinjam->details as $detail) {
                $alat = Alat::find($detail->alat_id);
                if($alat) {
                    $alat->stok += $detail->jumlah;
                    $alat->save();
                }
            }
        } elseif($pinjam->status == 'disetujui') {
            // Jika membatalkan yang sudah disetujui (misal salah klik), kembalikan juga stoknya
             foreach ($pinjam->details as $detail) {
                 $alat = Alat::find($detail->alat_id);
                 if($alat) {
                     $alat->stok += $detail->jumlah;
                     $alat->save();
                 }
             }
         }
         // Jika 'ditolak' atau 'dikembalikan', stok aman.

        // hapus detail dulu
        DetailPeminjaman::where('peminjaman_id',$id)->delete();
        $pinjam->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aksi' => 'Hapus Peminjaman',
            'deskripsi' => 'Menghapus peminjaman ID '.$id
        ]);

        return back()->with('success','Data peminjaman dihapus dan stok dikembalikan (jika pending/disetujui).');
    }

    // =========================
    // PETUGAS - LIST UNTUK DIPROSES
    // =========================
    public function petugasIndex()
    {
        $data = Peminjaman::with(['user','details.alat'])
                    ->whereIn('status',['pending','disetujui'])
                    ->latest()
                    ->get();

        return view('petugas.peminjaman.index', compact('data'));
    }

    // =========================
    // PETUGAS - APPROVE
    // =========================
    public function approve($id)
    {
        $peminjaman = Peminjaman::with('details')->findOrFail($id);

        if($peminjaman->status != 'pending'){
            return back()->with('error','Sudah diproses');
        }

        // HAPUS LOGIKA PENGURANGAN STOK DARI SINI
        // Karena stok sudah dikurangi saat 'store' (pending)

        $peminjaman->update([
            'status' => 'disetujui',
            'disetujui_oleh' => auth()->id()
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aksi' => 'Approve Peminjaman',
            'deskripsi' => 'Menyetujui peminjaman ID '.$peminjaman->id
        ]);

        return back()->with('success','Peminjaman disetujui');
    }

    // =========================
    // PETUGAS - TOLAK PEMINJAMAN
    // =========================
    public function tolak(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('details')->findOrFail($id);

        if ($peminjaman->status != 'pending') {
            return back()->with('error', 'Peminjaman sudah diproses');
        }

        $request->validate([
            'catatan' => 'nullable|string|max:255'
        ]);

        // KEMBALIKAN STOK KARENA DITOLAK
        foreach ($peminjaman->details as $detail) {
            $alat = Alat::find($detail->alat_id);
            if($alat) {
                $alat->stok += $detail->jumlah;
                $alat->save();
            }
        }

        $peminjaman->update([
            'status' => 'ditolak',
            'ditolak_oleh' => auth()->id(),
            'catatan' => $request->catatan
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'aksi' => 'Tolak Peminjaman',
            'deskripsi' => 'Menolak peminjaman ID '.$peminjaman->id
        ]);

        return back()->with('success', 'Peminjaman ditolak, stok alat dikembalikan.');
    }

}
