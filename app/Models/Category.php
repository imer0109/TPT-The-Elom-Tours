<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasFactory, HasApiTokens, HasUuids;

    protected $guarded = ['id'];

    public $timestamps = false;
    
    /**
     * Les attributs par défaut du modèle.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function typeProduct()
    {
        return $this->belongsTo(TypeProduct::class);
    }
    
    /**
     * Get the blog posts for the category.
     */
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }
    
    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        // Vérifier si la colonne is_active existe avant de l'utiliser
        if (\Illuminate\Support\Facades\Schema::hasColumn('categories', 'is_active')) {
            return $query->where('is_active', true);
        }
        
        return $query; // Retourner la requête sans filtre si la colonne n'existe pas
    }
}
