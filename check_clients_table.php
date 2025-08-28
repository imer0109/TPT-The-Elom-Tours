<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Check if the clients table exists
    $tableExists = Schema::hasTable('clients');
    echo "Table 'clients' exists: " . ($tableExists ? 'Yes' : 'No') . "\n";
    
    if ($tableExists) {
        // Get the columns of the clients table
        $columns = Schema::getColumnListing('clients');
        echo "Columns in 'clients' table:\n";
        echo implode(", ", $columns) . "\n\n";
        
        // Try to query the clients table
        $clients = DB::table('clients')->limit(5)->get();
        echo "Query executed successfully. Found " . count($clients) . " clients.\n";
        
        // Display the structure of the clients table
        $structure = DB::select('DESCRIBE clients');
        echo "\nTable structure:\n";
        foreach ($structure as $column) {
            echo "{$column->Field} - {$column->Type} - {$column->Null} - {$column->Key} - {$column->Default}\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
}