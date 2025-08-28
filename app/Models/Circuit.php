<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    use HasFactory;
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titre',
        'slug',
        'description',
        'duree',
        'prix',
        'image',
        'destination',
        'difficulte',
        'taille_groupe',
        'langues',
        'est_actif',
    ];
    
    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'langues' => 'array',
        'est_actif' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Obtenir les réservations associées au circuit.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
    /**
     * Obtenir les catégories associées au circuit.
     */
    public function categories()
    {
        return $this->belongsToMany(Categorie::class, 'circuit_categorie');
    }
    
    /**
     * Obtenir les avis associés au circuit.
     */
    public function avis()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Obtenir les images associées au circuit.
     */
    public function images()
    {
        return $this->hasMany(CircuitImage::class);
    }
    
    /**
     * Obtenir les étapes de l'itinéraire associées au circuit.
     */
    public function etapes()
    {
        return $this->hasMany(Etape::class)->orderBy('jour', 'asc');
    }
    
    /**
     * Calculer la note moyenne du circuit.
     *
     * @return float
     */
    public function getNoteMoyenneAttribute()
    {
        return $this->avis()->avg('rating') ?: 0;
    }
    
    /**
     * Obtenir le nombre total d'avis pour le circuit.
     *
     * @return int
     */
    public function getNombreAvisAttribute()
    {
        return $this->avis()->count();
    }
    
    /**
     * Obtenir le nombre de réservations pour le circuit.
     *
     * @return int
     */
    public function getNombreReservationsAttribute()
    {
        return $this->reservations()->where('statut', 'confirmed')->count();
    }
}