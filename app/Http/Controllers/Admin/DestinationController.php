<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Services\ActivityLogService;

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
    // Modifier la méthode store pour gérer l'upload d'image
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Générer le slug à partir du nom
        $validated['slug'] = Str::slug($validated['name']);
        
        // Gestion des cases à cocher
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_active'] = $request->has('is_active');
        
        $destination = Destination::create($validated);
        
        // Gérer l'upload d'image si présente
        if ($request->hasFile('image')) {
            $original = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = $request->file('image')->getClientOriginalExtension();
            $safe = Str::slug($original);
            $filename = time() . '_' . ($safe ?: 'image') . ($ext ? ('.' . $ext) : '');
            $path = $request->file('image')->storeAs('destinations', $filename, 'public');
            
            $file = new \App\Models\File([
                'name' => $request->file('image')->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $request->file('image')->getMimeType(),
                'size' => $request->file('image')->getSize(),
            ]);
            
            $destination->image()->save($file);
        }
        
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
    // Modifier la méthode update pour gérer l'upload d'image
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Mettre à jour le slug si le nom a changé
        if ($destination->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Gestion des cases à cocher
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_active'] = $request->has('is_active');
        
        $destination->update($validated);
        
        // Gérer l'upload d'image si présente
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($destination->image) {
                Storage::disk('public')->delete($destination->image->path);
                $destination->image->delete();
            }
            
            $original = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = $request->file('image')->getClientOriginalExtension();
            $safe = Str::slug($original);
            $filename = time() . '_' . ($safe ?: 'image') . ($ext ? ('.' . $ext) : '');
            $path = $request->file('image')->storeAs('destinations', $filename, 'public');
            
            $file = new \App\Models\File([
                'name' => $request->file('image')->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $request->file('image')->getMimeType(),
                'size' => $request->file('image')->getSize(),
            ]);
            
            $destination->image()->save($file);
        }
        
        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination mise à jour avec succès.');
    }

    /**
     * Supprime une destination
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Destination $destination, ActivityLogService $activityLogService): RedirectResponse
    {
        // Vérifier si la destination est utilisée par des circuits
        if ($destination->circuits()->count() > 0) {
            return redirect()->route('admin.destinations.index')
                ->with('error', 'Cette destination ne peut pas être supprimée car elle est utilisée par des circuits.');
        }
        
        // Administrateur: archive (soft delete). Super Administrateur: suppression définitive
        $user = auth()->user();
        if ($user && $user->hasRole('Super Administrateur')) {
            $activityLogService->logDeleted($destination);
            $destination->forceDelete();
        } else {
            $destination->delete();
            $activityLogService->logArchived($destination);
        }
        
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