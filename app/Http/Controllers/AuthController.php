<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artisan;
use App\Models\Investisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ===== AFFICHAGE DES FORMULAIRES =====

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // ===== INSCRIPTION =====

    public function register(Request $request)
{
    $validated = $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'phone' => ['nullable', 'string', 'max:20'],
        'role' => ['required', 'in:client,artisan,investisseur'],
        'password' => ['required', 'confirmed', Password::min(6)],
        'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
    ], [
        'first_name.required' => 'Le prénom est obligatoire.',
        'last_name.required' => 'Le nom est obligatoire.',
        'email.required' => 'L\'email est obligatoire.',
        'email.unique' => 'Cet email est déjà utilisé.',
        'role.required' => 'Veuillez choisir votre profil.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        'avatar.image' => 'Le fichier doit être une image.',
        'avatar.max' => 'L\'image ne doit pas dépasser 2 Mo.',
    ]);

    // Gestion de l'upload de l'avatar
    $avatarPath = null;
    if ($request->hasFile('avatar')) {
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
    }

    // Combinaison du prénom et du nom
    $fullName = $validated['first_name'] . ' ' . $validated['last_name'];

    // Création de l'utilisateur
    $user = User::create([
        'name' => $fullName,
        'email' => $validated['email'],
        'phone' => $validated['phone'] ?? null,
        'role' => $validated['role'],
        'password' => Hash::make($validated['password']),
        'is_active' => true,
        'is_admin' => false,
        'avatar' => $avatarPath,
    ]);

    // Création du profil associé au rôle
    if ($user->role === 'artisan') {
        Artisan::create([
            'user_id' => $user->id,
            'nom_entreprise' => 'Mon atelier',
            'specialite' => 'À définir',
        ]);
    } elseif ($user->role === 'investisseur') {
        Investisseur::create([
            'user_id' => $user->id,
            'entreprise' => 'Mon entreprise',
            'type_investissement' => 'Financement',
        ]);
    }

    // ✅ Redirection vers la page de connexion
    return redirect()->route('login')
        ->with('success', '✅ Compte créé avec succès ! Connectez-vous maintenant pour accéder à votre espace.');
}
    // ===== CONNEXION =====

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'L\'email est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Vérifier si le compte est actif
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
                ]);
            }

            // ✅ Redirection intelligente (admin en priorité)
            return redirect()->intended(route($this->getDashboardRoute($user)))
                ->with('success', 'Connexion réussie !');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    // ===== DÉCONNEXION =====

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('accueil')
            ->with('success', 'Vous avez été déconnecté.');
    }

    // ===== HELPER : Route du dashboard selon le profil =====
    // ✅ CORRECTION : Vérifie d'abord si l'utilisateur est admin

    private function getDashboardRoute(User $user): string
    {
        // 🛡️ PRIORITÉ 1 : Si l'utilisateur est admin → Dashboard Admin
        if ($user->is_admin) {
            return 'admin.dashboard';
        }

        // 🎯 PRIORITÉ 2 : Sinon, selon le rôle métier
        return match($user->role) {
            'artisan' => 'artisan.dashboard',
            'investisseur' => 'investisseur.dashboard',
            'client' => 'client.dashboard',
            default => 'accueil',
        };
    }
}