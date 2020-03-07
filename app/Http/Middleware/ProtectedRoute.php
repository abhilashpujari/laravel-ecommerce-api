<?php

namespace App\Http\Middleware;

use App\Auth\Header;
use Closure;
use Illuminate\Http\Request;

/**
 * Class ProtectedRoute
 * @package App\Http\Middleware
 */
class ProtectedRoute
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Header::decodeHeaderToken($request);
        return $next($request);
    }
}
