<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Artisan\DashboardController as ArtisanDashboard;
use App\Http\Controllers\Artisan\ProduitController;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;
use App\Http\Controllers\Investisseur\DashboardController as InvestisseurDashboard;
use App\Http\Controllers\CatalogueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Client\PanierController;
use App\Http\Controllers\Investisseur\PropositionController;
use App\Http\Controllers\Admin\PropositionController as AdminPropositionController;
// ===== PAGE D'ACCUEIL PUBLIQUE =====
Route::get('/', [AccueilController::class, 'accueil'])->name('accueil');

// ===== CATALOGUE PUBLIC =====
Route::get('/catalogue', [CatalogueController::class, 'index'])->name('catalogue');
Route::get('/produit/{produit}', [CatalogueController::class, 'show'])->name('produit.show');
// ===== AUTHENTIFICATION =====
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
// ===== GOOGLE AUTH =====
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
// ===== PAGES LÉGALES =====
Route::get('/conditions', function () {
    return view('pages.conditions');
})->name('conditions');

Route::get('/confidentialite', function () {
    return view('pages.confidentialite');
})->name('confidentialite');
// ===== PAGE CONTACT =====
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

// ===== MOT DE PASSE OUBLIÉ =====
Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ===== REDIRECTION PAR DÉFAUT =====
Route::get('/dashboard', function () {
    $user = auth()->user();
    return redirect()->route(match($user->role) {
        'artisan' => 'artisan.dashboard',
        'investisseur' => 'investisseur.dashboard',
        default => 'client.dashboard',
    });
})->middleware('auth')->name('dashboard');

// ===== ESPACE ARTISAN =====
Route::middleware(['auth', 'role:artisan'])->prefix('artisan')->name('artisan.')->group(function () {
    Route::get('/dashboard', [ArtisanDashboard::class, 'index'])->name('dashboard');
    Route::resource('produits', ProduitController::class);
  // Commandes
    Route::get('/commandes', [App\Http\Controllers\Artisan\CommandeController::class, 'index'])->name('commandes.index');
    Route::put('/commandes/{commande}/accepter', [App\Http\Controllers\Artisan\CommandeController::class, 'accepter'])
        ->name('commandes.accepter');
    
    Route::put('/commandes/{commande}/refuser', [App\Http\Controllers\Artisan\CommandeController::class, 'refuser'])
        ->name('commandes.refuser');
         // ✅ NOUVELLE ROUTE : Marquer comme terminée
    Route::put('/commandes/{commande}/terminer', [App\Http\Controllers\Artisan\CommandeController::class, 'terminer'])
        ->name('commandes.terminer');
    
    Route::get('/commandes', [App\Http\Controllers\Artisan\CommandeController::class, 'index'])
        ->name('commandes.index');
    
    // Route pour lister les commandes (si elle n'existe pas déjà)
    Route::get('/commandes', [App\Http\Controllers\Artisan\CommandeController::class, 'index'])
        ->name('commandes.index');
     Route::get('/rendez-vous', [App\Http\Controllers\Artisan\DashboardController::class, 'rendezVous'])->name('rendez_vous.index');
    
    // Confirmation de rendez-vous
    Route::post('/rendez-vous/{rdv}/confirmer', [App\Http\Controllers\Artisan\DashboardController::class, 'confirmerRdv'])->name('rendez_vous.confirmer');
    Route::post('/rendez-vous/{rdv}/terminer', [App\Http\Controllers\Artisan\DashboardController::class, 'terminerRdv'])->name('rendez_vous.terminer');
    // ✅ Gestion des propositions d'investissement reçues
   Route::get('/propositions', [App\Http\Controllers\Artisan\PropositionController::class, 'index'])
    ->name('propositions.index');

Route::put('/propositions/{proposition}/accepter', [App\Http\Controllers\Artisan\PropositionController::class, 'accepter'])
    ->name('propositions.accepter');

Route::put('/propositions/{proposition}/refuser', [App\Http\Controllers\Artisan\PropositionController::class, 'refuser'])
    ->name('propositions.refuser');

Route::get('/propositions/historique', [App\Http\Controllers\Artisan\PropositionController::class, 'historique'])
    ->name('propositions.historique');
});



// ===== ESPACE CLIENT =====
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('dashboard');
    Route::get('/profil', [App\Http\Controllers\Client\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [App\Http\Controllers\Client\ProfilController::class, 'update'])->name('profil.update');
    Route::get('/favoris', [App\Http\Controllers\Client\FavorisController::class, 'index'])->name('favoris.index');
    Route::post('/favoris/{produit}', [App\Http\Controllers\Client\FavorisController::class, 'toggle'])->name('favoris.toggle');
     // Routes de paiement
    Route::get('/paiement/{commande}', [App\Http\Controllers\PaymentController::class, 'show'])->name('paiement.show');
    Route::post('/paiement/{commande}', [App\Http\Controllers\PaymentController::class, 'process'])->name('paiement.process');
    Route::get('/paiement/{paiement}/status', [App\Http\Controllers\PaymentController::class, 'status'])->name('paiement.status');
    // Rendez-vous
    Route::get('/rendez-vous', [App\Http\Controllers\Client\RendezVousController::class, 'index'])->name('rendez_vous.index');
    Route::get('/rendez-vous/{service}/prendre', [App\Http\Controllers\Client\RendezVousController::class, 'create'])->name('rendez_vous.create');
    Route::post('/rendez-vous/{service}', [App\Http\Controllers\Client\RendezVousController::class, 'store'])->name('rendez_vous.store');
    Route::get('/rendez-vous/{rdv}/confirmation', [App\Http\Controllers\Client\RendezVousController::class, 'confirmation'])->name('rendez_vous.confirmation');
    // Routes du panier
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier/ajouter/{produit}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::put('/panier/{panier}', [PanierController::class, 'update'])->name('panier.update');
    Route::delete('/panier/{panier}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
    Route::delete('/panier/vider/tout', [PanierController::class, 'vider'])->name('panier.vider');
        // ✅ Route pour commander directement (sans panier)
 Route::post('/commander/{produit}', [App\Http\Controllers\CommandeController::class, 'store'])->name('commande.store');
 // ✅ NOUVELLE ROUTE : Commander depuis le panier
    Route::post('/panier/commander', [PanierController::class, 'commanderDepuisPanier'])
        ->name('panier.commander');
        // ✅ NOUVELLE ROUTE : Commander un seul produit du panier
    Route::post('/panier/commander-un/{panier}', [PanierController::class, 'commanderUnProduit'])
        ->name('panier.commanderUn');
});
 
Route::middleware(['auth'])->group(function () {
    Route::get('/commander/{produit}', [CommandeController::class, 'create'])->name('commande.create');
    Route::post('/commander/{produit}', [CommandeController::class, 'store'])->name('commande.store');
    Route::get('/mes-commandes', [CommandeController::class, 'mesCommandes'])->name('client.commandes.index');
});

/// ===== INVESTISSEUR =====
Route::middleware(['auth', 'role:investisseur'])->prefix('investisseur')->name('investisseur.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Investisseur\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/entreprise', [App\Http\Controllers\Investisseur\DashboardController::class, 'entreprise'])->name('entreprise');
    Route::put('/entreprise', [App\Http\Controllers\Investisseur\DashboardController::class, 'entrepriseUpdate'])->name('entreprise.update');
    Route::get('/opportunites', [App\Http\Controllers\Investisseur\DashboardController::class, 'opportunites'])->name('opportunites');
    // Propositions (l'investisseur soumet)
    Route::post('/propositions', [PropositionController::class, 'store'])->name('propositions.store');
    Route::get('/mes-propositions', [PropositionController::class, 'index'])->name('propositions.index');
    Route::get('/propositions/creer/{artisan}', [App\Http\Controllers\Investisseur\PropositionController::class, 'create'])
    ->name('propositions.create');
    // Profil entreprise
Route::get('/entreprise', [App\Http\Controllers\Investisseur\DashboardController::class, 'entreprise'])
    ->name('entreprise');

Route::put('/entreprise', [App\Http\Controllers\Investisseur\DashboardController::class, 'updateEntreprise'])
    ->name('entreprise.update');
});

// ===== ADMIN =====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
     Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    // Liste des produits à valider
    Route::get('/produits/validation', [App\Http\Controllers\Admin\ProduitController::class, 'index'])->name('produits.index');
    
    // Détails d'un produit
    Route::get('/produits/{produit}', [App\Http\Controllers\Admin\ProduitController::class, 'show'])->name('produits.show');
    
    // Valider un produit
    Route::post('/produits/{produit}/validate', [App\Http\Controllers\Admin\ProduitController::class, 'validateProduit'])->name('produits.validate');
    
    // Rejeter un produit
    Route::post('/produits/{produit}/reject', [App\Http\Controllers\Admin\ProduitController::class, 'reject'])->name('produits.reject');
    
    // Supprimer un produit
    Route::delete('/produits/{produit}', [App\Http\Controllers\Admin\ProduitController::class, 'destroy'])->name('produits.destroy');
    // Validation des propositions
    Route::get('/propositions', [App\Http\Controllers\Admin\PropositionController::class, 'index'])
    ->name('propositions.index');

Route::put('/propositions/{proposition}/valider', [App\Http\Controllers\Admin\PropositionController::class, 'valider'])
    ->name('propositions.valider');

Route::put('/propositions/{proposition}/refuser', [App\Http\Controllers\Admin\PropositionController::class, 'refuser'])
    ->name('propositions.refuser');
    Route::get('/propositions/historique', [AdminPropositionController::class, 'historique'])->name('propositions.historique');
    // Gestion des investisseurs par l'admin
Route::get('/investisseurs', [App\Http\Controllers\Admin\InvestisseurController::class, 'index'])->name('investisseurs.index');
Route::put('/investisseurs/{user}/valider', [App\Http\Controllers\Admin\InvestisseurController::class, 'valider'])->name('investisseurs.valider');
Route::put('/investisseurs/{user}/rejeter', [App\Http\Controllers\Admin\InvestisseurController::class, 'rejeter'])->name('investisseurs.rejeter');
// Gestion et validation des artisans par l'admin
Route::get('/artisans', [App\Http\Controllers\Admin\ArtisanController::class, 'index'])->name('artisans.index');
Route::put('/artisans/{artisan}/valider', [App\Http\Controllers\Admin\ArtisanController::class, 'valider'])->name('artisans.valider');
Route::put('/artisans/{artisan}/rejeter', [App\Http\Controllers\Admin\ArtisanController::class, 'rejeter'])->name('artisans.rejeter');
});
// ===== ESPACE ARTISAN =====
Route::middleware(['auth', 'role:artisan'])->prefix('artisan')->name('artisan.')->group(function () {
    Route::get('/dashboard', [ArtisanDashboard::class, 'index'])->name('dashboard');
    Route::resource('produits', ProduitController::class);
    Route::get('/profile', [App\Http\Controllers\Artisan\ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profile', [App\Http\Controllers\Artisan\ProfileController::class, 'update'])->name('profil.update');

    
    // ✅ AJOUTER CES ROUTES POUR LE PROFIL
    Route::get('/profil', [\App\Http\Controllers\Artisan\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profil/edit', [\App\Http\Controllers\Artisan\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [\App\Http\Controllers\Artisan\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil/portfolio/{index}', [\App\Http\Controllers\Artisan\ProfileController::class, 'deletePortfolioImage'])->name('profile.deleteImage');
});

// ===== MESSAGERIE =====
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{partnerId}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{partnerId}', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::get('/contacter/{produit}', [\App\Http\Controllers\MessageController::class, 'createFromProduit'])->name('messages.createFromProduit');
});

// ===== FAVORIS =====
Route::middleware(['auth'])->group(function () {
    Route::post('/favoris/{produit}', [\App\Http\Controllers\FavoriController::class, 'toggle'])->name('favoris.toggle');
});

// ===== ÉVALUATIONS =====
    Route::middleware(['auth'])->group(function () {
    Route::get('/evaluations/commande/{commande}', [\App\Http\Controllers\EvaluationController::class, 'create'])->name('evaluations.create');
    Route::post('/evaluations/commande/{commande}', [\App\Http\Controllers\EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('/artisans/{artisan}/evaluations', [\App\Http\Controllers\EvaluationController::class, 'index'])->name('evaluations.index');
});

// Notifications (pour tous les utilisateurs authentifiés)
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/delete-all-read', [App\Http\Controllers\NotificationController::class, 'deleteAllRead'])->name('notifications.delete-all-read');
     // Afficher une commande spécifique
    Route::get('/commandes/{commande}', [App\Http\Controllers\CommandeController::class, 'show'])->name('commandes.client.show');
});