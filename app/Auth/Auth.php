<?php

namespace App\Auth;

use App\Exceptions\HttpUnauthorizedException;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Exception;

class Auth
{
    /**
     * @param Request $request
     * @return array
     */
    public static function decodeAuthToken(Request $request)
    {
        $token = $request->header('X-Auth-Token');

        if (!$token) {
            throw new HttpUnauthorizedException('Missing authentication token');
        }

        try {
            $decodedToken =  JWT::decode($token, Config::get('jwt.secret'), [Config::get('jwt.algo')]);

            return [
                'id' => $decodedToken->id,
                'fullName' => $decodedToken->fullName,
                'role' => $decodedToken->role
            ];
        } catch (Exception $e) {
            throw new HttpUnauthorizedException('Invalid token');
        }
    }

    /**
     * @param $data
     * @return string
     */
    public static function encodeAuthToken($data)
    {
        $tokenExpiry = Carbon::now()->addSecond(Config::get('jwt.expiry'))->getTimestamp();
        $tokenSecret = Config::get('jwt.secret');
        $data = array_merge($data, [
            'exp' => $tokenExpiry
        ]);

        return JWT::encode($data, $tokenSecret, Config::get('jwt.algo'));
    }
}
