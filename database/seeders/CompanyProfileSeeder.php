<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil 10 user dengan role company
        $companies = User::where('role', 'company')->limit(10)->get();

        foreach ($companies as $user) {
            DB::table('company_profiles')->insert([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'name' => $faker->company,
                'description' => $faker->paragraph,
                'address' => $faker->address,
                'logo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
