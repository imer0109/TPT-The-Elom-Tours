<?php

namespace Database\Seeders;

use App\Models\Circuit;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les circuits existants
        $circuits = Circuit::all();
        
        if ($circuits->count() > 0) {
            // Créer quelques avis pour chaque circuit
            foreach ($circuits as $circuit) {
                // Avis approuvé avec note élevée
                Review::create([
                    'circuit_id' => $circuit->id,
                    'name' => 'Jean Dupont',
                    'email' => 'jean.dupont@example.com',
                    'rating' => 5,
                    'comment' => 'Excellent circuit ! Le guide était très professionnel et les paysages magnifiques.',
                    'is_approved' => true,
                ]);
                
                // Avis approuvé avec note moyenne
                Review::create([
                    'circuit_id' => $circuit->id,
                    'name' => 'Marie Martin',
                    'email' => 'marie.martin@example.com',
                    'rating' => 4,
                    'comment' => 'Très bon circuit, mais l\'hébergement aurait pu être meilleur.',
                    'is_approved' => true,
                ]);
                
                // Avis en attente d'approbation
                Review::create([
                    'circuit_id' => $circuit->id,
                    'name' => 'Pierre Durand',
                    'email' => 'pierre.durand@example.com',
                    'rating' => 3,
                    'comment' => 'Circuit correct mais un peu cher pour les prestations offertes.',
                    'is_approved' => false,
                ]);
            }
        } else {
            $this->command->info('Aucun circuit trouvé. Impossible de créer des avis.');
        }
    }
}