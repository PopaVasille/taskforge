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
        Schema::create('project_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['owner', 'admin', 'member', 'viewer']);
            $table->json('permissions')->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->datetime('access_start')->nullable();
            $table->datetime('access_end')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'user_id']);
            $table->index(['project_id', 'role']);

            $table->unique(['project_id', 'user_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_members');
    }
};
