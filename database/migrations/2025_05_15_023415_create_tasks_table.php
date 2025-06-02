<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('application_id')
                ->constrained('internship_applications')
                ->cascadeOnDelete();

            $table->string('name');
            $table->text('description');
            $table->date('deadline');
            $table->string('file_path')->nullable();
            $table->enum('status', ['To Do', 'In Progress', 'Done']);
            $table->timestamps();
            $table->softDeletes();

            $table->index('application_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
