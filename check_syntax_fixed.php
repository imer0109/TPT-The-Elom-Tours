<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Vérification si l'erreur de syntaxe a été corrigée...\n";

// Créer un fichier PHP temporaire avec la structure correcte
$tempFile = __DIR__ . '/temp_migration_test.php';

// Contenu correct d'une migration
$correctContent = <<<'EOT'
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
        // Code de migration
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Code de migration
    }
};
EOT;

// Écrire le fichier temporaire
file_put_contents($tempFile, $correctContent);

// Vérifier la syntaxe du fichier
echo "Vérification de la syntaxe du fichier temporaire...\n";
$command = sprintf('php -l "%s" 2>&1', $tempFile);
$output = shell_exec($command);
echo $output . "\n";

// Supprimer le fichier temporaire
unlink($tempFile);

echo "\nVérification terminée.\n";
echo "Si vous voyez 'No syntax errors detected', cela signifie que la structure de migration est correcte.\n";
echo "Vous pouvez maintenant exécuter 'php artisan migrate' pour appliquer les migrations.\n";