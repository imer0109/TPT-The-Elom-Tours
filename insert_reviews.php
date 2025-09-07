<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

try {
    // Vérifier si la table reviews existe
    if (Schema::hasTable('reviews')) {
        echo "La table 'reviews' existe.\n";
        
        // Récupérer un circuit existant ou en créer un nouveau avec un slug unique
        $circuit = DB::table('circuits')->first();
        
        if (!$circuit) {
            // Créer un circuit avec un slug unique
            $uniqueSlug = 'circuit-test-' . Str::random(5);
            $circuitId = DB::table('circuits')->insertGetId([
                'id' => (string) Str::uuid(),
                'titre' => 'Circuit de test',
                'slug' => $uniqueSlug,
                'description' => 'Description du circuit de test',
                'prix' => 1000,
                'duree' => 7,
                'destination' => 'Destination test',
                'difficulte' => 'Facile',
                'taille_groupe' => 10,
                'langues' => json_encode(['Français', 'Anglais']),
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "Nouveau circuit créé avec l'ID: {$circuitId}\n";
        } else {
            $circuitId = $circuit->id;
            echo "Utilisation du circuit existant avec l'ID: {$circuitId}\n";
        }
        
        // Insérer des avis de test
        for ($i = 1; $i <= 5; $i++) {
            $reviewId = DB::table('reviews')->insertGetId([
                'id' => (string) Str::uuid(),
                'circuit_id' => $circuitId,
                'name' => "Utilisateur Test {$i}",
                'email' => "user{$i}@example.com",
                'rating' => rand(3, 5),
                'comment' => "Commentaire de test numéro {$i} pour le circuit.",
                'is_approved' => ($i <= 3), // Les 3 premiers sont approuvés
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            echo "Avis {$i} créé avec l'ID: {$reviewId}\n";
        }
        
        // Vérifier le nombre d'avis
        $count = DB::table('reviews')->count();
        echo "Nombre total d'avis dans la base de données: {$count}\n";
        
        // Afficher les avis récents
        $recentReviews = DB::table('reviews')->orderBy('created_at', 'desc')->limit(3)->get();
        echo "\nAvis récents:\n";
        foreach ($recentReviews as $review) {
            echo "- {$review->name}: {$review->rating}/5 - {$review->comment}\n";
        }
    } else {
        echo "La table 'reviews' n'existe pas.\n";
    }
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}