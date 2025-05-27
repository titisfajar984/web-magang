<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'company', 'participant'];
        foreach ($roles as $role) {
            $count = $role === 'admin' ? 2 : 10;
            for ($i = 1; $i <= $count; $i++) {
                User::create([
                    'id' => Str::uuid(),
                    'name' => ucfirst($role) . " User {$i}",
                    'email' => "{$role}{$i}@example.com",
                    'password' => Hash::make('password'),
                    'role' => $role,
                ]);
            }
        }
    }
}
