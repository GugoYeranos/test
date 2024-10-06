<?php

namespace App\Http\Middleware;

use App\Http\Controllers\MainController;
use App\Models\City;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddPrefix
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $routes = ['/about', '/news'];
        $requestUri = $request->getRequestUri();

        foreach ($routes as $route) {
            if (str_ends_with($requestUri, $route)) {

                return response()->view(ltrim($route, '/'));
            }
        }

        return $next($request);
    }
}
