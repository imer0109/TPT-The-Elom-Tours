<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * Log a create action.
     *
     * @param Model $model
     * @param string $description
     * @return ActivityLog
     */
    public function logCreated(Model $model, string $description = null): ActivityLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "Création d'un nouvel élément {$modelName}";
        
        return ActivityLog::log(
            'create',
            $description,
            $model,
            null,
            $model->toArray()
        );
    }
    
    /**
     * Log an update action.
     *
     * @param Model $model
     * @param array $oldValues
     * @param string $description
     * @return ActivityLog
     */
    public function logUpdated(Model $model, array $oldValues, string $description = null): ActivityLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "Mise à jour d'un élément {$modelName}";
        
        return ActivityLog::log(
            'update',
            $description,
            $model,
            $oldValues,
            $model->toArray()
        );
    }
    
    /**
     * Log a delete action.
     *
     * @param Model $model
     * @param string $description
     * @return ActivityLog
     */
    public function logDeleted(Model $model, string $description = null): ActivityLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "Suppression d'un élément {$modelName}";
        
        return ActivityLog::log(
            'delete',
            $description,
            $model,
            $model->toArray(),
            null
        );
    }

    /**
     * Log an archive (soft delete) action.
     */
    public function logArchived(Model $model, string $description = null): ActivityLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "Archivage d'un élément {$modelName}";

        return ActivityLog::log(
            'archive',
            $description,
            $model,
            $model->toArray(),
            null
        );
    }
    
    /**
     * Log a login action.
     *
     * @param string $description
     * @return ActivityLog
     */
    public function logLogin(string $description = null): ActivityLog
    {
        $user = Auth::user();
        $description = $description ?? "Connexion de l'utilisateur {$user->name}";
        
        return ActivityLog::log(
            'login',
            $description,
            $user
        );
    }
    
    /**
     * Log a logout action.
     *
     * @param string $description
     * @return ActivityLog
     */
    public function logLogout(string $description = null): ActivityLog
    {
        $user = Auth::user();
        $description = $description ?? "Déconnexion de l'utilisateur {$user->name}";
        
        return ActivityLog::log(
            'logout',
            $description,
            $user
        );
    }
    
    /**
     * Log a custom action.
     *
     * @param string $action
     * @param string $description
     * @param Model|null $model
     * @param array|null $oldValues
     * @param array|null $newValues
     * @return ActivityLog
     */
    public function log(
        string $action,
        string $description,
        ?Model $model = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): ActivityLog {
        return ActivityLog::log(
            $action,
            $description,
            $model,
            $oldValues,
            $newValues
        );
    }
}