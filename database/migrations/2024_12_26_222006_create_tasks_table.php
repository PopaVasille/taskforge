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
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', [
                'backlog',
                'todo',
                'in_progress',
                'blocked',
                'under_review',
                'ready_for_testing',
                'in_testing',
                'rejected',
                'ready_for_deployment',
                'done',
                'closed',
                'reopened'
            ]);
            $table->enum('priority', ['low', 'medium', 'high', 'urgent']);
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('sprint_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->datetime('due_date')->nullable();
            $table->integer('estimated_hours')->nullable();
            $table->integer('actual_hours')->nullable();
            $table->integer('story_points')->nullable();
            $table->foreignId('parent_task_id')->nullable()->constrained('tasks')->nullOnDelete();
            $table->enum('type', ['epic', 'story', 'task', 'bug']);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('project_id');
            $table->index('sprint_id');
            $table->index('assigned_to');
            $table->index(['project_id', 'status']);
            $table->index(['due_date', 'status']);
            $table->index(['created_by', 'status']);
            $table->index(['type', 'status']);
            $table->index(['assigned_to', 'due_date']);
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
