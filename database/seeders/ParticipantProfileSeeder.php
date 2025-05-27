<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;

class ParticipantProfileSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil 10 user dengan role participant
        $participants = User::where('role', 'participant')->limit(10)->get();

        foreach ($participants as $user) {
            DB::table('participant_profiles')->insert([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'birth_date' => $faker->date('Y-m-d', '2003-01-01'),
                'gender' => $faker->randomElement(['male', 'female']),
                'university' => $faker->company . ' University',
                'study_program' => $faker->randomElement(['Computer Science', 'Business', 'Engineering', 'Design']),
                'portfolio_url' => $faker->url,
                'photo' => null,
                'cv' => null,
                'gpa' => $faker->randomFloat(2, 2.0, 4.0),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
