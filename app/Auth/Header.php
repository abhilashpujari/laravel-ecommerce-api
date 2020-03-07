<?php

namespace App\Auth;

use App\Exceptions\HttpUnauthorizedException;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Exception;

class Header
{
    public static function decodeHeaderToken(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        if (!$token) {
            throw new HttpUnauthorizedException('Missing authentication token');
        }

        try {
            return JWT::decode($token, Config::get('jwt.secret'), [Config::get('jwt.algo')]);
        } catch (Exception $e) {
            throw new HttpUnauthorizedException('Invalid token');
        }
    }
}
