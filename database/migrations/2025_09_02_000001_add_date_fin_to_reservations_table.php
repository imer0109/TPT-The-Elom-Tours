<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ajouter la colonne date_fin comme nullable d'abord
        Schema::table('reservations', function (Blueprint $table) {
            $table->dateTime('date_fin')->nullable()->after('date_debut');
        });

        // Mettre à jour les enregistrements existants
        $reservations = DB::table('reservations')
            ->join('circuits', 'reservations.circuit_id', '=', 'circuits.id')
            ->select('reservations.id', 'reservations.date_debut', 'circuits.duree')
            ->whereNull('reservations.date_fin')
            ->get();

        foreach ($reservations as $reservation) {
            $date_fin = Carbon::parse($reservation->date_debut)
                ->addDays($reservation->duree - 1);

            DB::table('reservations')
                ->where('id', $reservation->id)
                ->update(['date_fin' => $date_fin]);
        }

        // Rendre la colonne non nullable après la mise à jour
        Schema::table('reservations', function (Blueprint $table) {
            $table->dateTime('date_fin')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('date_fin');
        });
    }
};