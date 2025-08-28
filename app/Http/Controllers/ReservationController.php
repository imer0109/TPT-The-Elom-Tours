<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Circuit;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Enregistre une nouvelle réservation depuis le formulaire public
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        // Trouver le circuit par son slug
        $circuit = Circuit::where('slug', $slug)->firstOrFail();
        
        // Valider les données du formulaire
        $validator = Validator::make($request->all(), [
            'date_debut' => 'required|date|after_or_equal:today',
            'nombre_personnes' => 'required|integer|min:1|max:20',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Calculer la date de fin (en utilisant la durée du circuit)
        $duree = $circuit->duree ?? 1; // Durée par défaut de 1 jour si non spécifiée
        $date_debut = new \DateTime($request->date_debut);
        $date_fin = (clone $date_debut)->modify("+{$duree} days");
        
        // Calculer le montant total
        $prix_unitaire = $circuit->prix ?? 0;
        $montant_total = $prix_unitaire * $request->nombre_personnes;
        
        // Créer ou récupérer le client
        if (Auth::check()) {
            // Utilisateur connecté, vérifier s'il a déjà un profil client
            $client = Client::where('user_id', Auth::id())->first();
            
            if (!$client) {
                // Créer un nouveau profil client pour l'utilisateur
                $user = Auth::user();
                $client = Client::create([
                    'nom' => $user->name,
                    'email' => $user->email,
                    'user_id' => $user->id,
                ]);
            }
        } else {
            // Rediriger vers la page de connexion avec un message
            return redirect()->route('login')
                ->with('info', 'Veuillez vous connecter ou créer un compte pour finaliser votre réservation.');
        }
        
        // Créer la réservation
        $reservation = Reservation::create([
            'client_id' => $client->id,
            'circuit_id' => $circuit->id,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'nombre_personnes' => $request->nombre_personnes,
            'montant_total' => $montant_total,
            'statut' => 'en_attente', // Statut par défaut
            'commentaire' => $request->commentaire ?? null,
        ]);
        
        return redirect()->route('reservations.confirmation', ['reference' => $reservation->reference])
            ->with('success', 'Votre demande de réservation a été enregistrée avec succès.');
    }
    
    /**
     * Affiche la page de confirmation après une réservation
     *
     * @param  string  $reference
     * @return \Illuminate\Http\Response
     */
    public function confirmation($reference)
    {
        $reservation = Reservation::where('reference', $reference)->firstOrFail();
        $reservation->load(['client', 'circuit']);
        
        return view('reservations.confirmation', compact('reservation'));
    }
    
    /**
     * Affiche la liste des réservations de l'utilisateur connecté
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $client = Client::where('user_id', Auth::id())->first();
        
        if (!$client) {
            return redirect()->route('home')
                ->with('info', 'Vous n\'avez pas encore de profil client.');
        }
        
        $reservations = Reservation::where('client_id', $client->id)
            ->with('circuit')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('reservations.index', compact('reservations'));
    }
    
    /**
     * Affiche les détails d'une réservation
     *
     * @param  string  $reference
     * @return \Illuminate\Http\Response
     */
    public function show($reference)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $client = Client::where('user_id', Auth::id())->first();
        
        if (!$client) {
            return redirect()->route('home')
                ->with('info', 'Vous n\'avez pas encore de profil client.');
        }
        
        $reservation = Reservation::where('reference', $reference)
            ->where('client_id', $client->id)
            ->with(['circuit'])
            ->firstOrFail();
        
        return view('reservations.show', compact('reservation'));
    }
    
    /**
     * Annule une réservation
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $reference
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request, $reference)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $client = Client::where('user_id', Auth::id())->first();
        
        if (!$client) {
            return redirect()->route('home')
                ->with('info', 'Vous n\'avez pas encore de profil client.');
        }
        
        $reservation = Reservation::where('reference', $reference)
            ->where('client_id', $client->id)
            ->firstOrFail();
        
        // Vérifier si la réservation peut être annulée
        if ($reservation->statut === 'annulee' || $reservation->statut === 'terminee') {
            return redirect()->route('reservations.show', ['reference' => $reservation->reference])
                ->with('error', 'Cette réservation ne peut pas être annulée.');
        }
        
        // Annuler la réservation
        $reservation->update([
            'statut' => 'annulee',
            'commentaire' => $reservation->commentaire . '\n\nAnnulée par le client le ' . now()->format('d/m/Y H:i'),
        ]);
        
        return redirect()->route('reservations.index')
            ->with('success', 'Votre réservation a été annulée avec succès.');
    }
}