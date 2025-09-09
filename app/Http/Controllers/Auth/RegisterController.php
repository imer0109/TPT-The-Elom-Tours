<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Affiche le formulaire d'inscription
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Traite la demande d'inscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'lastName' => ['required', 'string', 'max:255'],
            'firstName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        // Dans la méthode register, après la création de l'utilisateur
        $user = User::create([
            'lastName' => $validated['lastName'],
            'firstName' => $validated['firstName'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'Utilisateur', // Assurez-vous que c'est une valeur valide de RoleEnum
        ]);
        
        // Attribuer le rôle correspondant
        $role = Role::where('name', $user->role)->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }
        
        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }
}