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
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', [
                'text',
                'textarea',
                'number',
                'date',
                'select',
                'multi-select',
                'checkbox',
                'user'
            ]);
            $table->boolean('required')->default(false);
            $table->boolean('enabled')->default(true);
            $table->integer('position')->default(0);
            $table->json('options')->nullable();
            $table->json('validation_rules')->nullable();
            $table->text('description')->nullable();
            $table->boolean('global')->default(false);
            $table->json('default_value')->nullable();
            $table->boolean('searchable')->default(false);
            $table->timestamps();
            $table->softDeletes();


            $table->index(['project_id', 'enabled']);
            $table->index(['global', 'enabled']);


            $table->unique(['project_id', 'name', 'global'], 'unique_field_per_scope');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_fields');
    }
};
