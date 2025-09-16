<?php

namespace App\Http\Controllers;

use App\Models\Circuit;
use App\Models\Destination;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CircuitController extends Controller
{
    /**
     * Affiche la liste des circuits
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // Construire la requête de base
        $query = Circuit::where('est_actif', true);
        
        // Filtrer par destination
        if ($request->filled('destination')) {
            $destination = Destination::find($request->destination);
            if ($destination) {
                $query->where('destination', $destination->name);
            }
        }
        
        // Filtrer par durée
        if ($request->filled('duration')) {
            $duration = $request->duration;
            switch ($duration) {
                case '1-3':
                    $query->whereBetween('duree', [1, 3]);
                    break;
                case '4-7':
                    $query->whereBetween('duree', [4, 7]);
                    break;
                case '8+':
                    $query->where('duree', '>=', 8);
                    break;
            }
        }
        
        // Filtrer par thème (basé sur la description ou les mots-clés)
        if ($request->filled('theme')) {
            $theme = $request->theme;
            $query->where(function($q) use ($theme) {
                $q->where('description', 'like', "%{$theme}%")
                  ->orWhere('meta_keywords', 'like', "%{$theme}%");
            });
        }
        
        // Récupérer les circuits avec pagination
        $circuits = $query->orderBy('created_at', 'desc')->paginate(9);
        
        // Récupérer les destinations pour le filtre
        $destinations = Destination::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('circuits.index', compact('circuits', 'destinations'));
    }

    /**
     * Affiche un circuit spécifique
     *
     * @param string $slug Le slug du circuit
     * @return \Illuminate\View\View
     */
    public function show(string $slug): View
    {
        // Récupérer le circuit avec ses relations
        $circuit = Circuit::where('slug', $slug)
            ->where('est_actif', true)
            ->with(['etapes', 'images', 'avis' => function($query) {
                $query->where('is_approved', true);
            }])
            ->firstOrFail();
            
        // Récupérer les circuits similaires
        $relatedCircuits = Circuit::where('est_actif', true)
            ->where('id', '!=', $circuit->id)
            ->where(function($query) use ($circuit) {
                $query->where('destination', $circuit->destination)
                      ->orWhere('difficulte', $circuit->difficulte);
            })
            ->take(3)
            ->get();
        
        return view('circuits.show', compact('circuit', 'relatedCircuits'));
    }
    
    /**
     * Soumet un avis sur un circuit
     *
     * @param Request $request
     * @param string $slug Le slug du circuit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitReview(Request $request, string $slug)
    {
        $circuit = Circuit::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);
        
        $review = new Review([
            'circuit_id' => $circuit->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Nécessite une approbation par l'admin
        ]);
        
        $review->save();
        
        return redirect()->back()->with('success', 'Merci pour votre avis ! Il sera publié après modération.');
    }
}