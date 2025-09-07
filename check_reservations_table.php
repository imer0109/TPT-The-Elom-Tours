<?php
require 'vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Vérifier si la table reservations existe
if (Schema::hasTable('reservations')) {
    echo "La table 'reservations' existe.\n\n";
    
    // Afficher les colonnes de la table
    echo "Colonnes dans la table 'reservations':\n";
    $columns = Schema::getColumnListing('reservations');
    foreach ($columns as $column) {
        echo "- $column\n";
    }
    
    // Afficher les données de la table
    echo "\nDonnées dans la table 'reservations':\n";
    $reservations = DB::table('reservations')->get();
    
    if (count($reservations) > 0) {
        foreach ($reservations as $reservation) {
            echo "ID: {$reservation->id}\n";
            echo "-----------------------------------\n";
        }
    } else {
        echo "Aucune donnée dans la table.\n";
    }
} else {
    echo "La table 'reservations' n'existe pas.\n";
    
    // Lister toutes les tables existantes
    echo "\nListe des tables existantes dans la base de données:\n";
    $tables = DB::select('SHOW TABLES');
    foreach ($tables as $table) {
        $tableName = array_values((array) $table)[0];
        echo "- $tableName\n";
    }
}