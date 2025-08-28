<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traite la demande de connexion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // \Log::info('Credentials: ', $credentials);

    // Debug: vérifiez si l'utilisateur existe
    $user = \App\Models\User::where('email', $credentials['email'])->first();
    // \Log::info('User found: ' . ($user ? $user->id : 'null'));

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        // \Log::info('Connexion réussie');
        $request->session()->regenerate();
        return view('admin.dashboard');
    }

    // \Log::info('Échec de connexion');
    return back()->withErrors([
        'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
    ])->onlyInput('email');
}
    /**
     * Déconnecte l'utilisateur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    { 
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}