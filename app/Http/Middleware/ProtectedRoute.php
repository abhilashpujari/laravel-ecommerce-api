<?php

namespace App\Http\Middleware;

use App\Exceptions\AppException;
use App\Exceptions\HttpUnauthorizedException;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Class ProtectedRoute
 * @package App\Http\Middleware
 */
class ProtectedRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-Auth-Token');

        if (!$token) {
            throw new HttpUnauthorizedException('Missing authentication token');
        }

        try {
            $decodedToken = JWT::decode($token, Config::get('jwt.secret'), [Config::get('jwt.algo')]);
        } catch (Exception $e) {
            throw new HttpUnauthorizedException('Invalid token');
        }

        return $next($request);
    }
}
