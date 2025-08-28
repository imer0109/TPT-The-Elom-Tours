<?php

namespace App\Traits;

use App\Services\ActivityLogService;

trait LogsActivity
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootLogsActivity()
    {
        // Log la création d'un modèle
        static::created(function ($model) {
            app(ActivityLogService::class)->logCreated($model);
        });

        // Log la mise à jour d'un modèle
        static::updated(function ($model) {
            $oldValues = $model->getOriginal();
            app(ActivityLogService::class)->logUpdated($model, $oldValues);
        });

        // Log la suppression d'un modèle
        static::deleted(function ($model) {
            app(ActivityLogService::class)->logDeleted($model);
        });
    }
}