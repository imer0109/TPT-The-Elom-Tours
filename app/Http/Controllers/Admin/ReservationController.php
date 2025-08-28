<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Circuit;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Affiche la liste des réservations
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Récupérer les filtres depuis la requête
        $statut = $request->input('statut');
        $circuit_id = $request->input('circuit_id');
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');
        $search = $request->input('search');
        
        // Construire la requête de base
        $query = Reservation::with(['client', 'circuit'])
            ->orderBy('created_at', 'desc');
        
        // Appliquer les filtres
        if ($statut) {
            $query->where('statut', $statut);
        }
        
        if ($circuit_id) {
            $query->where('circuit_id', $circuit_id);
        }
        
        if ($date_debut) {
            $query->where('date_debut', '>=', $date_debut);
        }
        
        if ($date_fin) {
            $query->where('date_fin', '<=', $date_fin);
        }
        
        if ($search) {
            $query->whereHas('client', function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('circuit', function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%");
            });
        }
        
        // Récupérer les réservations paginées
        $reservations = $query->paginate(10);
        
        // Récupérer les circuits pour le filtre
        $circuits = Circuit::orderBy('titre')->get(['id', 'titre']);
        
        // Statistiques des réservations
        $stats = [
            'total' => Reservation::count(),
            'pending' => Reservation::where('statut', 'pending')->count(),
            'confirmed' => Reservation::where('statut', 'confirmed')->count(),
            'cancelled' => Reservation::where('statut', 'cancelled')->count(),
            'montant_total' => Reservation::where('statut', '!=', 'cancelled')->sum('montant_total'),
        ];
        
        return view('admin.reservations.index', compact('reservations', 'circuits', 'stats', 'statut', 'circuit_id', 'date_debut', 'date_fin', 'search'));
    }

    /**
     * Affiche le formulaire de création d'une réservation
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $circuits = Circuit::where('est_actif', true)->orderBy('titre')->get();
        $clients = Client::orderBy('nom')->get();
        
        return view('admin.reservations.create', compact('circuits', 'clients'));
    }

    /**
     * Enregistre une nouvelle réservation
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'circuit_id' => 'required|exists:circuits,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'nombre_personnes' => 'required|integer|min:1',
            'montant_total' => 'required|numeric|min:0',
            'statut' => 'required|in:pending,confirmed,cancelled',
            'commentaire' => 'nullable|string',
        ]);
        
        // Créer la réservation
        $reservation = Reservation::create($validated);
        
        return redirect()->route('admin.reservations.index')
            ->with('success', 'La réservation a été créée avec succès.');
    }

    /**
     * Affiche les détails d'une réservation
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['client', 'circuit']);
        
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Affiche le formulaire d'édition d'une réservation
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        $circuits = Circuit::orderBy('titre')->get();
        $clients = Client::orderBy('nom')->get();
        
        return view('admin.reservations.edit', compact('reservation', 'circuits', 'clients'));
    }

    /**
     * Met à jour une réservation
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'circuit_id' => 'required|exists:circuits,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'nombre_personnes' => 'required|integer|min:1',
            'montant_total' => 'required|numeric|min:0',
            'statut' => 'required|in:pending,confirmed,cancelled',
            'commentaire' => 'nullable|string',
        ]);
        
        // Mettre à jour la réservation
        $reservation->update($validated);
        
        return redirect()->route('admin.reservations.index')
            ->with('success', 'La réservation a été mise à jour avec succès.');
    }

    /**
     * Supprime une réservation
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        
        return redirect()->route('admin.reservations.index')
            ->with('success', 'La réservation a été supprimée avec succès.');
    }
    
    /**
     * Change le statut d'une réservation
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'statut' => 'required|in:pending,confirmed,cancelled',
        ]);
        
        $reservation->update([
            'statut' => $validated['statut']
        ]);
        
        return redirect()->back()
            ->with('success', 'Le statut de la réservation a été mis à jour avec succès.');
    }
    
    /**
     * Affiche le tableau de bord des réservations
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Statistiques générales
        $stats = [
            'total' => Reservation::count(),
            'pending' => Reservation::where('statut', 'pending')->count(),
            'confirmed' => Reservation::where('statut', 'confirmed')->count(),
            'cancelled' => Reservation::where('statut', 'cancelled')->count(),
            'montant_total' => Reservation::where('statut', '!=', 'cancelled')->sum('montant_total'),
        ];
        
        // Réservations récentes
        $recent_reservations = Reservation::with(['client', 'circuit'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Données pour le graphique des réservations par mois
        $reservations_by_month = DB::table('reservations')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        
        // Compléter les mois manquants
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($reservations_by_month[$i])) {
                $reservations_by_month[$i] = 0;
            }
        }
        ksort($reservations_by_month);
        
        // Circuits les plus réservés
        $top_circuits = DB::table('reservations')
            ->join('circuits', 'reservations.circuit_id', '=', 'circuits.id')
            ->select('circuits.titre', DB::raw('COUNT(*) as count'))
            ->groupBy('circuits.id', 'circuits.titre')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
        
        return view('admin.reservations.dashboard', compact('stats', 'recent_reservations', 'reservations_by_month', 'top_circuits'));
    }
}