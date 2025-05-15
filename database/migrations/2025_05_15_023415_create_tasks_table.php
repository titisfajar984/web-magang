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
        Schema::create('tasks', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('intership_id');
        $table->foreign('intership_id')->references('id')->on('internship_postings')->onDelete('cascade');
        $table->string('name');
        $table->text('description');
        $table->date('deadline');
        $table->enum('status', ['To Do', 'In Progress', 'Done']);
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
