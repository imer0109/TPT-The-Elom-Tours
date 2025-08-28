<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();
        
        // Filtrage par action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }
        
        // Filtrage par type de modèle
        if ($request->has('model_type') && $request->model_type) {
            $query->where('model_type', $request->model_type);
        }
        
        // Filtrage par utilisateur
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filtrage par date
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $logs = $query->paginate(20);
        
        // Récupérer les options de filtrage
        $actions = ActivityLog::distinct('action')->pluck('action');
        $modelTypes = ActivityLog::distinct('model_type')->pluck('model_type');
        
        return view('admin.logs.index', compact('logs', 'actions', 'modelTypes'));
    }
    
    /**
     * Display the specified activity log.
     *
     * @param  \App\Models\ActivityLog  $log
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityLog $log)
    {
        return view('admin.logs.show', compact('log'));
    }
    
    /**
     * Remove the specified activity log from storage.
     *
     * @param  \App\Models\ActivityLog  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityLog $log)
    {
        $log->delete();
        
        return redirect()->route('admin.logs.index')
            ->with('success', 'Le log d\'activité a été supprimé avec succès.');
    }
    
    /**
     * Clear all activity logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function clearAll()
    {
        ActivityLog::truncate();
        
        return redirect()->route('admin.logs.index')
            ->with('success', 'Tous les logs d\'activité ont été supprimés avec succès.');
    }
}