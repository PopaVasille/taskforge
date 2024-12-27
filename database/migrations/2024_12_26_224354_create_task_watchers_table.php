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
        Schema::create('task_watchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('notification_level', [
                'all',
                'important',
                'none',
                'mentions_only',
                'status_changes',
                'updates_only',
                'comments_only',
                'custom'
            ])->default('all');
            $table->json('custom_preferences')->nullable();
            $table->timestamps();

            $table->unique(['task_id', 'user_id'], 'unique_task_watcher');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_watchers');
    }
};
