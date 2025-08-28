<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;

try {
    // Tester la méthode scopeActive
    echo "Test de la méthode scopeActive...\n";
    $categories = Category::active()->get();
    echo "Succès! La requête a fonctionné.\n";
    echo "Nombre de catégories actives: " . count($categories) . "\n";
    
    // Afficher les catégories trouvées
    if (count($categories) > 0) {
        echo "\nListe des catégories actives:\n";
        foreach ($categories as $category) {
            echo "- ID: {$category->id}, Nom: {$category->name}\n";
        }
    }
    
    // Tester une requête directe
    echo "\nTest d'une requête directe...\n";
    $allCategories = Category::all();
    echo "Nombre total de catégories: " . count($allCategories) . "\n";
    
} catch (\Exception $e) {
    echo "Erreur lors de l'exécution de la requête: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}