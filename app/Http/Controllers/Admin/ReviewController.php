<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Circuit;

class ReviewController extends Controller
{
    /**
     * Affiche la liste des avis
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $query = Review::with('circuit')->latest();
        
        // Filtrage par statut
        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }
        
        // Filtrage par circuit
        if ($request->filled('circuit_id')) {
            $query->where('circuit_id', $request->circuit_id);
        }
        
        // Filtrage par note minimale
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }
        
        $reviews = $query->paginate(10);
            
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Affiche le formulaire d'édition d'un avis
     *
     * @param Review $review
     * @return \Illuminate\View\View
     */
    public function edit(Review $review): View
    {
        return view('admin.reviews.edit', compact('review'));
    }

    /**
     * Met à jour un avis
     *
     * @param Request $request
     * @param Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'is_approved' => 'boolean',
        ]);
        
        // Gestion de la case à cocher
        $validated['is_approved'] = $request->has('is_approved');
        
        $review->update($validated);
        
        return redirect()->route('admin.reviews.edit', $review)
            ->with('success', 'L\'avis a été mis à jour avec succès.');
    }

    /**
     * Approuve ou désapprouve un avis
     *
     * @param Request $request
     * @param Review $review
     * @param bool $approve
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleApproval(Request $request, Review $review, bool $approve = true)
    {
        // Si la valeur par défaut est fournie via la route, l'utiliser
        if ($request->route()->hasParameter('approve')) {
            $approve = $request->route()->parameter('approve');
        }
        
        $review->update(['is_approved' => $approve]);
        
        $status = $approve ? 'approuvé' : 'mis en attente';
        
        return redirect()->route('admin.reviews.index')
            ->with('success', "L'avis a été {$status} avec succès.");
    }

    /**
     * Supprime un avis
     *
     * @param Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Review $review)
    {
        $review->delete();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'L\'avis a été supprimé avec succès.');
    }
}