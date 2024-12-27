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
        Schema::create('task_dependencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('dependent_task_id')->constrained('tasks')->onDelete('cascade');
            $table->enum('dependency_type', [
                'blocks',
                'is_blocked_by',
                'relates_to',
                'duplicates',
                'depends_on',
                'is_dependency_of',
                'parent_of',
                'child_of',
                'precedes',
                'follows',
                'is_related_to',
                'is_duplicated_by',
                'causes',
                'is_caused_by'
            ]);
            $table->timestamps();

            $table->unique(['task_id', 'dependent_task_id', 'dependency_type'], 'unique_task_dependency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_dependencies');
    }
};
