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
        // Récupérer les images actives et triées par ordre avec pagination
        $galleries = Gallery::active()
            ->ordered()
            ->with('image')
            ->paginate(12);
            
        // Récupérer les catégories disponibles pour le filtre
        $categories = Gallery::active()
            ->select('category')
            ->distinct()
            ->pluck('category');
        
        return view('galerie.index', compact('galleries', 'categories'));
    }

    /**
     * Affiche une image spécifique de la galerie
     *
     * @param Gallery $gallery
     * @return \Illuminate\View\View
     */
    public function show(Gallery $gallery): View
    {
        if (!$gallery->is_active) {
            abort(404);
        }

        $relatedGalleries = Gallery::active()
            ->where('id', '!=', $gallery->id)
            ->where('category', $gallery->category)
            ->with('image')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('galerie.show', compact('gallery', 'relatedGalleries'));
    }
}