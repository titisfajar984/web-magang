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
        Schema::create('task_submissions', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('task_id');
        $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        $table->uuid('user_id');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->string('submission_text');
        $table->string('attachment_file')->nullable();
        $table->date('submission_date');
        $table->enum('status', ['Submitted', 'Late'])->nullable();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_submissions');
    }
};
