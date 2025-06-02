<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $roles = ['admin', 'company', 'participant'];

        foreach ($roles as $role) {
            $count = $role === 'admin' ? 1 : 10;
            for ($i = 1; $i <= $count; $i++) {
                User::create([
                    'id' => Str::uuid(),
                    'name' => $faker->name,
                    'email' => strtolower($role . $i . '@example.com'),
                    'password' => Hash::make('password'),
                    'role' => $role,
                ]);
            }
        }

    }
}
