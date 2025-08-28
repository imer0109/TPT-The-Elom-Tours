<?php

// Script to create a new migration file for the clients table

$timestamp = date('Y_m_d_His');
$migrationName = "{$timestamp}_create_clients_table.php";
$migrationPath = __DIR__ . '/database/migrations/' . $migrationName;

$migrationContent = <<<'EOD'
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
            $table->string('telephone')->nullable();
            $table->text('adresse')->nullable();
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
EOD;

// Create the migration file
if (!is_dir(dirname($migrationPath))) {
    mkdir(dirname($migrationPath), 0777, true);
}

file_put_contents($migrationPath, $migrationContent);

echo "Migration file created: {$migrationName}\n";

// Check the syntax of the created file
$command = "php -l {$migrationPath}";
$output = [];
$returnVar = 0;
exec($command, $output, $returnVar);

if ($returnVar === 0) {
    echo "Syntax check passed. The migration file is valid.\n";
} else {
    echo "Syntax error detected in the migration file:\n";
    echo implode("\n", $output) . "\n";
}

echo "\nRun 'php artisan migrate' to execute the migration.\n";