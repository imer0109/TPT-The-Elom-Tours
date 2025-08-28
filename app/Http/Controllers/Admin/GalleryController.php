<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GalleryController extends Controller
{
    /**
     * Affiche la liste des éléments de la galerie
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $query = Gallery::query()->with('image');
        
        // Filtrage par catégorie
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        // Filtrage par statut
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        // Recherche par titre
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        // Tri par ordre
        $query->orderBy('order', 'asc');
        
        $galleryItems = $query->paginate(12);
        
        // Récupérer les catégories pour le filtre
        $categories = Gallery::select('category')->distinct()->pluck('category');
        
        return view('admin.gallery.index', compact('galleryItems', 'categories'));
    }

    /**
     * Affiche le formulaire de création d'un élément de galerie
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        // Récupérer les catégories existantes pour les suggestions
        $categories = Gallery::select('category')->distinct()->pluck('category');
        
        // Déterminer l'ordre par défaut (dernier ordre + 1)
        $lastOrder = Gallery::max('order') ?? 0;
        $nextOrder = $lastOrder + 1;
        
        return view('admin.gallery.create', compact('categories', 'nextOrder'));
    }

    /**
     * Enregistre un nouvel élément de galerie
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'order' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'image' => 'required|image|max:5120', // 5MB max
        ]);
        
        // Créer l'élément de galerie
        $galleryItem = Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'order' => $request->order,
            'is_active' => $request->has('is_active'),
        ]);
        
        // Traiter l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('gallery', 'public');
            
            // Créer l'entrée de fichier associée
            $file = new File([
                'name' => $image->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $image->getMimeType(),
                'size' => $image->getSize(),
                'disk' => 'public',
            ]);
            
            $galleryItem->image()->save($file);
        }
        
        return redirect()->route('admin.gallery.index')
            ->with('success', 'L\'élément de galerie a été créé avec succès.');
    }

    /**
     * Affiche les détails d'un élément de galerie
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\View\View
     */
    public function show(Gallery $gallery): View
    {
        $gallery->load('image');
        
        return view('admin.gallery.show', compact('gallery'));
    }

    /**
     * Affiche le formulaire d'édition d'un élément de galerie
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\View\View
     */
    public function edit(Gallery $gallery): View
    {
        $gallery->load('image');
        
        // Récupérer les catégories existantes pour les suggestions
        $categories = Gallery::select('category')->distinct()->pluck('category');
        
        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    /**
     * Met à jour un élément de galerie
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'order' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:5120', // 5MB max
        ]);
        
        // Mettre à jour l'élément de galerie
        $gallery->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'order' => $request->order,
            'is_active' => $request->has('is_active'),
        ]);
        
        // Traiter la nouvelle image si fournie
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($gallery->image) {
                Storage::disk($gallery->image->disk)->delete($gallery->image->path);
                $gallery->image->delete();
            }
            
            // Enregistrer la nouvelle image
            $image = $request->file('image');
            $path = $image->store('gallery', 'public');
            
            // Créer l'entrée de fichier associée
            $file = new File([
                'name' => $image->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $image->getMimeType(),
                'size' => $image->getSize(),
                'disk' => 'public',
            ]);
            
            $gallery->image()->save($file);
        }
        
        return redirect()->route('admin.gallery.index')
            ->with('success', 'L\'élément de galerie a été mis à jour avec succès.');
    }

    /**
     * Supprime un élément de galerie
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        // Supprimer l'image associée si elle existe
        if ($gallery->image) {
            Storage::disk($gallery->image->disk)->delete($gallery->image->path);
            $gallery->image->delete();
        }
        
        // Supprimer l'élément de galerie
        $gallery->delete();
        
        return redirect()->route('admin.gallery.index')
            ->with('success', 'L\'élément de galerie a été supprimé avec succès.');
    }
    
    /**
     * Active ou désactive un élément de galerie
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleActive(Gallery $gallery): RedirectResponse
    {
        $gallery->update([
            'is_active' => !$gallery->is_active,
        ]);
        
        $status = $gallery->is_active ? 'activé' : 'désactivé';
        
        return redirect()->route('admin.gallery.index')
            ->with('success', "L'élément de galerie a été {$status} avec succès.");
    }
    
    /**
     * Réorganise les éléments de la galerie
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reorder(Request $request): RedirectResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'required|integer|exists:galleries,id',
        ]);
        
        // Mettre à jour l'ordre de chaque élément
        foreach ($request->items as $index => $id) {
            Gallery::where('id', $id)->update(['order' => $index + 1]);
        }
        
        return redirect()->route('admin.gallery.index')
            ->with('success', 'L\'ordre des éléments de la galerie a été mis à jour avec succès.');
    }
}