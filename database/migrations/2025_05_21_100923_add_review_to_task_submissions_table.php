<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_submissions', function (Blueprint $table) {
            $table->enum('review_status', ['approved', 'revision', 'pending'])->nullable()->after('status');
            $table->text('review_notes')->nullable()->after('review_status');
            $table->date('review_date')->nullable()->after('review_notes');
        });
    }

    public function down(): void
    {
        Schema::table('task_submissions', function (Blueprint $table) {
            $table->dropColumn(['review_status', 'review_notes', 'review_date']);
        });
    }
};

