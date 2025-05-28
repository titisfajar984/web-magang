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
        Schema::create('finalreport', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')
                ->constrained('internship_applications')
                ->cascadeOnDelete();
            $table->string('description');
            $table->string('file_path')->nullable();
            $table->date('submission_date')->nullable();
            $table->enum('status', ['submitted', 'reviewed', 'approved', 'rejected'])->default('submitted');
            $table->text('feedback')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('application_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finalreport');
    }
};
