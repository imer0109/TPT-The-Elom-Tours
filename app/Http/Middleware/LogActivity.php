<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    /**
     * The activity log service.
     *
     * @var ActivityLogService
     */
    protected $activityLogService;

    /**
     * Create a new middleware instance.
     *
     * @param ActivityLogService $activityLogService
     */
    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $action
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $action = null)
    {
        // Si l'action est login et que l'utilisateur vient de se connecter
        if ($action === 'login' && Auth::check() && $request->session()->has('auth.password_confirmed_at')) {
            $this->activityLogService->logLogin();
        }

        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @param  string  $action
     * @return void
     */
    public function terminate($request, $response, $action = null)
    {
        // Si l'action est logout et que l'utilisateur vient de se déconnecter
        if ($action === 'logout' && !Auth::check() && $request->session()->has('auth.password_confirmed_at')) {
            $this->activityLogService->logLogout();
        }
    }
}