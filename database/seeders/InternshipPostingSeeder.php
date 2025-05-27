<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\CompanyProfile;

class InternshipPostingSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil 10 company profiles
        $companies = CompanyProfile::limit(10)->get();

        foreach ($companies as $company) {
            DB::table('internship_postings')->insert([
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'title' => $faker->jobTitle,
                'description' => $faker->paragraph,
                'quota' => $faker->numberBetween(1, 5),
                'location' => $faker->city,
                'start_date' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
                'end_date' => $faker->dateTimeBetween('+2 months', '+3 months')->format('Y-m-d'),
                'status' => $faker->randomElement(['active', 'inactive']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
