<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('admin123'),
        'role' => 'admin'
    ]);

    User::create([
        'name' => 'Petugas',
        'email' => 'petugas@gmail.com',
        'password' => Hash::make('petugas123'),
        'role' => 'petugas'
    ]);

    User::create([
        'name' => 'Peminjam',
        'email' => 'peminjam@gmail.com',
        'password' => Hash::make('peminjam123'),
        'role' => 'peminjam'
    ]);
}
}
