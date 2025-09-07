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
        if (!Schema::hasTable('reservations')) {
            Schema::create('reservations', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('circuit_id');
                $table->uuid('client_id')->nullable();
                $table->date('date_debut');
                $table->date('date_fin')->nullable();
                $table->decimal('montant_total', 10, 2)->default(0);
                $table->string('reference')->nullable()->unique();
                $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
                
                // Ajouter les clés étrangères
                $table->foreign('circuit_id')
                      ->references('id')
                      ->on('circuits')
                      ->onDelete('cascade');
                      
                if (Schema::hasTable('clients')) {
                    $table->foreign('client_id')
                          ->references('id')
                          ->on('clients')
                          ->onDelete('set null');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};