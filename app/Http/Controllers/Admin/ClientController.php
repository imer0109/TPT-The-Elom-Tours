<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Affiche la liste des clients.
     */
    public function index(Request $request)
    {
        $query = Client::query();
        
        // Filtrage par pays
        if ($request->filled('pays')) {
            $query->where('pays', $request->pays);
        }
        
        // Filtrage par date d'inscription
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        
        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }
        
        $clients = $query->latest()->paginate(10);
        
        // Récupérer les pays distincts pour le filtre
        $pays = Client::distinct()->pluck('pays')->filter()->values();
        
        return view('admin.clients.index', compact('clients', 'pays'));
    }

    /**
     * Affiche le formulaire de création d'un client.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Enregistre un nouveau client.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'create_user' => 'boolean',
            'password' => 'required_if:create_user,1|nullable|min:8|confirmed',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Créer un utilisateur si demandé
            $userId = null;
            if ($request->create_user) {
                $user = User::create([
                    'name' => $validated['prenom'] . ' ' . $validated['nom'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                ]);
                $userId = $user->id;
            }
            
            // Créer le client
            $client = Client::create([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'],
                'telephone' => $validated['telephone'],
                'adresse' => $validated['adresse'],
                'ville' => $validated['ville'],
                'pays' => $validated['pays'],
                'code_postal' => $validated['code_postal'],
                'date_naissance' => $validated['date_naissance'],
                'user_id' => $userId,
            ]);
            
            // Gérer l'upload de photo
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('clients', 'public');
                
                $client->file()->create([
                    'name' => 'photo_profil',
                    'path' => $path,
                    'isCover' => true
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('admin.clients.index')
                ->with('success', 'Client créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la création du client: ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'un client.
     */
    public function show(Client $client)
    {
        // Charger les réservations associées
        $client->load('reservations');
        
        return view('admin.clients.show', compact('client'));
    }

    /**
     * Affiche le formulaire d'édition d'un client.
     */
    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Met à jour un client.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('clients')->ignore($client->id)],
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Mettre à jour le client
            $client->update([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'],
                'telephone' => $validated['telephone'],
                'adresse' => $validated['adresse'],
                'ville' => $validated['ville'],
                'pays' => $validated['pays'],
                'code_postal' => $validated['code_postal'],
                'date_naissance' => $validated['date_naissance'],
            ]);
            
            // Mettre à jour l'utilisateur associé si existant
            if ($client->user_id) {
                User::where('id', $client->user_id)->update([
                    'name' => $validated['prenom'] . ' ' . $validated['nom'],
                    'email' => $validated['email'],
                ]);
            }
            
            // Gérer l'upload de photo
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($client->file) {
                    Storage::disk('public')->delete($client->file->path);
                    $client->file->delete();
                }
                
                // Enregistrer la nouvelle photo
                $path = $request->file('photo')->store('clients', 'public');
                
                $client->file()->create([
                    'name' => 'photo_profil',
                    'path' => $path,
                    'isCover' => true
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('admin.clients.index')
                ->with('success', 'Client mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour du client: ' . $e->getMessage());
        }
    }

    /**
     * Supprime un client.
     */
    public function destroy(Client $client)
    {
        try {
            // Supprimer la photo si elle existe
            if ($client->file) {
                Storage::disk('public')->delete($client->file->path);
                $client->file->delete();
            }
            
            // Supprimer le client (utilise SoftDeletes)
            $client->delete();
            
            return redirect()->route('admin.clients.index')
                ->with('success', 'Client supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la suppression du client: ' . $e->getMessage());
        }
    }
}