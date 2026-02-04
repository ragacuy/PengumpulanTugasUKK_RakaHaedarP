<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.activity.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy(string $id)
{
    $log = ActivityLog::findOrFail($id);

    // simpan info sebelum dihapus (kalau mau ditampilkan)
    $aksi = $log->aksi;
    $deskripsi = $log->deskripsi;

    $log->delete();

    return back()->with('success', 'Log aktivitas berhasil dihapus: ' . $aksi);
}

}
