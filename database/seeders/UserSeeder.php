<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'id' => Str::uuid(),
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Ganti dengan password aman
            'role' => 'admin',
        ]);

        // Company
        User::create([
            'id' => Str::uuid(),
            'name' => 'Perusahaan User',
            'email' => 'perusahaan@example.com',
            'password' => Hash::make('password'),
            'role' => 'company',
        ]);

        // Participant
        User::create([
            'id' => Str::uuid(),
            'name' => 'Peserta User',
            'email' => 'peserta@example.com',
            'password' => Hash::make('password'),
            'role' => 'participant',
        ]);
    }
}
