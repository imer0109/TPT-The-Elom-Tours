<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Affiche la liste des journaux d'activités.
     */
    public function index()
    {
        if (!auth()->check() || !auth()->user()->hasRole('Super Administrateur')) {
            abort(403, 'Accès non autorisé');
        }
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.activity-logs.index', compact('logs'));
    }

    /**
     * Affiche les détails d'un journal d'activité.
     */
    public function show($id)
    {
        if (!auth()->check() || !auth()->user()->hasRole('Super Administrateur')) {
            abort(403, 'Accès non autorisé');
        }
        $log = ActivityLog::with('user')->findOrFail($id);
        return view('admin.activity-logs.show', compact('log'));
    }
}