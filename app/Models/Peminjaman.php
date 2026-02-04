<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
     protected $table = 'peminjamans';
     
    protected $fillable = [
        'user_id',
        'alat_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function alat() {
        return $this->belongsTo(Alat::class);
    }

    public function pengembalian() {
        return $this->hasOne(Pengembalian::class);
    }

        // ini yang bikin $peminjaman->details hidup
    public function details()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }
}



