<?php

namespace App\Models;

use App\Models\Blog;
use App\Models\BlogPost;
use App\Traits\Routing\GenerateUniqueSlugTrait;
use App\Traits\Routing\ModelsSlugKeyTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\LogsActivity;

class Comment extends Model
{
    use HasFactory, HasApiTokens, HasUuids, LogsActivity;

    protected $fillable = [
        'blog_post_id',
        'name',
        'email',
        'comment',
        'parent_id',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relation avec le blog post
     */
    public function blogPost() {
        return $this->belongsTo(BlogPost::class);
    }
    
    /**
     * Relation avec le commentaire parent
     */
    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    
    /**
     * Relation avec les réponses (commentaires enfants)
     */
    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    
    /**
     * Scope pour les commentaires approuvés
     */
    public function scopeApproved($query) {
        return $query->where('is_approved', true);
    }
    
    /**
     * Scope pour les commentaires parents (pas de parent_id)
     */
    public function scopeParents($query) {
        return $query->whereNull('parent_id');
    }
}
