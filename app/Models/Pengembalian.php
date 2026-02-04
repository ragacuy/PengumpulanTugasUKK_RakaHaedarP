<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali',
        'kondisi_kembali',
        'denda',
        'diterima_oleh'
    ];

    public function peminjaman() {
        return $this->belongsTo(Peminjaman::class);
    }

    
    public function diterima()
{
    return $this->belongsTo(User::class, 'diterima_oleh');
}

}

