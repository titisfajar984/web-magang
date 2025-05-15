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
        Schema::create('internship_postings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('company_id')->constrained('company_profiles')->onDelete('cascade');
        $table->string('judul');
        $table->text('deskripsi');
        $table->integer('kuota');
        $table->string('lokasi');
        $table->string('periode_mulai');
        $table->string('periode_selesai');
        $table->string('status');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_postings');
    }
};
