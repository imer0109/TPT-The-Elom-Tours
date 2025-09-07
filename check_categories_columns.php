<?php
require 'vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Vérifier si la table categories existe
if (Schema::hasTable('categories')) {
    echo "La table 'categories' existe.\n\n";
    
    // Vérifier si les colonnes existent
    echo "Colonnes dans la table 'categories':\n";
    $columns = Schema::getColumnListing('categories');
    foreach ($columns as $column) {
        echo "- $column\n";
    }
    
    echo "\n";
    
    // Vérifier spécifiquement les colonnes 'nom' et 'est_actif'
    if (Schema::hasColumn('categories', 'nom')) {
        echo "La colonne 'nom' existe dans la table 'categories'.\n";
    } else {
        echo "La colonne 'nom' N'EXISTE PAS dans la table 'categories'.\n";
    }
    
    if (Schema::hasColumn('categories', 'est_actif')) {
        echo "La colonne 'est_actif' existe dans la table 'categories'.\n";
    } else {
        echo "La colonne 'est_actif' N'EXISTE PAS dans la table 'categories'.\n";
    }
    
    // Afficher les données de la table
    echo "\nDonnées dans la table 'categories':\n";
    $categories = DB::table('categories')->get();
    
    if (count($categories) > 0) {
        foreach ($categories as $category) {
            echo "ID: {$category->id}\n";
            echo "Name: " . ($category->name ?? 'NULL') . "\n";
            echo "Nom: " . ($category->nom ?? 'NULL') . "\n";
            echo "Slug: " . ($category->slug ?? 'NULL') . "\n";
            echo "Description: " . ($category->description ?? 'NULL') . "\n";
            echo "Is Active: " . ($category->is_active ? 'true' : 'false') . "\n";
            echo "Est Actif: " . (isset($category->est_actif) ? ($category->est_actif ? 'true' : 'false') : 'NULL') . "\n";
            echo "-----------------------------------\n";
        }
    } else {
        echo "Aucune donnée dans la table.\n";
    }
} else {
    echo "La table 'categories' n'existe pas.\n";
}