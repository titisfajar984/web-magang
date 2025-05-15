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
        Schema::create('internship_applications', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('participant_id');
        $table->foreign('participant_id')->references('id')->on('participant_profiles')->onDelete('cascade');
        $table->uuid('internship_posting_id');
        $table->foreign('internship_posting_id')->references('id')->on('internship_postings')->onDelete('cascade');
        $table->enum('status', ['Pending', 'Accepted', 'Rejected']);
        $table->date('tanggal');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_applications');
    }
};
