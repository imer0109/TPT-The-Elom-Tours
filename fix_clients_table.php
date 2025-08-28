<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

echo "Vérification de la table clients...\n";

// Vérifier si la table clients existe
if (!Schema::hasTable('clients')) {
    echo "La table 'clients' n'existe pas. Création de la table...\n";
    
    // Créer la table clients
    Schema::create('clients', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('nom');
        $table->string('prenom');
        $table->string('email')->unique();
        $table->string('telephone');
        $table->string('adresse')->nullable();
        $table->string('ville')->nullable();
        $table->string('pays')->nullable();
        $table->string('code_postal')->nullable();
        $table->date('date_naissance')->nullable();
        $table->uuid('user_id')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
    
    echo "Table 'clients' créée avec succès.\n";
} else {
    echo "La table 'clients' existe déjà.\n";
}

// Vérifier la structure de la table
echo "\nStructure de la table clients:\n";
$columns = Schema::getColumnListing('clients');
echo "Colonnes: " . implode(', ', $columns) . "\n";

// Tester la requête problématique
echo "\nTest de la requête: select * from clients where clients.deleted_at is null order by nom asc\n";
try {
    $results = DB::select("select * from clients where clients.deleted_at is null order by nom asc");
    echo "Requête exécutée avec succès. Nombre de résultats: " . count($results) . "\n";
} catch (\Exception $e) {
    echo "Erreur lors de l'exécution de la requête: " . $e->getMessage() . "\n";
}

echo "\nLa correction est terminée. La table 'clients' est maintenant disponible.\n";