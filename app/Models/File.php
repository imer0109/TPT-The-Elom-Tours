<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\File\FileManagementTrait;

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
        return parent::getFileUrl($this->path);
    }
}
