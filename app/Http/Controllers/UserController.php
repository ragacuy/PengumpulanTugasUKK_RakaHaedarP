<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // LIST USER
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    // FORM TAMBAH USER
    public function create()
    {
        return view('admin.user.create');
    }

    // SIMPAN USER BARU
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'role'     => 'required'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        // LOG AKTIVITAS
        ActivityLog::create([
            'user_id'   => auth()->id(),
            'aksi'      => 'Tambah User',
            'deskripsi' => 'Menambahkan user: ' . $user->name . ' (ID: ' . $user->id . ')',
        ]);

        return redirect('/admin/user')->with('success','User berhasil ditambahkan');
    }

    // FORM EDIT USER
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required'
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // LOG AKTIVITAS
        ActivityLog::create([
            'user_id'   => auth()->id(),
            'aksi'      => 'Update User',
            'deskripsi' => 'Mengubah user: ' . $user->name . ' (ID: ' . $user->id . ')',
        ]);

        return redirect('/admin/user')->with('success','User berhasil diupdate');
    }

    // HAPUS USER
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $nama = $user->name;

        $user->delete();

        // LOG AKTIVITAS
        ActivityLog::create([
            'user_id'   => auth()->id(),
            'aksi'      => 'Hapus User',
            'deskripsi' => 'Menghapus user: ' . $nama . ' (ID: ' . $id . ')',
        ]);

        return back()->with('success','User berhasil dihapus');
    }
}
