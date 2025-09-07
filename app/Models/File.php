<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\File\FileManagementTrait;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory, HasApiTokens, HasUuids, FileManagementTrait;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the URL of the file.
     */
    public function getFileUrl(): string
    {
        // Utiliser directement la méthode du trait avec le chemin du fichier
        return Storage::disk('public')->url($this->path);
    }
}
