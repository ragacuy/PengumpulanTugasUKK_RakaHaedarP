<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\ActivityLog;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori'
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'aksi'      => 'Tambah Kategori',
            'deskripsi' => 'Menambahkan kategori: ' . $kategori->nama_kategori . ' (ID: ' . $kategori->id . ')',
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'aksi'      => 'Update Kategori',
            'deskripsi' => 'Mengubah kategori: ' . $kategori->nama_kategori . ' (ID: ' . $kategori->id . ')',
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $nama = $kategori->nama_kategori;

        $kategori->delete();

        ActivityLog::create([
            'user_id'   => auth()->id(),
            'aksi'      => 'Hapus Kategori',
            'deskripsi' => 'Menghapus kategori: ' . $nama . ' (ID: ' . $id . ')',
        ]);

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
