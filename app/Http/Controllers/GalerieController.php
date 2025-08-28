<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalerieController extends Controller
{
    /**
     * Affiche la galerie de photos
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Récupérer les images actives et triées par ordre
        $images = Gallery::active()
            ->ordered()
            ->with('image')
            ->get()
            ->groupBy('category');
            
        // Récupérer les catégories disponibles pour le filtre
        $categories = Gallery::active()
            ->select('category')
            ->distinct()
            ->pluck('category');
        
        return view('galerie.index', compact('images', 'categories'));
    }
}