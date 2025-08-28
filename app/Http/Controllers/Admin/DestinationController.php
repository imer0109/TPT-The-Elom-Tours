<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DestinationController extends Controller
{
    /**
     * Affiche la liste des destinations
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $destinations = Destination::orderBy('name')->paginate(10);
        
        return view('admin.destinations.index', compact('destinations'));
    }

    /**
     * Affiche le formulaire de création d'une destination
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.destinations.create');
    }

    /**
     * Enregistre une nouvelle destination
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:destinations',
            'description' => 'required|string',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);
        
        // Générer le slug à partir du nom
        $validated['slug'] = Str::slug($validated['name']);
        
        // Gestion des cases à cocher
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_active'] = $request->has('is_active');
        
        Destination::create($validated);
        
        return redirect()->route('admin.destinations.index')->with('success', 'Destination créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'une destination
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\View\View
     */
    public function edit(Destination $destination): View
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    /**
     * Met à jour une destination
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Destination $destination): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:destinations,name,' . $destination->id,
            'description' => 'required|string',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);
        
        // Mettre à jour le slug si le nom a changé
        if ($destination->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Gestion des cases à cocher
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_active'] = $request->has('is_active');
        
        $destination->update($validated);
        
        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination mise à jour avec succès.');
    }

    /**
     * Supprime une destination
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Destination $destination): RedirectResponse
    {
        // Vérifier si la destination est utilisée par des circuits
        if ($destination->circuits()->count() > 0) {
            return redirect()->route('admin.destinations.index')
                ->with('error', 'Cette destination ne peut pas être supprimée car elle est utilisée par des circuits.');
        }
        
        $destination->delete();
        
        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination supprimée avec succès.');
    }
    
    /**
     * Active ou désactive une destination
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleActive(Destination $destination): RedirectResponse
    {
        $destination->update([
            'is_active' => !$destination->is_active
        ]);
        
        $status = $destination->is_active ? 'activée' : 'désactivée';
        
        return redirect()->route('admin.destinations.index')
            ->with('success', "La destination a été {$status} avec succès.");
    }
    
    /**
     * Marque ou démarque une destination comme populaire
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\RedirectResponse
     */
    public function togglePopular(Destination $destination): RedirectResponse
    {
        $destination->update([
            'is_popular' => !$destination->is_popular
        ]);
        
        $status = $destination->is_popular ? 'marquée comme populaire' : 'retirée des destinations populaires';
        
        return redirect()->route('admin.destinations.index')
            ->with('success', "La destination a été {$status} avec succès.");
    }
}