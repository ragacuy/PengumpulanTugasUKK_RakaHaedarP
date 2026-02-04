<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
   Schema::create('pengembalians', function (Blueprint $table) {
    $table->id();

    // INI YANG WAJIB ADA
    $table->foreignId('peminjaman_id')
        ->constrained('peminjamans')
        ->cascadeOnDelete();

    $table->date('tanggal_kembali');

    $table->enum('kondisi_kembali', [
        'Baik',
        'Rusak Ringan',
        'Rusak Berat'
    ]);

    $table->integer('denda')->default(0);

    $table->foreignId('diterima_oleh')
        ->constrained('users')
        ->cascadeOnDelete();

    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
