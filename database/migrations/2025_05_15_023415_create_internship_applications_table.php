<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internship_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('participant_id')
                ->constrained('participant_profiles')
                ->cascadeOnDelete();

            $table->foreignUuid('internship_posting_id')
                ->constrained('internship_postings')
                ->cascadeOnDelete();

            $table->enum('status', ['pending', 'accepted', 'rejected']);
            $table->date('tanggal');
            $table->timestamps();

            // Opsional, jika butuh index gabungan dan ingin aman:
            // $table->index(['participant_id', 'internship_posting_id'], 'app_participant_posting_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internship_applications');
    }
};
