<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\ParticipantProfile;
use App\Models\InternshipPosting;

class InternshipApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $participants = ParticipantProfile::limit(10)->get();
        $postings = InternshipPosting::limit(10)->get();

        foreach ($participants as $participant) {
            $posting = $postings->random();

            DB::table('internship_applications')->insert([
                'id' => Str::uuid(),
                'participant_id' => $participant->id,
                'internship_posting_id' => $posting->id,
                'status' => $faker->randomElement(['pending', 'accepted', 'rejected']),
                'tanggal' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
