<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('application_id')
                ->constrained('internship_applications')
                ->cascadeOnDelete();

            $table->integer('rating');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('application_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
