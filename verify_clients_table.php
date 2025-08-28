<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "Vérification de la table clients...\n";

// Vérifier si la table clients existe
if (Schema::hasTable('clients')) {
    echo "La table 'clients' existe.\n";
    
    // Vérifier la structure de la table
    echo "\nStructure de la table clients:\n";
    $columns = Schema::getColumnListing('clients');
    echo "Colonnes: " . implode(', ', $columns) . "\n";
    
    // Tester la requête problématique
    echo "\nTest de la requête: select * from clients where clients.deleted_at is null order by nom asc\n";
    try {
        $results = DB::select("select * from clients where clients.deleted_at is null order by nom asc");
        echo "Requête exécutée avec succès. Nombre de résultats: " . count($results) . "\n";
    } catch (Exception $e) {
        echo "Erreur lors de l'exécution de la requête: " . $e->getMessage() . "\n";
    }
} else {
    echo "La table 'clients' n'existe pas.\n";
}

echo "\nVérification terminée.\n";