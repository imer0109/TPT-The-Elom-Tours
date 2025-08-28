<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Tenter d'exécuter la requête qui échoue
    echo "Tentative d'exécution de la requête: select * from `clients` where `clients`.`deleted_at` is null order by `nom` asc\n";
    $clients = DB::select("select * from `clients` where `clients`.`deleted_at` is null order by `nom` asc");
    echo "Succès! La requête a fonctionné.\n";
    echo "Nombre de clients: " . count($clients) . "\n";
} catch (\Exception $e) {
    echo "Erreur lors de l'exécution de la requête: " . $e->getMessage() . "\n";
}

// Vérifier la structure de la table clients
echo "\nStructure de la table clients:\n";
$columns = Schema::getColumnListing('clients');
echo "Colonnes: " . implode(', ', $columns) . "\n";

// Vérifier si la migration a été exécutée
echo "\nVérification des migrations:\n";
$migrations = DB::table('migrations')->where('migration', 'like', '%create_clients_table%')->get();
echo "Migrations trouvées: " . count($migrations) . "\n";
foreach ($migrations as $migration) {
    echo "- " . $migration->migration . " (batch: " . $migration->batch . ")\n";
}

// Vérifier si la table existe physiquement dans la base de données
echo "\nVérification directe dans la base de données:\n";
try {
    $tables = DB::select("SHOW TABLES LIKE 'clients'");
    if (count($tables) > 0) {
        echo "La table 'clients' existe physiquement dans la base de données.\n";
        
        // Afficher la structure complète de la table
        $columns = DB::select("DESCRIBE clients");
        echo "Structure complète de la table 'clients':\n";
        foreach ($columns as $column) {
            echo "- {$column->Field} ({$column->Type})" . ($column->Null === 'NO' ? ' NOT NULL' : '') . "\n";
        }
    } else {
        echo "La table 'clients' n'existe PAS physiquement dans la base de données.\n";
        
        // Si la table n'existe pas, on la crée
        echo "Création de la table 'clients'...\n";
        
        Schema::create('clients', function ($table) {
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
    }
} catch (\Exception $e) {
    echo "Erreur lors de la vérification de la table: " . $e->getMessage() . "\n";
}