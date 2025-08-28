<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Créer un fichier de migration correct pour la table clients
$timestamp = date('Y_m_d_His');
$migrationFileName = $timestamp . '_create_clients_table.php';
$migrationPath = __DIR__ . '/database/migrations/' . $migrationFileName;

// Contenu correct de la migration
$migrationContent = <<<'EOT'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
EOT;

// Écrire le fichier de migration
file_put_contents($migrationPath, $migrationContent);

echo "Nouveau fichier de migration créé: $migrationFileName\n";
echo "Contenu du fichier:\n";
echo $migrationContent . "\n";

echo "\nVérification de la syntaxe du fichier...\n";
$command = sprintf('php -l "%s" 2>&1', $migrationPath);
$output = shell_exec($command);
echo $output . "\n";

echo "\nTraitement terminé.\n";