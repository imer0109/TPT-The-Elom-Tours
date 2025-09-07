<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Vérifier si la table categories existe
if (Schema::hasTable('categories')) {
    echo "La table 'categories' existe.\n";
    
    // Récupérer les colonnes de la table categories
    $columns = Schema::getColumnListing('categories');
    
    echo "Colonnes de la table 'categories':\n";
    foreach ($columns as $column) {
        echo "- $column\n";
    }
    
    // Vérifier si la colonne created_at existe
    if (in_array('created_at', $columns)) {
        echo "\nLa colonne 'created_at' existe dans la table.\n";
    } else {
        echo "\nLa colonne 'created_at' n'existe PAS dans la table.\n";
    }
} else {
    echo "La table 'categories' n'existe pas.\n";
}

// Vérifier les données existantes dans la table categories
echo "\nDonnées dans la table 'categories':\n";
try {
    $categories = DB::table('categories')->get();
    if ($categories->count() > 0) {
        foreach ($categories as $category) {
            echo "- ID: {$category->id}, ";
            // Afficher les autres colonnes disponibles
            foreach ((array)$category as $key => $value) {
                if ($key !== 'id') {
                    echo "$key: $value, ";
                }
            }
            echo "\n";
        }
    } else {
        echo "Aucune donnée dans la table.\n";
    }
} catch (\Exception $e) {
    echo "Erreur lors de la récupération des données: " . $e->getMessage() . "\n";
}