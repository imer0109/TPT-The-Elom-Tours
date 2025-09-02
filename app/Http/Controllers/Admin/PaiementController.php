<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    /**
     * Affiche la liste des paiements d'une réservation
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function index(Reservation $reservation)
    {
        $paiements = $reservation->paiements()
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.paiements.index', compact('reservation', 'paiements'));
    }

    /**
     * Affiche le formulaire de création d'un paiement
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function create(Reservation $reservation)
    {
        return view('admin.paiements.create', [
            'reservation' => $reservation,
            'methodes' => Paiement::$methodes,
        ]);
    }

    /**
     * Enregistre un nouveau paiement
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'montant' => 'required|numeric|min:0|max:' . $reservation->montant_restant,
            'methode' => 'required|in:' . implode(',', array_keys(Paiement::$methodes)),
            'date_paiement' => 'required|date',
            'commentaire' => 'nullable|string',
        ]);
        
        // Générer une référence unique
        $validated['reference'] = 'PAY-' . strtoupper(Str::random(8));
        $validated['reservation_id'] = $reservation->id;
        $validated['statut'] = 'en_attente';
        
        // Créer le paiement
        $paiement = Paiement::create($validated);
        
        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', 'Le paiement a été enregistré avec succès.');
    }

    /**
     * Affiche les détails d'un paiement
     *
     * @param  \App\Models\Reservation  $reservation
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation, Paiement $paiement)
    {
        return view('admin.paiements.show', compact('reservation', 'paiement'));
    }

    /**
     * Affiche le formulaire d'édition d'un paiement
     *
     * @param  \App\Models\Reservation  $reservation
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation, Paiement $paiement)
    {
        return view('admin.paiements.edit', [
            'reservation' => $reservation,
            'paiement' => $paiement,
            'methodes' => Paiement::$methodes,
        ]);
    }

    /**
     * Met à jour un paiement
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation, Paiement $paiement)
    {
        $validated = $request->validate([
            'montant' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($reservation, $paiement) {
                    $maxAmount = $reservation->montant_restant + $paiement->montant;
                    if ($value > $maxAmount) {
                        $fail("Le montant ne peut pas dépasser le montant restant à payer.");
                    }
                },
            ],
            'methode' => 'required|in:' . implode(',', array_keys(Paiement::$methodes)),
            'date_paiement' => 'required|date',
            'commentaire' => 'nullable|string',
        ]);
        
        // Mettre à jour le paiement
        $paiement->update($validated);
        
        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', 'Le paiement a été mis à jour avec succès.');
    }

    /**
     * Supprime un paiement
     *
     * @param  \App\Models\Reservation  $reservation
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation, Paiement $paiement)
    {
        $paiement->delete();
        
        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', 'Le paiement a été supprimé avec succès.');
    }
    
    /**
     * Change le statut d'un paiement
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, Reservation $reservation, Paiement $paiement)
    {
        $validated = $request->validate([
            'statut' => 'required|in:' . implode(',', array_keys(Paiement::$statuts)),
        ]);
        
        $paiement->update([
            'statut' => $validated['statut']
        ]);
        
        return redirect()->back()
            ->with('success', 'Le statut du paiement a été mis à jour avec succès.');
    }
}