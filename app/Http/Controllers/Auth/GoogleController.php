<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            Log::info('Google User:', [
                'id' => $googleUser->id,
                'email' => $googleUser->email,
                'name' => $googleUser->name,
            ]);

            // Chercher l'utilisateur par google_id
            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                // Chercher par email
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    // Lier le compte Google au compte existant
                    $existingUser->update([
                        'google_id' => $googleUser->id,
                    ]);
                    $user = $existingUser;
                    Log::info('Compte existant lié:', ['user_id' => $user->id]);
                } else {
                    // Créer un nouveau compte
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => Hash::make('google_' . $googleUser->id),
                        'role' => 'client',
                        'email_verified_at' => now(),
                    ]);
                    Log::info('Nouveau compte créé:', ['user_id' => $user->id]);
                }
            }

            // Connexion explicite
            Auth::login($user, true);

            Log::info('Utilisateur connecté:', [
                'user_id' => $user->id,
                'role' => $user->role,
            ]);

            // Redirection selon le rôle
            return $this->redirectToDashboard($user);

        } catch (\Exception $e) {
            Log::error('Erreur Google OAuth:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')
                ->with('error', 'Erreur lors de la connexion avec Google : ' . $e->getMessage());
        }
    }

    private function redirectToDashboard($user)
    {
        switch ($user->role) {
            case 'client':
                return redirect()->route('client.dashboard');
            case 'artisan':
                return redirect()->route('artisan.dashboard');
            case 'investisseur':
                return redirect()->route('investisseur.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            default:
                return redirect()->route('accueil');
        }
    }
}