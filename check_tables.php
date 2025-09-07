<?php

require 'vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Vérifier si la table circuits existe
if (Schema::hasTable('circuits')) {
    echo "La table circuits existe.\n";
    
    // Afficher la structure de la table circuits
    $columns = Schema::getColumnListing('circuits');
    echo "Colonnes de circuits: " . implode(', ', $columns) . "\n";
} else {
    echo "La table circuits n'existe pas.\n";
}