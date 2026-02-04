<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;

class Alat extends Model
{
    protected $fillable = ['nama_alat', 'stok', 'kondisi', 'kategori_id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
