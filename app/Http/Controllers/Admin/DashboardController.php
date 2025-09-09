<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Circuit;
use App\Models\Client;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord administratif
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupération des données réelles pour les statistiques
        $totalReservations = Reservation::count();
        $revenue = Reservation::sum('montant_total');
        $newClients = Client::where('created_at', '>=', Carbon::now()->subMonth())->count();
        
        // Calcul de la satisfaction (exemple basé sur les avis)
        $satisfaction = 0;
        $reviewsCount = \App\Models\Review::count();
        if ($reviewsCount > 0) {
            $satisfaction = round((\App\Models\Review::sum('rating') / ($reviewsCount * 5)) * 100);
        }
        
        $stats = [
            'reservations' => $totalReservations,
            'revenue' => $revenue,
            'newClients' => $newClients,
            'satisfaction' => $satisfaction,
        ];
        
        // Données pour les graphiques - réservations mensuelles
        $monthlyReservations = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyReservations[] = Reservation::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        
        // Circuits les plus populaires
        $popularCircuits = Circuit::select('circuits.titre', DB::raw('count(reservations.id) as total'))
            ->leftJoin('reservations', 'circuits.id', '=', 'reservations.circuit_id')
            ->groupBy('circuits.id', 'circuits.titre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        
        $chartData = [
            'monthlyReservations' => $monthlyReservations,
            'popularCircuits' => [
                'labels' => $popularCircuits->pluck('titre')->toArray(),
                'data' => $popularCircuits->pluck('total')->toArray(),
            ],
        ];
        
        // Réservations récentes
        $recentReservationsData = Reservation::with(['client', 'circuit'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(function ($reservation) {
                $client = $reservation->client;
                $circuit = $reservation->circuit;
                return [
                    'id' => $reservation->id,
                    'client' => $client ? trim(($client->nom ?? '').' '.($client->prenom ?? '')) : '—',
                    'email' => $client->email ?? '—',
                    'circuit' => $circuit->titre ?? '—',
                    'date' => optional($reservation->date_debut)->format('d/m/Y') ?? '—',
                    'amount' => $reservation->montant_total,
                    'status' => $reservation->status,
                ];
            })->toArray();
        
        // Notifications (messages récents, réservations en attente, etc.)
        $notifications = [];
        
        // Messages récents
        $recentMessages = Message::orderByDesc('created_at')->limit(2)->get();
        foreach ($recentMessages as $message) {
            $notifications[] = [
                'type' => 'info',
                'icon' => 'info-circle',
                'title' => 'Nouveau message',
                'message' => substr($message->nom . ' a envoyé un message: ' . $message->message, 0, 100) . '...',
                'time' => Carbon::parse($message->created_at)->diffForHumans(),
            ];
        }
        
        // Réservations en attente
        $pendingReservations = Reservation::where('status', 'pending')->count();
        if ($pendingReservations > 0) {
            $notifications[] = [
                'type' => 'warning',
                'icon' => 'exclamation-triangle',
                'title' => 'Réservations en attente',
                'message' => 'Il y a ' . $pendingReservations . ' réservation(s) en attente de traitement',
                'time' => 'Maintenant',
            ];
        }
        
        return view('admin.dashboard', compact('stats', 'chartData', 'recentReservationsData', 'notifications'));
    }
}