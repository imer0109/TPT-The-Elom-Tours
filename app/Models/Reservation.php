<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'circuit_id',
        'date_debut',
        'date_fin',
        'nombre_personnes',
        'montant_total',
        'status',
        'commentaire',
        'reference'
    ];
    
    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
        'nombre_personnes' => 'integer',
        'montant_total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reservation) {
            // Générer une référence unique pour la réservation si elle n'existe pas déjà
            if (!$reservation->reference) {
                $reservation->reference = 'RES-' . strtoupper(Str::random(8));
            }
        });
    }
    /**
     * Obtenir le client associé à la réservation.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    /**
     * Obtenir le circuit associé à la réservation.
     */
    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }
    
    /**
     * Obtenir les paiements associés à la réservation.
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
    
    /**
     * Vérifier si la réservation est confirmée.
     *
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }
    
    /**
     * Vérifier si la réservation est en attente.
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }
    
    /**
     * Vérifier si la réservation est annulée.
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
    
    /**
     * Vérifier si la réservation est terminée.
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
    
    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    /**
     * Calculer la durée du séjour en jours.
     *
     * @return int
     */
    public function getDureeAttribute()
    {
        if ($this->date_debut && $this->date_fin) {
            return $this->date_debut->diffInDays($this->date_fin) + 1;
        }
        return 0;
    }
    
    /**
     * Obtenir le libellé du statut.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmée',
            'cancelled' => 'Annulée',
            'completed' => 'Terminée',
            'refunded' => 'Remboursée'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Obtenir la couleur associée au statut.
     *
     * @return string
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'confirmed' => 'green',
            'cancelled' => 'red',
            'completed' => 'blue',
            'refunded' => 'purple'
        ];

        return $colors[$this->status] ?? 'gray';
    }
    
    /**
     * Calculer le montant restant à payer.
     *
     * @return float
     */
    public function getMontantRestantAttribute()
    {
        $paiementsTotal = $this->paiements()->sum('montant');
        return $this->montant_total - $paiementsTotal;
    }
}