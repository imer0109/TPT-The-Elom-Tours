<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Exécuter la migration
echo "Exécution de la migration pour créer la table clients...\n";
$exitCode = $kernel->call('migrate', ['--force' => true]);

if ($exitCode === 0) {
    echo "Migration réussie!\n";
} else {
    echo "Erreur lors de la migration. Code de sortie: {$exitCode}\n";
}

// Vérifier si la table existe maintenant
try {
    $hasTable = DB::getSchemaBuilder()->hasTable('clients');
    echo "La table 'clients' existe: " . ($hasTable ? 'Oui' : 'Non') . "\n";
    
    if ($hasTable) {
        $columns = DB::getSchemaBuilder()->getColumnListing('clients');
        echo "Colonnes de la table 'clients': " . implode(', ', $columns) . "\n";
    }
} catch (Exception $e) {
    echo "Erreur lors de la vérification de la table: " . $e->getMessage() . "\n";
}