<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Vérifier si la table reviews existe
    if (Schema::hasTable('reviews')) {
        echo "La table 'reviews' existe.\n";
        
        // Compter le nombre d'avis
        $count = DB::table('reviews')->count();
        echo "Nombre total d'avis dans la base de données: {$count}\n";
        
        // Afficher les avis récents
        $recentReviews = DB::table('reviews')->orderBy('created_at', 'desc')->limit(3)->get();
        echo "\nAvis récents:\n";
        
        if (count($recentReviews) > 0) {
            foreach ($recentReviews as $review) {
                echo "- ID: {$review->id}\n";
                echo "  Circuit ID: {$review->circuit_id}\n";
                echo "  Nom: {$review->name}\n";
                echo "  Note: {$review->rating}\n";
                echo "  Commentaire: {$review->comment}\n";
                echo "  Approuvé: " . ($review->is_approved ? 'Oui' : 'Non') . "\n";
                echo "  Date: {$review->created_at}\n\n";
            }
        } else {
            echo "Aucun avis trouvé.\n";
        }
    } else {
        echo "La table 'reviews' n'existe pas.\n";
    }
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}