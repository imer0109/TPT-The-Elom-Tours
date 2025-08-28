<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord administratif
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Dans une application réelle, nous récupérerions ici les données
        // nécessaires pour le tableau de bord à partir de la base de données
        
        // Exemple de données pour les statistiques
        $stats = [
            'reservations' => 124,
            'revenue' => 8540,
            'newClients' => 45,
            'satisfaction' => 92,
        ];
        
        // Exemple de données pour les graphiques
        $chartData = [
            'monthlyReservations' => [15, 20, 25, 30, 35, 40, 45, 50, 45, 40, 35, 30],
            'popularCircuits' => [
                'labels' => ['Découverte de Kpalimé', 'Safari à Fazao', 'Lomé Culturelle', 'Plages de Togoville', 'Montagnes de Kara'],
                'data' => [45, 38, 32, 28, 22],
            ],
        ];
        
        // Exemple de données pour les réservations récentes
        $recentReservations = [
            [
                'id' => 12345,
                'client' => 'Jean Dupont',
                'email' => 'jean.dupont@example.com',
                'circuit' => 'Découverte de Kpalimé',
                'date' => '15/06/2023',
                'amount' => 1250,
                'status' => 'confirmed',
            ],
            [
                'id' => 12346,
                'client' => 'Marie Lefebvre',
                'email' => 'marie.lefebvre@example.com',
                'circuit' => 'Safari à Fazao',
                'date' => '12/06/2023',
                'amount' => 2100,
                'status' => 'pending',
            ],
            [
                'id' => 12347,
                'client' => 'Pierre Thomas',
                'email' => 'pierre.thomas@example.com',
                'circuit' => 'Lomé Culturelle',
                'date' => '10/06/2023',
                'amount' => 950,
                'status' => 'confirmed',
            ],
        ];
        
        // Exemple de données pour les notifications
        $notifications = [
            [
                'type' => 'warning',
                'icon' => 'exclamation-triangle',
                'title' => 'Stock faible pour le circuit "Découverte de Kpalimé"',
                'message' => 'Il ne reste que 2 places disponibles pour la date du 20/07/2023',
                'time' => '3 heures',
            ],
            [
                'type' => 'info',
                'icon' => 'info-circle',
                'title' => 'Nouvelle demande de contact',
                'message' => 'Sophie Martin a envoyé une demande d\'information concernant le circuit "Safari à Fazao"',
                'time' => '5 heures',
            ],
            [
                'type' => 'success',
                'icon' => 'check-circle',
                'title' => 'Paiement reçu',
                'message' => 'Le paiement de 1,250€ pour la réservation #12345 a été reçu',
                'time' => '1 jour',
            ],
        ];
        
        return view('admin.dashboard', compact('stats', 'chartData', 'recentReservations', 'notifications'));
    }
}