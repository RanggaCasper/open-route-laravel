<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use Closure;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class RouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routes = Route::firstWhere('route', $request->route()?->getName());

        if (blank($routes) || ((bool) $routes->status && $request->user()->can($routes->permission_name))) {
            return $next($request);
        }
        
        if ($request->ajax()) {
            return ResponseFormatter::error('Permission Denied!', code: Response::HTTP_UNAUTHORIZED);
        }

        return abort(403, 'Permission Denied!');
    }
}
