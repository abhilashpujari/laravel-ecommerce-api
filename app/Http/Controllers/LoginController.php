<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends Controller
{
    /** @var UserService $userServcie */
    public $userServcie;

    public function __construct()
    {
        $this->userServcie = new UserService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $user = $this->userServcie->authenticate($request);

        $tokenExpiry = Carbon::now()->addSecond(Config::get('jwt.expiry'))->getTimestamp();
        $tokenSecret = Config::get('jwt.secret');
        $token = JWT::encode([
            'id' => $user->id,
            'full_name' => $user->full_name,
            'role' => $user->role,
            'exp' => $tokenExpiry
        ], $tokenSecret);

        return response()->json([
            'token' => $token
        ]);
    }
}
