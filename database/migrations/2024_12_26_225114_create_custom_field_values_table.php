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
        Schema::create('custom_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained('custom_fields')->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->json('value')->nullable();
            $table->json('old_values')->nullable();
            $table->foreignId('last_updated_by')->nullable()->constrained('users');
            $table->text('change_reason')->nullable();
            $table->boolean('is_valid')->default(true);
            $table->timestamps();


            $table->index(['field_id', 'task_id']);
            $table->index(['task_id', 'field_id']);
            $table->index('last_updated_by');


            $table->unique(['field_id', 'task_id'], 'unique_field_value_per_task');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_field_values');
    }
};
