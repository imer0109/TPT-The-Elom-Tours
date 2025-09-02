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
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });

        // Table pivot pour la relation many-to-many entre circuits et catégories
        Schema::create('circuit_categorie', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('circuit_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('categorie_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['circuit_id', 'categorie_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circuit_categorie');
        Schema::dropIfExists('categories');
    }
};
