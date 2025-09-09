<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Destination extends Model
{
    use HasFactory, HasUuids, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'country',
        'city',
        'is_popular',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($destination) {
            if (empty($destination->slug)) {
                $destination->slug = Str::slug($destination->name);
            }
        });
    }

    /**
     * Get the image associated with the destination.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(File::class, 'owner');
    }

    /**
     * Get the circuits associated with the destination.
     */
    public function circuits(): HasMany
    {
        // The circuits table uses a 'destination' string column instead of 'destination_id'
        // so we link on Destination.name -> Circuit.destination
        return $this->hasMany(Circuit::class, 'destination', 'name');
    }

    /**
     * Get the URL of the first media.
     */
    public function getFirstMediaUrl(string $collection = ''): ?string
    {
        if ($this->image) {
            return $this->image->getFileUrl();
        }
        return null;
    }
}