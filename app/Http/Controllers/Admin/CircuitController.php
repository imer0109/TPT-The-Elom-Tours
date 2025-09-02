<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Circuit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CircuitController extends Controller
{
    /**
     * Affiche la liste des circuits
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Circuit::with(['categories', 'avis']);

        // Filtre par destination
        if ($request->filled('destination')) {
            $query->where('destination', $request->destination);
        }

        // Filtre par difficulté
        if ($request->filled('difficulte')) {
            $query->where('difficulte', $request->difficulte);
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('est_actif', $request->statut === 'actif');
        }

        // Recherche par titre ou destination
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        $circuits = $query->latest()->paginate(9);
        return view('admin.circuits.index', compact('circuits'));
    }

    /**
     * Affiche le formulaire de création d'un circuit
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categorie::orderBy('nom')->get();
        return view('admin.circuits.create', compact('categories'));
    }

    /**
     * Enregistre un nouveau circuit
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:circuits',
            'description' => 'required|string',
            'duree' => 'required|integer|min:1',
            'prix' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Image principale du circuit
            'destination' => 'required|string|max:255',
            'difficulte' => 'required|string|in:facile,modere,difficile',
            'taille_groupe' => 'required|integer|min:1',
            'langues' => 'required|array',
            'est_actif' => 'boolean',
            'categories' => 'nullable|array',
        ]);

        // Gestion du slug
        $slug = $request->slug ?? Str::slug($request->titre);

        // Gestion de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            // Utiliser une méthode alternative pour enregistrer l'image
            $destinationPath = public_path('storage/circuits');
            
            // S'assurer que le répertoire existe
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            // Déplacer le fichier manuellement
            $image->move($destinationPath, $imageName);
            $imagePath = 'circuits/' . $imageName;
        }

        // Création du circuit
        $circuit = Circuit::create([
            'titre' => $request->titre,
            'slug' => $slug,
            'description' => $request->description,
            'duree' => $request->duree,
            'prix' => $request->prix,

            'destination' => $request->destination,
            'difficulte' => $request->difficulte,
            'taille_groupe' => $request->taille_groupe,
            'langues' => $request->langues,
            'est_actif' => $request->est_actif ?? false,
        ]);

        // Associer les catégories
        if ($request->has('categories')) {
            $circuit->categories()->attach($request->categories);
        }

        // Créer l'image du circuit si elle existe
        if ($imagePath) {
            $circuit->images()->create([
                'url' => $imagePath,
                'alt' => $request->titre,
                'ordre' => 1
            ]);
        }

        return redirect()->route('admin.circuits.index')
            ->with('success', 'Circuit créé avec succès.');
    }

    /**
     * Affiche les détails d'un circuit
     *
     * @param  \App\Models\Circuit  $circuit
     * @return \Illuminate\Http\Response
     */
    public function show(Circuit $circuit)
    {
        $circuit->load(['categories', 'avis', 'etapes', 'images']);
        return view('admin.circuits.show', compact('circuit'));
    }

    /**
     * Affiche le formulaire d'édition d'un circuit
     *
     * @param  \App\Models\Circuit  $circuit
     * @return \Illuminate\Http\Response
     */
    public function edit(Circuit $circuit)
    {
        $categories = Categorie::orderBy('nom')->get();
        $circuit->load('categories');
        return view('admin.circuits.edit', compact('circuit', 'categories'));
    }

    /**
     * Met à jour un circuit
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Circuit  $circuit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Circuit $circuit)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:circuits,slug,' . $circuit->id,
            'description' => 'required|string',
            'duree' => 'required|integer|min:1',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'destination' => 'required|string|max:255',
            'difficulte' => 'required|string|in:facile,modere,difficile',
            'taille_groupe' => 'required|integer|min:1',
            'langues' => 'required|array',
            'est_actif' => 'boolean',
            'categories' => 'nullable|array',
        ]);

        // Gestion du slug
        $slug = $request->slug ?? Str::slug($request->titre);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($circuit->images()->exists()) {
                $oldImage = $circuit->images()->first();
                // Supprimer le fichier physique
                $oldImagePath = public_path('storage/' . $oldImage->url);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $oldImage->delete();
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            // Utiliser une méthode alternative pour enregistrer l'image
            $destinationPath = public_path('storage/circuits');
            
            // S'assurer que le répertoire existe
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            // Déplacer le fichier manuellement
            $image->move($destinationPath, $imageName);
            $imagePath = 'circuits/' . $imageName;
            
            // Créer une nouvelle image de circuit
            $circuit->images()->create([
                'url' => $imagePath,
                'alt' => $request->titre,
                'ordre' => 1
            ]);
        }

        // Mise à jour du circuit
        $circuit->update([
            'titre' => $request->titre,
            'slug' => $slug,
            'description' => $request->description,
            'duree' => $request->duree,
            'prix' => $request->prix,

            'destination' => $request->destination,
            'difficulte' => $request->difficulte,
            'taille_groupe' => $request->taille_groupe,
            'langues' => $request->langues,
            'est_actif' => $request->est_actif ?? false,
        ]);

        // Mettre à jour les catégories
        if ($request->has('categories')) {
            $circuit->categories()->sync($request->categories);
        } else {
            $circuit->categories()->detach();
        }

        return redirect()->route('admin.circuits.index')
            ->with('success', 'Circuit mis à jour avec succès.');
    }

    /**
     * Supprime un circuit
     *
     * @param  \App\Models\Circuit  $circuit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Circuit $circuit)
    {
        // Supprimer les images associées
        foreach ($circuit->images as $image) {
            // Supprimer le fichier physique
            $imagePath = public_path('storage/' . $image->url);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image->delete();
        }

        // Supprimer le circuit
        $circuit->delete();

        return redirect()->route('admin.circuits.index')
            ->with('success', 'Circuit supprimé avec succès.');
    }

    /**
     * Active ou désactive un circuit
     *
     * @param  \App\Models\Circuit  $circuit
     * @return \Illuminate\Http\Response
     */
    public function toggleActive(Circuit $circuit)
    {
        $circuit->update([
            'est_actif' => !$circuit->est_actif
        ]);

        return redirect()->route('admin.circuits.index')
            ->with('success', 'Statut du circuit mis à jour avec succès.');
    }
}