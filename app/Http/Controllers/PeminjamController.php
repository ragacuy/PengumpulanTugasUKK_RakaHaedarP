<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Alat;
use App\Models\Pengembalian;

class PeminjamController extends Controller
{
    /**
     * =========================
     * DASHBOARD PEMINJAM
     * =========================
     */
    public function index()
    {
        return view('peminjam.dashboard');
    }

    /**
     * =========================
     * LIST ALAT YANG BISA DIPINJAM
     * =========================
     */
    public function alat()
    {
        $alat = Alat::with('kategori')
            ->where('stok', '>', 0)
            ->get();

        return view('peminjam.alat', compact('alat'));
    }

    /**
     * =========================
     * AJUKAN PEMINJAMAN
     * STOK LANGSUNG DIKURANGI (BOOKING)
     * =========================
     */
    public function store(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah'  => 'required|integer|min:1'
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        // cek stok
        if ($alat->stok < $request->jumlah) {
            return back()->with('error', 'Stok alat tidak mencukupi');
        }

        /**
         * 🔴 BOOKING STOK
         * (SENGAJA DI SINI, SAMA KAYAK ADMIN CREATE)
         */
        $alat->stok -= $request->jumlah;
        $alat->save();

        // header peminjaman
        $peminjaman = Peminjaman::create([
    'user_id'                 => auth()->id(),
    'alat_id'                 => $alat->id,        // 🔥 WAJIB
    'jumlah'                  => $request->jumlah, // 🔥 WAJIB
    'tanggal_pinjam'          => now(),
    'tanggal_rencana_kembali' => now()->addDays(3),
    'status'                  => 'pending'
]);


        // detail peminjaman
        DetailPeminjaman::create([
            'peminjaman_id' => $peminjaman->id,
            'alat_id'       => $alat->id,
            'jumlah'        => $request->jumlah
        ]);

        return back()->with(
            'success',
            'Peminjaman berhasil diajukan. Menunggu persetujuan petugas.'
        );
    }

    /**
     * =========================
     * RIWAYAT PEMINJAMAN SAYA
     * =========================
     */
    public function peminjamanSaya()
    {
        $data = Peminjaman::with('details.alat.kategori')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('peminjam.peminjaman', compact('data'));
    }

    /**
     * =========================
     * KEMBALIKAN ALAT (OLEH PEMINJAM)
     * HANYA JIKA SUDAH DISETUJUI
     * =========================
     */
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::with('details')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'disetujui')
            ->firstOrFail();

        // update status peminjaman
        $peminjaman->update([
            'status'          => 'dikembalikan',
            'tanggal_kembali' => now()
        ]);

        // kembalikan stok alat
        foreach ($peminjaman->details as $detail) {
            $alat = Alat::find($detail->alat_id);
            if ($alat) {
                $alat->stok += $detail->jumlah;
                $alat->save();
            }
        }

        // catat pengembalian
        Pengembalian::create([
            'peminjaman_id'   => $peminjaman->id,
            'tanggal_kembali' => now(),
            'kondisi_kembali' => 'Baik',
            'denda'           => 0,
            'diterima_oleh'   => auth()->user()->name // biar ga error SQL
        ]);

        return back()->with('success', 'Alat berhasil dikembalikan. Terima kasih.');
    }
}
