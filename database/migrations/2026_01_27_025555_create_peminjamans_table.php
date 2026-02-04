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
      Schema::create('peminjamans', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('alat_id')
        ->constrained('alats')
        ->cascadeOnDelete();

    $table->integer('jumlah');

    $table->date('tanggal_pinjam');

    $table->enum('status', [
        'pending',
        'disetujui',
        'ditolak',
        'dikembalikan'
    ])->default('pending');

    $table->foreignId('disetujui_oleh')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
