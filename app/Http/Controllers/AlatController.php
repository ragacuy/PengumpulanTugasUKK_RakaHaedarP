<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\ActivityLog;



class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alats = Alat::with('kategori')->get();
        $alats = Alat::all();
        return view('admin.alat.index', compact('alats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
      return view('admin.alat.create', [
    'kategoris' => $kategoris,
    'stokMaks' => 10,
]);

ActivityLog::create([
    'user_id' => auth()->id(),
    'aksi' => 'Tambah User',
    'deskripsi' => 'Menambahkan user: ' . $user->name,
]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $stokMaks = 10;

        $request->validate([
            'nama_alat'   => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok'        => 'required|integer|min:1|max:' . $stokMaks,
            'kondisi'     => 'required'
        ]);

        $alat = Alat::create([
            'nama_alat'   => $request->nama_alat,
            'kategori_id' => $request->kategori_id,
            'stok'        => $request->stok,
            'kondisi'     => $request->kondisi
        ]);

        // LOG AKTIVITAS
        ActivityLog::create([
            'user_id'   => auth()->id(),
            'aksi'      => 'Tambah Alat',
            'deskripsi' => 'Menambahkan alat: ' . $alat->nama_alat . ' (ID: ' . $alat->id . ')',
        ]);

        return redirect('/admin/alat')->with('success', 'Alat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $alat = Alat::findorFail($id);
        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(Request $request, string $id)
    {
        $alat = Alat::findOrFail($id);

        $request->validate([
            'nama_alat' => 'required',
            'stok'      => 'required|integer|min:0',
            'kondisi'   => 'required'
        ]);

        $alat->update([
            'nama_alat' => $request->nama_alat,
            'stok'      => $request->stok,
            'kondisi'   => $request->kondisi
        ]);

        // LOG AKTIVITAS
        ActivityLog::create([
            'user_id'   => auth()->id(),
            'aksi'      => 'Update Alat',
            'deskripsi' => 'Mengubah data alat: ' . $alat->nama_alat . ' (ID: ' . $alat->id . ')',
        ]);

        return redirect('/admin/alat')->with('success', 'Data alat berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id)
    {
        $alat = Alat::findOrFail($id);
        $namaAlat = $alat->nama_alat;

        $alat->delete();

        // LOG AKTIVITAS
        ActivityLog::create([
            'user_id'   => auth()->id(),
            'aksi'      => 'Hapus Alat',
            'deskripsi' => 'Menghapus alat: ' . $namaAlat . ' (ID: ' . $id . ')',
        ]);

        return back()->with('success', 'Data alat berhasil dihapus');
    }
}
