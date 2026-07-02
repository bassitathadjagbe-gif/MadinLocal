<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Vérifier si l'utilisateur a le rôle requis OU est admin
        if (auth()->user()->role !== $role && !auth()->user()->is_admin) {
            abort(403, 'ACCÈS NON AUTORISÉ POUR VOTRE RÔLE.');
        }

        return $next($request);
    }
}