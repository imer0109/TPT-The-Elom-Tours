<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Si l'utilisateur a le rôle SUPER_ADMIN, il a accès à tout
        if ($user->hasRole('Super Administrateur')) {
            return $next($request);
        }

        // Vérifier si l'utilisateur a au moins un des rôles requis
        if (empty($roles) || $user->hasAnyRole($roles)) {
            return $next($request);
        }

        abort(403, 'Accès non autorisé');
    }
}