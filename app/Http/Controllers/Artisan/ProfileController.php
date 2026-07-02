<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $artisan = $user->artisan;
        
        return view('artisan.profile.edit', compact('user', 'artisan'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $artisan = $user->artisan;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'specialite' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Mise à jour de l'utilisateur
        $user->name = $request->name;
        $user->email = $request->email;

        // Gestion de l'avatar
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        // Mise à jour de l'artisan
        $artisan->telephone = $request->telephone;
        $artisan->specialite = $request->specialite;
        $artisan->ville = $request->ville;
        $artisan->description = $request->description;
        $artisan->save();

        return redirect()->route('artisan.dashboard')
            ->with('success', '✅ Profil mis à jour avec succès !');
    }

    
}
