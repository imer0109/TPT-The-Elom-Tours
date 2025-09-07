<?php

require 'vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Vérifier la structure de la table comments
echo "Structure de la table comments:\n";
$columns = \Illuminate\Support\Facades\Schema::getColumnListing('comments');
echo "Colonnes existantes: " . implode(', ', $columns) . "\n\n";

// Vérifier si la colonne is_approved existe
if (in_array('is_approved', $columns)) {
    echo "La colonne 'is_approved' existe dans la table comments.\n";
} else {
    echo "La colonne 'is_approved' n'existe PAS dans la table comments.\n";
    
    // Afficher les migrations disponibles pour comments
    echo "\nRecherche des migrations liées à la table comments...\n";
    $migrationFiles = glob(__DIR__ . '/database/migrations/*_*_comments_*.php');
    
    if (count($migrationFiles) > 0) {
        echo "Migrations trouvées:\n";
        foreach ($migrationFiles as $file) {
            echo "- " . basename($file) . "\n";
        }
    } else {
        echo "Aucune migration spécifique aux commentaires trouvée.\n";
    }
}