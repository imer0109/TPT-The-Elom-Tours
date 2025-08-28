<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinationController extends Controller
{
    /**
     * Affiche la liste des destinations
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $destinations = Destination::where('is_active', true)
            ->orderBy('name')
            ->paginate(12);
        
        $popularDestinations = Destination::where('is_active', true)
            ->where('is_popular', true)
            ->take(4)
            ->get();
        
        return view('destinations.index', compact('destinations', 'popularDestinations'));
    }

    /**
     * Affiche les détails d'une destination
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show(string $slug): View
    {
        $destination = Destination::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        $relatedCircuits = $destination->circuits()
            ->where('is_active', true)
            ->take(4)
            ->get();
        
        return view('destinations.show', compact('destination', 'relatedCircuits'));
    }
}