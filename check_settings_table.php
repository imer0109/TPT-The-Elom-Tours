<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Vérifier si la table settings existe
if (Schema::hasTable('settings')) {
    echo "La table 'settings' existe.\n";
    
    // Récupérer les colonnes de la table settings
    $columns = Schema::getColumnListing('settings');
    
    echo "Colonnes de la table 'settings':\n";
    foreach ($columns as $column) {
        echo "- $column\n";
    }
    
    // Vérifier si la colonne hero_title existe
    if (in_array('hero_title', $columns)) {
        echo "\nLa colonne 'hero_title' existe dans la table.\n";
    } else {
        echo "\nLa colonne 'hero_title' n'existe PAS dans la table.\n";
    }
} else {
    echo "La table 'settings' n'existe pas.\n";
}

// Vérifier les données existantes dans la table settings
echo "\nDonnées dans la table 'settings':\n";
try {
    $settings = DB::table('settings')->get();
    foreach ($settings as $setting) {
        echo "- {$setting->key}: ";
        if (is_object($setting->value) || is_array($setting->value)) {
            echo json_encode($setting->value, JSON_PRETTY_PRINT);
        } else {
            echo $setting->value;
        }
        echo " (groupe: {$setting->group})\n";
    }
} catch (\Exception $e) {
    echo "Erreur lors de la récupération des données: " . $e->getMessage() . "\n";
}