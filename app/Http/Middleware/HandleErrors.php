<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HandleErrors
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (\Exception $e) {
            // Logger l'erreur
            Log::error('Erreur non gérée', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'url' => $request->url(),
                'user_id' => auth()->id(),
            ]);

            // Rediriger avec un message d'erreur
            return back()->with('error', 'Une erreur inattendue est survenue. Veuillez réessayer.');
        }
    }
}