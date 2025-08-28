<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    use HasFactory;
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'circuit_id',
        'titre',
        'description',
        'jour',
        'lieu',
        'duree',
        'image',
    ];
    
    /**
     * Obtenir le circuit associé à cette étape.
     */
    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }
}
