<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\LogsActivity;

class Client extends Model
{
    use HasFactory, HasApiTokens, HasUuids, SoftDeletes, LogsActivity;

    protected $guarded = ['id'];

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'ville',
        'pays',
        'code_postal',
        'date_naissance',
        'user_id'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'owner');
    }
    
    /**
     * Obtenir les réservations associées au client.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
    
    /**
     * Obtenir l'utilisateur associé au client.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Obtenir le nom complet du client.
     *
     * @return string
     */
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }
    
    /**
     * Obtenir le nombre de réservations du client.
     *
     * @return int
     */
    public function getNombreReservationsAttribute(): int
    {
        return $this->reservations()->count();
    }
    
    /**
     * Obtenir le montant total dépensé par le client.
     *
     * @return float
     */
    public function getMontantTotalAttribute(): float
    {
        return $this->reservations()->sum('montant_total');
    }
}
