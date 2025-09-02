<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Sauvegarder les données de la table paiements
        $paiements = DB::table('paiements')->get();

        // Supprimer la table paiements
        Schema::dropIfExists('paiements');

        // Supprimer la table temporaire si elle existe
        Schema::dropIfExists('reservations_new');

        // Créer une table temporaire avec la nouvelle structure
        Schema::create('reservations_new', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('circuit_id');
            $table->dateTime('date_debut');
            $table->integer('nombre_personnes');
            $table->string('nom');
            $table->string('email');
            $table->string('telephone');
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->string('reference')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // Copier les données
        DB::statement('INSERT INTO reservations_new (id, circuit_id, date_debut, nombre_personnes, nom, email, telephone, message, status, reference, created_at, updated_at, deleted_at) SELECT id, circuit_id, date_debut, nombre_personnes, nom, email, telephone, message, status, reference, created_at, updated_at, deleted_at FROM reservations');

        // Supprimer l'ancienne table reservations
        Schema::dropIfExists('reservations');

        // Renommer la nouvelle table
        Schema::rename('reservations_new', 'reservations');

        // Recréer la table paiements avec la bonne structure
        Schema::create('paiements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reservation_id');
            $table->decimal('montant', 10, 2);
            $table->string('mode_paiement');
            $table->string('statut_paiement');
            $table->string('reference_paiement');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('reservation_id')
                  ->references('id')
                  ->on('reservations')
                  ->onDelete('cascade');
        });

        // Restaurer les données de la table paiements
        foreach ($paiements as $paiement) {
            DB::table('paiements')->insert((array) $paiement);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cette migration ne peut pas être annulée de manière sûre
        throw new \Exception('Cette migration ne peut pas être annulée.');
    }
};