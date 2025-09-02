<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paiement extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reservation_id',
        'montant',
        'methode',
        'statut',
        'reference',
        'date_paiement',
        'commentaire'
    ];
    
    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Les méthodes de paiement disponibles.
     *
     * @var array<string, string>
     */
    public static $methodes = [
        'carte' => 'Carte bancaire',
        'virement' => 'Virement bancaire',
        'especes' => 'Espèces',
        'cheque' => 'Chèque'
    ];
    
    /**
     * Les statuts de paiement disponibles.
     *
     * @var array<string, string>
     */
    public static $statuts = [
        'en_attente' => 'En attente',
        'valide' => 'Validé',
        'refuse' => 'Refusé',
        'rembourse' => 'Remboursé'
    ];
    
    /**
     * Obtenir la réservation associée au paiement.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
    
    /**
     * Vérifier si le paiement est validé.
     *
     * @return bool
     */
    public function isValide()
    {
        return $this->statut === 'valide';
    }
    
    /**
     * Vérifier si le paiement est en attente.
     *
     * @return bool
     */
    public function isEnAttente()
    {
        return $this->statut === 'en_attente';
    }
    
    /**
     * Vérifier si le paiement est refusé.
     *
     * @return bool
     */
    public function isRefuse()
    {
        return $this->statut === 'refuse';
    }
    
    /**
     * Vérifier si le paiement est remboursé.
     *
     * @return bool
     */
    public function isRembourse()
    {
        return $this->statut === 'rembourse';
    }
    
    /**
     * Obtenir le libellé de la méthode de paiement.
     *
     * @return string
     */
    public function getMethodeLabelAttribute()
    {
        return self::$methodes[$this->methode] ?? $this->methode;
    }
    
    /**
     * Obtenir le libellé du statut.
     *
     * @return string
     */
    public function getStatutLabelAttribute()
    {
        return self::$statuts[$this->statut] ?? $this->statut;
    }
    
    /**
     * Obtenir la couleur associée au statut.
     *
     * @return string
     */
    public function getStatutColorAttribute()
    {
        $colors = [
            'en_attente' => 'yellow',
            'valide' => 'green',
            'refuse' => 'red',
            'rembourse' => 'purple'
        ];

        return $colors[$this->statut] ?? 'gray';
    }
}