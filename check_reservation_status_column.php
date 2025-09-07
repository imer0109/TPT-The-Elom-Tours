<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Vérifier si la table reservations existe
if (Schema::hasTable('reservations')) {
    echo "La table 'reservations' existe.\n";
    
    // Liste des colonnes
    $columns = Schema::getColumnListing('reservations');
    echo "Colonnes présentes : \n";
    print_r($columns);
    
    // Vérifier spécifiquement status
    if (in_array('status', $columns)) {
        echo "SUCCÈS : La colonne 'status' existe bien dans la table reservations.\n";
        
        // Vérifier les valeurs possibles
        $types = DB::select("SHOW COLUMNS FROM reservations WHERE Field = 'status'");
        if (!empty($types)) {
            echo "Type de la colonne 'status' : " . $types[0]->Type . "\n";
        }
    } else {
        echo "ERREUR : La colonne 'status' est absente.\n";
        
        // Vérifier si statut existe encore
        if (in_array('statut', $columns)) {
            echo "ATTENTION : La colonne 'statut' existe toujours.\n";
        }
    }
} else {
    echo "ERREUR : La table 'reservations' n'existe pas.\n";
}