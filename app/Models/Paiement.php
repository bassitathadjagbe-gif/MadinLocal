<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    protected $fillable = [
        'commande_id',
        'client_id',
        'montant',
        'methode',
        'statut',
        'reference',
        'operateur',
        'numero_transaction',
        'details',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'details' => 'array',
    ];

    // ===== RELATIONS =====

    /**
     * La commande associée au paiement
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    /**
     * Le client qui a effectué le paiement
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // ===== ACCESSORS =====

    /**
     * Label du statut
     */
    public function getStatutLabelAttribute()
    {
        return [
            'en_attente' => 'En attente',
            'en_cours' => 'En cours de traitement',
            'reussi' => 'Réussi',
            'echoue' => 'Échoué',
            'rembourse' => 'Remboursé',
        ][$this->statut] ?? ucfirst($this->statut);
    }

    /**
     * Classe CSS du badge selon le statut
     */
    public function getStatutBadgeClassAttribute()
    {
        return [
            'en_attente' => 'bg-secondary',
            'en_cours' => 'bg-warning',
            'reussi' => 'bg-success',
            'echoue' => 'bg-danger',
            'rembourse' => 'bg-info',
        ][$this->statut] ?? 'bg-secondary';
    }

    /**
     * Icône du statut
     */
    public function getStatutIconAttribute()
    {
        return [
            'en_attente' => 'bi-hourglass-split',
            'en_cours' => 'bi-arrow-repeat',
            'reussi' => 'bi-check-circle-fill',
            'echoue' => 'bi-x-circle-fill',
            'rembourse' => 'bi-arrow-counterclockwise',
        ][$this->statut] ?? 'bi-question-circle';
    }

    /**
     * Label de la méthode de paiement
     */
    public function getMethodeLabelAttribute()
    {
        return [
            'mobile_money' => 'Mobile Money',
            'carte_bancaire' => 'Carte Bancaire',
            'paiement_livraison' => 'Paiement à la livraison',
        ][$this->methode] ?? ucfirst(str_replace('_', ' ', $this->methode));
    }

    /**
     * Icône de la méthode de paiement
     */
    public function getMethodeIconAttribute()
    {
        return [
            'mobile_money' => 'bi-phone',
            'carte_bancaire' => 'bi-credit-card',
            'paiement_livraison' => 'bi-cash-stack',
        ][$this->methode] ?? 'bi-wallet2';
    }

    /**
     * Couleur de l'opérateur mobile money
     */
    public function getOperateurColorAttribute()
    {
        return [
            'MTN' => '#FFCC00',
            'Moov' => '#0066CC',
            'Celtiis' => '#CC0000',
        ][$this->operateur] ?? '#6c757d';
    }

    /**
     * Montant formaté
     */
    public function getMontantFormateAttribute()
    {
        return number_format($this->montant, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Date formatée
     */
    public function getDateFormateAttribute()
    {
        return $this->created_at->format('d/m/Y à H:i');
    }

    /**
     * Vérifier si le paiement est réussi
     */
    public function getEstReussiAttribute()
    {
        return $this->statut === 'reussi';
    }

    /**
     * Vérifier si le paiement est en attente
     */
    public function getEstEnAttenteAttribute()
    {
        return in_array($this->statut, ['en_attente', 'en_cours']);
    }

    /**
     * Vérifier si le paiement a échoué
     */
    public function getEstEchoueAttribute()
    {
        return $this->statut === 'echoue';
    }

    // ===== SCOPES =====

    /**
     * Scope pour les paiements réussis
     */
    public function scopeReussis($query)
    {
        return $query->where('statut', 'reussi');
    }

    /**
     * Scope pour les paiements en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->whereIn('statut', ['en_attente', 'en_cours']);
    }

    /**
     * Scope pour les paiements échoués
     */
    public function scopeEchoues($query)
    {
        return $query->where('statut', 'echoue');
    }

    /**
     * Scope pour une méthode spécifique
     */
    public function scopeParMethode($query, $methode)
    {
        return $query->where('methode', $methode);
    }

    /**
     * Scope pour un client spécifique
     */
    public function scopePourClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    /**
     * Scope pour une période donnée
     */
    public function scopePeriode($query, $debut, $fin)
    {
        return $query->whereBetween('created_at', [$debut, $fin]);
    }

    // ===== MÉTHODES UTILITAIRES =====

    /**
     * Générer une référence unique
     */
    public static function genererReference()
    {
        return 'PAY-' . strtoupper(\Illuminate\Support\Str::random(10)) . '-' . time();
    }

    /**
     * Générer un numéro de transaction
     */
    public static function genererNumeroTransaction()
    {
        return 'TXN-' . date('Ymd') . '-' . rand(100000, 999999);
    }

    /**
     * Marquer le paiement comme réussi
     */
    public function marquerReussi($details = [])
    {
        $this->update([
            'statut' => 'reussi',
            'details' => array_merge($this->details ?? [], $details, [
                'traite_a' => now()->toISOString(),
                'statut_api' => 'SUCCESS',
            ]),
        ]);

        // Mettre à jour la commande
        if ($this->commande) {
            $this->commande->update(['statut' => 'payee']);
        }
    }

    /**
     * Marquer le paiement comme échoué
     */
    public function marquerEchoue($erreur = null)
    {
        $this->update([
            'statut' => 'echoue',
            'details' => array_merge($this->details ?? [], [
                'traite_a' => now()->toISOString(),
                'statut_api' => 'FAILED',
                'erreur' => $erreur,
            ]),
        ]);
    }

    /**
     * Rembourser le paiement
     */
    public function rembourser($raison = null)
    {
        $this->update([
            'statut' => 'rembourse',
            'details' => array_merge($this->details ?? [], [
                'rembourse_a' => now()->toISOString(),
                'raison_remboursement' => $raison,
            ]),
        ]);

        // Remettre la commande en statut approprié
        if ($this->commande) {
            $this->commande->update(['statut' => 'remboursee']);
        }
    }
}