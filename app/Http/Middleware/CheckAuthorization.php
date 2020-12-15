<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class CheckAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed     $role
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        if (!$request->user()->isAdmin() && is_null($role)) {
            abort(403);
        }

        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        if (in_array($request->user()->role, $role)) {
            return $next($request);
        }

        abort(403);

    }

    static public function access($action, $arguments)
    {
        /*
         * See App\Policies
         *
         * @param $arguments mixed, 'Class@method'
         */
        if (Gate::denies($action, $arguments)) {
            abort(403);
        }
    }


}