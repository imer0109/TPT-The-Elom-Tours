<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Exécuter la requête qui a généré l'erreur
    $reviews = DB::table('reviews')->orderBy('created_at', 'desc')->limit(3)->get();
    
    echo "Requête exécutée avec succès. Nombre de résultats : " . count($reviews) . "\n";
    
    // Afficher les résultats (s'il y en a)
    if (count($reviews) > 0) {
        foreach ($reviews as $review) {
            echo "Review ID: {$review->id}, Rating: {$review->rating}\n";
        }
    } else {
        echo "Aucun avis trouvé.\n";
    }
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}