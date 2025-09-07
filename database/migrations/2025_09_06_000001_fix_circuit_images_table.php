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
        // Vérifier si la table circuit_images existe déjà
        if (!Schema::hasTable('circuit_images')) {
            Schema::create('circuit_images', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('circuit_id');
                $table->string('url');
                $table->string('alt')->nullable();
                $table->integer('ordre')->default(0);
                $table->timestamps();
                
                // Ajouter la clé étrangère manuellement
                $table->foreign('circuit_id')
                      ->references('id')
                      ->on('circuits')
                      ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ne pas supprimer la table si elle est utilisée par d'autres migrations
        // Schema::dropIfExists('circuit_images');
    }
};