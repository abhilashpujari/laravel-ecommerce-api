<?php

namespace App\Http\Controllers;

use App\Auth\Auth;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse as Response;

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
     * @param Response $response
     * @return Response
     */
    public function login(Request $request, Response $response)
    {
        $user = $this->userServcie->authenticate($request);
        $tokenData = [
            'id' => $user->id,
            'fullName' => $user->fullName,
            'role' => $user->role
        ];

        $response->headers->set('X-Auth-Token', Auth::encodeAuthToken($tokenData));
        $response->setData();
        $response->setStatusCode(200);

        return $response;
    }
}
