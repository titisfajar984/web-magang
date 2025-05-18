<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('task_id')
                ->constrained('tasks')
                ->cascadeOnDelete();

            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('submission_text');
            $table->string('attachment_file')->nullable();
            $table->date('submission_date');
            $table->enum('status', ['Submitted', 'Late'])->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['task_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_submissions');
    }
};
