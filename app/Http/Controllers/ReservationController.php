<?php

namespace App\Http\Controllers;

use App\Models\Circuit;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function store(Request $request, $slug)
    {
        $circuit = Circuit::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'date_debut' => 'required|date|after:today',
            'nombre_personnes' => 'required|integer|min:1',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'message' => 'nullable|string|max:1000'
        ]);

        // Calculer la date de fin en ajoutant la durée du circuit à la date de début
        $date_fin = Carbon::parse($validated['date_debut'])->addDays($circuit->duree - 1);

        // Calculer le montant total (prix du circuit * nombre de personnes)
        $montant_total = $circuit->prix * $validated['nombre_personnes'];

        $reservation = new Reservation();
        $reservation->circuit_id = $circuit->id;
        $reservation->date_debut = $validated['date_debut'];
        $reservation->date_fin = $date_fin;
        $reservation->nombre_personnes = $validated['nombre_personnes'];
        $reservation->montant_total = $montant_total;
        $reservation->nom = $validated['nom'];
        $reservation->email = $validated['email'];
        $reservation->telephone = $validated['telephone'];
        $reservation->message = $validated['message'];
        $reservation->status = 'pending';
        $reservation->save();

        return redirect()->back()->with('success', 'Votre réservation a été enregistrée avec succès. Nous vous contacterons bientôt.');
    }
}