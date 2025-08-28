<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Vérifier si la colonne is_active existe dans la table categories
$columns = Schema::getColumnListing('categories');
echo "Colonnes de la table categories : " . implode(', ', $columns) . "\n";

// Vérifier si la colonne is_active existe spécifiquement
if (Schema::hasColumn('categories', 'is_active')) {
    echo "La colonne 'is_active' existe dans la table categories.\n";
} else {
    echo "La colonne 'is_active' N'EXISTE PAS dans la table categories.\n";
    
    // Afficher la structure complète de la table
    echo "\nStructure détaillée de la table categories:\n";
    $structure = DB::select('DESCRIBE categories');
    print_r($structure);
}